<?php

class Avatar {

    public function get($data) {
        global $engine;


        return [
            "name" => "AvatarInformation:{$data['avatarId']}",
            "data" => [
                "avatarIdentifier" => $data['avatarId'],
                "userAccountIdentifier" => $data['userId'],
                "population" => "1200",
                "ranking" => 1,
                "villages" => 1,
                "lastLogin" => $data['login'],
                "lastClick" => $data['login'],
                "buildingQueue" => 0,
                "buildingQueueMaster" => 0,
                "incomingAttacks" => 0,
                "nextIncomingAttack" => 0,
                "signupTime" => "1",
                "deletionTime" => "0",
                "spawnedOnMap" => $data['spawn']
            ],
        ];
    }

    public function getAll() {
        global $engine;

        $servers = query("SELECT `sid`,`prefix` FROM `global_server_data`")->fetchAll(PDO::FETCH_ASSOC);
        $avatar = [];
        $collection = [];
        $r = [];

        foreach ($servers as $s) {
            $sdq = query("SELECT * FROM `{$s['prefix']}user` WHERE `email`=?;", [$_SESSION['lobby_email']]);
            if ($sdq->rowCount() == 1) {
                $sd = $sdq->fetch(PDO::FETCH_ASSOC);
                $avatar = "3416714";
                $data = [
                    "avatarId" => $avatar,
                    "userId" => $_SESSION['lobby_uid'],
                    "spawn" => $sd['spawn'],
                    "login" => $sd['lastLogin'],
                    
                ];

                array_push($r, $this->get($data));
                array_push($collection, [
                    "name" => "Avatar:$avatar",
                    "data" => [
                        "consumersId" => 1,
                        "userAccountIdentifier" => $_SESSION['lobby_uid'],
                        "avatarIdentifier" => $avatar,
                        "avatarName" => $sd['username'],
                        'accountName' => $sd['username'],
                        "worldName" => "COM3",
                        "country" => "en",
                        "accountName" => $sd['username'],
                        "isBanned" => false,
                        "isSuspended" => false,
                        "limitation" => "0",
                        "suspensionTime" => "0",
                        "banReason" => "0",
                        "banPaymentProvider" => ""
                    ],
                ]);
            }
        }
        $r[] = [
            "name" => "Collection:Avatar:",
            "data" => [
                "operation" => 1,
                "cache" => $collection,
            ]
        ];
        return $r;
        /* if (!$avatar) {
          return $r;
          } else {
          return $avatar;
          } */
    }

    public function getImage() {
        global $engine;

        return [
            "name" => "Collection:AvatarImage:",
            "data" => [
                "operation" => 1,
                "cache" => [],
            ]
        ];
    }

}
