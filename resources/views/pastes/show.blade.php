<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-300 leading-tight ">
            Show Paste
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-second overflow-hidden shadow-sm sm:rounded-lg mb-3">
                <div class="p-6 bg-white">
                    <h3 class="font-semibold text-xl leading-tight ">{{ $paste->title }}</h3>
                    @if($paste->status == "public")
                        PUBLIC
                    @elseif($paste->status == "private")
                        PRIVATE
                    @else
                        NOT LISTED
                    @endif
                    | {{$paste->updated_at->format('d/m/y')}}
                        <div class="markdown-zone my-5 border-2 border-quote rounded-md px-2 py-2">
                            {{ Illuminate\Mail\Markdown::parse($paste->content ) }}
                        </div>
                    @if(Auth()->user() && $paste->user_id == Auth()->user()->id)
                    <a href="{{ route('pastes.edit', $paste->not_listed_id) }}">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </button>
                    </a>
                    <form id="del_paste_{{ $paste->not_listed_id }}" method="post"
                          action="{{ route('pastes.destroy', $paste->not_listed_id) }}" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                                type="submit" value="Delete">Delete
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('pastes.index') }}">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
