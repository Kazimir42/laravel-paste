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
                        <div class="flex flex-row gap-2">
                            <select class="shadow appearance-none dark:bg-base border rounded w-full py-2 px-3 mb-2 leading-tight focus:outline-none focus:shadow-outline" name="status">
                                <option {{$paste->status == "public" ? "selected":""}} value="public">Public</option>
                                <option {{$paste->status == "private" ? "selected":""}} value="private">Private</option>
                                <option {{$paste->status == "not_listed" ? "selected":""}} value="not_listed">Not listed</option>
                            </select>
                            <select class="shadow appearance-none dark:bg-base border rounded w-full py-2 px-3 mb-2 leading-tight focus:outline-none focus:shadow-outline" name="type">
                                <option {{$paste->type == "raw" ? "selected":""}} value="raw">Raw text</option>
                                <option {{$paste->type == "markdown" ? "selected":""}} value="markdown">Markdown</option>
                            </select>
                        </div>
                        <div class="flex flex-row gap-2 pl-1 w-1/2 ml-auto">
                            @if($paste->password)
                                <input type="checkbox" checked onclick="document.getElementById('password').classList.contains('cursor-not-allowed')?document.getElementById('password').classList.remove('cursor-not-allowed'):document.getElementById('password').classList.add('cursor-not-allowed');  document.getElementById('password').disabled?document.getElementById('password').disabled = false:document.getElementById('password').disabled = true; document.getElementById('password').value = '';" class="shadow appearance-none dark:bg-base border rounded h-auto text-primary w-9 py-2 px-3 mb-2 leading-tight focus:outline-none focus:shadow-outline" name="checkPass">
                                <input type="text" id="password" class="shadow appearance-none dark:bg-base border rounded w-full py-2 px-3 mb-2 leading-tight focus:outline-none focus:shadow-outline" placeholder="Password" name="password" value="{{$paste->password}}">
                            @else
                                <input type="checkbox" onclick="document.getElementById('password').classList.contains('cursor-not-allowed')?document.getElementById('password').classList.remove('cursor-not-allowed'):document.getElementById('password').classList.add('cursor-not-allowed');  document.getElementById('password').disabled?document.getElementById('password').disabled = false:document.getElementById('password').disabled = true; document.getElementById('password').value = '';" class="shadow appearance-none dark:bg-base border rounded h-auto text-primary w-9 py-2 px-3 mb-2 leading-tight focus:outline-none focus:shadow-outline" name="checkPass">
                                <input type="text" disabled id="password" class="shadow appearance-none cursor-not-allowed dark:bg-base border rounded w-full py-2 px-3 mb-2 leading-tight focus:outline-none focus:shadow-outline" placeholder="Password" name="password" value="{{$paste->password}}">
                            @endif
                        </div>
                        <div>
                            <button class="bg-primary hover:bg-dark-primary text-white font-bold py-2 px-4 rounded duration-200" type="submit" value="Edit">Save</button>
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
