@extends('admin.admin_template')
@section('content')
<!-- Horizontal Form -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Input Data Obat</h3>
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
    <form class="form-horizontal" method="post" action="{{url('obat')}}" >
        {{csrf_field()}}
        <div class="box-body">
          <div class="form-group">
              <label for="kode_obat" class="col-sm-2 control-label">Kode Obat</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="kode_obat" name="kode_obat" placeholder="Kode Obat">
              </div>
          </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Nama Obat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="nama_obat" placeholder="Nama Obat">
                </div>
            </div>
            <div class="form-group">
                <label for="satuan" class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-10">
                  <select id="satuan" class="form-control" name="id_satuan" placeholder="Satuan">
                      @foreach ($satuan as $row)
                      <option value="{{ $row->id }}">{{ $row->satuan }}</option>
                      @endforeach
                  </select>
                </div>
            </div>


        </div>
        <!-- /.box-body -->
        <div class="box-footer">
              <a class="btn btn-default btn-close" href="/obat">Cancel</a>
            <button type="submit" class="btn btn-info pull-right">Tambah Obat</button>
        </div>
        <!-- /.box-footer -->
    </form>
</div>
@stop
