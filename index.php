<?php

include_once __DIR__.'/connect.php';

$db = new Database;

// check connection
if($db){
     echo 'connected.';
}

$db->insert();