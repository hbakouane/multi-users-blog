<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['categories', 'users'])->where('users_id', Auth::id())->orderByDesc('id')->paginate(7);
        $comments = Comment::where('users_id', Auth::id())->get();
        return view("posts.my_posts", [
            'posts' => $posts,
            'comments' => $comments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = categories::all();
        return view("posts.create", [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check the form and make it valid
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:30|max:120',
            'content' => 'required|min:120',
            'category_select' => 'required',
            'comments_approval' => 'in:1,0',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('posts/create')
                ->withErrors($validator)
                ->withInput();
        } else {

            // Deal with the post image
            if ($request->hasFile('image')) {
                if ($request->file('image')->isValid()) {
                    $validated = $request->validate([
                        'image' => 'required|image|max:2000|mimes:png,jpeg,gif,jpg|',
                    ]);
                    $extension = $request->file('image')->extension();
                    $image_name = uniqid('', true).".".$extension;
                    /*Storage::put(
                        "public/images/posts_images/$image_name",
                        file_get_contents($request->file('image')->getRealPath())
                    );*/
                    $request->file('image')->storeAs('public/images/posts_images', "$image_name");
                }
            }
            // Store data
            $auth_user_id = Auth::id();
            $post = new Post();
            $post->title = $request->input('title');
            $post->slug = Str::slug($request->input('title'), '-');
            $post->body = $request->input('content');
            $post->users_id = $auth_user_id;
            $post->comments = $request->input('comments_approval');
            $post->post_image = $image_name;
            $post->categories_id = $request->input('category_select');
            $post->visibility = 1; // Make the post visible by default on add
            $post->views = 0;
            if ($post->save()) {
                return redirect('/')->with('response', 'Post added succesfully!');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $value
     * @return \Illuminate\Http\Response
     */
    public function show($value)
    {
        $post = Post::with(['users', 'categories'])
                        ->where('slug', $value)
                        ->where('visibility', true)
                        ->first();

        if (!isset($post)) { // if the $value is int, then delete this comment which has the
            return view('errors.404');
        }

        $recent_posts = Post::orderBy('id', 'DESC')->limit(5)->get();
        $categories = categories::all();
        $post_from_user = Post::where('slug', 'not like', $post->slug)->where('users_id', 'not like', $post->users_id)->limit(1)->first();

        // Add one view to the column views on the posts table on any http request
        $actual_views = $post->views;
        $after_refresh_views = $post->views + 1;

        $post->views = $after_refresh_views;
        $post->save();

        // Get comments
        $comments = Comment::with(['posts', 'users'])->where('posts_id', $post->id)->orderBy('id', 'DESC')->paginate(10);

        $comments_for_count = Comment::where('posts_id', $post->id)->get();
        if (!$comments_for_count->count()==0) {
            $comments_count = $comments_for_count->count();
        } else {
            $comments_count = 0;
        }

        // Define the image src because we're generating some images via the seeder
        if (Str::contains($post->post_image, 'public/storage/images/posts_images/')) {
            $src = Str::after($post->post_image, 'public/storage/images/posts_images/');
        } else if (!Str::contains($post->post_image, 'public/storage/images/posts_images/')) {
            $src= $post->post_image;
        }

        return view('posts.show', [
            'post' => $post,
            'recent_posts' => $recent_posts,
            'categories' => $categories,
            'post_from_user' => $post_from_user,
            'actual_views' => $actual_views,
            'comments' => $comments,
            'comment_for_count' => $comments_count,
            'src' => $src
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::with('categories')->find($id);

        if ($post->users_id != Auth::id()) {
            abort(403);
        }

        $categories = categories::all();
        return view("posts.update", [
            'categories' => $categories,
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Check the form and make it valid
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:30|max:120',
            'content' => 'required|min:120',
            'category_select' => 'required',
            'comments_approval' => 'in:1,0',
        ]);

        if ($validator->fails()) {
            return redirect("/posts/{$id}/edit")
                ->withErrors($validator)
                ->withInput();
        } else {

            $auth_user_id = Auth::id();
            $post = Post::where('id', $id)->first();

            // Deal with the post image
            if ($request->hasFile('image')) {
                if ($request->file('image')->isValid()) {
                    $validated = $request->validate([
                        'image' => 'required|image|max:2000|mimes:png,jpeg,gif,jpg|',
                    ]);
                    $extension = $request->file('image')->extension();
                    $image_name = uniqid('', true).".".$extension;
                    $request->file('image')->storeAs('public/images/posts_images', "$image_name");
                }
                $post->post_image = $image_name;
            }
            // Store data
            $post->title = $request->input('title');
            $post->body = $request->input('content');
            $post->users_id = $auth_user_id;
            $post->comments = $request->input('comments_approval');
            $post->categories_id = $request->input('category_select');
            $post->visibility = $request->input('visibility'); // Make the post visible by default on add
            if ($post->save()) {
                return redirect('/posts')->with('response', 'Post updated succesfully!');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // for the post deleting, we handled it on the DeleteController
    }
    
}
