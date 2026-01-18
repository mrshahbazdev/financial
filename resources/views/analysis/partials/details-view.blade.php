<!-- Analysis Table (Desktop) -->
<div class="desktop-table-view hidden md:block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ __($row->category) }}
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
                            {{ __($row->fix) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ number_format($row->haps, 1) }}%
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex items-center space-x-1">
                                <input type="number" x-model.number="rows.find(r => r.id === {{ $row->id }}).q1_caps"
                                    class="w-20 text-sm p-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white print:hidden"
                                    step="0.1">
                                <span class="print:inline hidden"
                                    x-text="rows.find(r => r.id === {{ $row->id }}).q1_caps + '%'"></span>
                                <span class="text-gray-400 print:hidden">%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex items-center space-x-1">
                                <input type="number" x-model.number="rows.find(r => r.id === {{ $row->id }}).q2_caps"
                                    class="w-20 text-sm p-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white print:hidden"
                                    step="0.1">
                                <span class="print:inline hidden"
                                    x-text="rows.find(r => r.id === {{ $row->id }}).q2_caps + '%'"></span>
                                <span class="text-gray-400 print:hidden">%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex items-center space-x-1">
                                <input type="number" x-model.number="rows.find(r => r.id === {{ $row->id }}).q3_caps"
                                    class="w-20 text-sm p-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white print:hidden"
                                    step="0.1">
                                <span class="print:inline hidden"
                                    x-text="rows.find(r => r.id === {{ $row->id }}).q3_caps + '%'"></span>
                                <span class="text-gray-400 print:hidden">%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex items-center space-x-1">
                                <input type="number" x-model.number="rows.find(r => r.id === {{ $row->id }}).q4_caps"
                                    class="w-20 text-sm p-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white print:hidden"
                                    step="0.1">
                                <span class="print:inline hidden"
                                    x-text="rows.find(r => r.id === {{ $row->id }}).q4_caps + '%'"></span>
                                <span class="text-gray-400 print:hidden">%</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Analysis Cards (Mobile) -->
<div class="mobile-card-view md:hidden space-y-4">
    @foreach($analysis->rows as $row)
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
            <div class="flex justify-between items-center mb-2">
                <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ __($row->category) }}</h4>
                <span
                    class="text-xs font-semibold px-2 py-1 rounded {{ $row->fix == 'Increase' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ __($row->fix) }}
                </span>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Actual') }}</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">
                        ${{ number_format($row->actual_amount, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">{{ __('PF Target') }}</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">
                        ${{ number_format($row->pf_amount, 2) }}</p>
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
                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ number_format($row->haps, 1) }}%
                    </p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Q1 CAPS') }}</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">
                        <span x-text="rows.find(r => r.id === {{ $row->id }}).q1_caps + '%'"></span>
                    </p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Q2 CAPS') }}</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">
                        <span x-text="rows.find(r => r.id === {{ $row->id }}).q2_caps + '%'"></span>
                    </p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Q3 CAPS') }}</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">
                        <span x-text="rows.find(r => r.id === {{ $row->id }}).q3_caps + '%'"></span>
                    </p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Q4 CAPS') }}</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">
                        <span x-text="rows.find(r => r.id === {{ $row->id }}).q4_caps + '%'"></span>
                    </p>
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
        <div class="relative h-96 w-full">
            <canvas id="analysisChart"></canvas>
        </div>
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
                        {{ __($row->category) }}:
                        <span class="font-bold">{{ __($row->fix) }}</span>
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