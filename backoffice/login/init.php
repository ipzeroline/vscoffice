<?php
header('Content-Type: application/json');
require '../tm.define.php';
require 'tm.class.php';


if (!empty($_REQUEST["Mode"])) {
    $obj = new cCompile($db);
    if (method_exists($obj, $_REQUEST["Mode"])) {
        $func = $_REQUEST["Mode"];
        return $obj->$func();
    }
}
