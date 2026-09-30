<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WishlistItem;
use App\Services\Cart;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

/**
 * Customer sign-in / sign-up (email or mobile + password) and password reset.
 * Admins use the separate /admin/login screen.
 */
class AccountAuthController extends Controller
{
    public function showLogin(Request $request)
    {
        $this->rememberIntended($request);

        return view('store.auth.login');
    }

    public function login(Request $request, Cart $cart)
    {
        $data = $request->validate([
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ], [], ['login' => 'email or mobile number']);

        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $value = $field === 'phone' ? $this->normalisePhone($data['login']) : Str::lower(trim($data['login']));

        $guestToken = $request->cookie(Cart::COOKIE);

        if (! Auth::attempt([$field => $value, 'password' => $data['password']], $request->boolean('remember'))) {
            return back()
                ->withErrors(['login' => 'The email / mobile number or password is incorrect.'])
                ->onlyInput('login');
        }

        return $this->signedIn($request, $cart, $guestToken, 'Welcome back, ' . Str::before(Auth::user()->name, ' ') . '!');
    }

    public function showRegister(Request $request)
    {
        $this->rememberIntended($request);

        return view('store.auth.register');
    }

    public function register(Request $request, Cart $cart)
    {
        $request->merge([
            'phone' => $this->normalisePhone((string) $request->input('phone')),
            'email' => Str::lower(trim((string) $request->input('email'))),
        ]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/', 'unique:users,phone'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->numbers()],
            'terms' => ['accepted'],
        ], [
            'phone.regex' => 'Enter a valid 10-digit Indian mobile number.',
            'phone.unique' => 'An account with this mobile number already exists.',
            'email.unique' => 'An account with this email already exists.',
            'terms.accepted' => 'Please accept the terms to create your account.',
        ]);

        $guestToken = $request->cookie(Cart::COOKIE);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
        ]);

        Auth::login($user, true);

        return $this->signedIn($request, $cart, $guestToken, 'Your Yara account is ready. Welcome, ' . Str::before($user->name, ' ') . '!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('store.home')->with('toast', 'You have been signed out.');
    }

    public function showForgot()
    {
        return view('store.auth.forgot');
    }

    public function sendReset(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        // Same answer whether or not the email exists, so accounts cannot be discovered.
        Password::sendResetLink(['email' => Str::lower(trim($request->email))]);

        return back()->with('status', 'If an account exists for that email, we have sent a link to reset the password.');
    }

    public function showReset(Request $request, string $token)
    {
        return view('store.auth.reset', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->numbers()],
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function (User $user, string $password) {
            $user->forceFill(['password' => Hash::make($password), 'remember_token' => Str::random(60)])->save();
            event(new PasswordReset($user));
        });

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Your password has been reset. Please sign in.')
            : back()->withErrors(['email' => __($status)]);
    }

    /** Shared after a successful sign-in or sign-up: session, login stamp, cart + wishlist merge. */
    private function signedIn(Request $request, Cart $cart, ?string $guestToken, string $message)
    {
        $request->session()->regenerate();

        $user = Auth::user();
        $user->forceFill(['last_login_at' => now(), 'last_login_ip' => $request->ip()])->save();

        $cart->merge($guestToken, $user->id);

        // wishlist ids saved in the browser before signing in (sent along with the form)
        collect(explode(',', (string) $request->input('wishlist')))
            ->map(fn ($id) => (int) $id)->filter()->unique()->take(200)
            ->each(fn ($id) => \App\Models\Product::whereKey($id)->exists()
                && WishlistItem::firstOrCreate(['user_id' => $user->id, 'product_id' => $id]));

        return redirect()->intended(route('account.index'))->with('toast', $message)->with('wishlist_synced', true);
    }

    private function rememberIntended(Request $request): void
    {
        $to = $request->query('redirect');
        if ($to && str_starts_with($to, '/') && ! str_starts_with($to, '//')) {
            $request->session()->put('url.intended', url($to));
        }
    }

    private function normalisePhone(string $value): string
    {
        $digits = preg_replace('/\D/', '', $value);

        return strlen($digits) > 10 ? substr($digits, -10) : $digits;
    }
}
