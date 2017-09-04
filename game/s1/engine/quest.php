<?php

class Quest {
    #
    # Status
    #   1 = Inactive
    #   2 = Activeable
    #   3 = Active
    #   4 = Done
    #   5 = Finished
    #
    # QuestGiver.DAILY = -1;
    # QuestGiver.MYSELF = 0;
    # QuestGiver.WREN = 1;
    # QuestGiver.FARMER = 2;
    # QuestGiver.SCOUT = 3;
    # QuestGiver.WOODCUTTER = 4;
    # QuestGiver.CLAY_MAN = 5;
    # QuestGiver.MINER = 6;
    # QuestGiver.TRADER = 7;
    # QuestGiver.ROBBER = 8;
    # QuestGiver.CHIEF = 9;
    # QuestGiver.ENVOY = 10;
    # QuestGiver.ADVENTURER = 11;
    # QuestGiver.GENERAL = 12;

    public function giver($uid = null) {
        global $engine;
        $uid == null ? $uid = $_SESSION[$engine->server->prefix . 'uid'] : null;
        $player = $engine->account->getById($uid);
        $i = 1;
        $r = [];
        $t = $player['tutorial'];
        if ($t <= 256) {
            $status = 2;
            $dialog = -2;
            if ($t < 6) {
                if ($t >= 2) {
                    $status = 3;
                }
                $qid = "1";
            } elseif ($t < 13) {
                $qid = "30";
            } elseif ($t < 17) {
                $qid = "35";
            } elseif ($t < 19) {
                $qid = "203";
            } elseif ($t < 22) {
                $qid = "204";
            } elseif ($t < 100) {
                //$qid = "302"; //เมื่อรองรับ Robber hideout
                $qid = "399";
            } else {
                $qid = -1;
                $dialog = -1;
                $status = -1;
            }
            array_push($r, [
                'name' => 'QuestGiver:' . $i++,
                'data' => [
                    'npcId' => '0',
                    'questId' => $qid,
                    'dialog' => $dialog,
                    'questStatus' => $status,
                ],
            ]);
        } else {
            if ($engine->hero->isHome()) {
                //Can Adventure
                array_push($r, [
                    'name' => 'QuestGiver:' . $i++,
                    'data' => [
                        'npcId' => '11',
                        'questId' => '991',
                        'dialog' => '1',
                        'questStatus' => '2',
                    ],
                ]);
            } else {
                $hero = query("SELECT * FROM `{$engine->server->prefix}hero` WHERE `owner`=?;", [$_SESSION[$engine->server->prefix . 'uid']])->fetch(PDO::FETCH_ASSOC);
                //Can't adventure
                if ($hero['dead'] == 0) {
                    array_push($r, [
                        'name' => 'QuestGiver:' . $i++,
                        'data' => [
                            'npcId' => '11',
                            'questId' => '-1',
                            'dialog' => '-1',
                            'questStatus' => '1',
                        ],
                    ]);
                } else {
                    array_push($r, [
                        'name' => 'QuestGiver:' . $i++,
                        'data' => [
                            'npcId' => '11',
                            'questId' => '-1',
                            'dialog' => '-1',
                            'questStatus' => '2',
                        ],
                    ]);
                }
            }
        }

        return [
            "name" => "Collection:QuestGiver:",
            "data" => [
                "operation" => 1,
                "cache" => $r
            ]
        ];
    }

    public function get($giver = "", $uid = null) {
        global $engine;
        $r = [];
        $uid == null ? $uid = (isset($_SESSION[$engine->server->prefix . 'uid']) ? $_SESSION[$engine->server->prefix . 'uid'] : $giver) : '';

        if ($giver <= 12 && $giver >= -1) {
            if ($giver == -1) {
                $r = array_merge($r, $this->daliy($uid));
            } else {
                $tutorial = $engine->account->getById($uid, 'tutorial');
                if ($tutorial < 100) {
                    $r = array_merge($r, $this->tutorial($uid), $this->normal($uid), $this->heroAdventure($uid), $this->daliy($uid));
                } else {
                    $r = array_merge($r, $this->heroAdventure($uid));
                }
            }
        } else {
            $r = array_merge($r, $this->tutorial($uid), $this->normal($uid), $this->heroAdventure($uid), $this->daliy($uid));
        }
        return [
            "name" => "Collection:Quest:" . (($giver <= 12) ? $giver : ''),
            "data" => [
                "operation" => 1,
                "cache" => $r,
            ],
        ];
    }

