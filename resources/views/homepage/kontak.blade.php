@extends('layouts.template')
@section('content')
<div class="contact-main mx-2">
  <div class="container-fluid">
    <div class="row row-cols-1 row-cols-lg-3 g-2 g-lg-3">
      @foreach ($itemkontak as $kontak)
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h4>{{ $kontak->nama }}</h4>
              <h6>{{ $kontak->peran }}</h6>
              <p class="m-0">Jenis Kelamin : {{ $kontak->gender }}</p>
              <p class="m-0">Alamat : {{ $kontak->alamat }}</p>
            </div>
            <div class="card-footer">
             <a class="btn btn-primary w-100" href="https://api.whatsapp.com/send?phone=62{{ $kontak->no_hp }}" target="_blank">Chat Whatsapp</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
