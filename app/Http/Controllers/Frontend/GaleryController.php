<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Http;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

        $video = collect([]);

        if ($post->hasVideo()) {
            $postVideo = $post->video;
            switch ($postVideo->type) {
                case 'tiktok':
                    $data = Http::get('https://www.tiktok.com/oembed', [
                        'url' => $postVideo->url
                    ]);

                    $video['data'] = json_decode($data);
                    $video['type'] = 'tiktok';
                    break;
                case 'youtube':
                    $data = Http::get('https://youtube.com/oembed', [
                        'url' => $postVideo->url,
                        'format' => 'json'
                    ]);
                    // dd($data->body());
                    $video['data'] = json_decode($data->body());
                    $video['type'] = 'tiktok';

                    break;
                default:
                    # code...
                    break;
            }
        }

        return view('frontend.galery.show', compact('post', 'video'));
    }
}
