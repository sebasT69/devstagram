<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Faker\Core\File;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class PostController extends Controller
{
    //

    public function __construct()
    {
        //Midelware para que verifique a los usuarios
        $this->middleware('auth')->except(['show','index']);
    }

    public function index(User $user){

        $posts = Post::where('user_id', $user->id)->paginate(3);
        return view('dashboard', ['user'=>$user, 'posts'=>$posts]);
    }

    public function create(){
        return view('posts.create');
    }

    public function store(Request $request){

        $this->validate($request,[
            'titulo'=>'required|max:255',
            'descripcion'=>'required',
            'imagen'=>'required',

        ]);

        Post::create([
            'titulo' => $request->titulo,
            'descripcion'=>$request->descripcion,
            'imagen'=>$request->imagen,
            'user_id'=>auth()->user()->id
        ]);

        //Guardar registros usando las relaciones
        /*$request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion'=>$request->imagen,
            'imagen'=>$request->imagen,
            'user_id'=>auth()->user()->id
        ]);*/


        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post ){

        return view('posts.show', ['post'=>$post, 'user'=>$user]);
    }

    public function destroy(Post $post){
        $this->authorize('delete',$post);
        $post->delete();

        //eliminar la imagen
        $imagen_path=public_path('uploads/'.$post->imagen);

        if(file_exists($imagen_path)){
            unlink($imagen_path);
            
        }

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
