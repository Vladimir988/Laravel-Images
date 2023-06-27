<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function __invoke()
    {
        dd(\request()->all());

//        return view('index');
    }
}
