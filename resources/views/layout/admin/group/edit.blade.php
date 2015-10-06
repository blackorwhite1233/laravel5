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
        <li><a href="{{URL::to('admin/group')}}"><i class="fa fa-home mr5"></i> {{trans('admin.manager_group')}}</a></li>
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
                <form id="Formcreate" method="POST" action="{{URL::to('admin/group/edit')}}" class="form-horizontal">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="group_id" value="{{$group_id}}">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{{trans('admin.group_name')}} <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                      <input value="{{$name}}" type="text" name="name" class="form-control"  />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">{{trans('admin.description')}}</label>
                    <div class="col-sm-8">
                      <textarea rows="5" name="description" class="form-control">{{$description}}</textarea>
                    </div>
                  </div>

                  <hr>

                  <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
                      <input type="submit" class="btn btn-success btn-quirk btn-wide mr5" value="{{trans('admin.update')}}" />
                      <input type="button" class="btn btn-quirk btn-wide btn-default" value="{{trans('admin.back')}}" />
                    </div>
                  </div>

                </form>
      </div><!-- panel -->
@endsection