@extends('layouts.admin-template')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Event Diskon</h4>
          <div class="card-tools">
            <a href="{{ route('event.create') }}" class="btn btn-sm btn-primary">
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
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="50px">No</th>
                  <th>Kode</th>
                  <th>Banner</th>
                  <th>Nama</th>
                  <th>Jumlah Produk</th>
                  <th>Status</th>
                  <th>Start</th>
                  <th>End</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              @foreach($itemevent as $event)
                <tr>
                  <td>
                  {{ ++$no }}
                  </td>
                  <td>
                  {{ $event->kode_event }}
                  </td>
                  <td>
                    @if($event->banner != null)
                    <img src="{{ \Storage::url($event->banner) }}" alt="{{ $event->caption_title }}" width='100px' class="img-thumbnail">
                    @endif
                  </td>
                  <td>
                  {{ $event->nama_event }}
                  </td>
                  <td>
                  {{ count($event->eventdetail) }} produk
                  </td>
                  <td>
                  {{ $event->status }}
                  </td>
                  <td>
                  {{ $event->start_datetime }}
                  </td>
                  <td>
                  {{ $event->end_datetime }}
                  </td>
                  <td>
                    <a href="{{ route('event.edit', $event->id) }}" class="btn btn-sm btn-primary mr-2 mb-2">
                      Edit
                    </a>
                    <form action="{{ route('event.destroy', $event->id) }}" method="POST" style="display:inline;">
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
            {{ $itemevent->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection