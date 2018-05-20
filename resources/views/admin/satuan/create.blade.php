@extends('admin.admin_template')
@section('content')
<!-- Horizontal Form -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Input Data Satuan</h3>
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
    <form class="form-horizontal" method="post" action="{{url('satuan')}}" >
        {{csrf_field()}}
        <div class="box-body">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="satuan" placeholder="Nama Satuan">
                </div>
            </div>


        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-default">Cancel</button>
            <button type="submit" class="btn btn-info pull-right">Tambah Satuan</button>
        </div>
        <!-- /.box-footer -->
    </form>
</div>
@stop
