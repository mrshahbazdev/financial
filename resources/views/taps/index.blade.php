<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Industries (TAPS)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Create New Action -->
            <div class="flex justify-end">
                <a href="{{ route('taps.create') }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Add Custom Industry</a>
            </div>

            <!-- My Custom Industries -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg overflow-x-auto">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">My Custom Industries</h3>
                    @if($myTaps->isEmpty())
                        <p class="text-gray-500">You haven't created any custom industries yet.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Industry
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Profit %
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner Pay %
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tax %</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">OPEX %</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($myTaps as $tap)
                                    <tr>
                                        <td class="px-6 py-4">{{ $tap->industry }}</td>
                                        <td class="px-6 py-4">{{ $tap->profit }}%</td>
                                        <td class="px-6 py-4">{{ $tap->owner_pay }}%</td>
                                        <td class="px-6 py-4">{{ $tap->tax }}%</td>
                                        <td class="px-6 py-4">{{ $tap->opex }}%</td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('taps.destroy', $tap) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <!-- System Defaults -->
            <div class="bg-gray-100 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg opacity-75">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">System Defaults (Read Only)</h3>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Industry
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Profit %
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner Pay %
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tax %</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">OPEX %</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($systemTaps as $tap)
                                <tr>
                                    <td class="px-6 py-4">{{ $tap->industry }}</td>
                                    <td class="px-6 py-4">{{ $tap->profit }}%</td>
                                    <td class="px-6 py-4">{{ $tap->owner_pay }}%</td>
                                    <td class="px-6 py-4">{{ $tap->tax }}%</td>
                                    <td class="px-6 py-4">{{ $tap->opex }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>