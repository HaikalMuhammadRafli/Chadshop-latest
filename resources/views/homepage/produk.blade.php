@extends('layouts.template')
@section('content')
<div class="produk-main mx-2">
<div class="container-fluid">
  <div class="row mt-4">
    <div class="col-md-3 mb-2">
      <div class="kategori-list">
        <h6 class="mb-3">Kategori List</h6>
        <ul class="list-group">
          @foreach($listkategori as $kategori)
          <a href="{{ URL::to('kategori/'.$kategori->slug_kategori) }}" class="text-decoration-none">
            <li class="list-group-item list-group-item-action d-flex justify-content-between">
              <p>{{ $kategori->nama_kategori }}</p>
              <p>({{ count($kategori->produk) }} produk)</p>
            </li>
          </a>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="col-md-9 mb-2">
      @if(isset($itemkategori))
      <h3 class="sec-title">Kategori : {{ $itemkategori->nama_kategori }}</h3>
      @else
      <h3 class="sec-title">Semua Kategori</h3>
      @endif
      <div class="row row-cols-1 row-cols-lg-3 g-2 g-lg-3">
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
      <div class="row">
        <div class="col">
          {{ $itemproduk->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
