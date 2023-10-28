@extends('layouts.dashboard')
@section('content')
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
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Item</h3>
        </div>
        <div class="card-body">
        <div class="table-responsive">
            <table class="table">
            <thead>
                <tr>
                    <th>
                        No
                    </th>
                    <th>
                        Kode
                    </th>
                    <th>
                        Nama
                    </th>
                    <th>
                        Harga
                    </th>
                    <th>
                        Diskon
                    </th>
                    <th>
                        Qty
                    </th>
                    <th>
                        Subtotal
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach($itemorder->cart->detail as $detail)
                @if ($detail->produk->user_id == $itemuser->id)
                <tr>
                    <td>
                    {{ $no++ }}
                    </td>
                    <td>
                    {{ $detail->produk->kode_produk }}
                    </td>
                    <td>
                    {{ $detail->produk->nama_produk }}
                    </td>
                    <td>
                    {{ number_format($detail->harga) }}
                    </td>
                    <td>
                    {{ number_format($detail->diskon) }}
                    </td>
                    <td>
                    {{ $detail->qty }}
                    </td>
                    <td>
                    {{ number_format($detail->subtotal) }}
                    </td>
                    @if ($detail->produk->user_id == $itemuser->id)
                        @if ($detail->status_pesanan == 'menunggu')
                            <td>
                                <form action="{{ URL::to('seller/kirimpesanan') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="cart_id" value={{$detail->cart_id}}>
                                    <input type="hidden" name="cartdetail_id" value={{$detail->id}}>
                                    <input type="hidden" name="produk_id" value={{$detail->produk->id}}>
                                    <input type="hidden" name="qty_pesanan" value={{$detail->qty}}>
                                    <input type="hidden" name="qty_produk" value={{$detail->produk->qty}}>
                                    <button class="btn btn-primary" type="submit">
                                        Kirim
                                    </button>
                                </form>
                            </td>
                        @elseif ($detail->status_pesanan == 'terkirim')
                        <td>
                            <button class="btn btn-outline-primary">Terkirim</button>
                        </td>
                        @endif
                    @endif
                    </tr>
                @endif
            @endforeach
                    <tr>
                    <td colspan="7">
                        <b>Total</b>
                    </td>
                    <td class="text-right">
                        <b>
                        {{ number_format($itemorder->cart->detail->sum('subtotal')) }}
                        </b>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
        <div class="card-footer">
        <a href="{{ URL::to('seller/pesanan') }}" class="btn btn-sm btn-danger">Tutup</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ringkasan</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                        <tbody>
                            <tr>
                            <td>
                                Total
                            </td>
                            <td class="text-right">
                                {{ number_format($itemorder->cart->total, 2) }}
                            </td>
                            </tr>
                            <tr>
                            <td>
                                Subtotal
                            </td>
                            <td class="text-right">
                            {{ number_format($itemorder->cart->subtotal, 2) }}
                            </td>
                            </tr>
                            <tr>
                            <td>
                                Diskon
                            </td>
                            <td class="text-right">
                            {{ number_format($itemorder->cart->diskon, 2) }}
                            </td>
                            </tr>
                            <tr>
                            <td>
                                Ongkir
                            </td>
                            <td class="text-right">
                            {{ number_format($itemorder->cart->ongkir, 2) }}
                            </td>
                            </tr>
                            <tr>
                            <td>
                                Ekspedisi
                            </td>
                            <td class="text-right">
                            {{ number_format($itemorder->cart->ekspedisi, 2) }}
                            </td>
                            </tr>
                            <tr>
                            <td>
                                No. Resi
                            </td>
                            <td class="text-right">
                            {{ number_format($itemorder->cart->no_resi, 2) }}
                            </td>
                            </tr>
                            <tr>
                            <td>
                                Status Pembayaran
                            </td>
                            <td class="text-right">
                            {{ $itemorder->cart->status_pembayaran }}
                            </td>
                            </tr>
                            <tr>
                            <td>
                                Status Pengiriman
                            </td>
                            <td class="text-right">
                            {{ $itemorder->cart->status_pengiriman }}
                            </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
        <div class="card">
        <div class="card-header">Alamat Pengiriman</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-stripped">
              <thead>
                <tr>
                  <th>Nama Penerima</th>
                  <th>Alamat</th>
                  <th>No tlp</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    {{ $itemorder->nama_penerima }}
                  </td>
                  <td>
                    {{ $itemorder->alamat }}<br />
                    {{ $itemorder->kelurahan}}, {{ $itemorder->kecamatan}}<br />
                    {{ $itemorder->kota}}, {{ $itemorder->provinsi}} - {{ $itemorder->kodepos}}
                  </td>
                  <td>
                    {{ $itemorder->no_tlp }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
        </div>
    </div>
</div>
@endsection
