@extends('layouts.admin-template')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Kategori Produk</h4>
                        <div class="card-tools">
                            <a href="{{ route('kontak.create') }}" class="btn btn-sm btn-primary">
                                Baru
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                    <form action="#">
                        <div class="row">
                            <div class="col">
                                <input type="text" name="keyword" id="keyword" class="form-control" placeholder="ketik keyword disini">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary">
                                Cari
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                    <div class="card-body">
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
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th width="50px">No</th>
                                    <th>Nama</th>
                                    <th>Peran</th>
                                    <th>Gender</th>
                                    <th>Alamat</th>
                                    <th>No HP</th>
                                    <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($itemkontak as $kontak)
                                    <tr>
                                        <td>
                                        {{ ++$no }}
                                        </td>
                                        <td>
                                            {{ $kontak->nama }}
                                        </td>
                                        <td>
                                            {{ $kontak->peran }}
                                        </td>
                                        <td>
                                            {{ $kontak->gender }}
                                        </td>
                                        <td>
                                            {{ $kontak->alamat }}
                                        </td>
                                        <td>
                                            {{ $kontak->no_hp }}
                                        </td>
                                        <td>
                                            <a href="{{ route('kontak.edit', $kontak->id) }}" class="btn btn-sm btn-primary mr-2 mb-2">
                                                Edit
                                            </a>
                                            <form action="{{ route('kontak.destroy', $kontak->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                {{ method_field('delete') }}
                                                <button type="submit" class="btn btn-sm btn-danger mb-2">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!-- untuk menampilkan link page, tambahkan skrip di bawah ini -->
                            {{ $itemkontak->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection