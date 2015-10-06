@extends('layout.admin.index')

@section('style')
{!! HTML::style('admin/lib/select2/select2.css') !!}
@endsection

@section('script')
{!! HTML::script('admin/lib/select2/select2.js') !!}
{!! HTML::script('admin/js/jquery.nestable.js') !!}

<script>
$(document).ready(function(){
	$('#select1').select2();
	$('.dd').nestable();
    update_out('#nestable',"#reorder");
    
    $('#nestable').on('change', function() {
		var out = $('#nestable').nestable('serialize');
		$('#reorder').val(JSON.stringify(out));	  

    });
		$('.ext-link').hide(); 

	$('.menutype input:radio').on('ifClicked', function() {
	 	 val = $(this).val();
  			mType(val);
	  
	});
	
	mType('<?php echo $row['menu_type'];?>'); 
	
			
});	

function mType( val )
{
		/*if(val == 'external') {
			$('.ext-link').show(); 
			$('.int-link').hide();
		} else {
			$('.ext-link').hide(); 
			$('.int-link').show();
		}	*/
}

	
function update_out(selector, sel2){
	var out = $(selector).nestable('serialize');
	$(sel2).val(JSON.stringify(out));

}
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
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="panel-body">
          <div class="col-md-6">
          	<div class="dd"  id="nestable">
	          	<ul class="dd-list">
					@foreach ($menus as $menu)
						  <li data-id="{{$menu['menu_id']}}" class="dd-item dd3-item">
							<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$menu['menu_name']}}
								<span class="pull-right">
								<a href="{{ URL::to('menu/index/'.$menu['menu_id'].'?pos='.$active)}}"><i class="icon-cogs"></i></a></span>
							</div>
							@if(count($menu['childs']) > 0)
								<ul class="dd-list" style="">
									@foreach ($menu['childs'] as $menu2)
									 <li data-id="{{$menu2['menu_id']}}" class="dd-item dd3-item">
										<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$menu2['menu_name']}}
											<span class="pull-right">
											<a href="{{ URL::to('menu/index/'.$menu2['menu_id'].'?pos='.$active)}}"><i class="icon-cogs"></i></a></span>
										</div>
										@if(count($menu2['childs']) > 0)
										<ul class="dd-list" style="">
											@foreach($menu2['childs'] as $menu3)
											 	<li data-id="{{$menu3['menu_id']}}" class="dd-item dd3-item">
													<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{ $menu3['menu_name'] }}
														<span class="pull-right">
														<a href="{{ URL::to('menu/index/'.$menu3['menu_id'].'?pos='.$active)}}"><i class="icon-cogs"></i></a>
														</span>
													</div>
												</li>	
											@endforeach
										</ul>
										@endif
									</li>							
									@endforeach
								</ul>
							@endif
						</li>
					@endforeach			  
		              </ul>
		              <form method="POST" action="{{URL::to('admin/Menu/saveorder')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
				        	<input type="hidden" name="reorder" id="reorder" value="" />
					        <button type="submit" class="btn btn-primary ">  {{trans('admin.reorder_menu')}} </button>	
					 	</form>
		        </div>

        </div>
        <div class="col-md-6">
		        	<form id="Formcreate" method="POST" action="{{URL::to('admin/Menu/add')}}" class="form-horizontal">
	                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
	                  <div class="form-group">
	                    <label class="col-sm-3 control-label"> {{trans('admin.name_title')}} <span class="text-danger">*</span></label>
	                    <div class="col-sm-8">
	                      <input type="text" name="menu_name" class="form-control" placeholder="{{trans('admin.notice_name_menu')}}"  />
	                    </div>
	                  </div>

	                  <div class="form-group">
	                    <label class="col-sm-3 control-label">Link </label>
	                    <div class="col-sm-8">
	                      <input type="text" name="link" class="form-control" placeholder="{{trans('admin.notice_link_menu')}}"  />
	                    </div>
	                  </div>
	                  <div class="form-group">
	                    <label class="col-sm-3 control-label"> {{trans('admin.page')}}  </label>
	                    <div class="col-sm-8">
	                      <select id="select1" name="module_db" class="form-control">
	                      	<option value=""> -- {{trans('admin.select_page')}} -- </option>
		                      @foreach($listpage as $p)
								<option value="{{ $p->alias}}" @if($row['module']== $p->alias ) selected="selected" @endif >Page : {{ $p->title}}</option>
							@endforeach
		                    </select>
	                    </div>
	                  </div>


	                  <div class="row">
			                <div class="col-sm-6">
			                  <a href="{!!URL::to('admin/group/add')!!}" id="btn_create" class="btn btn-primary btn-quirk">{{trans('admin.create')}}</a>
			                  <a href="javascript:void(0)" id="btn_delete" class="btn btn-danger btn-quirk">{{trans('admin.delete')}}</a>
			                </div>
			            </div>
			          </div>

	                </form>
		        </div>
      </div><!-- panel -->
@endsection