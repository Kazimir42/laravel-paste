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
        $pastes = $user->pastes;

        return view('pastes.index', [
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

        $this->validate($request, [
            'content' => 'required',
        ]);

        $paste = Paste::create([
            'content' => $request->input('content'),
            'user_id' => $user->id
        ]);
        $paste->save();

        return redirect(route('pastes.index'));
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

        $paste->update([
            'content' => $request->input('content')
            ]
        );

        return redirect(route('pastes.index'));
    }

}
