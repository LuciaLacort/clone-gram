<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->paginate(20);
        return view('dashboard', [
            'user' => $user,
            'posts' => $posts  //Aquí accedemos a los posts de cada usuario
        ]);
    }

    public function create (){
        return view('posts.create');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'required'    
        ]);

        $request->user()->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image
        ]);

        return redirect()->route('posts.index', $request->user()->username);
    }
    
    public function show(User $user, Post $post)
    {
        return view ('posts.show',[
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        //eliminar la imagen
        $image_path = public_path('uploads/' . $post->image);
        if(File::exists($image_path)){
            unlink($image_path);
        }
        return redirect()->route('posts.index', auth()->user()->username);
    }
}

