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
        $pastes = Paste::all()->where('status', 'public')->sortDesc();

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
            'status' => 'required',
        ]);

        $title = $request->input('title');
        if (!$title) {
            $title = "No title";
        }

        if ($user) {
            $paste = Paste::create([
                'title' => $title,
                'content' => $request->input('content'),
                'status' => $request->input('status'),
                'not_listed_id' => getRandomString(8),
                'user_id' => $user->id
            ]);
            $paste->save();
        } else {
            $paste = Paste::create([
                'title' => $title,
                'content' => $request->input('content'),
                'status' => $request->input('status'),
                'not_listed_id' => getRandomString(8),
                'user_id' => $guest->id
            ]);
            $paste->save();
        }


        return redirect(route('pastes.show', $paste->not_listed_id));
    }

    public function destroy($not_listed_id)
    {
        $paste = Paste::where('not_listed_id', $not_listed_id)->first();


        $this->authorize('delete-paste', $paste);

        $paste->delete();
        return redirect(route('pastes.index'));
    }

    public function show($not_listed_id)
    {
        $paste = Paste::where('not_listed_id', $not_listed_id)->first();


        $this->authorize('view-paste', $paste);


        return view('pastes.show', [
            'paste' => $paste
        ]);
    }

    public function edit($not_listed_id)
    {
        $paste = Paste::where('not_listed_id', $not_listed_id)->first();


        $this->authorize('edit-paste', $paste);

        return view('pastes.edit', [
            'paste' => $paste
        ]);
    }

    public function update($not_listed_id, Request $request)
    {
        $paste = Paste::where('not_listed_id', $not_listed_id)->first();


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
                'content' => $request->input('content'),
                'status' => $request->input('status')
            ]
        );

        return redirect(route('pastes.show', $paste->not_listed_id));
    }

}
