@extends('layouts.template')
@section('content')
<div class="container-fluid">
  <div class="index-main mx-2">
    <!-- carousel -->
    @if (count($itemevent) > 0)
      <div class="row">
        <div class="col">
          <div id="carousel" class="carousel slide shadow-sm mb-4" data-bs-ride="true">
            <div class="carousel-indicators">
              @foreach($itemevent as $event)
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="true" aria-label="Slide 1"></button>
              @endforeach
            </div>
              <div class="carousel-inner rounded-4">
                @foreach($itemevent as $index => $event )
                <a href="{{ URL::to('event/' . $event->slug_event) }}">
                  @if($index == 0)
                    <div class="carousel-item active">
                      <img src="{{ \Storage::url($event->banner) }}" class="d-block w-100 img-fluid" alt="...">
                    </div>
                  @else
                    <div class="carousel-item">
                      <img src="{{ \Storage::url($event->banner) }}" class="d-block w-100 img-fluid" alt="...">
                    </div>
                  @endif
                </a>
                @endforeach
              </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
    @else
      <div class="row">
        <div class="col">
          <div id="carousel" class="carousel slide shadow-sm" data-bs-ride="true">
            <div class="carousel-indicators">
              @foreach($itemslide as $slide)
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="true" aria-label="Slide 1"></button>
              @endforeach
            </div>
            <div class="carousel-inner rounded-4">
              @foreach($itemslide as $index => $slide )
                @if($index == 0)
                  <div class="carousel-item active">
                    <img src="{{ \Storage::url($slide->foto) }}" class="d-block w-100 img-fluid" alt="...">
                  </div>
                @else
                  <div class="carousel-item">
                    <img src="{{ \Storage::url($slide->foto) }}" class="d-block w-100" alt="...">
                  </div>
                @endif
              @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
    @endif
    <!-- end carousel -->

    <div class="kategori-container mb-3 shadow-sm">
      <h2 class="sec-title mb-3">CATEGORY</h2> 
      <div class="btn-group justify-content-between d-flex" role="group" aria-label="Basic outlined example">
        @foreach($itemkategori as $kategori)
        <a class="btn btn-outline-primary btn-kategori" href="{{ URL::to('kategori/'.$kategori->slug_kategori) }}">{{ $kategori->nama_kategori }}</a>
        @endforeach
      </div>
    </div>
    <hr>

    
      @foreach ($itemevent as $event)
      @if (count($event->eventdetail) > 0)
      <div class="d-flex mb-2">
        <h4 class="me-3 my-auto">{{ $event->nama_event }}</h4>
        <a href="{{ URL::to('event/' . $event->slug_event) }}" class="my-auto"><h6 class="link-prim my-auto">Lihat Semua! <i class="fa-solid fa-angles-right"></i></h6></a>
      </div>
        <div class="event-container mb-4">
          <div class="row row-cols-1 row-cols-lg-5 g-2 g-lg-3">
            @foreach ($event->eventdetail->take(4) as $detail)
              <div class="col-md-2 mt-0">
                <div class="card shadow-sm">
                    <a href="{{ URL::to('produk/'.$detail->produk->slug_produk) }}">
                      <div class="product-img-container">
                        @if($detail->produk->foto != null)
                        <img src="{{\Storage::url($detail->produk->foto) }}" alt="{{ $detail->produk->nama_produk }}" class="card-img-top product-img">
                        @else
                        <img src="{{asset('images/bag.jpg') }}" alt="{{ $detail->produk->nama_produk }}" class="card-img-top product-img">
                        @endif
                      </div>
                      <p class="discount">{{ $detail->diskon_persen }}% off</p>
                      <p class="promoted-produk">{{ $event->nama_event }}</p>
                    <div class="card-body">
                      <div class="product-title-container">
                        <h6 class="category-text">{{ $detail->produk->kategori->nama_kategori }}</h6>
                        <h6 class="card-text">{{ $detail->produk->nama_produk }}</h6>
                      </div>
                      <div class="product-price-container">
                        <p><del>IDR {{ number_format($detail->harga_awal) }}</del></p>
                        <p>IDR {{ number_format($detail->harga_akhir) }}</p>
                      </div>
                      <h6 class="alamat-seller"><i class="fa-solid fa-location-dot"></i> {{ $detail->produk->user->alamat }}</h6>
                      <hr>
                      <div class="product-rating-container d-flex">
                        <i class="fa-solid fa-star"></i>
                        <p class="me-2">{{ number_format($detail->produk->rating, 1) }}</p>
                        <p class="me-2">|</p>
                        <p>{{ count($detail->produk->ulasan) }} Ulasan</p>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
      @endforeach

    <!-- produk Promo-->
    <h2 class="sec-title mt-4 mb-3">AVAILABLE PROMOS</h2>
    <div class="row row-cols-1 row-cols-lg-5 g-2 g-lg-3">
      @foreach($itempromo as $promo)
      <!-- produk pertama -->
      <div class="col-md-2">
        <div class="card mb-4 shadow-sm">
          <a href="{{ URL::to('produk/'.$promo->produk->slug_produk) }}">
            <div class="product-img-container">
              @if($promo->produk->foto != null)
              <img src="{{\Storage::url($promo->produk->foto) }}" alt="{{ $promo->produk->nama_produk }}" class="card-img-top product-img">
              @else
              <img src="{{asset('images/bag.jpg') }}" alt="{{ $promo->produk->nama_produk }}" class="card-img-top product-img">
              @endif
            </div>
            <p class="discount">{{ $promo->diskon_persen }}%</p>
            <p class="promoted-produk">Diskon Toko</p>
          <div class="card-body">
            <div class="product-title-container">
              <h6 class="category-text">{{ $promo->produk->kategori->nama_kategori }}</h6>
              <h6 class="card-text">{{ $promo->produk->nama_produk }}</h6>
            </div>
            <div class="product-price-container">
              <p><del>IDR {{ number_format($promo->harga_awal) }}</del></p>
              <p>IDR {{ number_format($promo->harga_akhir) }}</p>
            </div>
            <h6 class="alamat-seller"><i class="fa-solid fa-location-dot"></i> {{ $promo->produk->user->alamat }}</h6>
            <hr>
            <div class="product-rating-container d-flex">
              <i class="fa-solid fa-star"></i>
              <p class="me-2">{{ number_format($promo->produk->rating, 1) }}</p>
              <p class="me-2">|</p>
              <p>{{ count($promo->produk->ulasan) }} Ulasan</p>
            </div>
          </div>
          </a>
        </div>
      </div>
      @endforeach
    </div>
    <hr>
    <!-- end produk promo -->
    
    <!-- produk Terbaru-->
    <h2 class="sec-title mt-4 mb-3">NEW PRODUCTS</h2>
    <div class="row row-cols-1 row-cols-lg-5 g-2 g-lg-3">
      @foreach($itemproduk as $produk)
      <!-- produk pertama -->
      <div class="col-md-2">
        <div class="card mb-4 shadow-sm">
          <a href="{{ URL::to('produk/'.$produk->slug_produk ) }}">
            <div class="product-img-container">
              @if($produk->foto != null)
              <img src="{{ \Storage::url($produk->foto) }}" alt="{{ $produk->nama_produk }}" class="card-img-top product-img">
              @else
              <img src="{{ asset('images/bag.jpg') }}" alt="{{ $produk->nama_produk }}" class="card-img-top product-img">
              @endif
            </div>
              @if (isset($produk->promo))
                @if ($produk->promo->produk_id == $produk->id)
              <p class="discount">{{ $produk->promo->diskon_persen }}%</p>
              <p class="promoted-produk">Diskon Toko</p>
                <div class="card-body">
                  <div class="product-title-container">
                    <h6 class="category-text">{{ $produk->kategori->nama_kategori }}</h6>
                    <h6 class="card-text">{{ $produk->nama_produk }}</h6>
                  </div>
                  <div class="product-price-container">
                    <p><del>IDR {{ number_format($produk->promo->harga_awal) }}</del></p>
                    <p>IDR {{ number_format($produk->promo->harga_akhir) }}</p>
                  </div>
                  <h6 class="alamat-seller"><i class="fa-solid fa-location-dot"></i> {{ $produk->user->alamat }}</h6>
                  <hr>
                  <div class="product-rating-container d-flex">
                    <i class="fa-solid fa-star"></i>
                    <p class="me-2">{{ number_format($produk->rating, 1) }}</p>
                    <p class="me-2">|</p>
                    <p>{{ count($produk->ulasan) }} Ulasan</p>
                  </div>
                @endif
              @elseif (isset($produk->eventdetail))
                <p class="discount">{{ $produk->eventdetail->diskon_persen }}%</p>
                <p class="promoted-produk">{{ $produk->eventdetail->event->nama_event }}</p>
                <div class="card-body">
                  <div class="product-title-container">
                    <h6 class="category-text">{{ $produk->kategori->nama_kategori }}</h6>
                    <h6 class="card-text">{{ $produk->nama_produk }}</h6>
                  </div>
                  <div class="product-price-container">
                    <p><del>IDR {{ number_format($produk->eventdetail->harga_awal) }}</del></p>
                    <p>IDR {{ number_format($produk->eventdetail->harga_akhir) }}</p>
                  </div>
                  <h6 class="alamat-seller"><i class="fa-solid fa-location-dot"></i> {{ $produk->user->alamat }}</h6>
                  <hr>
                  <div class="product-rating-container d-flex">
                    <i class="fa-solid fa-star"></i>
                    <p class="me-2">{{ number_format($produk->rating, 1) }}</p>
                    <p class="me-2">|</p>
                    <p>{{ count($produk->ulasan) }} Ulasan</p>
                  </div>
              @else
              <div class="card-body">
                <div class="product-title-container">
                  <h6 class="category-text">{{ $produk->kategori->nama_kategori }}</h6>
                  <h6 class="card-text">{{ $produk->nama_produk }}</h6>
                </div>
                <div class="product-price-container">
                  <p>IDR {{ number_format($produk->harga) }}</p>
                </div>
                <h6 class="alamat-seller"><i class="fa-solid fa-location-dot"></i> {{ $produk->user->alamat }}</h6>
                <hr>
                <div class="product-rating-container d-flex">
                  <i class="fa-solid fa-star"></i>
                  <p class="me-2">{{ number_format($produk->rating, 1) }}</p>
                  <p class="me-2">|</p>
                  <p>{{ count($produk->ulasan) }} Ulasan</p>
                </div>
              @endif
            </div>
          </a>
        </div>
      </div>
      @endforeach
    </div>
    <!-- end produk terbaru -->
  </div>
</div>
@endsection