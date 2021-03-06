<?php

    // Autoload PSR-4
    //spl_autoload_register();
    spl_autoload_register(
        function ($pathClassName)
        {
            include str_replace('\\', '/', $pathClassName).'.php';
        }
    );

    // Imports
    use \Classes\Webforce3\Config\Config;
    //use \Classes\Webforce3\DB\Location;
    //use \Classes\Webforce3\DB\Training;
    use \Classes\Webforce3\Helpers\SelectHelper;
    // Get the config object
    $conf = Config::getInstance();

    // Formulaire soumis
    if(!empty($_POST)) {

    }

    // Views - toutes les variables seront automatiquement disponibles dans les vues
    require $conf->getViewsDir().'header.php';
    require $conf->getViewsDir().'session.php';
    require $conf->getViewsDir().'footer.php';