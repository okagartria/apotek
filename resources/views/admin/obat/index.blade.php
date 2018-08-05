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
                    <div class="alert alert-success" id="pesan">
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
    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('obat.index') !!}',
        columns: [
            { data: 'id', name: 'obats.id' },
            { data: 'kode_obat', name: 'kode_obat' },
            { data: 'nama_obat', name: 'nama_obat' },
            { data: 'stok', name: 'stok' },
            { data: 'satuan', name: 'satuans.satuan' },
            { data: 'action', name: 'action' },
        ]
    });

    $('#users-table').on('click', '.link[data-remote]', function (e) {
      e.preventDefault();
       $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      var url = $(this).data('remote');
      // confirm then
      if (confirm('Anda yakin ingin menghapus data ini?')) {
          $.ajax({
              url: url,
              type: 'DELETE',
              dataType: 'json',
              data: {method: '_DELETE', submit: true}
          }).always(function () {
            $( "#pesan" ).hide();
              alert("Data berhasil di hapus");
              table.ajax.reload();
          });
      }else
          alert("Batal menghapus");
  });


});



</script>
@stop
