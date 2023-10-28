@extends('layouts.template')
@section('content')
<div class="produkdetail-main mx-2">
<div class="container-fluid">
  <div class="row mt-4">
    <div class="col-md-8">
      <div id="carouselIndicators" class="carousel slide" data-bs-ride="true">
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
    <!-- deskripsi produk -->
    <div class="col-md-4">
      <div class="row">
        <div class="col">
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
              <div class="profil-toko d-flex justify-content-between">
                <div class="d-flex">
                  @if($itemproduk->user->foto != null)
                      <img src="{{ \Storage::url($itemproduk->user->foto) }}" alt="profil" class="profile-toko-img">
                  @else
                      <img src="{{ asset('img/user1-128x128.jpg') }}" alt="profil" class="profile-toko-img">
                  @endif
                  <div class="profil-toko-text">
                    <h6>{{ $itemproduk->user->name }}</h6>
                    <p>{{ $itemproduk->user->alamat }}</p>
                  </div>
                </div>
                <div>
                <div class="dropdown">
                  <button class="seller-more-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    More
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="https://api.whatsapp.com/send?phone=62{{$itemproduk->user->phone}}" target="_blank">Chat WA</a></li>
                  </ul>
                  </div>
                </div>
              </div>
              <hr>
              <span class="small sec-title">{{ $itemproduk->kategori->nama_kategori }}</span>
              <h5>{{ $itemproduk->nama_produk }}</h5>
              <div class="product-rating">
                <div class="rating-star me-2">
                @php $ratingnum = (int) $ratingvalue @endphp
                @for ($i = 1; $i <= $ratingnum; $i++)
                  <i class="fa-solid fa-star checked"></i>
                @endfor
                @for ($j = $ratingnum + 1; $j <= 5; $j++)
                  <i class="fa-solid fa-star unchecked"></i>
                @endfor
                </div>
                <h5 class="rating me-2">{{ number_format($ratingvalue, 1) }}</h5>
                <h5 class="rating me-2">|</h5>
                <h5 class="rating">{{ count($itemulasan) }} Ulasan</h5>
              </div>
              <p class="m-0">Stock: {{ $itemproduk->qty }}</p>
              <!-- cek apakah ada promo -->
              <div class="harga-produk">
                @if($itemproduk->promo != null)
                <p>
                  <del>IDR {{ number_format($itemproduk->promo->harga_awal) }}</del>
                  <br />
                  IDR {{ number_format($itemproduk->promo->harga_akhir) }}
                </p>
                @elseif ($itemproduk->eventdetail != null)
                <p>
                  <del>IDR {{ number_format($itemproduk->eventdetail->harga_awal) }}</del>
                  <br />
                  IDR {{ number_format($itemproduk->eventdetail->harga_akhir) }}
                </p>
                @else
                <p>
                  IDR {{ number_format($itemproduk->harga) }}
                </p>
                @endif
              </div>
              <form action="{{ route('wishlist.store') }}" method="POST">
                @csrf
                <input type="hidden" name="produk_id" value={{ $itemproduk->id }}>
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                @if(isset($itemwishlist) && $itemwishlist)
                <i class="fa-solid fa-heart-circle-minus"></i> Hapus dari wishlist
                @else
                <i class="fa-solid fa-heart-circle-plus"></i> Tambahkan ke wishlist
                @endif
                </button>
              </form>
              <hr>
              <h6 class="m-0 fw-bold mb-1">Deskripsi Produk</h6>
              <p class="m-0">{{ $itemproduk->deskripsi_produk }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col">
          <div class="card">
            @if (Auth::check())
              @if ($itemproduk->qty > 0)
                @if ($itemproduk->user_id != Auth::user()->id)
                  <div class="card-body">
                    <form action="{{ route('cartdetail.store') }}" method="POST">
                      @csrf
                      <input type="hidden" name="produk_id" value={{$itemproduk->id}}>
                      <button class="btn btn-block btn-primary" type="submit">
                      <i class="fa fa-shopping-cart"></i> Tambahkan Ke Keranjang
                      </button>
                    </form>
                    <form action="{{ URL::to('buynow') }}" method="POST">
                      @csrf
                      <input type="hidden" name="produk_id" value={{$itemproduk->id}}>
                      <button class="btn btn-block btn-danger mt-4" type="submit">
                      <i class="fa fa-shopping-basket"></i> Beli Sekarang
                      </button>
                    </form>
                  </div>
                @endif
              @endif
            @else
            <div class="card-body">
              <form action="{{ route('cartdetail.store') }}" method="POST">
                @csrf
                <input type="hidden" name="produk_id" value={{$itemproduk->id}}>
                <button class="btn btn-block btn-primary" type="submit">
                <i class="fa fa-shopping-cart"></i> Tambahkan Ke Keranjang
                </button>
              </form>
              <form action="{{ URL::to('buynow') }}" method="POST">
                @csrf
                <input type="hidden" name="produk_id" value={{$itemproduk->id}}>
                <button class="btn btn-block btn-danger mt-4" type="submit">
                <i class="fa fa-shopping-basket"></i> Beli Sekarang
                </button>
              </form>
            </div>
            @endif
            <div class="card-footer">
              <div class="row mt-4">
                <div class="col text-center">
                  <i class="fa fa-truck-moving"></i>
                  <p>Pengiriman Cepat</p>
                </div>
                <div class="col text-center">
                  <i class="fa fa-calendar-week"></i>
                  <p>Garansi 7 hari</p>
                </div>
                <div class="col text-center">
                  <i class="fa fa-money-bill"></i>
                  <p>Pembayaran Aman</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col">
          <div class="card">
            <div class="ulasan-card p-3">
            <h4>Ulasan</h4>
            <div class="ulasan-product">
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Lihat Ulasan Lain</button>
                <hr>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        @foreach ($itemulasan as $ulasan)
                        <div class="row mb-4">
                            <div class="col-md-2">
                              @if($ulasan->user->foto != null)
                                  <img src="{{ \Storage::url($ulasan->user->foto) }}" alt="profil" class="ulasan-profile-img">
                              @else
                                  <img src="{{ asset('img/user1-128x128.jpg') }}" alt="profil" class="ulasan-profile-img">
                              @endif
                            </div>
                            <div class="col col-md-10 ulasan-profile">
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
                                                                  @if($reply->user->foto != null)
                                                                      <img src="{{ \Storage::url($reply->user->foto) }}" alt="profil" class="ulasan-profile-img">
                                                                  @else
                                                                      <img src="{{ asset('img/user1-128x128.jpg') }}" alt="profil" class="ulasan-profile-img">
                                                                  @endif
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
                                    @if (Auth::check())
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
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{ $itemulasan->links() }}
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
</div>
@endsection
