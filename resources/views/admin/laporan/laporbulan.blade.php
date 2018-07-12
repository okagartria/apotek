@extends('admin.admin_template')
@section('style')
<link rel="stylesheet" href="{{ asset("bower_components/Ionicons/css/ionicons.min.css") }}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset("bower_components/bootstrap-daterangepicker/daterangepicker.css") }}">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset("bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css") }}">


@stop

@section('content')
    <div class="row">
      <div class="col-xs-12">
              <div class="box">
          <div class="box-header">
            <h3 class="box-title">Pelaporan Bulan</h3>
          </div>

          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-sm-3">
                <!-- Date -->
                <form  id="search-form" class="form-inline" role="form" >
                <div class="form-group">
                  <label>Bulan:</label>

                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker">
                  </div>

                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
              </div>
            </div>
            <div class="row">
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
<!-- date-range-picker -->
<script src="{{ asset("bower_components/moment/min/moment.min.js") }}"></script>
<script src="{{ asset("bower_components/bootstrap-daterangepicker/daterangepicker.js") }}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js") }}"></script>

<script>
//Date picker
$('#datepicker').datepicker({
    format: "mm-yyyy",
    startView: "months",
     autoclose: true,
    minViewMode: "months"
})




$('#search-form').on('submit', function(e) {
       e.preventDefault();
       var date = $('#datepicker').val();
       var oTable = $('#users-table').DataTable({
               destroy: true,
               processing: true,
               serverSide: true,
               ajax: {
                   url: '{{ url("bulanan") }}',
                   data: { tgl: date},
                   method: 'GET'
               },
               columns: [
                   { data: 'ido', name: 'ido' },
                   { data: 'kode', name: 'kode' },
                   { data: 'nama_obat', name: 'nama_obat' },
                   { data: 'satuan', name: 'satuan' },
                   { data: 'stok_awal', name: 'stok_awal' },
                   { data: 'penerimaan', name: 'penerimaan' },
                   { data: 'persediaan', name: 'persediaan' },
                   { data: 'pemakaian', name: 'pemakaian' },
                   { data: 'stok_akhir', name: 'stok_akhir' },
                   { data: 'stok_opt', name: 'stok_opt' },

               ]
           });

        oTable.draw();
   });
</script>
@stop
