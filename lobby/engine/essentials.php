<?php

function query($sql, $array = array()) {
    global $engine;
    $q = $engine->sql->prepare($sql);
    $q->execute($array);
    //$engine->error->sql =  $engine->sql->errorInfo();
    return $q;
}