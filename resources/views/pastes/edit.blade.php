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
                    <form method="post" action="{{ route('pastes.update', $paste->not_listed_id) }}">
                        @csrf
                        @method('PUT')
                        <input class="shadow appearance-none dark:bg-base border rounded w-full py-2 px-3 mb-2 leading-tight focus:outline-none focus:shadow-outline" name="title" id="title" type="text" placeholder="Title" value="{{$paste->title}}">
                        <textarea rows="20" class="shadow appearance-none dark:bg-base border rounded w-full py-2 px-3 mb-1 leading-tight focus:outline-none focus:shadow-outline" name="content" id="content" type="text">{{ $paste->content }}</textarea>
                        <select class="shadow appearance-none dark:bg-base border rounded w-full py-2 px-3 mb-2 leading-tight focus:outline-none focus:shadow-outline" name="status">
                            <option {{$paste->status == "public" ? "selected":""}} value="public">Public</option>
                            <option {{$paste->status == "private" ? "selected":""}} value="private">Private</option>
                            <option {{$paste->status == "not_listed" ? "selected":""}} value="not_listed">Not listed</option>
                        </select>
                        <div class="flex flex-row items-baseline justify-between">
                            <div>
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit" value="Edit">Save</button>
                                <a href="{{ route('pastes.index') }}">
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Cancel
                                    </button>
                                </a>
                            </div>
                            <div class="text-gray-300">markdown is activate</div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
