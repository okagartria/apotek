@extends('admin.admin_template')

@section('content')
    <div class="row">
      <div class="col-xs-12">
              <div class="box">
          <div class="box-header">
            <h3 class="box-title">Data Obat</h3>
          </div>
                  <div box-header><a href="/obat/create" class="btn btn-primary left10px">Tambah Data Obat</a></div>
          <!-- /.box-header -->
          <div class="box-body">
            <!-- will be used to show any messages -->
            @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
            @endif
            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
                        <th>Stok Terakhir</th>
                        <th>Satuan</th>
                        <th>Action</th>

                    </tr>
                </thead>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
@stop

@section('scripts')
<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('obat.index') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'kode_obat', name: 'kode_obat' },
            { data: 'nama_obat', name: 'nama_obat' },
            { data: 'stok', name: 'stok' },
            { data: 'satuan', name: 'satuan' },
            { data: 'action', name: 'action' },
        ]
    });
});
</script>
@stop
