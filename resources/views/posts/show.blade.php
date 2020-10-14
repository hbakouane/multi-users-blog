@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ">
                    <p class="h2 text-dark">{{ $post->title }}</p>
                    @if (Auth::id()==$post->users_id)
                        <a href="/posts/{{ $post->id }}/edit" class="text-primary">Edit my post</a><br>
                    @endif
                    <div class="form-group">
                        <small class="text-muted">Posted by
                            <a href="/{{ $post->users->username }}"><i class="fa fa-user"></i> {{ $post->users->username }}</a>
                            <small>{{ $post->created_at->diffForHumans() }}</small> | Views: <div class="badge badge-success">{{ $actual_views }}</div> |
                            Comments:
                            <div class="badge badge-info">
                                @if(!$comment_for_count==0)
                                    {{ $comment_for_count }}
                                @else
                                    0
                                @endif
                            </div> | Category: 
                            <div class="badge badge-danger">
                                <a href="/categories/{{ $post->categories->category }}" class="text-light">
                                    {{ $post->categories->category }}
                                </a>
                            </div>
                        </small>
                    </div>
                    <img class="img-fluid gray-border shadow post-page-image" src="{{ asset("storage/images/posts_images/{$src}") }}">
                    <hr>
                    <div class="bg-white gray-border" style="padding: 20px">
                        {!! $post->body !!}
                    </div>
                    <hr>
                    @if($post->comments==1)
                        @auth()
                            <br>
                            <form method="POST" action="{{ route('comments.store') }}">
                                @csrf
                                <div class="form-group">
                                    <p class="h4 text-dark">Comments
                                        (
                                        @if(!$comment_for_count==0)
                                            {{ $comment_for_count }}
                                        @else
                                            0
                                        @endif
                                    )
                                    </p>
                                    <textarea rows="2" name="comment" class="form-control comments-input border-main-color"></textarea><br>
                                    @if($errors->any())
                                        @foreach($errors->all() as $error)
                                            <p class="text-danger">{{ $error }}</p>
                                        @endforeach
                                    @endif
                                    <button class="btn btn-sm btn-main">Add Comment</button>
                                    <br><br>
                            </form>
                            @if(session()->has('response'))
                                <br><br>
                                <div class="alert alert-success">{{ session()->get('response') }}</div>
                            @endif
                            <hr>
                            @foreach($comments as $comment)
                                <div class="card" id="comment{{ $comment->id }}">
                                    <div class="card-body">
                                        <div class="no-wrap row">
                                            <div class="col-md-2">
                                                @if(empty($comment->users->profile_img))
                                                    <a href="/{{ $comment->users->username }}">
                                                        <img class="img-fluid rounded-pill margin-bottom-on-phone" src="{{ asset('images/default_cover.jpg') }}" style="height: 80px;width: 80px;">
                                                    </a>
                                                @else
                                                    <a href="/{{ $comment->users->username }}">
                                                        <img class="img-fluid rounded-pill margin-bottom-on-phone" style="height: 80px;width: 80px;" src="{{ asset("storage/images/profile_images/{$comment->users->profile_img}") }}">
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="col-md-10">
                                                <a href="/{{ $comment->users->username }}">
                                                    <p class="text-dark font-weight-bolder ">{{ $comment->users->username }} <a href="#comment{{ $comment->id }}" class="text-primary">#</a> </p>
                                                </a>
                                                <q id="actual_comment">
                                                    {{ $comment->comments }}
                                                </q>
                                                @if ($comment->users->id == Auth::id())
                                                    <input class="form-control input" autofocus style="display: none;" id="modified_comment{{ $comment->id }}" name="modified_comment" value="{{ $comment->comments }}">
                                                    <br>
                                                    <a href="#" id="save-btn{{ $comment->id }}" class="btn btn-success text-light btn-md" style="display: none;">Save</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if ($comment->users->id == Auth::id())
                                        <div class="card-footer d-flex justify-content-center">
                                            <!--<li class="d-inline-block  margin-right">
                                                <a type="button" id="edit-btn{{ $comment->id }}" class="btn btn-sm bg-warning" onclick="ShowCommentEdit()">
                                                    <i id="edit-icon{{ $comment->id }}" class="fa fa-edit text-light"></i>
                                                </a>
                                            </li>-->
                                            <form method="POST" action="{{ route('comments.destroy', $comment)}}">
                                                @csrf
                                                @method("DELETE")
                                                <button class="btn btn-sm bg-danger">
                                                    <i class="fa fa-trash text-light"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                <br>
                            @endforeach
                            </div>
                <div class="d-flex justify-content-center">{{ $comments->links() }}</div>
                        @endauth
                        @guest()
                            <p><i class="text-danger fa fa-exclamation-triangle"></i> You must be <a href="/login" class="text-primary">connected</a> to see and add comments.</p>
                        @endguest
                        @else
                        <p class="h4 text-dark">The author had disabled the comments for this post.</p>
                    @endif
                </div>
                <div class="col-md-4">
                    @if (isset($post_from_user))
                    <div class="card">
                        <div class="card-header bg-main-color text-light">You may like</div>
                        <div class="card-body" style="padding: 0">
                            <a href="/posts/{{ $post_from_user->slug }}">
                                @if (Str::contains($post_from_user->post_image, 'public/storage/images/posts_images/'))
                                    @php
                                        $post_from_user_src= Str::after($post_from_user->post_image, 'public/storage/images/posts_images/')
                                    @endphp
                                @elseif(! Str::contains($post_from_user->post_image, 'public/storage/images/posts_images/'))
                                    @php
                                        $post_from_user_src = $post_from_user->post_image    
                                    @endphp
                                @endif
                                <img src="{{ asset("storage/images/posts_images/{$post_from_user_src}") }}" class="img-fluid">
                                <p href="/posts/{{ $post_from_user->slug }}" class="text-dark" style="padding: 10px">{{ $post_from_user->title }}</p>
                            </a>
                        </div>
                        <div class="card-footer bg-secondary">
                            <a href="/posts/{{ $post_from_user->slug }}" style="display: block;margin-left: auto!important;margin-right: auto!important;" class="text-center text-light">Read More</a>
                        </div>
                    </div>
                    @endif
                    <br>
                    <div class="card">
                        <div class="card-header bg-main-color text-light">Recent Posts</div>
                        <div class="card-body">
                            @foreach($recent_posts as $recent_post)
                                <a class="text-primary" href="/posts/{{ $recent_post->slug }}">
                                    <small>{{ Str::limit($recent_post->title, 35, '...') }} <br></small>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header bg-main-color text-light">Categories</div>
                        <div class="card-body">
                            @foreach($categories as $category)
                                <a class="text-primary" href="/categories/{{ $category->category }}">
                                    <small>{{ $category->category }} <br></small>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
