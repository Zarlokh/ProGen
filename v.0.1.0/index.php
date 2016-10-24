<?php

require_once 'config.php';
require_once 'models/base.php';
require_once 'utils/functions.php';

define('BASEURL', dirname($_SERVER['SCRIPT_NAME']));
$db = new PDO(BDD_DSN, BDD_USER, BDD_PW);
Model_Base::set_db($db);

session_start();

// enregistrement de la sortie dans un buffer
// (permet d'appeler des méthodes qui ajoutent des headers à la
//  réponse HTTP avant d'avoir commencé à envoyer du contenu)
ob_start();

// Vérification URL du type /controlleur/methode
if (isset($_SERVER['PATH_INFO'])) {
	$arg = explode('/', $_SERVER['PATH_INFO']);
	if (count($arg) >= 3){
		//récupération du controlleur en argument 1
		$c = $arg[1];

		//récupération de la méthode en argument 2
		$m = $arg[2];

		$param = array();
		//Récupération des paramètres
		for ($i=3; $i < count($arg); $i++){
			$param[] = $arg[$i];
		}

		//Test si le controller existe dans le répertoire 'controllers'
		$controller_file = 'controllers/'.$c.'.php';
		if(($co = file_exist($controller_file, $c, $m, $param, true)) === false){
			header('Location:'.BASEURL.'/index.php');
			exit();
		}
		
	}else if(count($arg) === 2){
		if(($co = file_exist('controllers/'.$arg[1].'.php', $arg[1], 'index', array(), true)) === false){
			header('Location:'.BASEURL.'/index.php');
			exit();
		}
	}
} else{
    require_once 'controllers/Default.php';
    $co = new Controller_Default();
    create_constant_script_controller($co);
    $co->index();
//    include ACCUEIL;
}


echo SCRIPT_PATH_CURRENT_CONTROLLER;

// récupération du contenu du buffer de sortie
$content = ob_get_clean();
echo $content;
?>