<?php

include_once __DIR__.'/connect.php';

$db = new Database;

// check connection
if($db){
     echo 'connected.';
}

// $db->insert();

// $db->update();

// $db->delete() or if you want $db->insert()->delete();

// $db->updateColumn();

$db->lastInsertId();
