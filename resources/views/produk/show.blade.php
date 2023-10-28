@extends('layouts.dashboard')
@section('content')
<div class="container-fluid">
  <div class="produk-show-main">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Foto Produk</h3>
          </div>
          <div class="card-body">
            <form action="{{ url('/seller/produkimage') }}" method="post" enctype="multipart/form-data" class="form-inline">
              @csrf
              <div class="input-group w-100">
                <input type="hidden" name="produk_id" value={{ $itemproduk->id }}>
                <input type="file" name="image" class="form-control" id="image" aria-describedby="inputGroupFile" aria-label="Upload">
                <button class="btn btn-primary">Upload</button>
              </div>
            </form>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col mb-2">
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
              </div>
            </div>
            <div class="row">
              @foreach($itemproduk->images as $image)
              <div class="col-md-3 mb-2">
                <img src="{{ \Storage::url($image->foto) }}" alt="image" class="img-thumbnail mb-2">
                <form action="{{ url('/seller/produkimage/'.$image->id) }}" method="post" style="display:inline;">
                  @csrf
                  {{ method_field('delete') }}
                  <button type="submit" class="btn btn-sm btn-danger mb-2">
                    Hapus
                  </button>
                </form>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Detail Produk</h3>
            <div class="card-tools">
              <a href="{{ route('produk.index') }}" class="btn btn-sm btn-danger">
                Tutup
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <td>Kode Produk</td>
                  <td>
                    {{ $itemproduk->kode_produk }}
                  </td>
                </tr>
                <tr>
                  <td>Nama Produk</td>
                  <td>
                  {{ $itemproduk->nama_produk }}
                  </td>
                </tr>
                <tr>
                  <td>Qty</td>
                  <td>
                  {{ $itemproduk->qty }} {{ $itemproduk->satuan }}
                  </td>
                </tr>
                <tr>
                  <td>Harga</td>
                  <td>
                    Rp. {{ number_format($itemproduk->harga, 2) }}
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Ulasan Produk</h3>
          </div>
          <div class="card-body">
            @foreach ($itemproduk->ulasan as $ulasan)
              <div class="row mb-4">
                <div class="col-md-2">
                    <img src="{{ asset('img/user1-128x128.jpg') }}" alt="profil" class="ulasan-profile-img">
                </div>
                <div class="col-md-10 ulasan-profile">
                    <div class="row">
                        <div class="col">
                            <h6>{{ $ulasan->user->name }}</h6>  
                        </div>
                        <div class="col d-flex justify-content-end">
                            <p>{{ \Carbon\Carbon::parse($ulasan->created_at)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="rating-star">
                    @for ($i = 1; $i <= $ulasan->rating; $i++)
                        <i class="fa-solid fa-star checked"></i>
                    @endfor
                    @for ($j = $ulasan->rating + 1; $j <= 5; $j++)
                        <i class="fa-solid fa-star unchecked"></i>
                    @endfor
                    </div>                                           
                    <p>{{ $ulasan->isi_ulasan }}</p>
                    <div class="row">
                        <div class="col">
                            <button class="btn-reply" type="button" data-bs-toggle="modal" data-bs-target="#ReplyModal-{{ $ulasan->id }}">replies...</button>
                            <div class="modal fade" id="ReplyModal-{{ $ulasan->id }}" tabindex="-1" aria-labelledby="ReplyModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Balas Ulasan Dari {{ $ulasan->user->name }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-3">Berikan reply mu terhadap ulasan ini!</p>
                                            <h5>{{ $itemuser->name }}</h5>
                                            <form action="{{ route('reply.store') }}" method="POST">
                                                @csrf
                                                <div class="d-flex">
                                                    <div class="me-2 w-100">
                                                        <input type="hidden" name="ulasan_id" value="{{ $ulasan->id }}">
                                                        <textarea class="form-control" name="isi" id="ulasan" rows="1" placeholder="ketik reply..."></textarea>
                                                    </div>
                                                    <div>
                                                        <button class="btn btn-primary" type="submit"><i class="fa-regular fa-paper-plane"></i></button>
                                                    </div>
                                                </div>
                                                <hr>
                                            </form>
                                            @foreach ($ulasan->reply as $reply)
                                                <div class="d-flex mb-3">
                                                    <div class="me-3">
                                                        <img src="{{ asset('img/user1-128x128.jpg') }}" alt="profil" class="ulasan-profile-img">
                                                    </div>
                                                    <div class="ulasan-profile w-100">
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>{{ $reply->user->name }}</h6>
                                                            </div>
                                                            <div class="col d-flex justify-content-end">
                                                                <p>{{ \Carbon\Carbon::parse($reply->created_at)->format('d/m/Y') }}</p>
                                                            </div>
                                                        </div>                   
                                                        <p>{{ $reply->isi }}</p>
                                                        <div class="row">
                                                            <div class="col"></div>
                                                            @if ($reply->user_id == $itemuser->id)
                                                                <div class="col d-flex justify-content-end">
                                                                    <div class="dropdown">
                                                                        <button class="btn-more" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <i class="fa-solid fa-ellipsis"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                <form action="{{ route('reply.destroy', $reply->id) }}" method="POST">
                                                                                    @csrf
                                                                                    {{ method_field('delete') }}
                                                                                    <button type="submit" class="btn-hapus">
                                                                                        Hapus
                                                                                    </button>
                                                                                </form>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($ulasan->user_id == $itemuser->id)
                            <div class="col d-flex justify-content-end">
                                <div class="dropdown dropstart">
                                    <button class="btn-more" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('ulasan.destroy', $ulasan->id) }}" method="POST">
                                                @csrf
                                                {{ method_field('delete') }}
                                                <button type="submit" class="btn-hapus">
                                                    Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
