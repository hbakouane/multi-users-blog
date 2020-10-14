<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\Post;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;


class CategoryController extends Controller
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
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|max:20|min:3|unique:categories',
        ]);

        $category = new categories();
        $new_category = $request->input('category');
        $category->category = $new_category;
        $category->save();
        return redirect('/posts/create')->with('response', 'Category succesfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $value = $id;
        $posts = Post::where('visibility', true)
                        ->whereHas('categories', function ($q) use($value) { $q->where('category', $value); })
                        ->orderBy('id', 'Desc')
                        ->paginate(15);
        $posts_count = Post::where('visibility', true)
                        ->whereHas('categories', function ($q) use($value) { $q->where('category', $value); })->orderBy('id', 'Desc')
                        ->get()
                        ->count();

        if ($posts_count==0) {
//            return view('404');
//            $posts_count = 0;
        }

        return view('categories.show', [
            'value' => $value,
            'posts' => $posts,
            'posts_count' => $posts_count,
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
        //
    }
}
