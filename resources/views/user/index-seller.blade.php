@extends('layouts.dashboard')
@section('content')
<div class="container-fluid">
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
  @if(count($errors) > 0)
  @foreach($errors->all() as $error)
      <div class="alert alert-warning">{{ $error }}</div>
  @endforeach
  @endif
  <div class="row">
    <div class="col-md-4">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            @if(Auth::user()->foto != null)
                <img src="{{ \Storage::url(Auth::user()->foto) }}" alt="profil" class="profile-user-img img-responsive img-circle shadow-sm">
            @else
                <img src="{{ asset('img/user1-128x128.jpg') }}" alt="profil" class="profile-user-img img-responsive img-circle">
            @endif
          </div>
          <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
          <p class="text-muted text-center">Member sejak : {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d/m/Y') }}</p>
          <hr>
          <strong>
            <i class="fas fa-map-marker mr-2"></i>
            Alamat
          </strong>
          <p class="text-muted">
            {{ Auth::user()->alamat }}
          </p>
          <hr>
          <strong>
            <i class="fas fa-envelope mr-2"></i>
            Email
          </strong>
          <p class="text-muted">
            {{ Auth::user()->email }}
          </p>
          <hr>
          <strong>
            <i class="fas fa-phone mr-2"></i>
            No Tlp
          </strong>
          <p class="text-muted">
            +62 {{ Auth::user()->phone }}
          </p>
          <hr>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card card-primary card-outline">
        <div class="card-body">
          <h5 class="mb-4">Edit Profil</h5>
          <form action="{{ route('profil.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{ method_field('patch') }}
            <div class="input-group mb-3">
              <label class="input-group-text fw-normal" for="inputGroupFile">Foto Profil</label>
              <input type="file" name="image" class="form-control" id="inputGroupFile">
            </div>
            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" name="name" id="name" class="form-control" value={{ Auth::user()->name }}>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <input type="text" name="alamat" id="alamat" class="form-control" value={{ Auth::user()->alamat }}>
            </div>
            <div class="form-group mb-5">
              <label for="phone">No Hp</label>
              <input type="text" name="phone" id="phone" class="form-control" value={{ Auth::user()->phone }}>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update User Info</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
