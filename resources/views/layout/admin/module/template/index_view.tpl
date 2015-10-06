@extends('layout.admin.index')

@section('style')

@endsection

@section('script')
<script type="text/javascript">
  $('#btn_delete').click(function(event) {
        var flag = false;
        $(':checkbox').each(function() {
            if(this.checked == true){
                flag = true;
            }
        });
        if(flag){
          if(confirm('{{trans("admin.confirm_delete")}}')){
            $("#form").attr('action','{{ URL::to("admin/{Controller}/del")}}');
            $("#form").submit();
          }
        }else{
          alert("{{trans('admin.not_choose')}}");
        }

    });
</script>
@endsection

@section('content')
	<ol class="breadcrumb breadcrumb-quirk">
        <li><a href="{{URL::to('admin/dashboard')}}"><i class="fa fa-home mr5"></i> {{trans('admin.dashboard')}}</a></li>
        <li class="active">{{$page['title']}}</li>
      </ol>

      <div class="panel">
        <div class="panel-heading">
          <h4 class="panel-title">{{$page['title']}}</h4>
        </div>
        <form id="form" method="post" action="{{URL::to('/admin/{Controller}/multisearch')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="panel-body">
          <div class="table-responsive">
            <div class="row">
                <div class="col-sm-6">
                  <a href="{!!URL::to('admin/{Controller}/add')!!}" id="btn_create" class="btn btn-primary btn-quirk">{{trans('admin.create')}}</a>
                  <a href="javascript:void(0)" id="btn_delete" class="btn btn-danger btn-quirk">{{trans('admin.delete')}}</a>
                </div>
            </div>
            <table  style="margin-top: 10px;margin-bottom: 10px" id="dataTable1_wrapper" class="table table-hover nomargin">
              <thead>
                <tr>
               	  <th>
               	  	<label class="ckbox ckbox-success">
	                    <input class="select-all" type="checkbox"><span></span>
	                  </label>

               	  </th>
                  {!!Helper::buildFormSearch($module)!!}
                </tr>
              </thead>

              <tfoot>
                <tr>
                  <th>
                  	<label class="ckbox ckbox-success">
	                    <input class="select-all" type="checkbox"><span></span>
	                  </label>
                  </th>
                  {!!Helper::buildFormSearch($module)!!}
                </tr>
              </tfoot>

              <tbody>
              	<tr>
                  <td></td>
                  {!!Helper::buildFormSearch($module,'search')!!}
                </tr>
                    {!!Helper::buildFormData($module,$items,'{Key}','{Controller}')!!}

              </tbody>
            </table>
          </div>
          <div class="row">
          	<div class="col-sm-2">
                <select id="select1" name="rows" class="form-control" style="width: 100%" data-placeholder="Page">
                  <option value="5">5</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                  <option value="50">50</option>
                </select>
          	</div>
          	<div class="col-sm-2">
          		<select id="select2" name="order" class="form-control" style="width: 100%" data-placeholder="Sort">
                  {!!Helper::buildFromSort($module)!!}
                </select>
          	</div>
          	<div class="col-sm-2">
          		<select id="select3" name="sort" class="form-control" style="width: 100%" data-placeholder="Order">
                  <option value="DESC">{{trans('admin.desc')}}</option>
                  <option value="ASC">{{trans('admin.asc')}}</option>
                </select>
          	</div>
          	<div class="col-sm-3">
          		<button class="btn btn-primary btn-quirk" id="submit_search">{{trans('admin.go')}}</button>
          	</div>
          	<div class="col-sm-3">
          		<div aria-live="polite" role="status" id="dataTable1_info" class="dataTables_info">{!!Helper::buildShowCount($rows,$count,$total)!!}</div>
          	</div>
          </div>
          <div class="row">
          	<div class="col-sm-12">
          		<div id="dataTable1_paginate" class="dataTables_paginate paging_simple_numbers">
          			<ul class="pagination">
                  {!!$url_page!!}
          			</ul>
          		</div>
          	</div>
          </div>
        </div>
      </div><!-- panel -->
	</form>
@endsection