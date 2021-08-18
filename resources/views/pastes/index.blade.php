<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-300 leading-tight ">
            My Pastes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($pastes ?? '' as $paste)

                <div class="bg-white dark:bg-second overflow-hidden shadow-sm sm:rounded-lg mb-3">
                    <div class="p-6">
                        <h3 class="font-semibold text-xl text-gray-300 leading-tight ">{{ $paste->title }}</h3>

                        <textarea readonly rows="5"
                                  class="shadow appearance-none dark:bg-base border rounded w-full py-2 px-3 mb-2 leading-tight focus:outline-none focus:shadow-outline"
                                  name="content" id="content" type="text">{{ $paste->content }}</textarea>

                        <a href="{{ route('pastes.show', $paste) }}">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Show
                            </button>
                        </a>
                        <a href="{{ route('pastes.edit', $paste) }}">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </button>
                        </a>
                        <form id="del_task_{{ $paste->id }}" method="post"
                              action="{{ route('pastes.destroy', $paste) }}" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                                    type="submit" value="Delete">Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>


