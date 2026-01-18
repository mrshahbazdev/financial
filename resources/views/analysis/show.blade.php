<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profit First Analysis Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Actions -->
            <div class="mb-4 flex justify-end">
                <a href="{{ route('analyses.pdf', $analysis) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Download PDF Report') }}
                </a>
            </div>

            <!-- Summary Header -->
            <div class="mb-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Details') }}</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Real Revenue:') }}
                    ${{ number_format($analysis->real_revenue, 2) }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Date:') }}
                    {{ $analysis->created_at->format('M d, Y') }}
                </p>
            </div>

            <!-- Analysis Table (Desktop) -->
            <div class="hidden md:block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Category') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Actual') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('TAPS %') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('PF $') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('The Bleed') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('The Fix') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('HAPS %') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Q1 CAPS') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Q2 CAPS') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Q3 CAPS') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Q4 CAPS') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($analysis->rows as $row)
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $row->category }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        ${{ number_format($row->actual_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $row->taps_percentage }}%
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        ${{ number_format($row->pf_amount, 2) }}</td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm {{ $row->bleed < 0 ? 'text-red-500' : 'text-green-500' }}">
                                        ${{ number_format($row->bleed, 2) }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $row->fix == 'Increase' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $row->fix }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ number_format($row->haps, 1) }}%
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ number_format($row->q1_caps, 1) }}%
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ number_format($row->q2_caps, 1) }}%
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ number_format($row->q3_caps, 1) }}%
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ number_format($row->q4_caps, 1) }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Analysis Cards (Mobile) -->
            <div class="md:hidden space-y-4">
                @foreach($analysis->rows as $row)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $row->category }}</h4>
                            <span class="text-xs font-semibold px-2 py-1 rounded {{ $row->bleed < 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $row->fix }}
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('Actual') }}</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">${{ number_format($row->actual_amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('PF Target') }}</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">${{ number_format($row->pf_amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('Bleed') }}</p>
                                <p class="font-medium {{ $row->bleed < 0 ? 'text-red-500' : 'text-green-500' }}">
                                    ${{ number_format($row->bleed, 2) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('TAPS %') }}</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $row->taps_percentage }}%</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 grid grid-cols-2 gap-2 text-xs">
                             <div>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('HAPS') }}</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ number_format($row->haps, 1) }}%</p>
                            </div>
                             <div>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('Q1 CAPS') }}</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ number_format($row->q1_caps, 1) }}%</p>
                            </div>
                             <div>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('Q2 CAPS') }}</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ number_format($row->q2_caps, 1) }}%</p>
                            </div>
                             <div>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('Q3 CAPS') }}</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ number_format($row->q3_caps, 1) }}%</p>
                            </div>
                             <div>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('Q4 CAPS') }}</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ number_format($row->q4_caps, 1) }}%</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Annual Summary Section -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Chart Section -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Actual vs Target (TAPS)') }}
                    </h3>
                    <canvas id="analysisChart"></canvas>
                </div>

                <!-- Summary Text -->
                <div
                    class="bg-indigo-50 dark:bg-indigo-900 border border-indigo-200 dark:border-indigo-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-indigo-900 dark:text-indigo-100">{{ __('Annual Summary') }}</h3>
                    <p class="mt-2 text-sm text-indigo-700 dark:text-indigo-300">
                        {{ __('Total Allocation:') }} ${{ number_format($analysis->rows->sum('pf_amount'), 2) }}
                    </p>

                    <h4 class="mt-4 font-bold text-indigo-900 dark:text-indigo-100">{{ __('Money Moves (The Fix)') }}
                    </h4>
                    <ul class="mt-2 list-disc list-inside text-sm text-indigo-700 dark:text-indigo-300">
                        @foreach($analysis->rows as $row)
                            @if($row->bleed != 0)
                                <li>
                                    {{ $row->category }}:
                                    <span class="font-bold">{{ $row->fix }}</span>
                                    {{ __('by') }} ${{ number_format(abs($row->bleed), 2) }}
                                    @if($row->fix == 'Increase')
                                        {{ __('(Allocated too little)') }}
                                    @else
                                        {{ __('(Spent too much / Allocated too much)') }}
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('analyses.create') }}"
                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">{!! __('Start New Analysis &rarr;') !!}</a>
            </div>
        </div>
    </div>

    <script type="module">
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('analysisChart');

            const labels = @json($analysis->rows->pluck('category'));
            const actuals = @json($analysis->rows->pluck('actual_amount'));
            const targets = @json($analysis->rows->pluck('pf_amount'));

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Actual ($)',
                            data: actuals,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Target (PF $)',
                            data: targets,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
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
    </script>
</x-app-layout>