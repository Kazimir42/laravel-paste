<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-300 leading-tight ">
            Show Paste
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>
                    {{ $paste->content }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
