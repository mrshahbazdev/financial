<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profit First Analysis Results') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data='analysisLogic(@json($analysis->rows, JSON_HEX_APOS))' x-init="initChart()">
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
                    <button @click="saveData()" :disabled="isSaving"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <span x-show="!isSaving">{{ __('Save Changes') }}</span>
                        <span x-show="isSaving">{{ __('Saving...') }}</span>
                    </button>
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

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- January -->
                    <div class="space-y-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ __('January') }}</h4>
                        <div>
                            <x-input-label for="jan_10" :value="__('10th ($)')" />
                            <x-text-input id="jan_10" x-model.number="q1.jan_10" class="block mt-1 w-full" type="number"
                                step="0.01" />
                        </div>
                        <div>
                            <x-input-label for="jan_25" :value="__('25th ($)')" />
                            <x-text-input id="jan_25" x-model.number="q1.jan_25" class="block mt-1 w-full" type="number"
                                step="0.01" />
                        </div>
                    </div>

                    <!-- February -->
                    <div class="space-y-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ __('February') }}</h4>
                        <div>
                            <x-input-label for="feb_10" :value="__('10th ($)')" />
                            <x-text-input id="feb_10" x-model.number="q1.feb_10" class="block mt-1 w-full" type="number"
                                step="0.01" />
                        </div>
                        <div>
                            <x-input-label for="feb_25" :value="__('25th ($)')" />
                            <x-text-input id="feb_25" x-model.number="q1.feb_25" class="block mt-1 w-full" type="number"
                                step="0.01" />
                        </div>
                    </div>

                    <!-- March -->
                    <div class="space-y-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ __('March') }}</h4>
                        <div>
                            <x-input-label for="mar_10" :value="__('10th ($)')" />
                            <x-text-input id="mar_10" x-model.number="q1.mar_10" class="block mt-1 w-full" type="number"
                                step="0.01" />
                        </div>
                        <div>
                            <x-input-label for="mar_25" :value="__('25th ($)')" />
                            <x-text-input id="mar_25" x-model.number="q1.mar_25" class="block mt-1 w-full" type="number"
                                step="0.01" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-indigo-50 dark:bg-indigo-900 rounded-lg flex justify-between items-center">
                    <p class="text-lg font-bold text-indigo-900 dark:text-indigo-100">
                        {{ __('Total Q1 Revenue:') }} <span x-text="'$' + (
                                parseFloat(q1.jan_10 || 0) + parseFloat(q1.jan_25 || 0) +
                                parseFloat(q1.feb_10 || 0) + parseFloat(q1.feb_25 || 0) +
                                parseFloat(q1.mar_10 || 0) + parseFloat(q1.mar_25 || 0)
                            ).toFixed(2)"></span>
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
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Date') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Revenue') }}
                                </th>
                                <template x-for="row in rows" :key="row.id">
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <div class="flex flex-col">
                                            <span x-text="row.category"></span>
                                            <span class="text-xxs text-gray-400"
                                                x-text="'(' + row.q1_caps + '%)'"></span>
                                        </div>
                                    </th>
                                </template>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <template x-for="cycle in [
                                { key: 'jan_10', label: 'Jan 10' }, { key: 'jan_25', label: 'Jan 25' },
                                { key: 'feb_10', label: 'Feb 10' }, { key: 'feb_25', label: 'Feb 25' },
                                { key: 'mar_10', label: 'Mar 10' }, { key: 'mar_25', label: 'Mar 25' }
                            ]">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100"
                                        x-text="cycle.label"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <span x-text="'$' + (q1[cycle.key] || 0).toFixed(2)"></span>
                                    </td>
                                    <template x-for="row in rows" :key="row.id">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <span
                                                x-text="'$' + calculateTransfer((q1[cycle.key] || 0), row.category).toFixed(2)"></span>
                                        </td>
                                    </template>
                                </tr>
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
    <script>
        <script>
        document.addEventListener('alpine:init', () => {
                Alpine.data('analysisLogic', (initialRows) => ({
                    activeTab: 'details',
                    chartInstance: null,
                    isSaving: false,
                    rows: initialRows,
                    q1: @json($analysis->q1_revenue_data ?? [
                        'jan_10' => 0,
                        'jan_25' => 0,
                        'feb_10' => 0,
                        'feb_25' => 0,
                        'mar_10' => 0,
                        'mar_25' => 0
                    ]),
                    initChart() {
                        if (this.chartInstance) {
                            this.chartInstance.destroy();
                        }

                        this.$nextTick(() => {
                            const ctx = document.getElementById('analysisChart');
                            if (!ctx) return;

                            this.chartInstance = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: this.rows.map(r => r.category),
                                    datasets: [
                                        {
                                            label: 'Actual ($)',
                                            data: this.rows.map(r => r.actual_amount),
                                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                            borderColor: 'rgba(54, 162, 235, 1)',
                                            borderWidth: 1
                                        },
                                        {
                                            label: 'Target (PF $)',
                                            data: this.rows.map(r => r.pf_amount),
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
                        const row = this.rows.find(r => r.category === category);
                        return row ? (amount * (row.q1_caps / 100)) : 0;
                    },
                    async saveData() {
                        this.isSaving = true;
                        try {
                            const response = await fetch('{{ route('analyses.update-targets', $analysis) }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    q1_revenue_data: this.q1,
                                    rows_data: this.rows.map(r => ({ id: r.id, q1_caps: r.q1_caps }))
                                })
                            });

                            if (response.ok) {
                                alert('{{ __('Saved successfully!') }}');
                            } else {
                                alert('{{ __('Failed to save.') }}');
                            }
                        } catch (error) {
                            console.error('Error saving:', error);
                            alert('{{ __('Error saving data.') }}');
                        } finally {
                            this.isSaving = false;
                        }
                    },
                    printPage() {
                        window.print();
                    }
                }));
        });
    </script>
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