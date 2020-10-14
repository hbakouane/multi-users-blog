@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <h2 class="text-center font-weight-bolder text-dark">Manage My Posts</h2>
            <br>
            @if(session()->has('response'))
                <div class="alert alert-success">
                    {{ session()->get('response') }}
                </div>
                <br>
            @endif
            @if($posts->count()==0)
                <p class="text-dark text-center h6">You don't have any post yet, Add some.</p>
                <div class="d-flex justify-content-center">
                    <a href="/posts/create" class="btn btn-sm btn-warning">Add a post</a>
                </div>
            @else
            <br><br>
            <table class="table hover gray-border">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Created</th>
                        <th scope="col">Category</th>
                        <th scope="col">Type</th>
                        <th scope="col">Comments</th>
                        <th scope="col">Image</th>
                        <th scope="col">Views</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <th scope="row">{{ $post->title }}</th>
                            <th>{{ $post->created_at }}</th>
                            <th><p class="text-center">{{ $post->categories->category }}</p></th>
                            <th>
                                @if($post->visibility==true)
                                    <center><i class="fa fa-dot-circle text-center center bg-success rounded-pill text-success"></i></center>
                                @else
                                    <center><i class="fa fa-dot-circle text-center center bg-danger rounded-pill text-danger"></i></center>
                                @endif
                            </th>
                            <th class="d-flex justify-content-center">
                                @if($post->comments==true)
                                    <i class="fa fa-dot-circle text-center center bg-success rounded-pill text-success"></i>
                                @else
                                    <i class="fa fa-dot-circle text-center center bg-danger rounded-pill text-danger"></i>
                                @endif
                            </th>
                            @if (Str::contains($post->post_image, 'public/storage/images/posts_images/'))
                                @php
                                    $src= Str::after($post->post_image, 'public/storage/images/posts_images/')
                                @endphp
                            @elseif(! Str::contains($post->post_image, 'public/storage/images/posts_images/'))
                                @php
                                    $src = $post->post_image    
                                @endphp
                            @endif
                            <th><img class="img-fluid" style="height: 100px;width: 300px;" src="{{ asset("storage/images/posts_images/{$src}") }}"></th>
                            <th><p class="text-center">{{ $post->views }}</p></th>
                            <th>
                                <div class="no-wrap row">
                                    <a href="/posts/{{ $post->id }}/edit" data-toggle="tooltip" title="Edit your post" type="button" class="btn btn-sm margin-right btn-warning">
                                        <i class="fa fa-edit text-light"></i>
                                    </a>
                                    <a href="/posts/{{ $post->slug }}" data-toggle="tooltip" title="Preview your post" target="_blank" type="button" class="btn btn-sm margin-right btn-info">
                                        <i class="fa fa-eye text-light"></i>
                                    </a>
                                    <a href="{{ route('delete', $post) }}" data-toggle="tooltip" title="This post will be deleted once you clicked this button" type="button" class="btn btn-sm margin-right btn-danger">
                                        <i class="fa fa-trash text-light"></i>
                                    </a>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <center>{{ $posts->links('pagination::bootstrap-4') }}</center>
            @endif
        </div>
    </div>

@endsection
