<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comments;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request,  User $user, Post $post)  
    {
        // dd($user->username);
        //validar
        $request->validate([
            'comment' => 'required|min:1|max:255'
        ]);

        //guardar

        Comments::create([
                'user_id' => auth()->user()->id,
                'post_id' => $post->id,
                'comment' => $request->comment
        ]);

        //imprimir mensaje
        return back()->with('message', '¡Tu comentario ha sido enviado');
    }
}
