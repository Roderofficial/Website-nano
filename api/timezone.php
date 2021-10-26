<?php
function validate_timezone($timezone){
    $OptionsArray = timezone_identifiers_list();
    if (in_array($timezone, $OptionsArray)){
        return True;
    }else{
        return False;
    }

}
function current_timezone(){
    @session_start();
    require($_SERVER['DOCUMENT_ROOT'].'/api/module_settings.php');
    $timezone = module_settings_download($_SESSION['selected_guild'], 'timezone');
    if($timezone == Null || $timezone == ''){
        return 'UTC';
    }else{
        return $timezone['timezone'];
    }
}
function update_timezone($timezone){
    @session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . '/api/module_settings.php');
    module_settings_update($_SESSION['selected_guild'], 'timezone', 'timezone', $timezone);
}
function select_timezone($selected = '') {
    $OptionsArray = timezone_identifiers_list();
        $select= '<select name="timezone" class="form-control timezone">';
        foreach($OptionsArray as $value){
            $select .='<option value="'.$value.'"';
            $select .= ($value == $selected ? ' selected' : '');
            $select .= '>'.$value.'</option>';
        }  
        $select.='</select>';
return $select;
}