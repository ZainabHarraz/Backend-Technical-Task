@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h3>Create New Post</h3>

  <form id="create-form" enctype="multipart/form-data">
    @csrf
    <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>
    <textarea name="body" class="form-control mb-2" placeholder="Body" required></textarea>
    <input type="file" name="image" class="form-control mb-3">
    <button type="submit" class="btn btn-success">Submit</button>
  </form>

  <div id="success-message" class="alert alert-success mt-3" style="display: none;">
    Post created successfully!
  </div>
</div>

<script>
document.getElementById('create-form').addEventListener('submit', function(e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  fetch('{{ route("posts.store") }}', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      form.reset();
      document.getElementById('success-message').style.display = 'block';
      setTimeout(() => window.location.href = '{{ route("posts.index") }}', 1500);
    }
  });
});
</script>
@endsection
