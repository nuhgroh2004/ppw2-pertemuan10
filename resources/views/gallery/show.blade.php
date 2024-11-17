@extends('auth.layouts')
@section('content')
<div class="container mt-5 mb-5">
    <h2>Detail Gallery</h2>
    <div class="card">
        <div class="card-body">
            @if($gallery)
                <h3>{{ $gallery->title }}</h3>
                <p>{{ $gallery->description }}</p>
               
            <div class="d-flex justify-content-center">
                <img src="{{ asset('storage/posts_image/' . $gallery->picture) }}" alt="{{ $gallery->title }}" class="img-fluid" style="max-width: 100%;">
            </div>
            @else
                <p>Gallery not found.</p>
            @endif
        </div>
        <div class="d-flex justify-content-center my-3">
            <a href="{{ route('gallery.index') }}" class="btn btn-secondary" style="width: 200px;">Back to Gallery</a>
        </div>
    </div>
</div>
@endsection
