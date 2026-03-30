<?php

require '../tm.define.php';
require 'tm.class.php';

if (empty($_SESSION['LOGIN']['ID'])) header('Location:../login');
if (!empty($_REQUEST["Mode"])) {
    $obj = new cCompile($db);
    if (method_exists($obj, $_REQUEST["Mode"])) {
        $func = $_REQUEST["Mode"];
        $obj->$func();
    }
}
