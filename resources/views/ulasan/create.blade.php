@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="ulasan-create mx-2">
            <div class="product-details">
                <div class="row">
                    <div class="col-md-8">
                        <div id="carouselIndicators" class="carousel slide shadow-sm" data-bs-ride="true">
                            <div class="carousel-indicators">
                                @foreach($itemproduk->images as $image)
                                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="true" aria-label="Slide 1"></button>
                                @endforeach
                            </div>
                            <div class="carousel-inner">
                                @foreach($itemproduk->images as $index => $image)
                                    @if($index == 0)
                                        <div class="carousel-item active">
                                            <img src="{{ \Storage::url($image->foto) }}" class="d-block w-100" alt="...">
                                        </div>
                                    @else
                                        <div class="carousel-item">
                                            <img src="{{ \Storage::url($image->foto) }}" class="d-block w-100" alt="...">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-card card shadow-sm">
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
                            <div class="profil-toko d-flex">
                                <img src="{{ asset('img/user1-128x128.jpg') }}" alt="profil" class="profile-toko-img">
                                <div class="profil-toko-text">
                                    <h6>{{ $itemproduk->user->name }}</h6>
                                    <p>{{ $itemproduk->user->alamat }}</p>
                                </div>
                            </div>
                            <hr>
                            <h4>{{ $itemproduk->nama_produk }}</h4>
                            <p>{{ $itemproduk->kategori->nama_kategori }}</p>
                            <a class="btn btn-primary mb-2" href="{{ URL::to('produk/'.$itemproduk->slug_produk ) }}">Liat Halaman Produk</a>
                            <form action="{{ route('cartdetail.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produk_id" value={{$itemproduk->id}}>
                                <button class="btn btn-block btn-primary" type="submit">
                                    Beli lagi
                                </button>
                            </form>
                            <hr>
                            <div class="ulasan-card">
                                @if (!isset($cekulasan))
                                <form action="{{ route('ulasan.store', $itemproduk->id) }}" method="POST">
                                    @csrf
                                    <div class="rating-star">
                                        <input type="radio" value="1" name="rating" id="rating-1">
                                        <label for="rating-1" class="fa-solid fa-star"></label>
                                        <input type="radio" value="2" name="rating" id="rating-2">
                                        <label for="rating-2" class="fa-solid fa-star"></label>
                                        <input type="radio" value="3" name="rating" id="rating-3">
                                        <label for="rating-3" class="fa-solid fa-star"></label>
                                        <input type="radio" value="4" name="rating" id="rating-4">
                                        <label for="rating-4" class="fa-solid fa-star"></label>
                                        <input type="radio" value="5" name="rating" id="rating-5" checked>
                                        <label for="rating-5" class="fa-solid fa-star"></label>
                                    </div>
                                    <p>Apa tanggapanmu tentang produk ini?</p>
                                    <h5>{{ $itemuser->name }}</h5>
                                    <div class="row mb-3">
                                        <div class="col col-md-10">
                                            <input type="hidden" name="produk_id" value="{{ $itemproduk->id }}">
                                            <textarea class="form-control" name="isi_ulasan" id="ulasan" rows="1" placeholder="ketik ulasan..."></textarea>
                                        </div>
                                        <div class="col col-md-2">
                                            <button class="btn btn-primary" type="submit"><i class="fa-regular fa-paper-plane"></i></button>
                                        </div>
                                    </div>
                                </form>
                                @else
                                <h6>Anda sudah memberikan ulasan!</h6>
                                @endif
                                <div class="ulasan-product">
                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Lihat Ulasan Lain</button>
                                    <hr>
                                    <div class="collapse" id="collapseExample">
                                        <div class="card card-body">
                                            @foreach ($itemulasan as $ulasan)
                                            <div class="row mb-4">
                                                <div class="col col-md-2 col-lg-2">
                                                    <img src="{{ asset('img/user1-128x128.jpg') }}" alt="profil" class="ulasan-profile-img">
                                                </div>
                                                <div class="col col-md-10 col-lg-10 ulasan-profile">
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
                                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Balasan Dari Ulasan Milik {{ $ulasan->user->name }}</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            @foreach ($ulasan->reply as $reply)
                                                                                <div class="row mb-3">
                                                                                    <div class="col col-md-2 col-lg-2">
                                                                                        <img src="{{ asset('img/user1-128x128.jpg') }}" alt="profil" class="ulasan-profile-img">
                                                                                    </div>
                                                                                    <div class="col col-md-10 col-lg-10 ulasan-profile">
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
                                                                                            @if (Auth::check())
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
                                                                                <input type="hidden" name="produk_id" id="produk_id" value="{{ $itemproduk->id }}">
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
                </div>
            </div>
        </div>
    </div>
@endsection