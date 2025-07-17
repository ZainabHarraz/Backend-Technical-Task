@extends('layouts.app')

@section('content')
<div class="container py-4" style="background-color: #ffe6f0;">
  <div class="card shadow">
    <div class="card-body">
      <h3 class="mb-4 text-center">Edit Post</h3>

      <form id="edit-form" enctype="multipart/form-data">
        <input type="hidden" id="post_id" value="{{ $post->id }}">

        <div class="form-group mb-3">
          <label for="title">Title</label>
          <input type="text" id="title" name="title" class="form-control" value="{{ $post->title }}">
        </div>

        <div class="form-group mb-3">
          <label for="body">Body</label>
          <textarea id="body" name="body" class="form-control">{{ $post->body }}</textarea>
        </div>

        <div class="form-group mb-3">
          <label for="image">Image (optional)</label>
          <input type="file" id="image" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  document.getElementById('edit-form').addEventListener('submit', async function (e) {
    e.preventDefault();

    const postId = document.getElementById('post_id').value;
    const formData = new FormData(this);

    try {
      await axios.post(`/posts/${postId}`, formData, {
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'multipart/form-data'
        },
        params: {
          _method: 'PUT'
        }
      });

      alert('Post updated successfully!');
      window.location.href = "{{ route('posts.index') }}";
    } catch (err) {
      console.error(err);
      alert('Update failed.');
    }
  });
</script>
@endsection
