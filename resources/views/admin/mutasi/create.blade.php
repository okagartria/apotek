@extends('admin.admin_template')
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
          <div class="form-group">
              <label for="tgl_mutasi" class="col-sm-2 control-label">Tanggal</label>
              <div class="col-sm-10">
                  <input type="date" class="form-control" id="tgl_mutasi" name="tgl_mutasi" placeholder="Tanggal mutasi">
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

            <div class="form-group">
              <label for="masuk" class="col-sm-2 control-label">Masuk</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="masuk" name="masuk" placeholder="Jumlah penerimaan obat">
              </div>
            </div>
            <div class="form-group">
              <label for="keluar" class="col-sm-2 control-label">Keluar</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="keluar" name="keluar" placeholder="Jumlah pengeluaran obat">
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
            <button type="submit" class="btn btn-default">Cancel</button>
            <button type="submit" class="btn btn-info pull-right">Catat Mutasi</button>
        </div>
        <!-- /.box-footer -->
    </form>
</div>
@stop
