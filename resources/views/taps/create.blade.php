<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Custom Industry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('taps.store') }}" class="space-y-6">
                        @csrf

                        <!-- Industry Name -->
                        <div>
                            <x-input-label for="industry" :value="__('Industry Name')" />
                            <x-text-input id="industry" class="block mt-1 w-full" type="text" name="industry"
                                :value="old('industry')" required autofocus placeholder="e.g. Digital Agency" />
                            <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                        </div>

                        <!-- Percentages -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="profit" :value="__('Profit Target (%)')" />
                                <x-text-input id="profit" class="block mt-1 w-full" type="number" step="0.1"
                                    name="profit" :value="old('profit')" required />
                            </div>
                            <div>
                                <x-input-label for="owner_pay" :value="__('Owner Pay Target (%)')" />
                                <x-text-input id="owner_pay" class="block mt-1 w-full" type="number" step="0.1"
                                    name="owner_pay" :value="old('owner_pay')" required />
                            </div>
                            <div>
                                <x-input-label for="tax" :value="__('Tax Target (%)')" />
                                <x-text-input id="tax" class="block mt-1 w-full" type="number" step="0.1" name="tax"
                                    :value="old('tax')" required />
                            </div>
                            <div>
                                <x-input-label for="opex" :value="__('OPEX Target (%)')" />
                                <x-text-input id="opex" class="block mt-1 w-full" type="number" step="0.1" name="opex"
                                    :value="old('opex')" required />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save Industry') }}</x-primary-button>
                            <a href="{{ route('taps.index') }}"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>