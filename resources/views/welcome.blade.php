<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Financial Analysis') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans text-gray-900 bg-gray-50 dark:bg-gray-900 dark:text-gray-100">
    <div class="relative min-h-screen flex flex-col selection:bg-indigo-500 selection:text-white">
        <!-- Navigation -->
        <nav class="relative z-10 w-full px-6 py-4 flex justify-between items-center max-w-7xl mx-auto">
            <div class="flex items-center gap-2">
                <x-application-logo class="w-10 h-10 fill-current text-indigo-600 dark:text-indigo-400" />
                <span
                    class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ config('app.name', 'Financial') }}</span>
            </div>
            <div class="flex items-center gap-4">
                <!-- Language Switcher -->
                <div class="flex items-center space-x-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    <a href="{{ route('lang.switch', 'en') }}"
                        class="{{ app()->getLocale() == 'en' ? 'text-indigo-600 font-bold' : 'hover:text-gray-900 dark:hover:text-white' }}">EN</a>
                    <span>|</span>
                    <a href="{{ route('lang.switch', 'de') }}"
                        class="{{ app()->getLocale() == 'de' ? 'text-indigo-600 font-bold' : 'hover:text-gray-900 dark:hover:text-white' }}">DE</a>
                </div>

                @if (Route::has('login'))
                    <div class="flex gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-sm font-semibold leading-6 text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                {{ __('Dashboard') }} <span aria-hidden="true">&rarr;</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-sm font-semibold leading-6 text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                {{ __('Log in') }}
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="rounded-md bg-indigo-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-grow flex items-center justify-center relative isolate px-6 pt-14 lg:px-8">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>

            <div class="mx-auto max-w-2xl py-12 sm:py-24 lg:py-32 text-center">
                <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                    <div
                        class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-600 dark:text-gray-300 ring-1 ring-gray-900/10 dark:ring-gray-100/10 hover:ring-gray-900/20 dark:hover:ring-gray-100/20 transition">
                        {{ __('Empowering business growth with Profit First.') }} <a href="#"
                            class="font-semibold text-indigo-600 dark:text-indigo-400"><span class="absolute inset-0"
                                aria-hidden="true"></span>{{ __('Read more') }} <span
                                aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                    {{ __('Master Your Business Finances') }}
                </h1>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                    {{ __('Take control of your cash flow with our advanced analytics and simulation tools. Implement the Profit First methodology to ensure your business stays healthy and profitable.') }}
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="{{ route('register') }}"
                        class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                        {{ __('Get started') }}
                    </a>
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">
                        {{ __('Live demo') }} <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>

            <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
                aria-hidden="true">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
        </main>

        <!-- Feature Grid (Optional but powerful) -->
        <section class="py-12 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-indigo-600 dark:text-indigo-400">
                        {{ __('Deploy faster') }}</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        {{ __('Everything you need to analyze financial health') }}</p>
                </div>
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                        <div class="relative pl-16">
                            <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-white">
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                                    </svg>
                                </div>
                                {{ __('Instant Assessment') }}
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-300">
                                {{ __('Run comprehensive financial assessments in seconds. Understand where your business stands immediately.') }}
                            </dd>
                        </div>
                        <div class="relative pl-16">
                            <dt class="text-base font-semibold leading-7 text-gray-900 dark:text-white">
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                    </svg>
                                </div>
                                {{ __('TAPS Analysis') }}
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600 dark:text-gray-300">
                                {{ __('Define and track your Target Allocation Percentages. Adjust your strategy based on industry standards.') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>

        <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
            <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
                <div class="flex justify-center space-x-6 md:order-2">
                    <p class="text-center text-xs leading-5 text-gray-500">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </p>
                </div>
                <div class="mt-8 md:order-1 md:mt-0">
                    <p class="text-center text-xs leading-5 text-gray-500">
                        {{ __('Empowering businesses to profitability.') }}
                    </p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>