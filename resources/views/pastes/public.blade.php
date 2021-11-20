<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-300 leading-tight ">
            Public Pastes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-second overflow-hidden shadow-sm sm:rounded-lg mb-3">
                <div class="">
                    <a href="{{ route('pastes.create') }}">
                        <button class="mx-6 my-3 bg-primary hover:bg-dark-primary text-white font-bold py-2 px-4 rounded duration-200 float-right">
                            + New Paste
                        </button>
                    </a>
                </div>
            </div>
            @foreach($pastes ?? '' as $paste)
                <div class="bg-white dark:bg-second overflow-hidden shadow-sm sm:rounded-lg mb-3">
                    <div class="p-6">
                        <h3 class="font-semibold text-xl leading-tight ">{{ $paste->title }}</h3>
                        Creator : {{$paste->user->name}} | {{$paste->updated_at->format('d/m/y')}}

                        <textarea readonly rows="5"
                                  class="shadow appearance-none dark:bg-base border rounded w-full py-2 px-3 mb-2 leading-tight focus:outline-none focus:shadow-outline"
                                  name="content" id="content" type="text">{{ $paste->content }}</textarea>

                        <a href="{{ route('pastes.show', $paste->not_listed_id) }}">
                            <button class="bg-primary hover:bg-dark-primary text-white font-bold py-2 px-4 rounded duration-200">
                                Show
                            </button>
                        </a>
                        @if(auth()->user() && $paste->user->id == auth()->user()->id)
                        <a href="{{ route('pastes.edit', $paste->not_listed_id) }}">
                            <button class="bg-primary hover:bg-dark-primary text-white font-bold py-2 px-4 rounded duration-200">
                                Edit
                            </button>
                        </a>
                        <form id="del_task_{{ $paste->not_listed_id }}" method="post"
                              action="{{ route('pastes.destroy', $paste->not_listed_id) }}" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="bg-primary hover:bg-dark-primary text-white font-bold py-2 px-4 rounded duration-200"
                                    type="submit" value="Delete">Delete
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>


