@extends('layouts.app')

@section('content')
    <!-- Lastes Posts -->
    <div class="container-fluid">
        <div class="container">
            <h2 class="text-center font-weight-bolder text-dark">Latest Blog Posts</h2>
            <br>
            <form action="/search/posts/" method="GET">
                <div class="form-group">
                    <div class="from-group">
                        <div class="no-wrap row">
                            <div class="col-md-9">
                                <input class="form-control input" type="text" name="search" @if(isset($random_post)) placeholder="Ex: {{ $random_post->title ?? '' }}" @else() placeholder="Eg: What is the most usefull PHP framework" @endif>
                                <br>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-main full-width btn-md">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @if(session()->has('response'))
                <div class="alert alert-success">
                    {{ session()->get('response') }}
                </div>
            @endif
            @if (count($posts)==0)
                <p class="text-dark text-center">No post to show</p>
                <div class="d-flex justify-content-center">
                    <a href="/posts/create" class="btn btn-warning btn-sm">Add a post</a>
                </div>
            @endif
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-md-4">
                        <div class="card shadow post-card marginBottom">
                            <div class="card-body no-padding">
                                <a href="/posts/{{ $post->slug }}">
                                    @if (Str::contains($post->post_image, 'public/storage/images/posts_images/'))
                                        @php
                                            $src= Str::after($post->post_image, 'public/storage/images/posts_images/')
                                        @endphp
                                    @elseif(! Str::contains($post->post_image, 'public/storage/images/posts_images/'))
                                        @php
                                            $src = $post->post_image    
                                        @endphp
                                    @endif
                                    <img src="{{ asset("storage/images/posts_images/$src") }}" class="img-fluid">
                                </a>
                            </div>
                            <div class="card-footer bg-light">
                                <a href="/posts/{{ $post->slug }}">
                                    <p class="h5 text-dark text-left">{{ Str::limit($post->title, 70, '...') }}</p>
                                </a>
                                <small class="text-muted">{{ Str::limit($post->title, 70, '...') }}</small>
                                <hr>
                                <div class="row" id="post-footer">
                                    <div class="col-md-12">
                            <span>
                                <small class="text-dark main-color">Posted <span class="text-muted">{{ $post->created_at->diffForHumans() }}</span> by
                                    <a href="/{{ $post->users->username }}" class="text-muted">{{ $post->users->username }}</a>
                                </small>
                                <br>
                                <small class="text-dark main-color">Category:
                                    <a href="/categories/{{ $post->categories->category }}" class="text-muted">
                                        <div class="badge badge-info">{{ $post->categories->category }}</div>
                                    </a>
                                </small>
                            </span>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="/posts/{{ $post->slug }}">
                                            <p class="h6 main-color post-title text-center font-weight-bolder">Read More <i class="fa fa-arrow-right"></i> </p>
                                        </a>
                                    </div>
                                </div>
                                <div class="row" id="footer-link">
                                    <div class="col-md-12">
                                        <i class="fa fa-link center footer-link-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center" style="margin-top: 60px;">{{ $posts->links() }}</div>

        </div>
    </div>
    <!-- /Latest Posts -->
@endsection
