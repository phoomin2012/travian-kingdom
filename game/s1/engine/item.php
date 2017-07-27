<?php

class Item {

    public $instant = [120, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140];
    public $premium = [137,138,139,140];
    public $upgradeable = [];
    public $inventory = [112, 113, 114, 115, 116, 117, 118, 119, 141, 142];
    public $helmet = [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
    public $right_hand = [16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60];
    public $left_hand = [61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81];
    public $body = [82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93];
    public $shoes = [94, 95, 96, 97, 98, 99, 100, 101, 102, 121, 122, 123];
    public $horse = [103, 104, 105, 106, 107, 108, 109, 110, 111];
    public $bag = [73, 74, 75];
    public $icon = [
        4 => 'helmet1_0',
        5 => 'helmet1_1',
        6 => 'helmet1_2',
        7 => 'helmet2_0',
        8 => 'helmet2_1',
        9 => 'helmet2_2',
        10 => 'helmet3_0',
        11 => 'helmet3_1',
        12 => 'helmet3_2',
        13 => 'helmet4_0',
        14 => 'helmet4_1',
        15 => 'helmet4_2',
        16 => 'sword0_0',
        17 => 'sword0_1',
        18 => 'sword0_2',
        19 => 'sword1_0',
        20 => 'sword1_1',
        21 => 'sword1_2',
        22 => 'sword2_0',
        23 => 'sword2_1',
        24 => 'sword2_2',
        25 => 'sword3_0',
        26 => 'sword3_1',
        27 => 'sword3_2',
        28 => 'lance0_1',
        29 => 'lance0_2',
        30 => 'lance0_3',
        31 => 'spear0_0',
        32 => 'spear0_1',
        33 => 'spear0_2',
        34 => 'sword4_0',
        35 => 'sword4_1',
        36 => 'sword4_2',
        37 => 'bow0_0',
        38 => 'bow0_1',
        39 => 'bow0_2',
        40 => 'staff0_0',
        41 => 'staff0_1',
        42 => 'staff0_2',
        43 => 'spear1_0',
        44 => 'spear1_1',
        45 => 'spear1_2',
        46 => 'club0_0',
        47 => 'club0_1',
        48 => 'club0_2',
        49 => 'spear2_0',
        50 => 'spear2_1',
        51 => 'spear2_2',
        52 => 'axe0_0',
        53 => 'axe0_1',
        54 => 'axe0_2',
        55 => 'hammer0_0',
        56 => 'hammer0_1',
        57 => 'hammer0_2',
        58 => 'sword5_0',
        59 => 'sword5_1',
        60 => 'sword5_2',
        61 => 'map0_0',
        62 => 'map0_1',
        63 => 'map0_2',
        64 => 'flag0_0',
        65 => 'flag0_1',
        66 => 'flag0_2',
        67 => 'flag1_0',
        68 => 'flag1_1',
        69 => 'flag1_2',
        70 => 'telescope0_0',
        71 => 'telescope0_1',
        72 => 'telescope0_2',
        73 => 'sack0_0',
        74 => 'sack0_1',
        75 => 'sack0_2',
        76 => 'shield0_0',
        77 => 'shield0_1',
        78 => 'shield0_2',
        79 => 'horn0_0',
        80 => 'horn0_1',
        81 => 'horn0_2',
        82 => 'shirt0_0',
        83 => 'shirt0_1',
        84 => 'shirt0_2',
        85 => 'shirt1_0',
        86 => 'shirt1_1',
        87 => 'shirt1_2',
        88 => 'shirt2_0',
        89 => 'shirt2_1',
        90 => 'shirt2_2',
        91 => 'shirt3_0',
        92 => 'shirt3_1',
        93 => 'shirt3_2',
        94 => 'shoes0_0',
        95 => 'shoes0_1',
        96 => 'shoes0_2',
        97 => 'shoes1_0',
        98 => 'shoes1_1',
        99 => 'shoes1_2',
        100 => 'shoes2_0',
        101 => 'shoes2_1',
        102 => 'shoes2_2',
        103 => 'horse1_0',
        104 => 'horse1_1',
        105 => 'horse1_2',
        106 => 'horse2_0',
        107 => 'horse2_1',
        108 => 'horse2_2',
        109 => 'horse0_0',
        110 => 'horse0_1',
        111 => 'horse0_2',
        112 => 'ointment',
        113 => 'scroll',
        114 => 'water_bucket',
        115 => 'book',
        116 => 'artwork',
        117 => 'small_bandage',
        118 => 'bandage',
        119 => 'cage',
        120 => 'treasures',
        121 => 'shoes3_0',
        122 => 'shoes3_1',
        123 => 'shoes3_2',
        124 => 'healing_potion',
        125 => 'upgrade_armor',
        126 => 'upgrade_weapon',
        127 => 'upgrade_accessory',
        128 => 'upgrade_helmet',
        129 => 'upgrade_shoes',
        130 => ['resourceChest3', 'resourceChest4'],
        131 => ['resourceChest4', 'resourceChest5'],
        132 => ['resourceChest5'],
        133 => ['cropChest3', 'cropChest4'],
        134 => ['cropChest4', 'cropChest5'],
        135 => ['cropChest5'],
        136 => 'adventure_point',
        137 => 'building_ground',
        138 => 'finishImmediately',
        139 => 'npcTrader',
        140 => 'instantDelivery',
        141 => 'small_bandage',
        142 => 'bandage'
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

    public function getAll($owner, $head = false) {
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
        if ($head) {
            return [
                "name" => "Collection:HeroItem:own",
                "data" => [
                    "operation" => 1,
                    "cache" => $r,
                ],
            ];
        } else {
            return $r;
        }
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
        if (is_array($this->icon[$type])) {
            return $this->icon[$type][0];
        } else {
            return $this->icon[$type];
        }
    }

    public function get($id, $head = false) {
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
            "cardGameItem" => $this->getSlot($item['type']) == -1 ? true : false,
            "premiumItem" => $this->getSlot($item['type']) == -1 ? (in_array($item['type'],$this->premium) ? true : false) : false,
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

    public function add($owner, $type, $amount = 1) {
        global $engine;

        $items = query("SELECT * FROM `{$engine->server->prefix}hero_item` WHERE `owner`=? AND `equip`=? ORDER BY `slot` ASC;", [$owner,0])->fetchAll(PDO::FETCH_ASSOC);
        $slot = 1;
        for ($i = 0; $i < count($items); $i++) {
            if ($items[$i]['slot'] == $slot) {
                $slot++;
            }
        }

        $have = query("SELECT * FROM `{$engine->server->prefix}hero_item` WHERE `owner`=? AND `type`=?;", [$owner, $type])->rowCount();
        if ($have == 1 && $this->getSlot($item['type']) > 0) {
            query("UPDATE `{$engine->server->prefix}hero_item` SET `amount`=? WHERE `owner`=? AND `type`=?;", [$amount, $owner, $type]);
        } else {
            $params = [$owner, $type, $amount, $slot, 1, 1, "[]", "[]", time()];
            query("INSERT INTO `{$engine->server->prefix}hero_item` (`owner`,`type`,`amount`,`slot`,`quality`,`tier`,`bonus`,`upgrade`,`lastChange`) VALUES (?,?,?,?,?,?,?,?,?);", $params);
        }
    }

    public function useItem($param) {
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
         */
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
                $items = query("SELECT * FROM `{$engine->server->prefix}hero_item` WHERE `owner`=? AND `equip`=? ORDER BY `slot` ASC;", [$item['owner'], 0])->fetchAll(PDO::FETCH_ASSOC);
                $slot = 1;
                for ($a = 0; $a < count($items); $a++) {
                    if ($items[$a]['slot'] == $slot) {
                        $slot++;
                    }
                }
                query("UPDATE `{$engine->server->prefix}hero_item` SET `equip`=?,`slot`=? WHERE `id`=?;", [0, $slot, $item['id']]);
            } else {
                $items = query("SELECT * FROM `{$engine->server->prefix}hero_item` WHERE `owner`=? AND `equip`=? ORDER BY `slot` ASC;", [$item['owner'], 1])->fetchAll(PDO::FETCH_ASSOC);
                foreach ($items as $i) {
                    if ($this->getSlot($item['type']) == $this->getSlot($i['type'])) {
                        query("UPDATE `{$engine->server->prefix}hero_item` SET `equip`=?,`slot`=? WHERE `id`=?;", [0, $item['slot'], $i['id']]);
                    }
                }
                query("UPDATE `{$engine->server->prefix}hero_item` SET `equip`=?,`slot`=? WHERE `id`=?;", [1, 0, $item['id']]);
            }
            $return['cache'] += [
                $engine->item->getAll('own', true),
                $engine->hero->get($_SESSION[$engine->server->prefix . 'uid'])
            ];
        } else {
            if ($item['type'] == 120) {
                $return['response'] = [
                    "amount" => 1,
                    "destTime" => time() + 15,
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
