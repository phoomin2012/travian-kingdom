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

class Field_calculate {

    const PATTERN = '/(?:\-?\d+(?:\.?\d+)?[\+\-\*\/])+\-?\d+(?:\.?\d+)?/';
    const PARENTHESIS_DEPTH = 10;

    public function calculate($input) {
        if (strpos($input, '+') != null || strpos($input, '-') != null || strpos($input, '/') != null || strpos($input, '*') != null) {
            //  Remove white spaces and invalid math chars
            $input = str_replace(',', '.', $input);
            $input = preg_replace('[^0-9\.\+\-\*\/\(\)]', '', $input);

            //  Calculate each of the parenthesis from the top
            $i = 0;
            while (strpos($input, '(') || strpos($input, ')')) {
                $input = preg_replace_callback('/\(([^\(\)]+)\)/', 'self::callback', $input);

                $i++;
                if ($i > self::PARENTHESIS_DEPTH) {
                    break;
                }
            }

            //  Calculate the result
            if (preg_match(self::PATTERN, $input, $match)) {
                return $this->compute($match[0]);
            }

            return 0;
        }

        return $input;
    }

    private function compute($input) {
        $compute = create_function('', 'return ' . $input . ';');

        return 0 + $compute();
    }

    private function callback($input) {
        if (is_numeric($input[1])) {
            return $input[1];
        } elseif (preg_match(self::PATTERN, $input[1], $match)) {
            return $this->compute($match[0]);
        }

        return 0;
    }

}
