@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-4 bg-light gray-border rounded margin-bottom-on-phone" style="height: fit-content">
                    @if(empty($data->profile_img))
                        <img src="{{ asset('images/default_cover.jpg') }}" class="img-fluid shadow gray-border profile-image">
                    @else
                        <img src="{{ asset("storage/images/profile_images/{$data->profile_img}") }}" class="img-fluid shadow gray-border profile-image">
                    @endif
                    @if($auth_user_id == $data->id)
                        <a href="/settings/{{ Auth::id() }}/edit">
                            <p class="text-center text-dark pointer"><i class="text-center fa fa-camera"></i></p>
                        </a>
                    @endif
                    <p class="text-dark h6 text-center">{{ $data->name }}</p>
                    <a href="{{ url()->current() }}">
                        <p class="text-center">@<span class="text-dark">{{ $data->username }}</span></p>
                    </a>
                    <hr>
                    <p class="text-sm-left text-dark">Author Level: No Level</p>
                    <p class="text-sm-left text-dark">Membership: {{ $data->created_at->diffForHumans() }}</p>
                    <p class="text-sm-left text-dark">Post Views: {{ $views }}</p>
                </div>
                <div class="col-md-8 rounded">
                    <p class="text-left h4 text-dark">Posts ({{ $posts_count }})</p><br>
                    @if($posts->count()==0)
                        <p class="text-muted">This user has no post yet.</p>
                    @endif
                    @if(session()->has('response_danger'))
                        <div class="alert alert-danger">
                            {{ session()->get('response_danger') }} <br>
                        </div>
                    @endif
                    <div class="row">
                        @foreach($posts as $post)
                            <div class="col-md-6">
                                <div class="card shadow post-card marginBottom">
                                    <div class="card-body no-padding">
                                        <a href="posts/{{ $post->slug }}">
                                            @if (Str::contains($post->post_image, 'public/storage/images/posts_images/'))
                                                @php
                                                    $src= Str::after($post->post_image, 'public/storage/images/posts_images/')
                                                @endphp
                                            @elseif(! Str::contains($post->post_image, 'public/storage/images/posts_images/'))
                                                @php
                                                    $src = $post->post_image    
                                                @endphp
                                            @endif
                                            <img src="{{ asset("storage/images/posts_images/$src") }}" class="img-fluid" height="200px">
                                        </a>
                                    </div>
                                    <div class="card-footer bg-light">
                                        <a href="posts/{{ $post->slug }}">
                                            <p class="h5 text-dark text-left">{{ $post->title }}</p>
                                        </a>
                                        <!-- <small class="text-muted">{{ Str::limit($post->body, 100, '...') }}</small> -->
                                        <hr>
                                        <div class="row" id="post-footer">
                                            <div class="col-md-12">
                                                <span>
                                                    <small class="text-dark main-color">Posted on <span class="text-muted">{{ $post->created_at }}</span> by
                                                        <a href="{{ url()->full() }}" class="text-muted"> {{ $data->username }}</a>
                                                    </small>
                                                </span>
                                                <small class="text-dark main-color">Category:
                                                    <a href="/categories/{{ $post->categories->category }}" class="text-muted">{{ $post->categories->category }}</a>
                                                </small>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="posts/{{ $post->slug }}">
                                                    <p class="h6 main-color post-title text-center font-weight-bolder">Read More <i class="fa fa-arrow-right"></i> </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
