@extends('layout.admin.index')

@section('style')
{!! HTML::style('admin/lib/select2/select2.css') !!}
@endsection

@section('script')

{!! HTML::script('admin/lib/select2/select2.js') !!}
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
                <form id="Formcreate" method="POST" action="{{URL::to('admin/module/add')}}" class="form-horizontal">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Module name <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                      <input type="text" name="module_title" class="form-control"  />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Module note</label>
                    <div class="col-sm-8">
                      <input type="text" name="module_note" class="form-control"  />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Module Controller <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                      <input type="text" name="module_name" class="form-control"  />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Module Controller <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                      <select id="select1" name="module_db" class="form-control">
                      @foreach ($table_list as $t)
                              <option value="{{$t}}">{{$t}}</option>
                      @endforeach
                    </select>
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