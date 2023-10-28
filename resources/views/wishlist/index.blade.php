@extends('layouts.template')
@section('content')
<div class="container-fluid">
  <div class="wishlist-main mx-2">
    <h2>Wishlist</h2>
    <div class="wishlist-list row">
      @foreach ($itemwishlist as $wish)
      <div class="col-md-6 mb-3">
        <a href="{{ URL::to('produk/'.$wish->produk->slug_produk ) }}">
          <div class="wish-card">
            <div class="content d-flex flex-row justify-content-between">
              <div class="head d-flex flex-row">
                @if($wish->produk->foto != null)
                  <img src="{{ \Storage::url($wish->produk->foto) }}" alt="{{ $wish->produk->nama_produk }}" class="product-img">
                @else
                  <img src="{{ asset('images/bag.jpg') }}" alt="{{ $wish->produk->nama_produk }}" class="product-img">
                @endif
                <div class="ms-3">
                  <h6>{{ $wish->produk->nama_produk }}</h6>
                  <p>{{ $wish->produk->kategori->nama_kategori }}</p>
                </div>
              </div>
              <div class="action-btn">
                <form action="{{ route('wishlist.destroy', $wish->id) }}" method="post" style="display:inline;">
                  @csrf
                  {{ method_field('delete') }}
                  <button type="submit" class="btn btn-sm btn-danger mb-2">
                    Hapus
                  </button>
                </form>
              </div>
            </div>
          </div>
        </a>
      </div>
      @endforeach
    </div>
    {{ $itemwishlist->links() }}

  </div>
</div>
@endsection
