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

        return redirect(route('pastes.index'));
    }

    public function destroy(Paste $paste)
    {

        return redirect(route('pastes.index'));
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

        return redirect(route('pastes.index'));
    }

}
