@extends('layouts.dashboard')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            Data Transaksi
          </h3>
        </div>
        <div class="card-body">
          <!-- digunakan untuk menampilkan pesan error atau sukses -->
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
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Invoice</th>
                  <th>Nama Pembeli</th>
                  <th>Alamat Pembeli</th>
                  <th>Status Pengiriman</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              @foreach($itempesanan as $pesanan)
              @if ($pesanan->cart->status_cart == 'checkout')
              @if ($pesanan->cart->status_pembayaran == 'sudah')
              <tr>
                  <td>
                    {{ ++$no }}
                  </td>
                  <td>
                    {{ $pesanan->cart->no_invoice }}
                  </td>
                  <td>
                    {{ $pesanan->cart->user->name }}
                  </td>
                  <td>
                    {{ $pesanan->cart->order->nama_penerima }} - ({{ $pesanan->cart->order->no_tlp }}) {{ $pesanan->cart->order->kota }}, {{ $pesanan->cart->order->kecamatan }}, {{ $pesanan->cart->order->provinsi }}
                  </td>
                  <td>
                    {{ $pesanan->cart->status_pengiriman }}
                  </td>
                  <td>
                    <a href="{{ URL::to('seller/pesanan/' . $pesanan->cart->order->id) }}" class="btn btn-sm btn-info mb-2">
                      Detail
                    </a>
                    @if($itemuser->role == 'admin')
                    <a href="{{ route('transaksi.edit', $pesanan->id) }}" class="btn btn-sm btn-primary mb-2">
                      Edit
                    </a>
                    @endif
                  </td>
                </tr>
              @endif
              @endif
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
