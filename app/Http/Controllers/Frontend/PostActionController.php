<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Arr;
use Cookie;
use Illuminate\Http\Request;

class PostActionController extends Controller
{
    public function like(Request $request, Post $post)
    {

        if (!$request->user()) {
            return response()->json(
                [
                    'post' => $post->likeCount,
                    'message' => 'not_logged_in'
                ],
                401
                );
        }

        $post->like($request->user()->id);

        $data = [
            'post' => $post,
            'message' => 'Berhasil sukai item'
        ];

        return response()->json($data);
    }

    public function unlike(Request $request, Post $post)
    {

        if (!$request->user()) {
            return response()->json(
                [
                    'post' => $post->likeCount,
                    'message' => 'not_logged_in'
                ],
                401
                );
        }

        $post->unlike($request->user()->id);

        $data = [
            'post' => $post,
            'message' => 'Berhasil sukai item'
        ];

        return response()->json($data);
    }

    public function share(Request $request, Post $post)
    {
        $userExist = !empty($request->user());
        $shareTimes = $request->cookie('shareTimes');
        $expires = 1440;

        $id = $post->id;

        if ($shareTimes == 0 || empty($shareTimes)) {
            $shareTimes = $id;

            $cookie = Cookie::make('shareTimes', $shareTimes, $expires, '/');

            // dd($cookie);

            return response()->json([
                'message' => 'success',
                'action' => 'make_cookie',
                'cookie' => $cookie
            ])->withCookie($cookie);
        }else{
            $existsShare = explode(",", $shareTimes);

            $match = Arr::first($existsShare, function(int $value, int $key) use ($id){
                return $value == $id;
            });

            if ($match) {
                return response()->json([
                    'message' => 'success',
                    'action' => 'cookie_exists'
                ]);
            }

            $shareTimes .= ",$id";
            $cookie = Cookie::make('shareTimes', $shareTimes, $expires, '/');
        }

        return response()->json([
            'cookie' => $cookie,
            'action' => 'cookie_added',
            'message' => 'success'
        ])->withCookie($cookie);

    }

    public function testCookie(Request $request, Post $post)
    {
        dd(Cookie::get('shareTimes'));
    }
}
