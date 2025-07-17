@extends('layouts.app')

@section('content')
<style>
  body {
    background-color: #ffe6f0;
  }

  .card {
    background-color: #a9c7e6ff; 
    color: #333;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }
  .btn-primary, .btn-success, .btn-danger {
    color: #fff;
  }
  .list-group-item {
    background-color: #fff;
    color: #333;
  }
  .form-control {
    background-color: #fefefe;
    color: #333;
    border: 1px solid #ccc;
  }
</style>

<div class="container mt-4">
  <h2 class="text-center mb-4">My Posts </h2>

  <div id="posts-list">
    @foreach($posts as $post)
    <div class="card mb-3">
      <div class="card-body">
        <h5>{{ $post->title }}</h5>
        <p>{{ $post->body }}</p>
        @if($post->image)
          <img src="{{ asset('storage/'.$post->image) }}" width="100" class="img-thumbnail mb-2">
        @endif
        <div class="d-flex gap-2">
          <a href="{{ route('posts.create') }}" class="btn btn-sm btn-info">+ Create Post</a>
          <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Edit</a>
          <button onclick="deletePost('{{ $post->id }}')" class="btn btn-sm btn-danger">Delete</button>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>

<script>
  function deletePost(id) {
    if (confirm("Are you sure you want to delete this post?")) {
      fetch(`/posts/${id}`, {
        method: "DELETE",
      
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}",
        'X-Requested-With': 'XMLHttpRequest'
      }

      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'deleted') {
          location.reload();
        }
      });
    }
  }
</script>
@endsection
