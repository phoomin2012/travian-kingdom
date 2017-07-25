<?php

class Avatar {

    public function get($data) {
        global $engine;


        return [
            "name" => "AvatarInformation:{$data['avatarId']}",
            "data" => [
                "avatarIdentifier" => $data['avatarId'],
                "userAccountIdentifier" => $data['userId'],
                "signupTime" => "1",
                "population" => "12",
                "villages" => 1,
                "lastLogin" => "1492049152",
                "lastClick" => "1492049152",
                "ranking" => 0,
                "buildingQueue" => 0,
                "buildingQueueMaster" => 0,
                "incomingAttacks" => 0,
                "spawnedOnMap" => "1488165259"
            ],
        ];
    }

    public function getAll() {
        global $engine;

        $servers = query("SELECT `sid`,`prefix` FROM `global_server_data`")->fetchAll(PDO::FETCH_ASSOC);
        $avatar = [];
        $collection = [];

        foreach ($servers as $s) {
            $sdq = query("SELECT * FROM `{$s['prefix']}user` WHERE `email`=?;", [$_SESSION['lobby_email']]);
            if ($sdq->rowCount() == 1) {
                $sd = $sdq->fetch(PDO::FETCH_ASSOC);
                $data = [
                    "avatarId" => "3416714",
                    "userId" => $_SESSION['lobby_uid'],
                ];

                array_push($avatar, $this->get($data));
                array_push($collection, [
                    "userAccountIdentifier" => $_SESSION['lobby_uid'],
                    "avatarIdentifier" => "3416714",
                    "avatarName" => $sd['username'],
                    "consumersId" => $sd['uid'],
                    "worldName" => "COM3",
                    "country" => "en",
                    "accountName" => $sd['username'],
                    "isBanned" => false,
                    "isSuspended" => false,
                    "limitation" => "0",
                    "banReason" => "0",
                    "banPaymentProvider" => ""
                ]);
            }
        }


        return [
            [
                "name" => "Collection:Avatar:",
                "data" => [
                    "operation" => 1,
                    "cache" => [],
                ]
            ]
        ];
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
