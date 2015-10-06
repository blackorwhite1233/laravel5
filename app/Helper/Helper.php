<?php
use Request;
class Helper {

    public static function buildFormSearch($module,$type = "header") {
    	$result = '';
    	if($type == 'header'){
    		foreach($module as $name => $option){
	    		$result .= "<th>".$option['title']."</th>";
	    	}
	    	$result .="<th>".trans('admin.action')."</th>";
    	}
    	else{
    		foreach($module as $name => $option){
    			if($option['type'] == "text"){
    				$result .= "<td><input type='text' name='$name' class='form-control' value='".$option['value']."' ></td>";
    			}
                elseif($option['type'] == "radio"){
                    $options = '';

                    foreach($option['option'] as $v=>$o){
                        $active = $option['value'] == $v ? 'selected' : '';
                        $options .= '<option '.$active.' value="'.$v.'">'.$o.'</option>';
                    }

                    $result .= "<td><select name='$name' class='form-control'>
                                    <option value=''>-- ".trans('admin.status')." --</option>
                                    ".$options."
                                </select></td>";
                }else{
                    $result .= "<td></td>";
                }
	    	}
	    	$result .="<td></td>";
    	}

      return $result;

    }

    public static function buildFormData($module,$data,$pri_key,$module_name){
    	$result = '';
    	foreach($data as $item){
    		$result .= "<tr>";
    		$result .= "<td><label class='ckbox ckbox-success'><input name='destroy_id[]' value='".$item->$pri_key."' type='checkbox'><span></span></label></td>";
	    	foreach($module as $name => $option){
                if($option['type'] == "text"){
	    	          $result .= "<td>".$item->$name."</td>";
                }elseif($option['type'] == "radio"){
                    $value = $item->$name;
                    $result .= "<td>".$option['option'][$value]."</td>";
                }elseif($option['type'] == "date"){
                    $result .= "<td>".date('Y-m-d H:i:s', $item->$name)."</td>";
                }
	    	}
            $result .= "<td><ul class='table-options'><li><a title='".trans('admin.edit')."' href='".URL::to("admin/")."/".$module_name.'/edit'."?id=".$item->$pri_key."'><i class='fa fa-pencil'></i></a></li><li><a title='".trans('admin.view')."' href='".URL::to("admin/")."/".$module_name.'/detail'."?id=".$item->$pri_key."'><i class='fa fa-eye'></i></a></li></ul></td>";
	    	$result .= "<tr></tr>";
	    	$result .= "</tr>";
	    }
	    return $result;
    }

    public static function moduleType($data = ''){
        $result = '';
        $ck_text = $data == "text" ? 'selected=""' : '';
        $ck_select = $data == "select" ? 'selected=""' : '';
        $ck_select_nola = $data == "select_nola" ? 'selected=""' : '';
        $ck_radio = $data == "radio" ? 'selected=""' : '';
        $ck_date = $data == "date" ? 'selected=""' : '';

        $result .= '<option '.$ck_text.' value="text">Text</option>';
        $result .= '<option '.$ck_select.' value="select">Select</option>';
        $result .= '<option '.$ck_select_nola.' value="select_nola">Select no language</option>';
        $result .= '<option '.$ck_radio.' value="radio">Radio</option>';
        $result .= '<option '.$ck_date.' value="date">Date</option>';
        return $result;
    }

    public static function moduleRequired($data = ''){
        $result = '';
        $ck_no = $data == "no" ? 'selected=""' : '';
        $ck_require = $data == "require" ? 'selected=""' : '';
        $ck_alpha = $data == "alpha" ? 'selected=""' : '';
        $ck_number = $data == "number" ? 'selected=""' : '';
        $ck_alphanum = $data == "alphanum" ? 'selected=""' : '';
        $ck_email = $data == "email" ? 'selected=""' : '';

        $result .= '<option '.$ck_no.' value="no">No Required</option>';
        $result .= '<option '.$ck_require.' value="require">Required</option>';
        $result .= '<option '.$ck_alpha.' value="alpha">Only Alpha</option>';
        $result .= '<option '.$ck_number.' value="number">Only Number</option>';
        $result .= '<option '.$ck_alphanum.' value="alphanum">Alpha and Number</option>';
        $result .= '<option '.$ck_email.' value="email">Email</option>';
        return $result;
    }

    public static function buildFromSort($module){
        $result = '';
        foreach($module as $name => $option){
            $result .= "<option value='".$option['name']."'>".$option['title']."</option>";
        }
        return $result;
    }

    public static function buildShowCount($rows,$count,$total){
        $page = Request::input('page','1');
        $result = '';
        $from = '';
        $to = '';
        if($page == 1){
            $from = 1;
            $to = $rows;
        }else{
            $from = (($page - 1) * $rows) + 1;
            $to = $page * $rows;
        }
        $result = trans('admin.showing').$from.trans('admin.to').$to.trans('admin.of').$total.trans('admin.entries');
        return $result;
    }

    public static function showMessage(){
        $result = "";
        $message = Session::get('message');
        foreach($message as $type => $m){
            if($type == "error"){
                $result .= '<div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                '.$m.'
                            </div>';
            }elseif($type == "success"){
                $result .= '<div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                '.$m.'
                            </div>';
            }
        }
        return $result;
    }

}

?>