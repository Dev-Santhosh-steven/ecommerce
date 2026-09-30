{{-- One labelled input with its error. Props: name, label, type, autocomplete, placeholder, value, prefix --}}
@php $type = $type ?? 'text'; $isPassword = $type === 'password'; @endphp
<div @if ($isPassword) x-data="{ show: false }" @endif>
    <label for="f-{{ $name }}" class="block text-sm font-semibold text-gray-800">{{ $label }}</label>
    <div class="relative mt-2">
        @isset($prefix)
            <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm font-medium text-gray-500">{{ $prefix }}</span>
        @endisset
        <input id="f-{{ $name }}" name="{{ $name }}"
               @if ($isPassword) :type="show ? 'text' : 'password'" type="password" @else type="{{ $type }}" @endif
               value="{{ $isPassword ? '' : old($name, $value ?? '') }}"
               @isset($autocomplete) autocomplete="{{ $autocomplete }}" @endisset
               @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
               @isset($inputmode) inputmode="{{ $inputmode }}" @endisset
               @if (! empty($autofocus)) autofocus @endif
               @if (empty($optional)) required @endif
               class="block w-full rounded-xl border-0 bg-gray-50 py-3.5 {{ isset($prefix) ? 'pl-14' : 'pl-4' }} {{ $isPassword ? 'pr-12' : 'pr-4' }} text-gray-900 ring-1 ring-inset {{ $errors->has($name) ? 'ring-brand-500' : 'ring-gray-200' }} placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-brand-500">
        @if ($isPassword)
            <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-1.5 text-gray-400 hover:text-gray-700" :aria-label="show ? 'Hide password' : 'Show password'">
                <i data-lucide="eye" class="h-4 w-4" x-show="!show"></i>
                <i data-lucide="eye-off" class="h-4 w-4" x-show="show" x-cloak></i>
            </button>
        @endif
    </div>
    @error($name)
        <p class="mt-1.5 text-sm text-brand-600">{{ $message }}</p>
    @enderror
    @isset($hint)
        @unless ($errors->has($name))
            <p class="mt-1.5 text-xs text-gray-500">{{ $hint }}</p>
        @endunless
    @endisset
</div>
