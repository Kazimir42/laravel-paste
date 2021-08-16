<?php

namespace App\Http\Controllers;

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
}
