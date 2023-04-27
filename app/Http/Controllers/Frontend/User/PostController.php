<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Post\CreatePostRequest;
use App\Models\Post;
use App\Services\PostServices;
use Illuminate\Http\Request;
use Storage;

class PostController extends Controller
{
    protected $postServices;

    /**
     * PostController constructor
     *
     *
     *
     * @param PostServices $postServices
     **/
    public function __construct(PostServices $postServices)
    {
        $this->postServices = $postServices;
    }

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
        $this->postServices->store($request->user(), $request->validated(), $request->file('thumbnail'));

        return redirect()->route('frontend.galery.index')->withFlashSuccess('Kamu Berhasil menambahkan Video ke dalam galery!');
    }
}
