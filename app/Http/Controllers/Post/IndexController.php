<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Image;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function __invoke()
    {
//        $data   = $request->validated();
//        $images = $data['images'] ?? [];
//
//        unset($data['images']);
//
//        $post = Post::firstOrCreate($data);
//
//        foreach ($images as $image) {
//            $name = md5(Carbon::now().'_'.$image->getClientOriginalName()).'.'.$image->getClientOriginalExtension();
//            $filePath = Storage::disk('public')->putFileAs('/images', $image, $name);
//
//            Image::create([
//                'path'    => $filePath,
//                'url'     => url('/storage/' . $filePath),
//                'post_id' => $post->id,
//            ]);
//        }

        $post = Post::latest()->first();
//        echo "<pre>";
//        var_dump($post);
//        echo "</pre>";
//        exit;

        return new PostResource($post);
    }
}
