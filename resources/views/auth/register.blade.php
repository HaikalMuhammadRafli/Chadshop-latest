@extends('layouts.app')

@section('content')
<div class="register-main">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    @if(count($errors) > 0)
                    @foreach($errors->all() as $error)
                        <div class="alert alert-warning">{{ $error }}</div>
                    @endforeach
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-warning">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <h4 class="title text-center">{{ __('Register') }}</h4>
                    <form method="POST" action="{{ route('register') }}">
                        <div class="row">
                            <div class="col">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                                <div class="form-group mb-1">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control">
                                </div>
                                <h6 class="m-0 mb-1">No HP</h6>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="phone">+62</span>
                                    <input type="text" name="phone" id="phone" class="form-control">
                                </div>
                                <p>Ingin Menjadi:</p>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="role-1" value="member" checked>
                                    <label class="form-check-label" for="role-1">Member</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="role-2" value="seller">
                                    <label class="form-check-label" for="role-2">Seller</label>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary mb-4">Register</button>
                                    <p>Forgot your password? <a href="{{ route('password.request') }}" class="text-decoration-none logreg">click here</a></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
