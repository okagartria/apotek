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
    <form class="form-horizontal" method="post" action="{{action('MutasiController@update', $mutasi->id)}}" >
        {{csrf_field()}}
          <input name="_method" type="hidden" value="PATCH">
        <div class="box-body">
          <div class="form-group">
              <label for="tgl_mutasi" class="col-sm-2 control-label">Tanggal</label>
              <div class="col-sm-10">
                  <input type="date" class="form-control" id="tgl_mutasi" name="tgl_mutasi" value="{{$mutasi->tgl_mutasi}}">
              </div>
          </div>
            <div class="form-group">
                <label for="jenis_mutasi" class="col-sm-2 control-label">Jenis Mutasi</label>
                <div class="col-sm-10">
                  <select id="jenis_mutasi" class="form-control" name="jenis_mutasi">
                         @if ($mutasi->jenis_mutasi == 0)
                            <option value="0" selected>Penerimaan</option>
                            <option value="1">Pengeluaran</option>
                            @else
                            <option value="0">Penerimaan</option>
                             <option value="1" selected>Pengeluaran</option>
                          @endif
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label for="kode_obat" class="col-sm-2 control-label">Kode Obat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="kode_obat" name="kode_obat" value="{{ $mutasi->kode_obat }}" placeholder="Kode Obat">
                </div>
            </div>

            <div class="form-group">
              <label for="masuk" class="col-sm-2 control-label">Masuk</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="masuk" name="masuk" value={{$mutasi->masuk}} placeholder="Jumlah penerimaan obat">
              </div>
            </div>
            <div class="form-group">
              <label for="keluar" class="col-sm-2 control-label">Keluar</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="keluar" name="keluar" value={{ $mutasi->keluar }} placeholder="Jumlah pengeluaran obat">
              </div>
            </div>
            <div class="form-group">
              <label for="keterangan" class="col-sm-2 control-label">Keterangan</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{$mutasi->keterangan}}" placeholder="Keterangan">
              </div>
            </div>



        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-default">Cancel</button>
            <button type="submit" class="btn btn-info pull-right">Edit Mutasi</button>
        </div>
        <!-- /.box-footer -->
    </form>
</div>
@stop
