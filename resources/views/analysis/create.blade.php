<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New Profit First Analysis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('analyses.store') }}" class="space-y-6">
                        @csrf

                        <!-- Real Revenue -->
                        <div>
                            <x-input-label for="real_revenue" :value="__('Real Revenue ($)')" />
                            <x-text-input id="real_revenue" class="block mt-1 w-full" type="number" step="0.01"
                                name="real_revenue" required autofocus />
                            <x-input-error :messages="$errors->get('real_revenue')" class="mt-2" />
                        </div>

                        <!-- Industry Selection -->
                        <div>
                            <x-input-label for="tap_id" :value="__('Select Industry (TAPS)')" />
                            <select id="tap_id" name="tap_id"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach($taps as $tap)
                                    <option value="{{ $tap->id }}">{{ $tap->industry }} (Profit {{ $tap->profit }}%)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h3 class="text-lg font-medium">Actual Numbers (Current Status)</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label for="actual_profit" :value="__('Actual Profit ($)')" />
                                    <x-text-input id="actual_profit" class="block mt-1 w-full" type="number" step="0.01"
                                        name="actual_profit" required />
                                </div>
                                <div>
                                    <x-input-label for="actual_pay" :value="__('Owner Pay ($)')" />
                                    <x-text-input id="actual_pay" class="block mt-1 w-full" type="number" step="0.01"
                                        name="actual_pay" required />
                                </div>
                                <div>
                                    <x-input-label for="actual_tax" :value="__('Tax ($)')" />
                                    <x-text-input id="actual_tax" class="block mt-1 w-full" type="number" step="0.01"
                                        name="actual_tax" required />
                                </div>
                                <div>
                                    <x-input-label for="actual_opex" :value="__('Operating Expenses ($)')" />
                                    <x-text-input id="actual_opex" class="block mt-1 w-full" type="number" step="0.01"
                                        name="actual_opex" required />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Run Analysis') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>