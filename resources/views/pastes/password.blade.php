<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-300 leading-tight ">
            Edit Paste
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-second overflow-hidden shadow-sm sm:rounded-lg mb-3">
                <div class="p-6 bg-white">
                    <h3 class="font-semibold text-xl leading-tight mb-4">{{ $paste->title }}</h3>

                    <form method="post" action="{{ route('pastes.password-check', $paste->not_listed_id) }}">
                        @csrf
                        @method('PUT')
                        <input class="shadow appearance-none dark:bg-base border rounded w-full py-2 px-3 mb-2 leading-tight focus:outline-none focus:shadow-outline" name="password" id="password" type="text" placeholder="Password">

                        <div>
                            <button class="bg-primary hover:bg-dark-primary text-white font-bold py-2 px-4 rounded duration-200" type="submit" value="Unlock The Paste">Unlock The Paste</button>
                            <a href="{{ route('pastes.index') }}">
                                <button class="bg-primary hover:bg-dark-primary text-white font-bold py-2 px-4 rounded duration-200">
                                    Cancel
                                </button>
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
