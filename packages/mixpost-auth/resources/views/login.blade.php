<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <title>Sign in · {{ config('app.name', 'Social Hub') }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('/vendor/mixpost-auth/img/favicon.ico') }}">
    {{ \Inovector\MixpostAuth\MixpostAuth::assets() }}
</head>
<body class="font-sans antialiased bg-white">
<div class="min-h-screen grid lg:grid-cols-2">

    {{-- Brand panel (black + purple) --}}
    <div class="relative hidden lg:flex flex-col justify-between overflow-hidden bg-[#0b0b10] text-white p-12">
        <div class="pointer-events-none absolute -top-32 -left-24 w-[520px] h-[520px] rounded-full bg-indigo-600/35 blur-[120px]"></div>
        <div class="pointer-events-none absolute -bottom-40 right-[-120px] w-[460px] h-[460px] rounded-full bg-indigo-400/20 blur-[120px]"></div>
        <div class="pointer-events-none absolute inset-0 opacity-[0.07]"
             style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 48px 48px; mask-image: radial-gradient(ellipse at 40% 40%, #000 20%, transparent 70%);"></div>

        <div class="relative flex items-center gap-3">
            <svg viewBox="0 0 40 40" class="h-11 w-11" aria-hidden="true">
                <defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#a676ff"/><stop offset="100%" stop-color="#6421d4"/></linearGradient></defs>
                <rect width="40" height="40" rx="11" fill="url(#g)"/>
                <circle cx="14" cy="20" r="3.2" fill="#fff"/>
                <path d="M20 13.5a9 9 0 0 1 0 13" stroke="#fff" stroke-width="2.4" fill="none" stroke-linecap="round"/>
                <path d="M24.5 9.5a14.5 14.5 0 0 1 0 21" stroke="#fff" stroke-opacity=".6" stroke-width="2.4" fill="none" stroke-linecap="round"/>
            </svg>
            <span class="text-2xl font-bold tracking-tight">{{ config('app.name', 'Social Hub') }}</span>
        </div>

        <div class="relative max-w-[30rem]">
            <h1 class="text-5xl font-bold leading-[1.05] tracking-tight">
                Post once.<br><span class="bg-gradient-to-r from-indigo-300 to-indigo-500 bg-clip-text text-transparent">Publish everywhere.</span>
            </h1>
            <p class="mt-6 text-lg text-white/60 leading-relaxed">
                Upload your video one time. Titles, descriptions and thumbnails go out to every social platform, on schedule.
            </p>
            <div class="mt-10 flex flex-wrap gap-2">
                @foreach (['YouTube', 'TikTok', 'Instagram', 'Facebook', 'LinkedIn', 'X'] as $platform)
                    <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-white/5 border border-white/10 text-white/80">{{ $platform }}</span>
                @endforeach
            </div>
        </div>

        <div class="relative text-sm text-white/35">&copy; {{ date('Y') }} {{ config('app.name', 'Social Hub') }}</div>
    </div>

    {{-- Sign-in form (white) --}}
    <div class="flex items-center justify-center px-6 py-12 bg-white">
        <div class="w-full max-w-[24rem]">
            <div class="lg:hidden mb-10 flex items-center gap-3">
                <svg viewBox="0 0 40 40" class="h-10 w-10" aria-hidden="true">
                    <defs><linearGradient id="g2" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#a676ff"/><stop offset="100%" stop-color="#6421d4"/></linearGradient></defs>
                    <rect width="40" height="40" rx="11" fill="url(#g2)"/>
                    <circle cx="14" cy="20" r="3.2" fill="#fff"/>
                    <path d="M20 13.5a9 9 0 0 1 0 13" stroke="#fff" stroke-width="2.4" fill="none" stroke-linecap="round"/>
                    <path d="M24.5 9.5a14.5 14.5 0 0 1 0 21" stroke="#fff" stroke-opacity=".6" stroke-width="2.4" fill="none" stroke-linecap="round"/>
                </svg>
                <span class="text-xl font-bold text-gray-900">{{ config('app.name', 'Social Hub') }}</span>
            </div>

            <h2 class="text-3xl font-bold tracking-tight text-gray-900">Welcome back</h2>
            <p class="mt-2 text-gray-500">Sign in to manage and publish your content.</p>

            <form method="POST" action="{{ route('login') }}" class="mt-10 space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 transition"
                           placeholder="you@company.com">
                    <x-mixpost-auth::input-error :messages="$errors->get('email')" class="mt-xs"/>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 transition"
                           placeholder="••••••••">
                    <x-mixpost-auth::input-error :messages="$errors->get('password')" class="mt-xs"/>
                </div>
                <label for="remember_me" class="flex items-center gap-2 text-sm text-gray-600 select-none">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500/30">
                    Remember me
                </label>
                <button type="submit"
                        class="w-full rounded-xl py-3 font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-700 shadow-lg shadow-indigo-500/25 hover:from-indigo-400 hover:to-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 transition">
                    Sign in
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
