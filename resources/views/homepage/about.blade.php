@extends('layouts.template')
@section('content')
<div class="about-main">
  <img src="{{ \Storage::url($about->banner) }}" alt="about_banner" class="w-100 position-absolute shadow">
  <div class="mx-2">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card shadow">
            <div class="card-body text-center">
              <h4>Tentang Kami</h4>
              <p>{{ $about->tentang }}</p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card shadow">
            <div class="card-body text-center">
              <h4>Tujuan Kami</h4>
              <p>{{ $about->tujuan }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
