<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Analyses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end">
                <a href="{{ route('analyses.create') }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">New Analysis</a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($analyses->isEmpty())
                        <p>No analyses found. Start one!</p>
                    @else
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($analyses as $analysis)
                                <li class="py-4 flex justify-between items-center">
                                    <div>
                                        <p class="text-lg font-medium">Analysis #{{ $analysis->id }}</p>
                                        <p class="text-sm text-gray-500">Revenue:
                                            ${{ number_format($analysis->real_revenue, 2) }} •
                                            {{ $analysis->created_at->diffForHumans() }}</p>
                                    </div>
                                    <a href="{{ route('analyses.show', $analysis) }}"
                                        class="text-indigo-600 hover:underline">View Results</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>