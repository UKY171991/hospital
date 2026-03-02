<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($title) }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="h5 mb-2">{{ $title }}</h3>
                    <p class="mb-0">This pathology page is now available from the Pathology menu.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
