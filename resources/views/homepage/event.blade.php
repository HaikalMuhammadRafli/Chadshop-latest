@extends('layouts.template')
@section('content')
    <div class="event-main">
        <img src="{{ \Storage::url($itemevent->banner) }}" alt="{{ $itemevent->nama_event }}" class="banner">

        <div class="container-fluid">
            <div class="mx-2">
                <div class="row row-cols-1 row-cols-lg-5 g-2 g-lg-3 mt-2">
                    @foreach($itemeventdetail as $eventdet)
                        <div class="col-md-2">
                            <div class="card mb-4 shadow-sm">
                                <a href="{{ URL::to('produk/'.$eventdet->produk->slug_produk ) }}">
                                    <div class="product-img-container">
                                    @if($eventdet->produk->foto != null)
                                        <img src="{{ \Storage::url($eventdet->produk->foto) }}" alt="{{ $eventdet->produk->nama_produk }}" class="card-img-top product-img">
                                    @else
                                        <img src="{{ asset('images/bag.jpg') }}" alt="{{ $eventdet->produk->nama_produk }}" class="card-img-top product-img">
                                    @endif
                                    </div>
                                    <p class="discount">{{ $eventdet->diskon_persen }}%</p>
                                    <p class="promoted-produk">{{ $eventdet->event->nama_event }}</p>
                                    <div class="card-body">
                                        <div class="product-title-container">
                                            <h6 class="category-text">{{ $eventdet->produk->kategori->nama_kategori }}</h6>
                                            <h6 class="card-text">{{ $eventdet->produk->nama_produk }}</h6>
                                        </div>
                                        <div class="product-price-container">
                                            <p><del>IDR {{ number_format($eventdet->harga_awal) }}</del></p>
                                            <p>IDR {{ number_format($eventdet->harga_akhir) }}</p>
                                        </div>
                                        <hr>
                                        <div class="product-rating-container d-flex">
                                            <i class="fa-solid fa-star"></i>
                                            <p class="me-2">{{ number_format($eventdet->produk->rating, 1) }}</p>
                                            <p class="me-2">|</p>
                                            <p>{{ count($eventdet->produk->ulasan) }} Ulasan</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection