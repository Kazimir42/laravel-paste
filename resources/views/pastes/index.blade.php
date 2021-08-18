<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Pastes
        </h2>
    </x-slot>

    <div class="py-12">
        @foreach($pastes ?? '' as $paste)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <a href="{{ route('pastes.show', $paste) }}">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-3">
                        <div class="p-6 border-b border-gray-200">
                            {{$paste->id}}
                            <p>{{ $paste->content }}</p>

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
                </a>
        </div>
        @endforeach
    </div>
</x-app-layout>


