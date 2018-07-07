@extends('admin.admin_template')

@section('content')
    <div class="row">
      <div class="col-xs-12">
              <div class="box">
          <div class="box-header">
            <h3 class="box-title">Pelaporan Bulan</h3>
          </div>

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
                        <th>No</th>
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
                        <th>Satuan</th>
                        <th>Stok Awal</th>
                        <th>Penerimaan</th>
                        <th>Persediaan</th>
                        <th>Pemakaian</th>
                        <th>Sisa Stok</th>
                        <th>Stok Opt</th>
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
        ajax: '{!! url('bulanan') !!}',
        columns: [
            { data: 'ido', name: 'ido' },
            { data: 'kode', name: 'kode' },
            { data: 'nama_obat', name: 'nama_obat' },
            { data: 'satuan', name: 'satuan' },
            { data: 'stok_awal', name: 'stok_awal' },
            { data: 'penerimaan', name: 'penerimaan' },
            { data: 'persediaan', name: 'persediaan' },
            { data: 'pemakaian', name: 'pemakaian' },
            { data: 'stok', name: 'stok' },
            { data: 'stok_opt', name: 'stok_opt' },

        ]
    });
});
</script>
@stop
