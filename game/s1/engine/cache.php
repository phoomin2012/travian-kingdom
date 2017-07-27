<?php

class Cache {

    public function getAll() {
        global $engine;

        $json = array('cache' => array());

        if (count($engine->village->getAll('own')) > 0) {
            $json['cache'][count($json['cache'])] = $engine->unit->getTraining($_COOKIE['village']);
            $json['cache'][count($json['cache'])] = $engine->building->getQueue($_COOKIE['village']);
            $json['cache'][count($json['cache'])] = $engine->building->getBuildings($_COOKIE['village']);
            $json['cache'][count($json['cache'])] = $engine->unit->getStay($_COOKIE['village']);
            $json['cache'][count($json['cache'])] = $engine->move->get($_COOKIE['village']);
            $json['cache'][count($json['cache'])] = array(
                'name' => 'Collection:Troops:trapped:' . $_COOKIE['village'],
                'data' => array(
                    'cache' => array(),
                    'operation' => 1,
                ),
            );
            $json['cache'][count($json['cache'])] = array(
                'name' => 'Collection:Troops:elsewhere:' . $_COOKIE['village'],
                'data' => array(
                    'cache' => array(),
                    'operation' => 1,
                ),
            );
            $json['cache'][count($json['cache'])] = $engine->hero->get($_SESSION[$engine->server->prefix . 'uid']);
            $json['cache'][count($json['cache'])] = $engine->hero->getFace($_SESSION[$engine->server->prefix . 'uid'], $_SESSION[$engine->server->prefix . 'avatar']);
        }
        $json['cache'][count($json['cache'])] = array(
            'name' => 'Collection:Village:own',
            'data' => array(
                'cache' => $engine->village->getAll('own'),
                'operation' => 1,
            ),
        );
        $json['cache'][count($json['cache'])] = array(
            'name' => 'Collection:PlayerProgressTrigger:',
            'data' => array(
                'cache' => array(),
                'operation' => 1,
            )
        );
        $json['cache'][count($json['cache'])] = $engine->account->getAjax($_SESSION[$engine->server->prefix . 'uid']);
        $json['cache'][count($json['cache'])] = array(
            'name' => 'Settings:' . $_SESSION[$engine->server->prefix . 'uid'],
            'data' => $engine->setting->getAll(),
        );
        $json['cache'][count($json['cache'])] = array(
            'name' => 'Session:' . session_id(),
            'data' => array(
                'sessionId' => session_id(),
                'avatarIdentifier' => $_SESSION[$engine->server->prefix . 'avatar'],
                'userAccountIdentifier' => $_SESSION[$engine->server->prefix . 'uid'],
                'type' => 0,
                'rights' => NULL,
            ),
        );
        return $json['cache'];
    }

}
