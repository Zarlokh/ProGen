<?php

function file_exist($controller_file, $c, $m, $param, $callmethod = false){
	if(is_file($controller_file)){
		require_once $controller_file;

		$controller_name = 'Controller_'.ucfirst(strtolower($c));	//Reconstitution de la classe controller
		if(class_exists($controller_name)){
			$co = new $controller_name;	//Création de l'instance de la classe controller
			if(method_exists($co, $m)){
				if($callmethod){
					call_method($co, $m, $param);
					return $co;
				}
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function call_method($co, $m, $param){
	create_constant_script_controller($co);
	call_user_func_array(array($co, $m), array($param));
}

function create_constant_script_controller($co){
	$classname = get_class($co);
	$name = strtolower(str_replace('Controller_', '', $classname));
	$script_name_path = BASEURL.'/'.SCRIPT_PATH.'/'.$name.'/script_'.$name.'.js';
	define('SCRIPT_PATH_CURRENT_CONTROLLER', $script_name_path);
}