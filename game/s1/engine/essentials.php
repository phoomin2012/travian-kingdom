<?php

function query($sql, $array = array()) {
    global $engine;
    $q = $engine->sql->prepare($sql);
    $q->execute($array);
    $engine->error->sql = $engine->sql->errorInfo();
    return $q;
}

function l($type, $var, $option = null, $returnf = false) {
    global $engine;
    if ($option === null) {
        $lang = $_COOKIE[$engine->server->prefix . 'lang'];
    } elseif (gettype($option) == "boolean") {
        $lang = $_COOKIE[$engine->server->prefix . 'lang'];
        $returnf = $option;
    } elseif (gettype($option) == "string") {
        $lang = $option;
    }
    if (file_exists(dirname(__FILE__) . '/language/' . $lang . '.php')) {
        include dirname(__FILE__) . '/language/' . $lang . '.php';
        if (!isset($language[$type][$var])) {
            include dirname(__FILE__) . '/language/th.php';
            $return = $language[$type][$var];
        } else {
            $return = $language[$type][$var];
        }
        if ($returnf !== true) {
            echo $return;
        } else {
            return (string) $return;
        }
    } else {
        include dirname(__FILE__) . '/language/th.php';
        if (!isset($language[$type][$var])) {
            if ($returnf !== true) {
                echo strtoupper($type . '.' . $var);
            } else {
                return strtoupper($type . '.' . $var);
            }
        } else {
            $return = $language[$type][$var];
            if ($returnf !== true) {
                echo $return;
            } else {
                return (string) $return;
            }
        }
    }
}
