<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class SearchController extends Controller
{
    public function index(Request $request) {

        $query = $request->Input('search');
        // search in the posts table
        $posts = Post::where('title', 'like', "%$query%")/*->orWhere('body', 'like', "%$query%")*/->paginate(15);
        $posts_count = Post::where('title', 'like', "%$query%")/*->orWhere('body', 'like', "%$query%")*/->get()->count();
        // search in the users table
        $users = User::where('name', 'like', "%$query%")->orWhere('username', 'like', "$query")->paginate(15);
        $users_count = User::where('name', 'like', "%$query%")->orWhere('username', 'like', "$query")->get()->count();
        // search in the comments table
        $comments = Comment::with('users')->where('comments', 'like', "%$query%")->paginate(15);
        $comments_count = Comment::with('users')->where('comments', 'like', "%$query%")->get()->count();

        return view('search.search_results', [
            'posts' => $posts,
            'users' => $users,
            'comments' => $comments,
            'posts_count' => $posts_count,
            'users_count' => $users_count,
            'comments_count' => $comments_count,
        ]);
        
    }
}
