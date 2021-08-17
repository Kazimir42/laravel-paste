<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Paste
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="post" action="{{ route('pastes.update', $paste) }}">
                        @csrf
                        @method('PUT')
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 mb-2 leading-tight focus:outline-none focus:shadow-outline" name="content" id="content" type="text" style="height: 8em">{{ $paste->content }}</textarea>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit" value="Edit">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
