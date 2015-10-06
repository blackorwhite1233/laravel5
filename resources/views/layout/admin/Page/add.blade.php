@extends('layout.admin.index')

@section('style')

@endsection

@section('script')
{!! HTML::script('admin/js/ckeditor/ckeditor.js') !!}
<script>
	$( document ).ready(function() {

      CKEDITOR.replace( 'editor1' );
	});
</script>

@endsection

@section('content')
	<ol class="breadcrumb breadcrumb-quirk">
        <li><a href="{{URL::to('admin/dashboard')}}"><i class="fa fa-home mr5"></i> {{trans('admin.dashboard')}}</a></li>
        <li><a href="{{URL::to('admin/Page')}}"><i class="fa fa-home mr5"></i> {{trans('admin.manager_page')}} </a></li>
        <li class="active">{{trans('admin.add_page')}}</li>
      </ol>

      <div class="panel">
        <div class="panel-heading">
          <h4 class="panel-title">{{trans('admin.add_page')}}</h4>
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
                <form id="Formcreate" method="POST" action="{{URL::to('admin/Page/add')}}" class="form-horizontal">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="form-group">
                    <label class="col-sm-3 control-label"> {{trans('admin.title')}} <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                      <input type="text" name="title" class="form-control"  />
                    </div>
                  </div><div class="form-group">
                    <label class="col-sm-3 control-label"> {{trans('admin.status')}} <span class="text-danger"></span></label>
                    <div class="col-sm-8">
                      <label class="rdiobox">
                        <input name="status" checked="" value="1" type="radio">
                        <span>{{trans('admin.enable')}}</span>
                      </label>
                      <label class="rdiobox">
                        <input name="status" value="0"  type="radio">
                        <span>{{trans('admin.disable')}}</span>
                      </label>
                    </div>
                  </div><div class="form-group">
                    <label class="col-sm-3 control-label"> {{trans('admin.content_page')}} <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                      <textarea name="content" id="editor1" rows="10" cols="80"></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label"> Meta Description <span class="text-danger"></span></label>
                    <div class="col-sm-8">
                      <textarea name="meta_description" rows="10" cols="80" placeholder="asdasd"></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label"> Meta Keyword <span class="text-danger"></span></label>
                    <div class="col-sm-8">
                      <textarea name="meta_keyword" rows="10" cols="80"></textarea>
                    </div>
                  </div>

                  <hr>

                  <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
                      <input type="submit" class="btn btn-success btn-quirk btn-wide mr5" value="{{trans('admin.create')}}" />
                      <button type="reset" class="btn btn-quirk btn-wide btn-default">{{trans('admin.reset')}}</button>
                    </div>
                  </div>

                </form>
      </div><!-- panel -->
@endsection