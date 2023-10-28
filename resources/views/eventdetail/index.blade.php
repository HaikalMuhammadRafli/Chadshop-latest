@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Produk Event Diskon</h4>
          <div class="card-tools">
            <a href="{{ route('eventdetail.create') }}" class="btn btn-sm btn-primary">
              Baru
            </a>
          </div>
        </div>
        <div class="card-body">
          <form action="#">
            <div class="row">
              <div class="col">
                <input type="text" name="keyword" id="keyword" class="form-control" placeholder="ketik keyword disini">
              </div>
              <div class="col-auto">
                <button class="btn btn-primary">
                  Cari
                </button>
              </div>
            </div>
          </form>
        </div>
        <div class="card-body">
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
          @if(count($errors) > 0)
          @foreach($errors->all() as $error)
              <div class="alert alert-warning">{{ $error }}</div>
          @endforeach
          @endif
          @foreach ($itemevent as $event)
          <div class="d-flex justify-content-between">
            <h5>{{ $event->nama_event }}</h5>
            <p>-- ({{ count($event->eventdetail) }}) produk --</p>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="50px">No</th>
                  <th>Nama produk</th>
                  <th>Harga Awal</th>
                  <th>Harga Akhir</th>
                  <th>Diskon</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              @foreach($event->eventdetail as $eventdet)
                <tr>
                  <td>
                  {{ ++$no }}
                  </td>
                  <td>
                  {{ $eventdet->produk->nama_produk }}
                  </td>
                  <td>
                  {{ number_format($eventdet->harga_awal) }}
                  </td>
                  <td>
                  ({{ $eventdet->diskon_persen }} %) - {{ number_format($eventdet->diskon_nominal) }}
                  </td>
                  <td>
                  {{ number_format($eventdet->harga_akhir) }}
                  </td>
                  <td>
                    <a href="{{ route('eventdetail.edit', $eventdet->id) }}" class="btn btn-sm btn-primary mr-2 mb-2">
                      Edit
                    </a>
                    <form action="{{ route('eventdetail.destroy', $eventdet->id) }}" method="POST" style="display:inline;">
                      @csrf
                      {{ method_field('delete') }}
                      <button type="submit" class="btn btn-sm btn-danger mb-2">
                        Hapus
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
            {{ $itemeventdetail->links() }}
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection