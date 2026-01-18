<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profit First Analysis Results') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        activeTab: 'details',
        chartInstance: null,
        chartData: {
            labels: @json($analysis->rows->pluck('category')),
            actuals: @json($analysis->rows->pluck('actual_amount')),
            targets: @json($analysis->rows->pluck('pf_amount'))
        },
        q1: {
            jan: 0,
            feb: 0,
            mar: 0
        },
        caps: {
            @foreach($analysis->rows as $row)
                '{{ $row->category }}': {{ $row->q1_caps }},
            @endforeach
        },
        initChart() {
            if (this.chartInstance) {
                this.chartInstance.destroy();
            }

            // Wait for DOM update
            this.$nextTick(() => {
                const ctx = document.getElementById('analysisChart');
                if (!ctx) return;

                this.chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: this.chartData.labels,
                        datasets: [
                            {
                                label: 'Actual ($)',
                                data: this.chartData.actuals,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Target (PF $)',
                                data: this.chartData.targets,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function (value) {
                                        return '$' + value;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        },
        calculateTransfer(amount, category) {
            let cap = this.caps[category] || 0;
            return (amount * (cap / 100));
        },
        printPage() {
            window.print();
        }
    }" x-init="initChart()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Actions -->
            <div class="mb-4 flex justify-between items-center print:hidden">
                <!-- Tabs Navigation -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button @click="activeTab = 'details'; $nextTick(() => initChart())"
                            :class="activeTab === 'details' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            {{ __('Analysis Details') }}
                        </button>
                        <button @click="activeTab = 'q1'"
                            :class="activeTab === 'q1' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            {{ __('Q1 2026 Data') }}
                        </button>
                        <button @click="activeTab = 'targets'"
                            :class="activeTab === 'targets' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            {{ __('Target Overview') }}
                        </button>
                    </nav>
                </div>

                <div class="flex space-x-2">
                    <button @click="printPage()"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('Print View') }}
                    </button>
                    <a href="{{ route('analyses.pdf', $analysis) }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        {{ __('Download PDF') }}
                    </a>
                </div>
            </div>

            <!-- Tab 1: Analysis Details -->
            <div x-show="activeTab === 'details'" class="space-y-6">
                <!-- Summary Header -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Details') }}</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Real Revenue:') }}
                        ${{ number_format($analysis->real_revenue, 2) }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Date:') }}
                        {{ $analysis->created_at->format('M d, Y') }}
                    </p>
                </div>

                <!-- Analysis Contents (Existing Table) -->
                @include('analysis.partials.details-view', ['analysis' => $analysis])
            </div>

            <!-- Tab 2: Q1 2026 Data Input -->
            <div x-show="activeTab === 'q1'"
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Q1 2026 Revenue Projection') }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Enter your projected or actual revenue for Q1 to calculate your transfer targets.') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <x-input-label for="jan_rev" :value="__('January Revenue ($)')" />
                        <x-text-input id="jan_rev" x-model.number="q1.jan" class="block mt-1 w-full" type="number"
                            step="0.01" />
                    </div>
                    <div>
                        <x-input-label for="feb_rev" :value="__('February Revenue ($)')" />
                        <x-text-input id="feb_rev" x-model.number="q1.feb" class="block mt-1 w-full" type="number"
                            step="0.01" />
                    </div>
                    <div>
                        <x-input-label for="mar_rev" :value="__('March Revenue ($)')" />
                        <x-text-input id="mar_rev" x-model.number="q1.mar" class="block mt-1 w-full" type="number"
                            step="0.01" />
                    </div>
                </div>

                <div class="mt-6 p-4 bg-indigo-50 dark:bg-indigo-900 rounded-lg flex justify-between items-center">
                    <p class="text-lg font-bold text-indigo-900 dark:text-indigo-100">
                        {{ __('Total Q1 Revenue:') }} <span
                            x-text="'$' + (parseFloat(q1.jan || 0) + parseFloat(q1.feb || 0) + parseFloat(q1.mar || 0)).toFixed(2)"></span>
                    </p>
                    <button @click="activeTab = 'targets'"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('Next: View Targets') }} &rarr;
                    </button>
                </div>
            </div>

            <!-- Tab 3: Target Overview -->
            <div x-show="activeTab === 'targets'"
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 print:block">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Target Overview (Transfers)') }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Transfer targets for the 10th and 25th of each month based on Q1 CAPS.') }}
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Month') }}
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Date') }}
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Allocation Base (50%)') }}
                                </th>
                                @foreach($analysis->rows as $row)
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __($row->category) }} <br>
                                        <span class="text-xxs text-gray-400">({{ number_format($row->q1_caps, 1) }}%)</span>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- Helper template for rows -->
                            <template x-for="month in ['jan', 'feb', 'mar']">
                                <template x-for="date in ['10th', '25th']">
                                    <tr>
                                        <template x-if="date === '10th'">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100 capitalize"
                                                :rowspan="2" x-text="month"></td>
                                        </template>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100"
                                            x-text="date"></td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <span x-text="'$' + ((q1[month] || 0) / 2).toFixed(2)"></span>
                                        </td>
                                        @foreach($analysis->rows as $row)
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                <span
                                                    x-text="'$' + calculateTransfer((q1[month] || 0) / 2, '{{ $row->category }}').toFixed(2)"></span>
                                            </td>
                                        @endforeach
                                    </tr>
                                </template>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="mt-8 text-xs text-gray-400">
                    <p>* {{ __('Allocation Base is 50% of the total revenue for the month, assuming equal distribution for the 10th and 25th transfers.') }}
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {

            nav,
            header,
            .print\:hidden,
            aside,
            .fixed.inset-y-0 {
                display: none !important;
            }

            body {
                background-color: white !important;
                color: black !important;
            }

            .max-w-7xl {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
</x-app-layout>