@extends('layouts.app')
@section('titulo')
    Perfil: {{$user->username}}
@endsection
@section('contenido')
<div class="flex justify-center">
    <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
        <div class="w-8/12 lg:w-6/12 px-5">
            <img src="{{asset('img/usuario.svg')}}" alt="imagen usuario">
        </div>

        <div class="md:w-8/12 lg:w-6/12 flex px-5 flex-col md:justify-center items-center py-10 md:py-10 md:items-start"> 
            <p class="text-gray-700 text2xl">
                {{$user->username}}
            </p>
            <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                0
                <span class="font-normal"> Seguidores</span>
            </p>    
            <p class="text-gray-800 text-sm mb-3 font-bold">
                0
                <span class="font-normal">Siguiendo</span>
            </p>
            <p class="text-gray-800 text-sm mb-3 font-bold">
                0
                <span class="font-normal">Posts</span>
            </p>
        </div>

    </div>
</div>

<section class="container mx-auto mt-10">
    <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>
    @if($posts->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($posts as $post)
            <div class="p-5 bg-white rounded-lg shadow-xl">
                <a href="{{route('posts.show', ['user' => $user, 'post' => $post]) }}">
                    <img src="{{ asset('uploads') . '/' . $post->image}}" alt="imagen del post {{$post->title}}" >
                </a>

            </div>
        @endforeach
    </div>
    
    <div class="my-10">
        {{$posts->links('pagination::tailwind')}}
    </div>

    @else
    <p class="text-gray-600 uppercase text-sm text-center font-bold">¡Este usuario todavía no ha publicado!</p>
    @endif
</section>
  
@endsection