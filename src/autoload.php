<?php

function autoload1($class){

    $prefix = 'Aloefflerj\\FedTheDog\\';

    $baseDir = __DIR__ . '/';

    $len = strlen($prefix);

    if(strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);

    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if(file_exists($file)) {
        require $file;
    }

};

// autoload1('Aloefflerj\FedTheDog\UserClass');

spl_autoload_register('autoload1');