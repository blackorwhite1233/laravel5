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
        <li><a href="{{URL::to('admin/group')}}"><i class="fa fa-home mr5"></i> {{trans('admin.manager_module')}}</a></li>
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
                <form id="Formcreate" method="POST" action="{{URL::to('admin/module/edit')}}" class="form-horizontal">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="module_id" value="{{$module_id}}">
                  <ul class="nav nav-tabs nav-line nav-justified">
                    <li class="active"><a href="#popular12" data-toggle="tab"><strong>Info</strong></a></li>
                    <li><a href="#recent12" data-toggle="tab"><strong>Table</strong></a></li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div class="tab-pane active" id="popular12">
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Module name </label>
                        <div class="col-sm-8">
                          <input type="text" value="{{$data->module_title}}" readonly class="form-control"  />
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-3 control-label">Module note</label>
                        <div class="col-sm-8">
                          <input type="text" value="{{$data->module_note}}" readonly  class="form-control"  />
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-3 control-label">Module Controller </label>
                        <div class="col-sm-8">
                          <input type="text" value="{{$data->module_name}}" readonly  class="form-control"  />
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-3 control-label">Module DB </label>
                        <div class="col-sm-8">
                          <input type="text" value="{{$data->module_db}}" readonly class="form-control"  />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Action </label>
                        <div class="col-sm-8">
                          <label class="ckbox">
                            <input  name="action[create]" @if($config['action']['create'] == 1) checked @endif type="checkbox"><span>Create</span>
                          </label>
                          <label class="ckbox">
                            <input  name="action[delete]" @if($config['action']['delete'] == 1) checked @endif type="checkbox"><span>Delete</span>
                          </label>
                          <label class="ckbox">
                            <input   name="action[detail]" @if($config['action']['detail'] == 1) checked @endif type="checkbox"><span>Detail</span>
                          </label>
                          <label class="ckbox">
                            <input  name="action[edit]" @if($config['action']['edit'] == 1) checked @endif type="checkbox"><span>Edit</span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="recent12">
                      <div class="table-responsive">
                          <table class="table table-bordered table-inverse table-striped nomargin">
                            <thead>
                              <tr>
                                <th class="text-center">
                                  NO #
                                </th>
                                <th>Field name</th>
                                <th class="text-center">Title</th>
                                <th class="text-right">Type</th>
                                <th class="text-right">Required</th>
                                <th class="text-right">Show</th>
                                <th class="text-right">Form</th>
                                <th class="text-right">Search</th>
                                <th class="text-center">Path/File</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 1; ?>
                              @foreach($field_list as $f)
                                <tr>
                                  <td class="text-center">
                                    {{$i}}
                                  </td>
                                  <td>{{$f}}</td>
                                  <td class="text-center">
                                    <input type="text" value="{{$config['fields'][$f]['title']}}" name="title[{{$f}}]" class="form-control">
                                  </td>
                                  <td  class="text-center">
                                    <select   name="type[{{$f}}]" class="form-control">
                                      {!!Helper::moduleType($config['fields'][$f]['type'])!!}
                                    </select>
                                  </td>
                                  <td class="text-center">
                                    <select  name="require[{{$f}}]" class="form-control">
                                      {!!Helper::moduleRequired($config['fields'][$f]['require'])!!}
                                    </select>
                                  </td>
                                  <td class="">
                                    <label class="ckbox">
                                      <input  name="show[{{$f}}]" @if($config['fields'][$f]['show'] == 1) checked @endif type="checkbox"><span></span>
                                    </label>
                                  </td>
                                  <td class="">
                                    <label class="ckbox">
                                      <input  name="form[{{$f}}]" @if($config['fields'][$f]['form'] == 1) checked @endif type="checkbox"><span></span>
                                    </label>
                                  </td>
                                  <td  class="text-center">
                                    <select  name="search[{{$f}}]" class="form-control">
                                      <option @if($config['fields'][$f]['search'] == "=") selected @endif value="=">=</option>
                                      <option @if($config['fields'][$f]['search'] == "LIKE") selected @endif value="LIKE">LIKE</option>
                                    </select>
                                  </td>
                                  <td class="text-center">
                                    <input class="form-control" value="{{$config['fields'][$f]['path']}}"  name="path[{{$f}}]" type="text">
                                    <label class="ckbox">
                                      <input  name="image[{{$f}}]" @if($config['fields'][$f]['image'] == 1) checked @endif type="checkbox"><span></span>
                                    </label>
                                  </td>
                                </tr>
                              <?php $i++ ?>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                    </div>
                  </div>
                            <div class="row" style="margin-top: 10px">
                    <div class="col-sm-9 col-sm-offset-3">
                      <input type="submit" class="btn btn-success btn-quirk btn-wide mr5" value="Submit" />
                      <a href="{{URL::to('admin/module')}}" class="btn btn-quirk btn-wide btn-default">Back</a>
                    </div>
                  </div>
                          </form>
                        </div><!-- table-responsive -->
                      </div>
                    </div><!-- panel -->
                  </div>
      </div><!-- panel -->
@endsection