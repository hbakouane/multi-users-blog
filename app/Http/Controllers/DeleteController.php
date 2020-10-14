<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    public function destroy($id) {
        // Secure the post, give the possibility of deleting this post to the user who has it not everyone
        // We can do this with Laravel Policies as well
        $post = Post::find($id);
        if (isset($post) and Auth::id() == $post->users_id) {
            $post = Post::find($id);
            $post->delete();
            return redirect(url()->previous())->with('response', 'Post deleted successfully.');
        } else {
            abort(403);
        }
    }

    public function deleteUser($id) {
        if (Auth::id() == $id) {
            $user = User::find($id);
            $user->delete();
            return redirect('/')->with('response', 'Your account was deleted succesfully, see you again!');
        } else {
            return view('errors.404');
        }
    }

}
