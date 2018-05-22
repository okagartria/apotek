@extends('admin.admin_template')

@section('content')
    <div class="row">
      <div class="col-xs-12">
              <div class="box">
          <div class="box-header">
            <h3 class="box-title">Data Pengeluaran Obat</h3>
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
                        <th>Id</th>
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
                        <th>Penerimaan</th>
                        <th>Satuan</th>


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
        ajax: '{!! url('pengeluaran') !!}',
        columns: [
            { data: 'ido', name: 'ido' },
            { data: 'kode', name: 'kode' },
            { data: 'nama_obat', name: 'nama_obat' },
            { data: 'jumlah', name: 'jumlah',"defaultContent": 0 },
            { data: 'satuan', name: 'satuan' },
        ]
    });
});
</script>
@stop
