@extends('admin.admin_template')
@section('style')
<link rel="stylesheet" href="{{ asset("bower_components/Ionicons/css/ionicons.min.css") }}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset("bower_components/bootstrap-daterangepicker/daterangepicker.css") }}">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset("bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css") }}">


@stop
@section('content')
<!-- Horizontal Form -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Input Data Mutasi</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    @if (isset($errors) && (count($errors) > 0))
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form class="form-horizontal" method="post" action="{{url('mutasi')}}" >
        {{csrf_field()}}
        <div class="box-body">
          <div class="form-group" id="picker">
              <label for="tgl_mutasi" class="col-sm-2 control-label">Tanggal</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="tgl_mutasi" name="tgl_mutasi" placeholder="Tanggal mutasi">
              </div>
          </div>
            <div class="form-group">
                <label for="jenis_mutasi" class="col-sm-2 control-label">Jenis Mutasi</label>
                <div class="col-sm-10">
                  <select id="jenis_mutasi" class="form-control" name="jenis_mutasi">
                      <option value="0">Penerimaan</option>
                      <option value="1">Pengeluaran</option>
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label for="kode_obat" class="col-sm-2 control-label">Kode Obat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="kode_obat" name="kode_obat" placeholder="Kode Obat">
                </div>
            </div>

            <div class="form-group" id="penerimaan" style="display:none">
              <label for="masuk" class="col-sm-2 control-label">Masuk</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="masuk" name="masuk" placeholder="Jumlah penerimaan obat" value=0>
              </div>
            </div>
            <div class="form-group" id="pengeluaran" style="display:none">
              <label for="keluar" class="col-sm-2 control-label">Keluar</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="keluar" value=0 name="keluar" placeholder="Jumlah pengeluaran obat">
              </div>
            </div>

            <div class="form-group">
              <label for="keterangan" class="col-sm-2 control-label">Keterangan</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan">
              </div>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a class="btn btn-default btn-close" href="/mutasi">Cancel</a>
            <button type="submit" class="btn btn-info pull-right">Catat Mutasi</button>
        </div>
        <!-- /.box-footer -->
    </form>
</div>
@stop

@section('scripts')
<!-- date-range-picker -->
<script src="{{ asset("bower_components/moment/min/moment.min.js") }}"></script>
<script src="{{ asset("bower_components/bootstrap-daterangepicker/daterangepicker.js") }}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js") }}"></script>

<script>

$('#tgl_mutasi').datepicker({
    format: "mm/dd/yyyy",
     autoclose: true,
})

$("#picker").click(function() {
  $("#tgl_mutasi").datepicker("show");
});


$(document).ready(function() {
  if($('#jenis_mutasi').val() == 0){
      $("#pengeluaran").hide();
      $("#penerimaan").show();
  } else {
    $("#pengeluaran").show();
    $("#penerimaan").hide();
  }
});

$('#jenis_mutasi').change(function(){
  if($(this).val() == 0){ // or this.value == 'volvo'
      $("#pengeluaran").hide();
      $("#penerimaan").show();
  } else {
    $("#pengeluaran").show();
    $("#penerimaan").hide();
  }
});

</script>
@stop
