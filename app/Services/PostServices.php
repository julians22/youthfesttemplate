<?php

namespace App\Services;

use App\Domains\Auth\Models\User;
use App\Exceptions\GeneralException;
use App\Models\Post;
use App\Models\Video;
use App\Services\BaseService;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class PostServices extends BaseService
{

    protected $videoModel;

    /**
     * PostServices constructor
     **/
    public function __construct(Post $post, Video $video)
    {
        $this->model = $post;
        $this->videoModel = $video;
    }

    public function store(User $user, array $data = [], UploadedFile $thumbnail = null)
    {

        $path = '';

        DB::beginTransaction();

        try {
            $post = $this->createPost([
                'title' => $data['title'],
                'user_id' => $user->id
            ]);

            if ($thumbnail) {
                $thumbnailPath = 'YouthFest-'.$post->slug.'.'.$thumbnail->extension();
                $fileUpload = $thumbnail->storeAs(date('Y-m-d'), $thumbnailPath, 'post_thumbnail');
                $path = $fileUpload;
                $this->resizeImage($fileUpload);
            }

            $this->createVideo([
                'url' => $data['url'],
                'post_id' => $post->id,
                'type' => $data['type'],
                'thumbnail' => $path
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem creating your post.' . $e->getMessage()));
        }

        DB::commit();

        return $post;
    }

    protected function createPost(array $data = [])
    {
        return $this->model::create([
            'title' => $data['title'],
            'user_id' => $data['user_id'],
        ]);;
    }

    protected function createVideo(array $data = []){

        return $this->videoModel::create([
            'url' => $data['url'],
            'type' => $data['type'],
            'post_id' => $data['post_id'],
            'thumbnail' => $data['thumbnail'] ?? null
        ]);
    }

    protected function resizeImage($path = null, $folderName = 'post_thumbnails'){
        if ($path) {

            $folderName = "storage".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;

            $fullPath = public_path($folderName.$path);

            // dd($fullPath);

            $image = Image::make($fullPath)->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save($fullPath, 80);
        }
    }

}
