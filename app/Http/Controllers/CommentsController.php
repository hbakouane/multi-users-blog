<?php

namespace App\Http\Controllers;

use App\Events\NewNotification;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect(url()->previous())
                ->withInput()
                ->withErrors($validator);
        }

        $comment = new Comment();
        $comment->comments = $request->input('comment');
        $current_url =  url()->previous(); // we created this variable to get the value of the slug
        // Let's check if the slug has a pagination variable like: ?page=3, if there is one, the post will not be found
        if (Str::contains($current_url, '?page=')) {
            $slug = Str::between($current_url, 'posts/', '?page'); // here, we got all what is after the param posts
        } else {
            $slug = Str::of($current_url)->after('posts/'); // here, we got all what is after the param posts
        }
        //return $slug; // try it
        $post = Post::where('slug', $slug)->first(); // here is the post where the comment form is on
        // now let's fill the id column in the comments table
        $comment->posts_id = $post->id;
        $comment->users_id = Auth::id();

        $comment->save(); // save that

        $data = [
            'user_id' => Auth::id(),
            'comment' => $request->input('comments'),
            'post_id' => $post->id,
        ];

        return redirect($current_url)->with('response', 'Comment added successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) 
    {
        $comment = Comment::find($id);
        if (Auth::id() == $comment->users_id) {
            $comment->destroy($id);
            return back()->with('response', 'Comment deleted succesfully.');
        }
    }
}
