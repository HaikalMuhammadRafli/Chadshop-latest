@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Form Event</h3>
          <div class="card-tools">
            <a href="{{ route('event.index') }}" class="btn btn-sm btn-danger">
              Tutup
            </a>
          </div>
        </div>
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
          <form action="{{ route('eventdetail.store') }}" method='POST'>
          @csrf
            <div class="form-group">
                <label for="event_id">Pilih Event</label>
                <select class="custom-select" name="event_id" required>
                    <option selected>...</option>
                    @foreach ($itemevent as $event)
                    <option value="{{ $event->id }}">{{ $event->nama_event }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="produk_id">Pilih Produk</label>
                <select class="custom-select" name="produk_id" id="produk_id" required>
                    <option selected>...</option>
                    @foreach ($itemproduk as $produk)
                    @if (!isset($produk->eventdetail) && !isset($produk->promo))
                    <option value="{{ $produk->id }}">{{ $produk->nama_produk }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
              <label for="harga_awal">Harga Awal</label>
              <input type="text" name="harga_awal" id="harga_awal" class="form-control" value={{ old('harga_awal') }}>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="diskon_persen">Diskon Persen</label>
                  <input type="text" name="diskon_persen" id="diskon_persen" class="form-control" value={{ old('diskon_persen') }}>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="diskon_nominal">Diskon Nominal</label>
                  <input type="text" name="diskon_nominal" id="diskon_nominal" class="form-control" value={{ old('diskon_nominal') }}>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="harga_akhir">Harga Akhir</label>
              <input type="text" name="harga_akhir" id="harga_akhir" class="form-control" value={{ old('harga_akhir') }}>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="reset" class="btn btn-warning">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  // cari nominal diskon
  $('#diskon_persen').on('keyup', function() {
    var harga_awal = $('#harga_awal').val();
    var diskon_persen = $('#diskon_persen').val();
    var diskon_nominal = diskon_persen / 100 * harga_awal;
    var harga_akhir = harga_awal - diskon_nominal;
    $('#diskon_nominal').val(diskon_nominal);
    $('#harga_akhir').val(harga_akhir);
  })
  // cari nominal persen
  $('#diskon_nominal').on('keyup', function() {
    var harga_awal = $('#harga_awal').val();
    var diskon_nominal = $('#diskon_nominal').val();
    var diskon_persen = diskon_nominal / harga_awal * 100;
    var harga_akhir = harga_awal - diskon_nominal;
    $('#diskon_persen').val(diskon_persen);
    $('#harga_akhir').val(harga_akhir);
  })
  // load produk detail
  $('#produk_id').on('change', function() {
    var id = $('#produk_id').val();
    $.ajax({
      url: '{{ URL::to('seller/loadprodukasync') }}/'+id,
      type: 'get',
      dataType: 'json',
      success: function (data,status) {
        if (status == 'success') {
          $('#harga_awal').val(data.itemproduk.harga);
        }
      },
      error : function(x,t,m) {
      }
    })
  })
</script>
@endsection