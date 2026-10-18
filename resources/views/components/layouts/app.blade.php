{{-- resources/views/components/layouts/app.blade.php --}}
{{-- Usage: <x-layouts.app title="Posts"> ...page content... </x-layouts.app> --}}
@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title . ' · ' : '' }}{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php
    $links = [
        ['label' => 'Dashboard', 'icon' => 'layout-dashboard', 'route' => 'dashboard', 'active' => 'dashboard'],
        ['label' => 'Posts', 'icon' => 'file-text', 'route' => 'posts.index', 'active' => 'posts.*'],
    ];
@endphp

<body class="h-full font-sans antialiased text-gray-900">
    <div class="min-h-full">

        {{-- Navbar --}}
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur border-b border-gray-100">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="flex items-center justify-between h-16">

                    {{-- Brand + links --}}
                    <div class="flex items-center gap-8">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                            <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30">
                                <x-lucide-layers class="w-5 h-5" />
                            </span>
                            <span class="font-bold tracking-tight">{{ config('app.name', 'MyCMS') }}</span>
                        </a>

                        <nav class="hidden sm:flex items-center gap-1">
                            @foreach ($links as $link)
                                <a href="{{ route($link['route']) }}"
                                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition
                                    {{ request()->routeIs($link['active'])
                                        ? 'bg-indigo-50 text-indigo-700'
                                        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                    <x-dynamic-component :component="'lucide-' . $link['icon']" class="w-4 h-4" />
                                    {{ $link['label'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>

                    {{-- User + logout --}}
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex items-center gap-2 text-sm text-gray-600">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </span>
                            {{ auth()->user()->name ?? '' }}
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" title="Log out"
                                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-red-600 transition">
                                <x-lucide-log-out class="w-4 h-4" />
                                <span class="hidden sm:inline">Log out</span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Mobile links --}}
                <nav class="flex sm:hidden items-center gap-1 pb-3 overflow-x-auto">
                    @foreach ($links as $link)
                        <a href="{{ route($link['route']) }}"
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition
                            {{ request()->routeIs($link['active'])
                                ? 'bg-indigo-50 text-indigo-700'
                                : 'text-gray-600 hover:bg-gray-100' }}">
                            <x-dynamic-component :component="'lucide-' . $link['icon']" class="w-4 h-4" />
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </header>

        {{-- Page content --}}
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>