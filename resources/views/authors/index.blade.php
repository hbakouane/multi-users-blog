@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <br>
            <p class="h3 text-dark text-center font-weight-bolder">Authors</p>
            <br>
            <div class="row">
                @foreach($authors as $author)
                    <a href="/{{ $author->username }}">
                        <div class="col-md-4 rounded" style="height: fit-content">
                            <div class="card">
                                <div class="card-body">
                                    @if(empty($author->profile_img))
                                        <img src="{{ asset('images/default_cover.jpg') }}" class="img-fluid profile-image">
                                    @else
                                        <img src="{{ asset("storage/images/profile_images/{$author->profile_img}") }}" class="img-fluid profile-image">
                                    @endif
                                    <p class="text-dark h6 text-center">{{ $author->name }}</p>
                                    <a href="{{ $author->username }}">
                                        <p class="text-center">@<span class="text-muted">{{ $author->username }}</span></p>
                                    </a>
                                    <hr>
                                    <p class="text-sm-left text-dark">Author Level: No Level</p>
                                    <p class="text-sm-left text-dark">Member since {{ $author->created_at }}</p>
                                    <p class="text-sm-left text-dark">Post Views: {{ App\Models\Post::with('users')->where('users_id', $author->id)->sum('views') }}</p>
                                </div>
                            </div>
                            <br>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="d-flex justify-content-center">
                {{ $authors->links() }}
            </div>
        </div>
    </div>
@endsection
