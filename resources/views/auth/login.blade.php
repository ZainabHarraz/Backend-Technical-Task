@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4 class="mb-4">Login</h4>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('web.login.submit') }}">
                @csrf
                <div class="form-group mb-3">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>

                <div class="form-group mb-3">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button class="btn btn-primary" type="submit">Login</button>
            </form>
        </div>
    </div>
</div>
@endsection
