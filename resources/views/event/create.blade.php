@extends('layouts.admin-template')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Form Event</h3>
          <div class="card-tools">
            <a href="{{ route('event.index') }}" class="btn btn-sm btn-danger">
              Tutup
            </a>
          </div>
        </div>
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
          <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="form-group">
              <label for="kode_event">Kode Event</label>
              <input type="text" name="kode_event" id="kode_event" class="form-control">
            </div>
            <div class="form-group">
              <label for="nama_event">Nama Event</label>
              <input type="text" name="nama_event" id="nama_event" class="form-control">
            </div>
            <div class="form-group">
              <label for="slug_event">Slug Event</label>
              <input type="text" name="slug_event" id="slug_event" class="form-control">
            </div>
            <h6 style="font-weight: bold;">Pilih Banner Event</h6>
            <div class="input-group mb-3">
              <input type="file" name="image" id="image" class="form-control">
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="start_datetime">Start DateTime</label>
                  <input type="date" name="start_datetime" id="start_datetime" class="form-control" required>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="end_datetime">End DateTime</label>
                  <input type="date" name="end_datetime" id="end_datetime" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="reset" class="btn btn-warning">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection