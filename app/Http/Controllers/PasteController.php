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

        $paste = Paste::create([
            'content' => $request->input('content'),
            'user_id' => $user->id
        ]);
        $paste->save();

        return redirect(route('pastes.myPastes'));
    }

    public function destroy(Paste $paste)
    {
        $paste->delete();
        return redirect(route('pastes.myPastes'));
    }

    public function show(Paste $paste)
    {
        return view('pastes.show', [
            'paste' => $paste
        ]);
    }

    public function edit(Paste $paste)
    {

        return view('pastes.edit', [
            'paste' => $paste
        ]);
    }

    public function update(Paste $paste, Request $request)
    {

        //$data = $request->input('content');
        $paste->update([
            'content' => $request->input('content')
            ]
        );

        return redirect(route('pastes.myPastes'));
    }

}
