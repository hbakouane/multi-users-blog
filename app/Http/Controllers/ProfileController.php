<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index($username) {
        if ($username=='authors') {
            $authors = User::inRandomOrder()->paginate(18);
            return view('authors.index', [
                'authors' => $authors,
            ]);
        } else {
            $auth_user_id = Auth::id();
            $user = User::where('username', $username)->first();
            if (!isset($user)) {
                return view('errors.404');
            }
            $posts = Post::where('users_id', $user->id)
                            ->where('visibility', true)
                            ->paginate(4);
            $posts_count = Post::where('users_id', $user->id)
                            ->where('visibility', true)
                            ->get()
                            ->count();
            $views = Post::with('users')
                            ->whereHas('users', function($q) use ($username) { $q->where('username', $username); })
                            ->sum('views');
            return view('profile.show', [
                'auth_user_id' => $auth_user_id,
                'data' => $user,
                'posts' => $posts,
                'views' => $views,
                'posts_count' => $posts_count
            ]);
        }
    }
}
