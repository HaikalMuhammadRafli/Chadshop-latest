@extends('layouts.admin-template')
@section('content')
<div class="about-main">
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
    <div class="card">
        <div class="card-body">
            @if (!isset($about))
                <form action="{{ route('about.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h4 class="text-center">Masukkan Isi Halaman About!</h4>
                    <div class="input-group mb-3">
                        <input type="file" name="banner" id="banner" class="input-banner">
                    </div>
                    <div class="form-group">
                        <label for="tentang">Tentang Kami</label>
                        <textarea name="tentang" id="tentang" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tujuan">Tujuan Kami</label>
                        <textarea name="tujuan" id="tujuan" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            @else
                <form action="{{ route('about.update', $about->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <h4 class="text-center">Masukkan Isi Halaman About!</h4>
                    <div class="card">
                        <div class="card-body">
                            <img src="{{ \Storage::url($about->banner) }}" alt="about_banner" class="w-100 img-fluid">
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="file" name="banner" id="banner" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tentang">Tentang Kami</label>
                        <textarea name="tentang" id="tentang" cols="30" rows="5" class="form-control">{{ $about->tentang }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="tujuan">Tujuan Kami</label>
                        <textarea name="tujuan" id="tujuan" cols="30" rows="5" class="form-control">{{ $about->tujuan }}</textarea>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection