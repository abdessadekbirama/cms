{{-- resources/views/components/form.blade.php --}}
{{--
    Usage:
        <x-form type="register" />
        <x-form type="login" />
        <x-form type="login" title="Welcome" :action="route('custom.login')" />

    Requires: mallardduck/blade-lucide-icons  (composer require mallardduck/blade-lucide-icons)
    Password show/hide uses Alpine.js (already included with Breeze/Jetstream/Livewire).
--}}

@props([
'type' => 'login', // 'login' | 'register'
'action' => null, // override form action
'title' => null, // override heading
'subtitle' => null, // override sub heading
'submit' => null, // override button label
'loginUrl' => null, // link used on the register form
'registerUrl' => null, // link used on the login form
'forgotUrl' => null, // forgot password link (login only)
])

@php
$isRegister = $type === 'register';

$action ??= $isRegister
? (Route::has('register') ? route('register') : url('/register'))
: (Route::has('login') ? route('login') : url('/login'));

$loginUrl ??= Route::has('login') ? route('login') : url('/login');
$registerUrl ??= Route::has('register') ? route('register') : url('/register');
$forgotUrl ??= Route::has('password.request') ? route('password.request') : '#';

$title ??= $isRegister ? 'Create an account' : 'Welcome back';
$subtitle ??= $isRegister
? 'Start your journey with us in less than a minute.'
: 'Sign in to continue to your account.';
$submit ??= $isRegister ? 'Create account' : 'Sign in';

$fields = $isRegister
? [
['name' => 'name', 'label' => 'Full name', 'type' => 'text', 'icon' => 'user', 'placeholder' => 'John Doe', 'autocomplete' => 'name'],
['name' => 'email', 'label' => 'Email address', 'type' => 'email', 'icon' => 'mail', 'placeholder' => 'you@example.com', 'autocomplete' => 'email'],
['name' => 'password', 'label' => 'Password', 'type' => 'password', 'icon' => 'lock', 'placeholder' => 'Create a password', 'autocomplete' => 'new-password'],
['name' => 'password_confirmation', 'label' => 'Confirm password', 'type' => 'password', 'icon' => 'shield-check', 'placeholder' => 'Confirm your password', 'autocomplete' => 'new-password'],
]
: [
['name' => 'email', 'label' => 'Email address', 'type' => 'email', 'icon' => 'mail', 'placeholder' => 'you@example.com', 'autocomplete' => 'email'],
['name' => 'password', 'label' => 'Password', 'type' => 'password', 'icon' => 'lock', 'placeholder' => 'Enter your password', 'autocomplete' => 'current-password'],
];
@endphp

<div class="w-full max-w-md mx-auto">
    <form method="POST" action="{{ $action }}"
        {{ $attributes->merge(['class' => 'relative overflow-hidden p-8 sm:p-10 bg-white border border-gray-100 rounded-3xl shadow-2xl shadow-indigo-200/40']) }}>

        @csrf

        {{-- decorative gradient glow --}}
        <div class="pointer-events-none absolute -top-24 -right-24 w-64 h-64 rounded-full bg-gradient-to-br from-indigo-200/60 to-purple-200/40 blur-3xl"></div>

        <div class="relative">
            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto mb-5 flex items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30">
                    @if ($isRegister)
                    <x-lucide-user-plus class="w-7 h-7" />
                    @else
                    <x-lucide-log-in class="w-7 h-7" />
                    @endif
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $title }}</h1>
                <p class="mt-2 text-sm text-gray-500">{{ $subtitle }}</p>
            </div>

            {{-- Global errors (e.g. invalid credentials) --}}
            @if (session('status'))
            <div class="mb-5 flex items-start gap-2 rounded-xl bg-emerald-50 border border-emerald-100 px-4 py-3 text-sm text-emerald-700">
                <x-lucide-circle-check class="w-4 h-4 mt-0.5 shrink-0" />
                <span>{{ session('status') }}</span>
            </div>
            @endif

            {{-- Fields --}}
            <div class="space-y-5">
                @foreach ($fields as $field)
                @php $hasError = $errors->has($field['name']); @endphp

                <div @if ($field['type']==='password' ) x-data="{ show: false }" @endif>
                    <label for="{{ $field['name'] }}" class="block mb-2 text-sm font-semibold text-gray-700">
                        {{ $field['label'] }}
                    </label>

                    <div class="relative group">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 {{ $hasError ? 'text-red-400' : 'text-gray-400 group-focus-within:text-indigo-600' }} transition-colors">
                            <x-dynamic-component :component="'lucide-' . $field['icon']" class="w-5 h-5" />
                        </span>

                        <input
                            id="{{ $field['name'] }}"
                            name="{{ $field['name'] }}"
                            @if ($field['type']==='password' )
                            :type="show ? 'text' : 'password'"
                            @else
                            type="{{ $field['type'] }}"
                            value="{{ old($field['name']) }}"
                            @endif
                            placeholder="{{ $field['placeholder'] }}"
                            autocomplete="{{ $field['autocomplete'] }}"
                            required
                            @if ($loop->first) autofocus @endif
                        class="w-full pl-12 {{ $field['type'] === 'password' ? 'pr-12' : 'pr-4' }} py-3 rounded-xl border bg-gray-50 text-gray-900 placeholder-gray-400 outline-none transition
                        {{ $hasError
                                        ? 'border-red-300 focus:border-red-500 focus:ring-4 focus:ring-red-100'
                                        : 'border-gray-200 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100' }}">

                        @if ($field['type'] === 'password')
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 transition-colors"
                            :aria-label="show ? 'Hide password' : 'Show password'">
                            <x-lucide-eye x-show="!show" class="w-5 h-5" />
                            <x-lucide-eye-off x-show="show" x-cloak class="w-5 h-5" />
                        </button>
                        @endif
                    </div>

                    @error($field['name'])
                    <p class="mt-1.5 flex items-center gap-1 text-sm text-red-600">
                        <x-lucide-circle-alert class="w-4 h-4 shrink-0" />
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                @endforeach

                {{-- Login extras: remember me + forgot password --}}
                @unless ($isRegister)
                <div class="flex items-center justify-between">
                    <label for="remember" class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <input id="remember" type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-gray-600">Remember me</span>
                    </label>

                    <a href="{{ $forgotUrl }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 hover:underline">
                        Forgot password?
                    </a>
                </div>
                @endunless

                {{-- Submit --}}
                <button type="submit"
                    class="group w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold shadow-lg shadow-indigo-600/25 transition hover:from-indigo-700 hover:to-purple-700 hover:shadow-indigo-600/40 focus:outline-none focus:ring-4 focus:ring-indigo-200 active:scale-[0.98]">
                    {{ $submit }}
                    <x-lucide-arrow-right class="w-5 h-5 transition-transform group-hover:translate-x-1" />
                </button>
            </div>

            {{-- Extra slot (social buttons, terms, etc.) --}}
            @if ($slot->isNotEmpty())
            <div class="mt-6">{{ $slot }}</div>
            @endif

            {{-- Footer link --}}
            <p class="mt-8 text-center text-sm text-gray-500">
                @if ($isRegister)
                Already have an account?
                <a href="{{ $loginUrl }}" class="font-semibold text-indigo-600 hover:text-indigo-700 hover:underline">Sign in</a>
                @else
                Don't have an account?
                <a href="{{ $registerUrl }}" class="font-semibold text-indigo-600 hover:text-indigo-700 hover:underline">Create one</a>
                @endif
            </p>
        </div>
    </form>
</div>