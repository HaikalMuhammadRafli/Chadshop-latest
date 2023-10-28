@extends('layouts.admin-template')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Kontak</h3>
                <div class="card-tools">
                    <a href="{{ route('kontak.index') }}" class="btn btn-sm btn-danger">
                        Tutup
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('kontak.update', $itemkontak->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" value={{ $itemkontak->nama }}>
                    </div>
                    <div class="form-group">
                        <label for="peran">Peran</label>
                        <input type="text" name="peran" id="peran" class="form-control" value={{ $itemkontak->peran }}>
                    </div>
                    <h6 class="fw-bold">Pilih Gender</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender-1" value="Pria" {{ $itemkontak->gender == "Pria" ? 'checked' : '' }}>
                        <label class="form-check-label" for="gender-1">
                            Pria
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="gender" id="gender-2" value="Wanita" {{ $itemkontak->gender == "Wanita" ? 'checked' : '' }}>
                        <label class="form-check-label" for="gender-2">
                            Wanita
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" value={{ $itemkontak->alamat }}>
                    </div>
                    <h6 class="fw-bold">Nomor HP</h6>
                    <div class="input-group mb-5">
                        <span class="input-group-text" id="no_hp">+62</span>
                        <input type="text" name="no_hp" id="no_hp" class="form-control" value={{ $itemkontak->no_hp }}>
                    </div>
                    <div class="form-group float-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection