<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Models\Post;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data   = $request->validated();
        $images = $data['images'] ?? [];

        unset($data['images']);

        $post = Post::firstOrCreate($data);
        dd(1111111);

        foreach ($images as $image) {

        }
        dd($data);
//        return view('index');
    }
}
