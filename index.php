<?php

$deb = microtime();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function __autoload($class) {
    $chemins = explode('\\', strtolower($class));
    switch ($chemins[0]) {
        case 'install':
            $fichier = INSTALL . $chemins[1] . '.php';
            break;
        case 'mvc':
            $fichier = MVC . $chemins[1] . '.php';
            break;
        default:
            $fichier = \Install\Chemins::ROOT . implode('/', $chemins) . '.php';
    }
    if (file_exists($fichier)) {
        include $fichier;
    } else {
        if ($chemins[0] . '\\' . $chemins[1] == 'appli\m') {
            if (substr($chemins[2], -3) == 'row') {
                $code = 'namespace APPLI\M;class ' . ucfirst($chemins[2]) . 'Row extends \MVC\TableRow{};';
            } else {
                $code = 'namespace APPLI\M;class ' . ucfirst($chemins[2]) . ' extends \MVC\Table{
                        protected $_table=\'' . $chemins[2] . '\';
                        protected $_tableRow=\'\\APPLI\M\\' . ucfirst($chemins[2]) . 'Row\';
                    };';
            }
            var_dump($code);
            eval($code);
        } else {
            throw new Exception('file not exist : ' . $fichier, E_USER_ERROR);
        }
    }
}

//init app
\Install\App::init();

$c = \MVC\A::post('c', \Install\App::C);
$a = \MVC\A::post('a', \Install\App::A);
$controleurNom = '\APPLI\\C\\' . $c;

//var_dump(\MVC\A::getParams());

if (!$controleurNom::acl($a, \MVC\A::getParams())) {
//    $c = 'Error';
//    $controleurNom = '\APPLI\\C\\Error';
//    $a = 'notAllowed';
    mail('info@test.fr', 'Accès non autorisé', 'c=' . $c . PHP_EOL . 'a=' . $a);
    exit('Unauthorized access');
}
\MVC\Controleur::setVue(new \MVC\Vue($c, $a));

$controleurNom::$a(\MVC\A::getParams());

if (!is_null(\MVC\A::post('return_c'))) {
    $c = \MVC\A::post('return_c', \Install\App::C);
    $a = \MVC\A::post('return_a', \Install\App::A);
    $controleurNom = '\APPLI\\C\\' . $c;
    if (!$controleurNom::acl($a, \MVC\A::getParams())) {
//        $c = 'Error';
//        $controleurNom = '\APPLI\\C\\Error';
//        $a = 'notAllowed';
        throw new Exception('Accès non autorisé : ' . $c . '::' . $a);
    }

    \MVC\Controleur::setVue(new \MVC\Vue($c, $a));

    $controleurNom::$a(\MVC\A::getParams());
}

$controleurNom::getVue()->display();

/*
$f=fopen(Install\Chemins::ROOT.'/logs/'.date('Y-m-d').'.log','a');
fwrite($f,date('H:i:s').'//'.$c.':'.$a.':'.json_encode(\MVC\A::getParams()).PHP_EOL);
 * 
 */
