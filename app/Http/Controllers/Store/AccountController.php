<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->loadCount('wishlistItems');
        $wishlist = $user->wishlistItems()->with('product.primaryImage')->latest()->take(4)->get()->pluck('product')->filter();
        $cartCount = (int) $user->cartItems()->where('saved_for_later', false)->sum('quantity');

        return view('store.account.index', compact('user', 'wishlist', 'cartCount'));
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $request->merge(['phone' => substr(preg_replace('/\D/', '', (string) $request->phone), -10)]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/', Rule::unique('users')->ignore($user->id)],
        ], ['phone.regex' => 'Enter a valid 10-digit Indian mobile number.']);

        $user->update($data);

        return back()->with('toast', 'Profile updated.');
    }

    public function updatePassword(Request $request)
    {
        $request->validateWithBag('password', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->numbers()],
        ]);

        $request->user()->update(['password' => Hash::make($request->password)]);

        return back()->with('toast', 'Password changed.');
    }
}