    private function normal($uid = null) {
        global $engine;
        $player = $engine->account->getById($uid);
        $quests = [];
        array_push($quests, 202, 205);
        array_push($quests, 501, 502, 503, 504, 505, 506, 507, 508, 509, 510, 511, 512, 513, 514, 515, 516, 517, 518, 519, 520, 521, 522, 523, 524, 526, 533, 534, 535, 536, 537, 538, 539, 540, 561);
        array_push($quests, 600, 601, 602, 603, 604, 605, 606, 607, 608, 609, 610, 611, 612, 613, 621, 622, 623, 624, 625, 626, 627, 628, 629, 630, 631, 632, 633, 634, 635, 636, 637, 638, 639, 640, 641, 642, 643, 644, 660);
        array_push($quests, 701, 702, 703, 704, 705, 712, 713, 714, 715, 716, 717, 721, 722, 731, 732, 733, 734, 735, 736, 737, 741, 742);
        array_push($quests, 801, 811, 812, 813, 814, 815, 820, 821, 822, 824, 823, 825, 826, 827, 828, 829, 830, 831, 832, 833, 834, 835, 836, 837, 838, 850);
        array_push($quests, 901, 902, 903, 904, 905, 906);
        $r = [];
        foreach ($quests as $q) {
            $rn = [
                'name' => 'Quest:' . $q,
                'data' => [
                    'id' => $q,
                    'questGiver' => 0,
                    'data' => 0,
                    'progress' => 0,
                    'finishedSteps' => 0,
                    'finalStep' => 1,
                    'rewards' => [],
                    'status' => 1,
                ],
            ];
            // Adventure quest
            if (in_array($q, [826, 827, 821, 822, 825, 823, 824, 825, 828, 829, 830])) {
                $rn = $this->quest_adventure($q, $rn);
            }

            array_push($r, $rn);
        }
        return $r;
    }

