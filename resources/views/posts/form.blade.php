@if(session()->has('response'))
    <div class="alert alert-success">
        {{ session()->get('response') }}
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li class="text-danger">{{ $error }}</li>
        @endforeach
    </div>
@endif
<div class="form-group">
    <label>Title</label>
    <input type="text" name="title" class="form-control input" value="{{ old('title', $post->title ?? null) }}" autocomplete="title" autofocus required>
</div>
<div class="form-group">
    <label>Content</label>
    <textarea type="text" name="content" id="content" class="form-control input" rows="10">{{ old('content', $post->body ?? null) }}</textarea>

</div>
<div class="form-group">
    <label>Select a category
        <small>
            didn't find your category? add one
            <a href="#" type="button" data-toggle="modal" data-target="#exampleModal">here</a>
        </small>
    </label>
    <select name="category_select" class="form-control input" value="{{ old('category_select', $post->categories->category ?? null) }}">
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @if(isset($post) and $category->id==$post->categories->id) selected @endif()>{{ $category->category }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label>Enable Comments</label>
    <input type="radio" value="1" name="comments_approval" @if(isset($post) and $post->comments == true) checked @endif> Yes
    <input type="radio" value="0" name="comments_approval" @if(isset($post) and $post->comments == false) checked @endif> No
</div>
@if (isset($post))
    @if (Str::contains($post->post_image, 'public/storage/images/posts_images/'))
    @php
        $src= Str::after($post->post_image, 'public/storage/images/posts_images/')
    @endphp
    @elseif(! Str::contains($post->post_image, 'public/storage/images/posts_images/'))
    @php
        $src = $post->post_image    
    @endphp
    @endif
    <div class="form-group d-flex justify-content-center">
        <img class="img-fluid rounded" src="{{ asset("storage/images/posts_images/$src") }}">
    </div>
@endif
<div class="form-group upload bg-dark rounded">
    <input type="file" name="image" class="form-control input bg-main-color" value="{{ old('image', $post->post_image ?? null) }}">
</div>
