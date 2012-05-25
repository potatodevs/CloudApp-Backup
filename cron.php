<?php
/**
 * Cron script which delete all generated zips older than one hour
 * ~ to be run every 30 mins or so
 * 
 * @copyright   Copyright (c) 2011 Tomas Vitek, Yogesh Nagarur
 * @author      Tomas Vitek ~ http://tomik.jmx.cz

 * @version     0.1
 * @link        http://www.project135.com
 */

// Load Nette
require __DIR__ . '/libs/Nette/loader.php';

require __DIR__ . '/libs/rrmdir.php';

use Nette\Diagnostics\Debugger;

function dirmtime($dir) {
    $iterator = new DirectoryIterator($dir);

    $mtime = -1;
    $file;
    foreach ($iterator as $fileinfo) {
        if ($fileinfo->isFile()) {
            if ($fileinfo->getMTime() > $mtime) {
                $file = $fileinfo->getFilename();
                $mtime = $fileinfo->getMTime();
            }
        }
    }
    return $mtime;
}

// Debuugger
Debugger::$strictMode = TRUE;
Debugger::$logDirectory = __DIR__ . '/log';
Debugger::enable();

$folder = __DIR__ . '/generated';

$files = scandir($folder);

foreach ($files as $file) {
    if (is_file($folder . '/' . $file)) {
        $time = filectime($folder . '/' . $file);
        if ($time < (time() - 3600)) {
            @unlink($folder . '/' . $file); // intentionally @
            if (!is_file($folder . '/' . $file)) echo "Deleted file: ".$file. "\n";
        }
    }
    if ($file != "." && $file != ".." && is_dir($folder . '/' . $file)) {
        $time = dirmtime($folder . '/' . $file);
        if ($time < (time() - 3600)) {
            @rrmdir($folder . '/' . $file); // intentionally @
            if (!is_dir($folder . '/' . $file)) echo "Deleted folder: ".$file. "\n";
        }
    }   
}

// All done
echo "Done!";