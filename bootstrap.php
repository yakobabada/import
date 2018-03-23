<?php

function callHook($arg) {

    if (!isset($arg[1])) {
        echo 'You haven\'t chose the command';
        return;
    }

    $commandName = $arg[1];
    $commandClass = $commandName . 'Command';


    $command = new $commandClass();
    $command->execute();

}

function callConstants() {
    require_once('Config/database.php');
    require_once('Config/default.php');
}

function __autoload($className) {
    if (file_exists('Command/' . strtolower($className) . '.php')) {
        require_once('Command/' . strtolower($className) . '.php');
    } elseif (file_exists('Model/' . strtolower($className) . '.php')) {
        require_once('Model/' . strtolower($className) . '.php');
    } elseif (file_exists('Service/' . strtolower($className) . '.php')) {
        require_once('Service/' . strtolower($className) . '.php');
    } elseif (file_exists('Service/CsvReader/' . strtolower($className) . '.php')) {
        require_once('Service/CsvReader/' . strtolower($className) . '.php');
    } elseif (file_exists('Service/CsvValidator/' . strtolower($className) . '.php')) {
        require_once('Service/CsvValidator/' . strtolower($className) . '.php');
    } elseif(file_exists('Manager/' . strtolower($className) . '.php')) {
        require_once('Manager/' . strtolower($className) . '.php');
    } else {
        //Error not implemented
        return new View('page/500.php', array());
    }
}

callConstants();
callHook($argv);