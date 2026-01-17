<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Financial Health Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(!$hasData)
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-10 text-center">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Welcome to Profit First! 🚀') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">
                        {{ __('You haven\'t run any analyses yet. Start your first financial checkup now.') }}
                    </p>
                    <a href="{{ route('analyses.create') }}"
                        class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 text-lg font-semibold">
                        {{ __('Start New Analysis') }}
                    </a>
                </div>
            @else
                <!-- 1. AI Advisor Section -->
                <div
                    class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-6 text-white flex items-start gap-4">
                    <div class="text-4xl">🤖</div>
                    <div>
                        <h3 class="text-lg font-bold uppercase tracking-wider opacity-90">{{ __('AI Financial Advisor') }}
                        </h3>
                        <p class="text-xl font-medium mt-1">"{{ $advisor['message'] }}"</p>
                    </div>
                </div>

                <!-- 2. KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Revenue Card -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Revenue Analyzed') }}
                        </p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                            ${{ number_format($metrics['total_revenue']) }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ __('Latest:') }}
                            ${{ number_format($metrics['latest_revenue']) }}</p>
                    </div>

                    <!-- Profit Margin Card -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Latest Profit Margin') }}</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ number_format($metrics['profit_margin'], 1) }}%
                        </p>
                        <p class="text-xs text-gray-400 mt-1">{{ __('Target: Varies by Industry') }}</p>
                    </div>

                    <!-- Action Card -->
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-indigo-500 flex flex-col justify-center items-center">
                        <a href="{{ route('analyses.create') }}"
                            class="w-full text-center bg-indigo-50 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 py-3 rounded-md font-bold hover:bg-indigo-100 dark:hover:bg-indigo-800 transition">
                            {{ __('+ New Analysis') }}
                        </a>
                    </div>
                </div>

                <!-- 3. Trend Chart -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Profit Trend (Actual vs Target)') }}
                    </h3>
                    <div class="h-80">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>

                <!-- Chart Script -->
                <script type="module">
                    document.addEventListener('DOMContentLoaded', function () {
                        const ctx = document.getElementById('dashboardChart');
                        const data = @json($chartData);

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.labels,
                                datasets: [
                                    {
                                        label: '{{ __('Actual Profit ($)') }}',
                                        data: data.profitActuals,
                                        borderColor: 'rgba(34, 197, 94, 1)', // Green
                                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                                        fill: true,
                                        tension: 0.3
                                    },
                                    {
                                        label: '{{ __('Target Profit ($)') }}',
                                        data: data.profitTargets,
                                        borderColor: 'rgba(99, 102, 241, 1)', // Indigo
                                        borderDash: [5, 5],
                                        fill: false,
                                        tension: 0.3
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: { color: 'rgba(200, 200, 200, 0.1)' }
                                    },
                                    x: {
                                        grid: { display: false }
                                    }
                                }
                            }
                        });
                    });
                </script>
            @endif
        </div>
    </div>
</x-app-layout>