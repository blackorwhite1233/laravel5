@extends('layout.admin.index')

@section('style')

@endsection

@section('script')

<script>
	$( document ).ready(function() {


	});
</script>

@endsection

@section('content')
	<ol class="breadcrumb breadcrumb-quirk">
        <li><a href="{{URL::to('admin/dashboard')}}"><i class="fa fa-home mr5"></i> {{trans('admin.dashboard')}}</a></li>
        <li><a href="{{URL::to('admin/Post')}}"><i class="fa fa-home mr5"></i> post </a></li>
        <li class="active">{{$page['title']}}</li>
      </ol>

      <div class="panel">
        <div class="panel-heading">
          <h4 class="panel-title">{{$page['title']}}</h4>
        </div>
        @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif
        <div class="panel-body">
          <hr>
                <form id="Formcreate" method="POST" action="{{URL::to('admin/Post/add')}}" class="form-horizontal">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="form-group">
                    <label class="col-sm-3 control-label"> ID <span class="text-danger"></span></label>
                    <div class="col-sm-8">
                      <input type="text" name="post_id" class="form-control"  />
                    </div>
                  </div><div class="form-group">
                    <label class="col-sm-3 control-label"> <span class="text-danger"></span></label>
                    <div class="col-sm-8">
                      <select id="select1" name="post_typecustomer" class="form-control">
                    </select>
                    </div>
                  </div><div class="form-group">
                    <label class="col-sm-3 control-label">  <span class="text-danger"></span></label>
                    <div class="col-sm-8">
                      <input type="text" name="post_file1" class="form-control"  />
                    </div>
                  </div>

                  <hr>

                  <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
                      <input type="submit" class="btn btn-success btn-quirk btn-wide mr5" value="Submit" />
                      <button type="reset" class="btn btn-quirk btn-wide btn-default">Reset</button>
                    </div>
                  </div>

                </form>
      </div><!-- panel -->
@endsection