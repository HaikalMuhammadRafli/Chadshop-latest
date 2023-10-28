@extends('layouts.template')

@section('content')
    <div class="transaksi-list-main mx-2">
        <div class="container-fluid">
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
            <h2 class="sec-title">Daftar Transaksi</h2>
            <ul class="nav nav-pills d-flex justify-content-between mb-3 shadow-sm" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-belum-pembayaran-tab" data-bs-toggle="pill" data-bs-target="#pills-belum-pembayaran" type="button" role="tab" aria-controls="pills-belum-pembayaran" aria-selected="true">Belum Pembayaran</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-sudah-pembayaran-tab" data-bs-toggle="pill" data-bs-target="#pills-sudah-pembayaran" type="button" role="tab" aria-controls="pills-sudah-pembayaran" aria-selected="false">Sudah Pembayaran</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-proses-pengiriman-tab" data-bs-toggle="pill" data-bs-target="#pills-proses-pengiriman" type="button" role="tab" aria-controls="pills-proses-pengiriman" aria-selected="false">Proses Pengiriman</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-sudah-diterima-tab" data-bs-toggle="pill" data-bs-target="#pills-sudah-diterima" type="button" role="tab" aria-controls="pills-sudah-diterima" aria-selected="false">Sudah Diterima</button>
                </li>
            </ul>
            <hr>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-belum-pembayaran" role="tabpanel" aria-labelledby="pills-belum-pembayaran-tab" tabindex="0">
                    @if (count($itemorder_n_n_n) == 0)
                        <h5>Tidak ada daftar transaksi!</h5>
                    @endif
                    <div class="transaksi-list">
                        @foreach ($itemorder_n_n_n as $order)
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="heads">
                                    <div class="head-left">
                                        <div class="icon">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                        </div>
                                        <div class="title">
                                            <h5>{{ $order->cart->no_invoice }}</h5>
                                            <p>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="head-right">
                                        <h5 class="btn btn-success">{{ ucfirst(trans($order->cart->status_pengiriman)) }} Dikirim</h5>
                                        <h5 class="btn btn-success">{{ ucfirst(trans($order->cart->status_pembayaran)) }} Dibayar</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @foreach ($order->cart->detail as $detail)
                                    <div class="produk-head mb-2">
                                        <div class="produk-left">
                                            @if($detail->produk->foto != null)
                                                <img src="{{ \Storage::url($detail->produk->foto) }}" alt="{{ $detail->produk->nama_produk }}" class="product-img">
                                            @else
                                                <img src="{{ asset('images/bag.jpg') }}" alt="{{ $detail->produk->nama_produk }}" class="product-img">
                                            @endif
                                            <div class="produk-title ms-3">
                                            <h5>{{ $detail->produk->nama_produk }}</h5>
                                            <p>{{ $detail->qty }} PCS</p>
                                            </div>
                                        </div>
                                        @if ($order->cart->status_penerimaan == 'sudah')
                                            <div class="produk-right">
                                                <a class="btn btn-primary" href="{{ URL::to('beri_ulasan/'.$detail->produk->slug_produk ) }}">Beri ulasan</a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer">
                                <div class="foot-left">
                                    <h5>Total Belanja</h5>
                                    <p>Rp {{ number_format($order->cart->total, 2) }}</p>
                                </div>
                                <div class="foot-right d-flex my-auto">
                                    <form action="{{ route('transaksi.destroy', $order->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="cart_id" value={{ $order->cart->id }}>
                                        <button type="submit" class="btn btn-danger">Cancel</button>
                                    </form>
                                    <div class="vr mx-3"></div>
                                    <div>
                                        <a href="{{ URL::to('transaksi_detail', $order->id) }}" class="btn btn-primary">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-sudah-pembayaran" role="tabpanel" aria-labelledby="pills-sudah-pembayaran-tab" tabindex="0">
                    @if (count($itemorder_y_n_n) == 0)
                        <h5>Tidak ada daftar transaksi!</h5>
                    @endif
                    <div class="transaksi-list">
                        @foreach ($itemorder_y_n_n as $order)
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="heads">
                                    <div class="head-left">
                                        <div class="icon">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                        </div>
                                        <div class="title">
                                            <h5>{{ $order->cart->no_invoice }}</h5>
                                            <p>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="head-right">
                                        <h5 class="btn btn-success">{{ ucfirst(trans($order->cart->status_pengiriman)) }} Dikirim</h5>
                                        <h5 class="btn btn-success">{{ ucfirst(trans($order->cart->status_pembayaran)) }} Dibayar</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @foreach ($order->cart->detail as $detail)
                                    <div class="produk-head mb-2">
                                        <div class="produk-left">
                                            @if($detail->produk->foto != null)
                                                <img src="{{ \Storage::url($detail->produk->foto) }}" alt="{{ $detail->produk->nama_produk }}" class="product-img">
                                            @else
                                                <img src="{{ asset('images/bag.jpg') }}" alt="{{ $detail->produk->nama_produk }}" class="product-img">
                                            @endif
                                            <div class="produk-title ms-3">
                                            <h5>{{ $detail->produk->nama_produk }}</h5>
                                            <p>{{ $detail->qty }} PCS</p>
                                            </div>
                                        </div>
                                        @if ($order->cart->status_penerimaan == 'sudah')
                                            <div class="produk-right">
                                                <a class="btn btn-primary" href="{{ URL::to('beri_ulasan/'.$detail->produk->slug_produk ) }}">Beri ulasan</a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer">
                                <div class="foot-left">
                                    <h5>Total Belanja</h5>
                                    <p>Rp {{ number_format($order->cart->total, 2) }}</p>
                                </div>
                                <div class="foot-right">
                                    <a href="{{ URL::to('transaksi_detail', $order->id) }}" class="btn btn-primary">Details</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-proses-pengiriman" role="tabpanel" aria-labelledby="pills-proses-pengiriman-tab" tabindex="0">
                    @if (count($itemorder_y_y_n) == 0)
                        <h5>Tidak ada daftar transaksi!</h5>
                    @endif
                    <div class="transaksi-list">
                        @foreach ($itemorder_y_y_n as $order)
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="heads">
                                    <div class="head-left">
                                        <div class="icon">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                        </div>
                                        <div class="title">
                                            <h5>{{ $order->cart->no_invoice }}</h5>
                                            <p>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="head-right">
                                        <h5 class="btn btn-success">{{ ucfirst(trans($order->cart->status_pengiriman)) }} Dikirim</h5>
                                        <h5 class="btn btn-success">{{ ucfirst(trans($order->cart->status_pembayaran)) }} Dibayar</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @foreach ($order->cart->detail as $detail)
                                    <div class="produk-head mb-2">
                                        <div class="produk-left">
                                            @if($detail->produk->foto != null)
                                                <img src="{{ \Storage::url($detail->produk->foto) }}" alt="{{ $detail->produk->nama_produk }}" class="product-img">
                                            @else
                                                <img src="{{ asset('images/bag.jpg') }}" alt="{{ $detail->produk->nama_produk }}" class="product-img">
                                            @endif
                                            <div class="produk-title ms-3">
                                            <h5>{{ $detail->produk->nama_produk }}</h5>
                                            <p>{{ $detail->qty }} PCS</p>
                                            </div>
                                        </div>
                                        @if ($order->cart->status_penerimaan == 'sudah')
                                            <div class="produk-right">
                                                <a class="btn btn-primary" href="{{ URL::to('beri_ulasan/'.$detail->produk->slug_produk ) }}">Beri ulasan</a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer">
                                <div class="foot-left">
                                    <h5 class="mb-1">Total Belanja</h5>
                                    <p class="mb-2">Rp {{ number_format($order->cart->total, 2) }}</p>
                                </div>
                                <div class="foot-right d-flex my-auto">
                                    <form action="{{ URL::to('/pesananditerima') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="cart_id" value={{$order->cart->id}}>
                                        <button class="btn btn-primary" type="submit">
                                            Barang Diterima
                                        </button>
                                    </form>
                                    <div class="vr mx-3"></div>
                                    <div>
                                        <a href="{{ URL::to('transaksi_detail', $order->id) }}" class="btn btn-primary">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-sudah-diterima" role="tabpanel" aria-labelledby="pills-sudah-diterima-tab" tabindex="0">
                    @if (count($itemorder_y_y_y) == 0)
                        <h5>Tidak ada daftar transaksi!</h5>
                    @endif
                    <div class="transaksi-list">
                        @foreach ($itemorder_y_y_y as $order)
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="heads">
                                    <div class="head-left">
                                        <div class="icon">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                        </div>
                                        <div class="title">
                                            <h5>{{ $order->cart->no_invoice }}</h5>
                                            <p>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="head-right">
                                        <h5 class="btn btn-success">{{ ucfirst(trans($order->cart->status_pengiriman)) }} Dikirim</h5>
                                        <h5 class="btn btn-success">{{ ucfirst(trans($order->cart->status_pembayaran)) }} Dibayar</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @foreach ($order->cart->detail as $detail)
                                    <div class="produk-head mb-2">
                                        <div class="produk-left">
                                            @if($detail->produk->foto != null)
                                                <img src="{{ \Storage::url($detail->produk->foto) }}" alt="{{ $detail->produk->nama_produk }}" class="product-img">
                                            @else
                                                <img src="{{ asset('images/bag.jpg') }}" alt="{{ $detail->produk->nama_produk }}" class="product-img">
                                            @endif
                                            <div class="produk-title ms-3">
                                            <h5>{{ $detail->produk->nama_produk }}</h5>
                                            <p>{{ $detail->qty }} PCS</p>
                                            </div>
                                        </div>
                                        @if ($order->cart->status_penerimaan == 'sudah')
                                            <div class="produk-right">
                                                <a class="btn btn-primary" href="{{ URL::to('beri_ulasan/'.$detail->produk->slug_produk ) }}">Beri ulasan</a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer">
                                <div class="foot-left">
                                    <h5>Total Belanja</h5>
                                    <p>Rp {{ number_format($order->cart->total, 2) }}</p>
                                </div>
                                <div class="foot-right">
                                    <a href="{{ URL::to('transaksi_detail', $order->id) }}" class="btn btn-primary">Details</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection