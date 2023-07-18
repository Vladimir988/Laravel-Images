<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Image;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageManager;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Post $post)
    {
        $data              = $request->validated();
        $images            = $data['images'] ?? [];
        $imageIdsForDelete = $data['image_ids_for_delete'] ?? [];

        unset($data['images']);
        unset($data['image_ids_for_delete']);

//        $post = Post::firstOrCreate($data);



        if (! empty($images)) {
            foreach ($images as $image) {
                $name = md5(Carbon::now() . '_' . $image->getClientOriginalName()) . '.'
                    . $image->getClientOriginalExtension();
                $prevName = 'prev_' . $name;
                $filePath = Storage::disk('public')->putFileAs('/images', $image, $name);

                Image::create([
                    'path'        => $filePath,
                    'url'         => url('/storage/' . $filePath),
                    'preview_url' => url('/storage/images/' . $prevName),
                    'post_id'     => $post->id,
                ]);

                ImageManager::make($image)->fit(100, 100)->save(storage_path('app/public/images/' . $prevName));
            }
        }

        return response()->json(['message' => 'success']);
    }
}
