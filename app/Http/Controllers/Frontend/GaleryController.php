<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Route;
use Share;

class GaleryController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['user', 'likes'])->withCount('likes');

        $posts = $posts->when($request->has('keyword'), function($query) use ($request){
            $query->where(function($q) use ($request) {
                return $q->where('title', 'LIKE', "%$request->keyword%")
                    ->orWhereHas('user', function(Builder $query2) use ($request){
                        return $query2->where('name', 'LIKE', "%$request->keyword%");
                    });
            });
        });

        $posts = $posts->when($request->has('sort'), function($query) use ($request){
            switch ($request->sort) {
                case 'popularity':
                    $query->orderBy('likes_count', 'DESC');
                    break;
                default:
                    $query->orderBy('updated_at', 'DESC');
                    break;
            }
        });

        $posts = $posts->paginate(9)->withQueryString();

        $query = [
            'keyword' => $request->has('keyword') ? $request->keyword : null,
            'sort' => $request->has('sort') ? $request->sort : null
        ];

        return view('frontend.galery.index', compact('posts', 'query'));
    }

    public function show(Request $request, $slug = null)
    {
        $post = Post::where('slug', $slug)->first();

        return view('frontend.galery.show', compact('post'));
    }
}
