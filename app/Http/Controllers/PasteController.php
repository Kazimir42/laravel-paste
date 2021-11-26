<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PasteController extends Controller
{
    public function index()
    {
        $user = Auth::user();


        $pastes = $user->pastes()->orderByDesc('updated_at')->paginate(5);


        return view('pastes.index', [
            'pastes' => $pastes,
        ]);
    }

    public function public()
    {
        $pastes = Paste::where('status', 'public')->orderByDesc('updated_at')->paginate(5);

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
            'type' => 'required',
            'password' => '',
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
                'type' => $request->input('type'),
                'password' => $request->input('password'),
                'not_listed_id' => getRandomString(8),
                'user_id' => $user->id
            ]);
            $paste->save();
        } else {
            if ($request->input('status') == 'private'){
                abort('403');
            }
            $paste = Paste::create([
                'title' => $title,
                'content' => $request->input('content'),
                'status' => $request->input('status'),
                'type' => $request->input('type'),
                'password' => $request->input('password'),
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
        if(!$paste){
            abort(404);
        }

        $this->authorize('delete-paste', $paste);

        $paste->delete();
        return redirect(route('pastes.index'));
    }

    public function show($not_listed_id)
    {
        $paste = Paste::where('not_listed_id', $not_listed_id)->first();


        if(!$paste){
            abort(404);
        }

        $this->authorize('view-paste', $paste);


        return view('pastes.show', [
            'paste' => $paste
        ]);
    }

    public function edit($not_listed_id)
    {
        $paste = Paste::where('not_listed_id', $not_listed_id)->first();
        if(!$paste){
            abort(404);
        }

        if (Cookie::get('paste') == $paste->password){
            return view('pastes.edit', [
                'paste' => $paste
            ]);
        }

        $this->authorize('edit-paste', $paste);

        return view('pastes.edit', [
            'paste' => $paste
        ]);
    }

    public function update($not_listed_id, Request $request)
    {
        $paste = Paste::where('not_listed_id', $not_listed_id)->first();
        if(!$paste){
            abort(404);
        }

        if (!Cookie::get('paste') == $paste->password) {
            $this->authorize('edit-paste', $paste);
        }


        $this->validate($request, [
            'content' => 'required',
            'status' => 'required',
            'type' => 'required',
            'password' => '',
        ]);

        $title = $request->input('title');
        if (!$title) {
            $title = "No title";
        }

        $paste->update([
                'title' => $title,
                'content' => $request->input('content'),
                'status' => $request->input('status'),
                'type' => $request->input('type'),
                'password' => $request->input('password'),
            ]
        );

        return redirect(route('pastes.show', $paste->not_listed_id));
    }

    public function password($not_listed_id){
        $paste = Paste::where('not_listed_id', $not_listed_id)->first();
        if(!$paste){
            abort(404);
        }
        if(!$paste->password){
            abort(403);
        }

        return view('pastes.password', [
            'paste' => $paste
        ]);
    }

    public function password_check($not_listed_id, Request $request)
    {
        $paste = Paste::where('not_listed_id', $not_listed_id)->first();
        if(!$paste){
            abort(404);
        }

        //$this->authorize('edit-paste', $paste);

        $this->validate($request, [
            'password' => 'required',
        ]);

        if ($request->password === $paste->password){
            Cookie::queue(Cookie::make('paste', $paste->password, 120));
            return redirect(route('pastes.edit', $paste->not_listed_id));
        }else{
            return redirect(route('pastes.password', $paste->not_listed_id));
        }


    }

}
