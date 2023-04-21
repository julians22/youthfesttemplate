<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Post\CreatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Storage;

class PostController extends Controller
{
    public function index()
    {
        # code...
    }

    public function create()
    {
        return view('frontend.user.post.create');
    }

    public function store(CreatePostRequest $request)
    {

        // $name =

        // Storage::disk('public')->put('filename', $file_content);


        $post = Post::create([
            'title' => $request->title,
            'user_id' => auth()->user()->id,
        ]);

        $file = $request->file('thumbnail');

        $thumbnailPath = 'YouthFest-'.$post->slug.'.'.$file->extension();
        $fileUpload = $file->storeAs(date('Y-m-d'), $thumbnailPath, 'post_thumbnail');

        $post->video()->create([
            'url' => $request->url,
            'type' => $request->type,
            'thumbnail' => $fileUpload
        ]);

        return redirect()->route('frontend.galery.index')->withFlashSuccess('Kamu Berhasil menambahkan Video ke dalam galery!');
    }
}
