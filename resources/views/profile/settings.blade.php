@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-4 gray-border bg-light" style="height: fit-content;">
                    @if(empty($data->profile_img))
                        <img src="{{ asset('images/default_cover.jpg') }}" class="img-fluid profile-image shadow">
                    @else
                        <img src="{{ asset("storage/images/profile_images/{$data->profile_img}") }}" class="img-fluid shadow profile-image">
                    @endif
                    <p class="text-dark h6 text-center">{{ $data->name }}</p>
                    <a href="{{ url()->current() }}">
                        <p class="text-center">@<span class="text-muted">{{ $data->username }}</span></p>
                    </a>
                    <hr>
                    <p class="text-sm-left text-dark">Author Level: No Level</p>
                    <p class="text-sm-left text-dark">Membership: {{ $data->created_at->diffForHumans() }}</p>
                    <p class="text-sm-left text-dark">Post Views: {{ $views }}</p>
                </div>
                <div class="col-md-8">
                    <p class="text-left text-dark h4">Settings</p>
                    <form method="POST" action="{{ route('settings.update', $data) }}" enctype="multipart/form-data">
                        @csrf
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control input" name="name" value="{{ $data->name }}">
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control input" value="{{ $data->username }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control input" name="email" value="{{ $data->email }}">
                        </div>
                        <div class="form-group">
                            <label>Profile Picture</label>
                            <input type="file" value="{{ $data->profile_img }}" class="form-control-file input" name="photo">
                        </div>
                        @method('PATCH')
                        <div class="form-group">
                            <button class="btn text-light bg-main-color btn-main">Update</button>
                        </div>
                    </form>
                    <div class="form-group">
                        <a href="#delete_modal" data-toggle="modal">
                            <button class="btn text-light btn-main">Delete my account</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal" id="delete_modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body d-flex justify-content-center">
                            Are you sure you want to delete your account?
                            <br>
                            <a href="{{ route('delete.user', $data->id) }}">
                            <button class="btn btn-danger">Confirm</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
