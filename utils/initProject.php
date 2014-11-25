<?php
mkdir('./appli/');
mkdir('./appli/c');
mkdir('./appli/m');
mkdir('./appli/v');
mkdir('./appli/forms');
mkdir('./installs/');
mkdir('./installs/install01/');
mkdir('./www/');
mkdir('./www/_');
mkdir('./www/_/js');
mkdir('./www/_/css');
mkdir ('./www/install01');

//creation des fichiers
$app='
<?php
namespace Install;

class App{
    const C="utilisateur";
    const A="identification";
    const NAME=\'\';
    static $utilisateur=null;
    const SALT_BEFORE=\''.uniqid(mt_rand(), true).'\';
    const SALT_AFTER=\''.uniqid(mt_rand(), true).'\';
}';
file_put_contents('./installs/install01/app.php', $app);

$bdd='<?php

namespace Install;

class Bdd{
    const USER=\'root\';
    const PWD=\'123456\';
    const HOST=\'localhost\';
    const NAME=\'\';
}';
file_put_contents('./installs/install01/bdd.php', $bdd);

$chemins='<?php
namespace Install;

class Chemins {
    const ROOT=\''.realpath('.').'/\';
    const WWW=\''.realpath('.').'/www/\';
    const MVC=\''.realpath('.').'/mvc/\';
    const VUE=\''.realpath('.').'/appli/v/\';
    const CSS=\'../_/css/\';
    const JS=\'../_/js/\';
    const FONT=\'../_/font-awesome/\';
}';
     
file_put_contents('./installs/install01/chemins.php', $chemins);

$install='<?php
define(\'MVC\',\''.realpath('.').'/mvc/\');
define(\'INSTALL\',\''.realpath('.').'/installs/install01/\');

include(MVC.\'index.php\');';

file_put_contents('./www/install01/index.php', $chemins);