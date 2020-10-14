@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container">
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
@endsection
