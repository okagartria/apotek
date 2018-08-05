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
            <h3 class="box-title">Data Pengeluaran Obat</h3>
          </div>

          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-sm-3">
                <!-- Date -->
                <form  id="search-form" class="form-inline" role="form" >
                <div class="form-group">
                  <label>Bulan:</label>

                  <div class="input-group date" id="picker">
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
              <div class="col-sm-2">
                  <button class="btn btn-success" id="download" style="display:none">Download Laporan</button>
              </div>
            </div>
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
                        <th>Pengeluaran</th>
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
});

$('#download').click(function(){
  var date = $('#datepicker').val();
  var form = $(document.createElement('form'));
    form.attr('action', '{{ url("pengeluaran/excel") }}');
    form.attr('method', 'GET');
    var input = $('<input>').attr('type', 'hidden').attr('name', 'tgl').val(date);
    form.append(input);
    form.appendTo(document.body);
    form.submit();
    form.remove();

});

$("#picker").click(function() {
  $("#datepicker").datepicker("show");
});

$('#search-form').on('submit', function(e) {
       e.preventDefault();
       var date = $('#datepicker').val();
       var oTable = $('#users-table').DataTable({
         destroy: true,
         processing: true,
         serverSide: true,
         ajax: {
             url: '{{ url("pengeluaran") }}',
             data: { tgl: date},
             method: 'GET'
         },
        columns: [
            { data: 'ido', name: 'ido' },
            { data: 'kode', name: 'kode' },
            { data: 'nama_obat', name: 'nama_obat' },
            { data: 'jumlah', name: 'jumlah',"defaultContent": 0 },
            { data: 'satuan', name: 'satuan' },
        ]
    });
    oTable.draw();
    $("#download").show();
  });
</script>
@stop
