<?php

class Page {

    public $page;
    public $include;

    public function __construct() {
        global $engine;
        $this->page = $this->getPageURI();
    }

    public function getURI($index = null) {
        $str = str_replace(strtolower(str_replace('\\','/',str_replace('engine', '', __DIR__))), '', strtolower($_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI']));
        $page = explode('/', $str);
        $qs = explode("?", $page[count($page) - 1]);
        $page[count($page) - 1] = $qs[0];
        $return = $page;
        if ($index === null) {
            return $return;
        } else {
            if (isset($return[$index])) {
                return $return[$index];
            } else {
                return "";
            }
        }
    }
    
    public function baseURI($index = null) {
        return str_replace($this->getFullURI(), '', $_SERVER['REQUEST_URI']);
    }

    public function getFullURI() {
        return str_replace(strtolower(str_replace('\\','/',str_replace('engine', '', __DIR__))), '', strtolower($_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI']));
    }

    public function getPageURI() {
        if ($this->getURI(0) != "") {
            return $this->getURI(0);
        } else {
            return 'home';
        }
    }
}