    private function tutorial($uid = null) {
        global $engine;
        $player = $engine->account->getById($uid);
        $quests = [1, 23, 24, 25, 30, 31, 32, 33, 34, 35, 101, 102, 203, 204, 302, 303, 399, 400, 401, 402, 403];
        $r = [];
        $t = $player['tutorial'];
        foreach ($quests as $q) {
            $rn = [
                'name' => 'Quest:' . $q,
                'data' => [
                    'id' => $q,
                    'questGiver' => 0,
                    'status' => 1,
                    'data' => 0,
                    'progress' => 0,
                    'finishedSteps' => 0,
                    'finalStep' => 1,
                    'rewards' => [],
                ],
            ];
            if ($q == 1) {
                if ($t == 1) {
                    $rn['data']['status'] = 2;
                } elseif ($t == 2) {
                    $rn['data']['status'] = 3;
                } elseif ($t == 3) {
                    $rn['data']['status'] = 3;
                    $rn['data']['progress'] = 2;
                    $rn['data']['finishedSteps'] = 1;
                } elseif ($t == 4) {
                    $rn['data']['status'] = 4;
                    $rn['data']['progress'] = 2;
                    $rn['data']['finishedSteps'] = 1;
                } elseif ($t == 5) {
                    $rn['data']['status'] = 4;
                    $rn['data']['progress'] = 3;
                    $rn['data']['finishedSteps'] = 1;
                } elseif ($t >= 6) {
                    $rn['data']['status'] = 5;
                    $rn['data']['progress'] = 3;
                    $rn['data']['finishedSteps'] = 1;
                }
            } elseif ($q == 30) {
                if ($t == 6) {
                    $rn['data']['status'] = 3;
                } elseif ($t == 7) {
                    $rn['data']['status'] = 3;
                    $rn['data']['progress'] = 1;
                } elseif ($t == 8) {
                    $rn['data']['status'] = 3;
                    $rn['data']['progress'] = 1;
                } elseif ($t == 9) {
                    $rn['data']['status'] = 3;
                    $rn['data']['progress'] = 2;
                } elseif ($t == 10) {
                    $rn['data']['status'] = 3;
                    $rn['data']['progress'] = 3;
                } elseif ($t == 11) {
                    $rn['data']['status'] = 3;
                    $rn['data']['progress'] = 4;
                } elseif ($t == 12) {
                    $rn['data']['status'] = 4;
                    $rn['data']['progress'] = 5;
                    $rn['data']['finishedSteps'] = 1;
                } elseif ($t >= 13) {
                    $rn['data']['status'] = 5;
                    $rn['data']['progress'] = 5;
                    $rn['data']['finishedSteps'] = 1;
                }
            } elseif ($q == 31) {
                if ($t == 6) {
                    $rn['data']['status'] = 3;
                } elseif ($t == 7) {
                    $rn['data']['status'] = 4;
                    $rn['data']['progress'] = 1;
                    $rn['data']['finishedSteps'] = 1;
                } elseif ($t >= 8) {
                    $rn['data']['status'] = 5;
                    $rn['data']['progress'] = 1;
                    $rn['data']['finishedSteps'] = 1;
                }
            } elseif ($q == 32) {
                if ($t == 8) {
                    $rn['data']['status'] = 3;
                } elseif ($t >= 9) {
                    $rn['data']['status'] = 5;
                    $rn['data']['progress'] = 1;
                    $rn['data']['finishedSteps'] = 1;
                }
            } elseif ($q == 33) {
                if ($t == 9) {
                    $rn['data']['status'] = 3;
                } elseif ($t >= 10) {
                    $rn['data']['status'] = 5;
                    $rn['data']['progress'] = 1;
                    $rn['data']['finishedSteps'] = 1;
                }
            } elseif ($q == 34) {
                if ($t == 13) {
                    $rn['data']['status'] = 3;
                } elseif ($t >= 14) {
                    $rn['data']['status'] = 5;
                    $rn['data']['progress'] = 1;
                    $rn['data']['finishedSteps'] = 1;
                }
            } elseif ($q == 35) {
                if ($t == 14) {
                    $rn['data']['status'] = 2;
                } elseif ($t == 15) {
                    $rn['data']['status'] = 3;
                } elseif ($t == 16) {
                    $rn['data']['status'] = 4;
                    $rn['data']['progress'] = 1;
                    $rn['data']['finishedSteps'] = 1;
                } elseif ($t >= 17) {
                    $rn['data']['status'] = 5;
                    $rn['data']['progress'] = 1;
                    $rn['data']['finishedSteps'] = 1;
                }
            } elseif ($q == 203) {
                if ($t == 17) {
                    $rn['data']['status'] = 2;
                } elseif ($t == 18) {
                    $rn['data']['status'] = 3;
                } elseif ($t >= 19) {
                    $rn['data']['status'] = 5;
                    $rn['data']['progress'] = 2;
                    $rn['data']['finishedSteps'] = 1;
                }
            } elseif ($q == 204) {
                $rn['data']['data'] = 3;
                $rn['data']['rewards'] = [6 => 'Map'];
                if ($t == 19) {
                    $rn['data']['status'] = 2;
                } elseif ($t == 20) {
                    $rn['data']['status'] = 3;
                } elseif ($t == 21) {
                    $rn['data']['status'] = 3;
                    $rn['data']['progress'] = 4;
                } elseif ($t >= 22) {
                    $rn['data']['status'] = 5;
                    $rn['data']['progress'] = 4;
                    $rn['data']['finishedSteps'] = 1;
                }
            } elseif ($q == 302) {
                if ($t == 22) {
                    $rn['data']['status'] = 5; //จิงๆเป็น 3
                    $rn['data']['finishedSteps'] = 1;
                }/* elseif ($t == 23) {
                  $rn['data']['status'] = 4;
                  } */ elseif ($t >= 22) {
                    $rn['data']['status'] = 5;
                    $rn['data']['finishedSteps'] = 1;
                }
            } elseif ($q == 303) {
                if ($t == 22) {
                    $rn['data']['status'] = 5;
                    $rn['data']['finishedSteps'] = 1;
                } elseif ($t >= 22) {
                    $rn['data']['status'] = 5;
                    $rn['data']['finishedSteps'] = 1;
                }
            } elseif ($q == 399) {
                if ($t == 22) {
                    $rn['data']['status'] = 2;
                } elseif ($t == 23) {
                    $rn['data']['status'] = 3;
                }
                if ($t >= 100) {
                    $rn['data']['status'] = 5;
                    $rn['data']['finishedSteps'] = 1;
                }
            }
            array_push($r, $rn);
        }
        return $r;
    }

