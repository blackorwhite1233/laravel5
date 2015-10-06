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
          <div class="table-responsive">
            <table class="table table-bordered table-inverse table-striped nomargin">
              <tbody>
                <tr>
		                  <td align="right" width="30%">Title</td>
		                  <td>{{$title}}</td>
		                </tr><tr>
		                  <td align="right" width="30%">Status</td>
		                  <td>{{$status}}</td>
		                </tr><tr>
		                  <td align="right" width="30%">Content</td>
		                  <td>{{$content}}</td>
		                </tr>
              </tbody>
            </table>
          </div><!-- table-responsive -->
      </div><!-- panel -->
@endsection