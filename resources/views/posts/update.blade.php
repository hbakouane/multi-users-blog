@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container">

            <!-- Text Editor -->
            <script src='https://cdn.tiny.cloud/1/eji6z5jzrerdrlyzxbo4k4fo8lfrqzmwhfn22u18r05inlwf/tinymce/5/tinymce.min.js' referrerpolicy="origin">
            </script>
            <script>
                tinymce.init({
                    selector: '#content'
                });
            </script>
            <br>
            <p class="h3 text-dark text-center font-weight-bolder">Update Post</p>
            <br>
            <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('posts.form')
            
                <div class="form-group">
                    <label>Type</label>
                    <input type="radio" name="visibility" value="1" @if($post->visibility==true) checked @endif> Enabled
                    <input type="radio" name="visibility" value="0" @if($post->visibility==false) checked @endif> Disabled
                </div>

                <div class="form-group">
                    <button class="btn btn-main" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Category Model -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Help the community by adding a valid category
                        <small>(this will affect the entered data)</small>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" name="category" class="form-control input">
                            @error('category')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-main">Create category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Bootstrap Model -->
@endsection
