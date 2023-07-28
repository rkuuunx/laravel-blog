<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    private $post;
    const LOCAL_STORAGE_FOLDER = 'public/images/';
    public function __construct(Post $post){
        $this->post = $post;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $all_posts = $this->post->latest()->get();

        return view('posts.index')
              ->with('all_posts',$all_posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->post->user_id = Auth::user()->id;
        $this->post->title = $request->title;
        $this->post->body = $request->body;
        $this->post->image = $this->uploadImage($request);

        $this->post->save();

        return redirect()->route('index');

    }
    public function uploadImage($request){
        #changing image name
        #image_name = 1690373852.jpeg
        $image_name = time().".".$request->image->extension();

        $request->image->storeAs(self::LOCAL_STORAGE_FOLDER,$image_name);

        return $image_name;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $post = $this->post->findOrFail($id);

        return view('posts.show')->with('post',$post);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $post = $this->post->findOrFail($id);

        return view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $post = $this->post->findOrFail($id);
        $post->title = $request->title;
        $post->body = $request->body;

        if($request->image){// if the user will upload a new image
            $this->delete_image($post->image);

            $post->image = $this->uploadImage($request);
        }
        $post->save();

        return redirect()->route('posts.show',$post->id);
    }
    public function delete_image($image_name){
        $image_path = self::LOCAL_STORAGE_FOLDER.$image_name;
        // path = public/images/178123.jpeg
        if(Storage::disk('local')->exists($image_path)){
            Storage::disk('local')->delete($image_path);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
