<?php

class Item {

    public $instant = [120, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140];
    public $inventory = [112, 113, 114, 115, 116, 117, 118, 119, 141, 142];
    public $helmet = [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
    public $right_hand = [16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60];
    public $left_hand = [61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81];
    public $body = [82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93];
    public $shoes = [94, 95, 96, 97, 98, 99, 100, 101, 102, 121, 122, 123];
    public $horse = [103, 104, 105, 106, 107, 108, 109, 110, 111];
    public $bag = [73, 74, 75];
    public $icon = [
        1 => 'helmet3_0',
        2 => 'rightHand3_0',
        3 => 'leftHand3_0',
        4 => 'body3_0',
        5 => 'shoes3_0',
        6 => 'horse3_0',
        7 => 'bag1_0',
        112 => 'ointment',
        113 => 'scroll',
        114 => 'bucket',
        115 => 'bookOfWisdom',
        116 => 'artwork',
        117 => 'smallBandage',
        118 => 'bandage',
        119 => 'cage',
        120 => 'treasures',
    ];

    /*
      HeroItem.SLOT_INSTANT_USE = -1;
      HeroItem.SLOT_INVENTORY = 0;
      HeroItem.SLOT_HELMET = 1;
      HeroItem.SLOT_RIGHT_HAND = 2;
      HeroItem.SLOT_LEFT_HAND = 3;
      HeroItem.SLOT_BODY = 4;
      HeroItem.SLOT_SHOES = 5;
      HeroItem.SLOT_HORSE = 6;
      HeroItem.SLOT_BAG = 7;

      HeroItem.BONUS_XP = 1;
      HeroItem.BONUS_BARRACKS = 2;
      HeroItem.BONUS_STABLE = 3;
      HeroItem.BONUS_WORKSHOP = 4;
      HeroItem.BONUS_SPEED_RETURN = 5;
      HeroItem.BONUS_SPEED_OWN_VILLAGES = 6;
      HeroItem.BONUS_SPEED_KINGDOM_VILLAGES = 7;
      HeroItem.BONUS_SPEED_STAMINA = 8;
      HeroItem.BONUS_RAID = 9;
      HeroItem.BONUS_NATARS = 10;
      HeroItem.BONUS_UNIT_ID = 11;
      HeroItem.BONUS_UNIT_STRENGTH = 12;
      HeroItem.BONUS_FIGHT_STRENGTH = 13;
      HeroItem.BONUS_HEALTH_REGEN = 14;
      HeroItem.BONUS_CULTURE_POINTS = 15;
      HeroItem.BONUS_ARMOR = 16;
      HeroItem.BONUS_SPEED_HERO = 17;
      HeroItem.BONUS_SPEED_HORSE = 18;
      HeroItem.BONUS_RESKILL = 20;
      HeroItem.BONUS_TROOP_HEALING = 21;
      HeroItem.BONUS_EYESIGHT = 22;
      HeroItem.BONUS_CHICKEN = 23;
      HeroItem.BONUS_RESOURCES = 24;
      HeroItem.BONUS_CROP = 25;
      HeroItem.BONUS_POTION = 26;


      HeroItem.TYPE_OINTMENT = 112;
      HeroItem.TYPE_SCROLLS = 113;
      HeroItem.TYPE_WATERBUCKET = 114;
      HeroItem.TYPE_BOOK = 115;
      HeroItem.TYPE_ARTWORK = 116;
      HeroItem.TYPE_BANDAGE_25 = 117;
      HeroItem.TYPE_BANDAGE_33 = 118;
      HeroItem.TYPE_CAGES = 119;
      HeroItem.TYPE_TREASURES = 120;
      HeroItem.TYPE_HEALING_POTION = 124;
      HeroItem.TYPE_ARMOR_UPGRADE = 125;
      HeroItem.TYPE_WEAPON_UPGRADE = 126;
      HeroItem.TYPE_LEFT_HAND_UPGRADE = 127;
      HeroItem.TYPE_HELMET_UPGRADE = 128;
      HeroItem.TYPE_SHOE_UPGRADE = 129;
      HeroItem.TYPE_RESOURCE_BONUS_3 = 130;
      HeroItem.TYPE_RESOURCE_BONUS_4 = 131;
      HeroItem.TYPE_RESOURCE_BONUS_5 = 132;
      HeroItem.TYPE_CROP_BONUS_3 = 133;
      HeroItem.TYPE_CROP_BONUS_4 = 134;
      HeroItem.TYPE_CROP_BONUS_5 = 135;
      HeroItem.TYPE_ADVENTURE_POINT = 136;
      HeroItem.TYPE_BUILDING_GROUND = 137;
      HeroItem.TYPE_FINISH_IMMEDIATELY = 138;
      HeroItem.TYPE_NPC_TRADER = 139;
      HeroItem.TYPE_INSTANT_TRADE_DELIVERY = 140;
      HeroItem.TYPE_BANDAGE_25_UPGRADED = 141;
      HeroItem.TYPE_BANDAGE_33_UPGRADED = 142;

     */

    public function getAll($owner) {
        global $engine;

        if ($owner == "own") {
            $owner = $engine->session->data->uid;
        }

        $items = query("SELECT * FROM `{$engine->server->prefix}hero_item` WHERE `owner`=?;", [$owner])->fetchAll(PDO::FETCH_ASSOC);
        $r = [];

        foreach ($items as $item) {
            array_push($r, [
                "name" => "HeroItem:" . $item['id'],
                "data" => $this->get($item['id'])
            ]);
        }

        return $r;
    }

    private function getSlot($type) {
        if (in_array($type, $this->instant)) {
            return -1;
        } elseif (in_array($type, $this->inventory)) {
            return 0;
        } elseif (in_array($type, $this->helmet)) {
            return 1;
        } elseif (in_array($type, $this->right_hand)) {
            return 2;
        } elseif (in_array($type, $this->left_hand)) {
            return 3;
        } elseif (in_array($type, $this->body)) {
            return 4;
        } elseif (in_array($type, $this->shoes)) {
            return 5;
        } elseif (in_array($type, $this->horse)) {
            return 6;
        } elseif (in_array($type, $this->bag)) {
            return 7;
        }
    }

    public function getIcon($type) {
        if (in_array($type, $this->helmet)) {
            return $this->icon[1];
        } elseif (in_array($type, $this->right_hand)) {
            return $this->icon[2];
        } elseif (in_array($type, $this->left_hand)) {
            return $this->icon[3];
        } elseif (in_array($type, $this->body)) {
            return $this->icon[4];
        } elseif (in_array($type, $this->shoes)) {
            return $this->icon[5];
        } elseif (in_array($type, $this->horse)) {
            return $this->icon[6];
        } elseif (in_array($type, $this->bag)) {
            return $this->icon[7];
        } else {
            return $this->icon[$type];
        }
    }

    public function get($id) {
        global $engine;

        $item = query("SELECT * FROM `{$engine->server->prefix}hero_item` WHERE `id`=?;", [$id])->fetch(PDO::FETCH_ASSOC);



        $r = [
            "id" => $item['id'],
            "playerId" => $item['owner'],
            "tribeId" => 0,
            "inSlot" => $item['equip'] == 1 ? $this->getSlot($item['type']) : "0",
            "itemId" => $item['type'],
            "itemType" => $item['type'],
            "amount" => $item['amount'],
            "strength" => "225",
            "images" => [$this->getIcon($item['type'])],
            "bonuses" => json_decode($item['bonus'], true),
            "stackable" => false,
            "slot" => $this->getSlot($item['type']),
            "lastChange" => $item['lastChange'],
            "hasSpeedBonus" => false,
            "inventorySlotNr" => $item['equip'] == 1 ? "0" : $item['slot'],
            "previousOwners" => $item['previousOwners'],
            "upgradeLevel" => "0",
            "upgradableItemType" => false,
            "itemQuality" => $item['quality'],
            "itemTier" => $item['tier'],
            "baseUpgradeBonus" => json_decode($item['bonus'], true),
            "cardGameItem" => false,
            "premiumItem" => false,
            "upgradedItem" => false
        ];
        return $r;
    }

    public function swap($param) {
        global $engine;

        if ($param['id2'] != 0) {
            $item1 = query("SELECT * FROM `{$engine->server->prefix}hero_item` WHERE `id`=?;", [$param['id1']])->fetch(PDO::FETCH_ASSOC);
            $item2 = query("SELECT * FROM `{$engine->server->prefix}hero_item` WHERE `id`=?;", [$param['id2']])->fetch(PDO::FETCH_ASSOC);

            query("UPDATE `{$engine->server->prefix}hero_item` SET `slot`=? WHERE `id`=?;", [$item2['slot'], $item1['id']]);
            query("UPDATE `{$engine->server->prefix}hero_item` SET `slot`=? WHERE `id`=?;", [$item1['slot'], $item2['id']]);
        } else {
            query("UPDATE `{$engine->server->prefix}hero_item` SET `slot`=? WHERE `id`=?;", [$param['newSlotNr'], $param['id1']]);
        }
    }

    public function useItem($param) {
        global $engine;
        $return = [
            "cache" => [],
            "response" => [],
        ];
        $item = query("SELECT * FROM `{$engine->server->prefix}hero_item` WHERE `id`=?;", [$param['id']])->fetch(PDO::FETCH_ASSOC);
        $amount = isset($param['amount']) ? $param['amount'] : 0;
        $village = $param['villageId'];

        if ($this->getSlot($item['type']) > 0) {
            if ($item['equip'] == 1) {
                query("UPDATE `{$engine->server->prefix}hero_item` SET `equip`=? WHERE `id`=?;", [0, $item['id']]);
            } else {
                query("UPDATE `{$engine->server->prefix}hero_item` SET `equip`=? WHERE `id`=?;", [1, $item['id']]);
            }
            $return['cahe'] += [
                [
                    "name" => "Collection:HeroItem:own",
                    "data" => [
                        "operation" => 1,
                        "cache" => $engine->item->getAll('own'),
                    ],
                ],
                $engine->hero->get($_SESSION[$engine->server->prefix . 'uid'])
            ];
        } else {
            if ($item['type'] == 120) {
                $return['response'] = [
                    "amount" => 1,
                    "destTime" => time()+15,
                    "troopId" => 0,
                    "resources" => [
                        1 => 100,
                        2 => 100,
                        3 => 100,
                        4 => 0,
                    ]
                ];
            }
        }

        return $return;
    }

}
