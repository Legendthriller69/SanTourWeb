<?php

function loadClass($className)
{
    $prefix = "SanTourWeb\\";
    $className = substr($className, strlen($prefix), strlen($className));
    $fileName = '';

    // Sets the include path as the "src" directory
    $includePath = ROOT;

    if (false !== ($lastNsPos = strripos($className, '\\'))) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR);
    }

    $fileNameNormal = $fileName . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $fileNameClass = $fileName . str_replace('_', DIRECTORY_SEPARATOR, 'class.' . $className) . '.php';
    $fullFileName = $includePath . DIRECTORY_SEPARATOR . $fileNameNormal;
    $fullFileNameClass = $includePath . DIRECTORY_SEPARATOR . $fileNameClass;

    if (file_exists($fullFileName)) {
        require $fullFileName;
    } else if (file_exists($fullFileNameClass)) {
        require $fullFileNameClass;
    } else {
        echo 'Class "' . $className . '" does not exist.' . '<br />';
        echo $fullFileName . '<br />';
        echo $fullFileNameClass . '<br />';
    }
}

spl_autoload_register('loadClass'); // Registers the autoloader