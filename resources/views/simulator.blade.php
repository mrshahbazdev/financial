<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Scenario Simulator 🎮') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        revenueChange: 0,
        opexReduction: 0,
        baseRevenue: {{ $baseData['revenue'] }},
        baseProfit: {{ $baseData['profit'] }},
        baseOpex: {{ $baseData['opex'] }},
        chart: null,

        init() {
            this.initChart();
            this.$watch('revenueChange', () => this.updateCharts());
            this.$watch('opexReduction', () => this.updateCharts());
        },

        get projectedRevenue() {
            return this.baseRevenue * (1 + (this.revenueChange / 100));
        },

        get projectedOpex() {
            return this.baseOpex * (1 - (this.opexReduction / 100));
        },

        get projectedProfit() {
            let profitMargin = this.baseRevenue > 0 ? (this.baseProfit / this.baseRevenue) : 0;
            let profitFromNewRevenue = this.projectedRevenue * profitMargin;
            let savingsFromOpex = this.baseOpex - this.projectedOpex;
            return profitFromNewRevenue + savingsFromOpex;
        },

        get analysisMessage() {
            let diff = this.projectedProfit - this.baseProfit;
            if (diff > 0) return `🚀 Your profit could increase by ${this.formatMoney(diff)}!`;
            if (diff < 0) return `⚠️ Warning: Your profit might drop by ${this.formatMoney(Math.abs(diff))}.`;
            return 'Adjust the sliders to see what happens.';
        },

        formatMoney(value) {
            return '$' + new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value);
        },

        initChart() {
            const ctx = document.getElementById('simulatorChart');
            this.chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Current', 'Projected'],
                    datasets: [{
                        label: 'Profit ($)',
                        data: [this.baseProfit, this.projectedProfit],
                        backgroundColor: ['#6366f1', '#22c55e']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        },

        updateCharts() {
            if (this.chart) {
                this.chart.data.datasets[0].data = [this.baseProfit, this.projectedProfit];
                this.chart.update();
            }
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Controls Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6">{{ __('Simulation Controls') }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Revenue Slider -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-2">
                            {{ __('Projected Revenue Change:') }} <span
                                class="font-bold text-indigo-600 dark:text-indigo-400"
                                x-text="revenueChange + '%'"></span>
                        </label>
                        <input type="range" min="-50" max="50" step="5" x-model="revenueChange"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>-50%</span>
                            <span>0%</span>
                            <span>+50%</span>
                        </div>
                    </div>

                    <!-- OPEX Slider -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-2">
                            {{ __('Reduce OPEX by:') }} <span class="font-bold text-red-600 dark:text-red-400"
                                x-text="opexReduction + '%'"></span>
                        </label>
                        <input type="range" min="0" max="30" step="5" x-model="opexReduction"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>0%</span>
                            <span>-15%</span>
                            <span>-30%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Projected Numbers -->
                <div class="bg-indigo-50 dark:bg-indigo-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-indigo-900 dark:text-indigo-100 mb-4">
                        {{ __('Projected Outcome') }}
                    </h3>

                    <div class="space-y-4">
                        <div
                            class="flex justify-between items-center border-b border-indigo-200 dark:border-indigo-700 pb-2">
                            <span class="text-indigo-700 dark:text-indigo-300">{{ __('New Revenue:') }}</span>
                            <span class="text-xl font-bold text-indigo-900 dark:text-indigo-100"
                                x-text="formatMoney(projectedRevenue)"></span>
                        </div>
                        <div
                            class="flex justify-between items-center border-b border-indigo-200 dark:border-indigo-700 pb-2">
                            <span class="text-indigo-700 dark:text-indigo-300">{{ __('Projected Profit:') }}</span>
                            <span class="text-xl font-bold text-green-600 dark:text-green-400"
                                x-text="formatMoney(projectedProfit)"></span>
                        </div>
                        <div class="flex justify-between items-center pb-2">
                            <span class="text-indigo-700 dark:text-indigo-300">{{ __('Projected OPEX:') }}</span>
                            <span class="text-xl font-bold text-red-500 dark:text-red-300"
                                x-text="formatMoney(projectedOpex)"></span>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-inner">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Analysis:') }}</p>
                        <p class="text-md font-bold text-gray-900 dark:text-gray-100 mt-1" x-text="analysisMessage"></p>
                    </div>
                </div>

                <!-- Visual Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Current vs Projected Profit') }}
                    </h3>
                    <div class="h-64">
                        <canvas id="simulatorChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>