    private function daliy($uid = null) {
        global $engine;
        $player = $engine->account->getById($uid);
        $quests = [10000, 10001, 10002, 10003, 10004, 10005, 10006, 10007, 10008, 10009, 10010, 10011, 10012, 10013, 10014, 10015];
        $r = [];
        $t = $player['tutorial'];
        foreach ($quests as $q) {
            $rn = [
                'name' => 'Quest:' . $q,
                'data' => [
                    'id' => $q,
                    'questGiver' => 0,
                    'data' => 0,
                    'progress' => 0,
                    'finishedSteps' => 0,
                    'finalStep' => 1,
                    'rewards' => [],
                    'status' => 1,
                ],
            ];
            array_push($r, $rn);
        }
        return $r;
    }

    private function heroAdventure($uid) {
        global $engine;
        $hero = query("SELECT * FROM `{$engine->server->prefix}hero` WHERE `owner`=?;", [$uid])->fetch(PDO::FETCH_ASSOC);
        $r = [
            [
                'name' => 'Quest:991',
                'data' => [
                    'id' => 991,
                    'questGiver' => 11,
                    'data' => 1,
                    'progress' => $hero['advShort'],
                    'finishedSteps' => 0,
                    'finalStep' => 1,
                    'rewards' => [],
                    'status' => 2,
                ],
            ],
            [
                'name' => 'Quest:992',
                'data' => [
                    'id' => 992,
                    'questGiver' => 11,
                    'data' => 2,
                    'progress' => $hero['advLong'],
                    'finishedSteps' => 0,
                    'finalStep' => 1,
                    'rewards' => [],
                    'status' => 2,
                ],
            ],
        ];
        return $r;
    }

    public function quest_adventure($id, $rn) {
        global $engine;
        $hero = query("SELECT * FROM `{$engine->server->prefix}hero` WHERE `owner`=?;", [$_SESSION[$engine->server->prefix . 'uid']])->fetch(PDO::FETCH_ASSOC);

        switch ($id) {
            case 826:
                if ($hero['useAdvPoint'] >= 1) {
                    $rn['data']['status'] = 4;
                }
                break;
            case 827:
                if ($hero['useAdvPoint'] >= 1) {
                    $rn['data']['status'] = 4;
                }
                break;
            case 821:
                if ($hero['useAdvPoint'] >= 1) {
                    $rn['data']['status'] = 4;
                }
                break;
            case 822:
                if ($hero['useAdvPoint'] >= 1) {
                    $rn['data']['status'] = 4;
                }
                break;
            case 825:
                if ($hero['useAdvPoint'] >= 1) {
                    $rn['data']['status'] = 4;
                }
                break;
            case 823:
                if ($hero['useAdvPoint'] >= 1) {
                    $rn['data']['status'] = 4;
                }
                break;
            case 824:
                if ($hero['useAdvPoint'] >= 1) {
                    $rn['data']['status'] = 4;
                }
                break;
            case 825:
                if ($hero['useAdvPoint'] >= 1) {
                    $rn['data']['status'] = 4;
                }
                break;
            case 828:
                if ($hero['useAdvPoint'] >= 1) {
                    $rn['data']['status'] = 4;
                }
                break;
            case 829:
                if ($hero['useAdvPoint'] >= 1) {
                    $rn['data']['status'] = 4;
                }
                break;
            case 830:
                if ($hero['useAdvPoint'] >= 1) {
                    $rn['data']['status'] = 4;
                }
                break;
        }
        return $rn;
    }

}
