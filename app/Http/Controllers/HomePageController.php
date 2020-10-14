<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function index() {
        $random_title = Post::inRandomOrder()->where('visibility', true)->limit(1)->get();
        foreach($random_title as $random_post) {
            //
        }
        $posts = Post::with(['users', 'categories'])->where('visibility', true)->orderByDesc('id')->paginate(9);

        return view('homepage', [
            'posts' => $posts,
            'random_post' => $random_post ?? null,
        ]);
    }
}
