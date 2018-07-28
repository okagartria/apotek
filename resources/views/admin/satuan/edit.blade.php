@extends('admin.admin_template')
@section('content')
<!-- Horizontal Form -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Horizontal Form</h3>
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
    <form class="form-horizontal" method="post" action="{{action('SatuanController@update', $satuan->id)}}" >
        {{csrf_field()}}
          <input name="_method" type="hidden" value="PATCH">
        <div class="box-body">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="satuan" placeholder="Nama Satuan"  value="{{$satuan->satuan}}">
                </div>
            </div>


        </div>
        <!-- /.box-body -->
        <div class="box-footer">
              <a class="btn btn-default btn-close" href="/satuan">Cancel</a>
            <button type="submit" class="btn btn-info pull-right">Ubah Satuan</button>
        </div>
        <!-- /.box-footer -->
    </form>
</div>
@stop
