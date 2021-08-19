<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasteController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user) {
            $pastes = $user->pastes;
        } else {
            return redirect(route('pastes.public'));
        }


        return view('pastes.index', [
            'pastes' => $pastes,
        ]);
    }

    public function public()
    {
        $pastes = Paste::all()->where('public', true);


        return view('pastes.public', [
            'pastes' => $pastes,
        ]);
    }

    public function create()
    {
        return view('pastes.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $guest = User::where('name', 'Guest')->first();


        $this->validate($request, [
            'content' => 'required',
            'public' => 'required',
        ]);

        $title = $request->input('title');
        if (!$title) {
            $title = "No title";
        }

        if ($user) {
            $paste = Paste::create([
                'title' => $title,
                'content' => $request->input('content'),
                'public' => $request->input('public'),
                'user_id' => $user->id
            ]);
            $paste->save();
        } else {
            $paste = Paste::create([
                'title' => $title,
                'content' => $request->input('content'),
                'public' => $request->input('public'),
                'user_id' => $guest->id
            ]);
            $paste->save();
        }


        return redirect(route('pastes.show', $paste));
    }

    public function destroy(Paste $paste)
    {
        $this->authorize('delete-paste', $paste);

        $paste->delete();
        return redirect(route('pastes.index'));
    }

    public function show(Paste $paste)
    {

        $this->authorize('view-paste', $paste);


        return view('pastes.show', [
            'paste' => $paste
        ]);
    }

    public function edit(Paste $paste)
    {
        $this->authorize('edit-paste', $paste);

        return view('pastes.edit', [
            'paste' => $paste
        ]);
    }

    public function update(Paste $paste, Request $request)
    {
        $this->authorize('edit-paste', $paste);

        $this->validate($request, [
            'content' => 'required',
        ]);

        $title = $request->input('title');
        if (!$title) {
            $title = "No title";
        }

        $paste->update([
                'title' => $title,
                'content' => $request->input('content')
            ]
        );

        return redirect(route('pastes.show', $paste));
    }

}
