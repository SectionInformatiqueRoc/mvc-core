#!/usr/bin/php
<?php
unset($argv[0]);
foreach ($argv as $nom) {
    echo $nom . PHP_EOL;

    $fileTable = './c/' . $nom . '.php';
    if (!file_exists($fileTable)) {

        $dataTable = '<?php
namespace APPLI\C;

class ' . ucfirst($nom) . ' extends \MVC\Controleur {
    public static function acl($a,$params){
        return false;
    }
}';
        file_put_contents($fileTable, $dataTable);
    } else {
        echo 'ERREUR : Le fichier existe déjà' . PHP_EOL;
    }
}