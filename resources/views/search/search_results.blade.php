@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <h2 class="text-center font-weight-bolder text-dark">Search results for {{ Request::Input('search') }}</h2>
            <br>
            <form action="/search/posts/" method="GET">
                <div class="form-group">
                    <div class="from-group">
                        <div class="no-wrap row">
                            <div class="col-md-9">
                                <input class="form-control input" type="text" name="search" value="{{ Request::input('search') }} ">
                                <br>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-main full-width btn-md">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ $posts_count }} Post(s)</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ $users_count }} User(s)</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">{{ $comments_count }} Comment(s)</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    @if ($posts->count() == 0)
                        <p class="text-dark text-center marginTop">No post was found.</p>
                    @else
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-md-4 marginTop">
                                <div class="card post-card marginBottom">
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
                                            <img src="{{ asset("storage/images/posts_images/{$src}") }}" class="img-fluid">
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
                    <div class="marginTop d-flex justify-content-center">
                        {{ $posts->links() }}
                    </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    @if ($users->count() == 0)
                        <p class="text-dark text-center marginTop">No user was found.</p>
                    @else
                    <div class="row">
                        @foreach($users as $user)
                        <a href="/{{ $user->username }}">
                            <div class="col-md-4 rounded marginTop" style="height: fit-content">
                                <div class="card">
                                    <div class="card-body">
                                        @if(empty($user->profile_img))
                                            <img src="{{ asset('images/default_cover.jpg') }}" class="img-fluid profile-image">
                                        @else
                                            <img src="{{ asset("storage/images/profile_images/{$user->profile_img}") }}" class="img-fluid profile-image">
                                        @endif
                                        <p class="text-dark h6 text-center">{{ $user->name }}</p>
                                        <a href="/{{ $user->username }}">
                                            <p class="text-center">@<span class="text-muted">{{ $user->username }}</span></p>
                                        </a>
                                        <hr>
                                        <p class="text-sm-left text-dark">Author Level: No Level</p>
                                        <p class="text-sm-left text-dark">Member since {{ $user->created_at }}</p>
                                        <p class="text-sm-left text-dark">Post Views: {{ $posts_views = App\Models\Post::with('users')->where('users_id', $user->id)->sum('views') }}</p>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <div class="marginTop d-flex justify-content-center">
                        {{ $users->links() }}
                    </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    @if ($comments->count() == 0)
                        <p class="text-dark text-center marginTop">No comment was found.</p>
                    @else
                    <div class="card marginTop">
                        <div class="card-body">
                        @foreach ($comments as $comment)
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
                                    <p class="text-dark font-weight-bolder ">{{ $comment->users->username }}</p>
                                </a>
                                <q id="actual_comment">
                                    {{ $comment->comments }}
                                </q>
                                <br>
                                <small class="text-muted">posted {{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <br><br>
                        @endforeach
                        </div>
                    </div>
                    <div class="marginTop d-flex justify-content-center">
                        {{ $comments->links() }}
                    </div>
                    @endif
                </div>
              </div>
        </div>
    </div>
@endsection