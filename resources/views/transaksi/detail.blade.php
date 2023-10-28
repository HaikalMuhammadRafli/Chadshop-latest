@extends('layouts.template')

@section('content')
<div class="container-fluid">
  <div class="transaksi-detail-main mx-2">
    <div class="row">
      <div class="col col-lg-8 col-md-8 mb-2">
        <div class="card mb-3">
          <div class="card-header">
            <div class="card-title">Item</div>
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
                      Foto
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
                  </tr>
                </thead>
                <tbody>
                @foreach($itemorder->cart->detail as $detail)
                  <tr>
                    <td>
                    {{ $no++ }}
                    </td>
                    <td>
                    {{ $detail->produk->kode_produk }}
                    </td>
                    <td>
                    @if($detail->produk->foto != null)
                      <img src="{{ \Storage::url($detail->produk->foto) }}" alt="{{ $detail->produk->nama_produk }}" class="product-img">
                    @else
                      <img src="{{ asset('images/bag.jpg') }}" alt="{{ $detail->produk->nama_produk }}" class="product-img">
                    @endif
                    </td>
                    <td>
                    {{ $detail->produk->nama_produk }}
                    </td>
                    <td class="text-right">
                    {{ number_format($detail->harga, 2) }}
                    </td>
                    <td class="text-right">
                    {{ number_format($detail->diskon, 2) }}
                    </td>
                    <td class="text-right">
                    {{ $detail->qty }}
                    </td>
                    <td class="text-right">
                    {{ number_format($detail->subtotal, 2) }}
                    </td>
                  </tr>
                @endforeach
                  <tr>
                    <td colspan="7">
                      <b>Total</b>
                    </td>
                    <td class="text-right">
                      <b>
                      {{ number_format($itemorder->cart->total, 2) }}
                      </b>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <a href="{{ URL::to('transaksi_list') }}" class="btn btn-sm btn-danger">Tutup</a>
          </div>
        </div>
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
      <div class="col col-lg-4 col-md-4">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Ringkasan</div>
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
                  <tr>
                    <td>
                      Status Penerimaan
                    </td>
                    <td class="text-right">
                    {{ $itemorder->cart->status_penerimaan }}
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <button id="pay-button" class="btn btn-success w-100">Bayar!</button>
                    </td>
                  </tr>
                  <script type="text/javascript">
                    // For example trigger on button clicked, or any time you need
                    var payButton = document.getElementById('pay-button');
                    payButton.addEventListener('click', function () {
                      // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
                      window.snap.pay('{{ $snap_token }}');
                      // customer will be redirected after completing payment pop-up
                    });
                  </script>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection