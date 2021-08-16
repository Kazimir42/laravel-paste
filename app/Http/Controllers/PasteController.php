<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasteController extends Controller
{
    public function index()
    {

        return view('pastes.index', [

        ]);
    }
}
