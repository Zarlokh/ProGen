<?php

function file_exist($controller_file, $c, $m, $param){
	if(is_file($controller_file)){
		require_once $controller_file;

		$controller_name = 'Controller_'.ucfirst(strtolower($c));	//Reconstitution de la classe Controller_User
		if(class_exists($controller_name)){
			$co = new $controller_name;	//Création de l'instance de la classe Controller_User
			if(method_exists($co, $m)){
				call_user_func_array(array($co, $m), array($param));
				return $co;
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