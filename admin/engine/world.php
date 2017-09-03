<?php

/*
 * Develop by Phumin Chanthalert from Thailand
 * Facebook : http://fb.com/phoomin2012
 * Tel. : 091-8585234 (Thai mobile)
 * Copy Rigth © Phumin Chanthalert.
 */

class World {

    public $data = null;
    public $worldmax = 100;
    public $radius = 70;
    public $ww_radius = 8;
    public $percent_spawn_oasis = 40;

    public function generateMap() {
        global $engine;
        ini_set("max_execution_time", "600");
        ini_set("max_input_time", "600");
        //if($engine->server->genmap==1){
        #
        # Create border of circle
        #
        $border = [];
        for ($x = -$this->worldmax; $x <= $this->worldmax; $x += 1) {
            $border[$x] = [
                - sqrt(pow($this->radius, 2) - pow($x, 2)),
                sqrt(pow($this->radius, 2) - pow($x, 2))
            ];
        }


        $fieldsData = ["3339", "3447", "3456", "3546", "4347", "4356", "4437", "4446", "4536", "5346", "5436", "11115"];
        for ($x = -$this->worldmax; $x <= $this->worldmax; $x += 1) {
            for ($y = -$this->worldmax; $y <= $this->worldmax; $y += 1) {
                if ($y >= $border[$x][0] && $y <= $border[$x][1]) { // Check is in circle
                    $rand = rand(1, 900);
                    $fieldtype = 0;
                    $oasistype = 0;
                    if (10 >= $rand) {
                        $fieldtype = "4437";
                    } elseif (90 >= $rand) {
                        $fieldtype = "3447";
                    } elseif (400 >= $rand) {
                        $fieldtype = "4446";
                    } elseif (480 >= $rand) {
                        $fieldtype = "3456";
                    } elseif (560 >= $rand) {
                        $fieldtype = "11115";
                    } elseif (570 >= $rand) {
                        $fieldtype = "4356";
                    } elseif (600 >= $rand) {
                        $fieldtype = "3339";
                    } elseif (630 >= $rand) {
                        $fieldtype = "4347";
                    } elseif (670 >= $rand) {
                        $fieldtype = "5346";
                    } elseif (740 >= $rand) {
                        $fieldtype = "5436";
                    } elseif (820 >= $rand) {
                        $fieldtype = "4536";
                    } else {
                        $fieldstype = $fieldsData[rand(0, count($fieldsData) - 1)];
                    }
                    $image = rand(0, 31);
                    $oasistype = "0";
                    $this->setField($this->xy2id($x, $y), $image, $fieldtype, $oasistype);
                }
            }
        }
        foreach ($engine->server->ww_position as $ww) {
            $this->setWonder($ww[0], $ww[1]);
        }
        $this->oasisGenerate();

        query("UPDATE `global_server_data` SET `genmap`=? WHERE `tag`=?;", array('2', 'server1'));
    }

    public function setWonder($xo, $yo = 0) {
        global $engine;

        if (is_array($xo)) {
            $yo = $xo[1];
            $xo = $xo[0];
        }
        for ($x1 = -1; $x1 <= 3; $x1++) {
            for ($y1 = -3; $y1 <= 1; $y1++) {
                $x = $x1;
                $y = $y1;

                if ($x == -1 && $y == -3) {
                    $image = "9000";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 0 && $y == -3) {
                    $image = "9010";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 1 && $y == -3) {
                    $image = "9020";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 2 && $y == -3) {
                    $image = "9030";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 3 && $y == -3) {
                    $image = "9040";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == -1 && $y == -2) {
                    $image = "9001";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 0 && $y == -2) {
                    $image = "9011";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 1 && $y == -2) {
                    $image = "9021";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 2 && $y == -2) {
                    $image = "9031";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 3 && $y == -2) {
                    $image = "9041";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == -1 && $y == -1) {
                    $image = "9002";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 0 && $y == -1) {
                    $image = "9012";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 1 && $y == -1) {
                    $image = "9022";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 2 && $y == -1) {
                    $image = "9032";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 3 && $y == -1) {
                    $image = "9042";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == -1 && $y == 0) {
                    $image = "9003";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 0 && $y == 0) {
                    $image = "9013";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 1 && $y == 0) {
                    $image = "9023";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 2 && $y == 0) {
                    $image = "9033";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 3 && $y == 0) {
                    $image = "9043";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == -1 && $y == 1) {
                    $image = "9004";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 0 && $y == 1) {
                    $image = "9014";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 1 && $y == 1) {
                    $image = "9024";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 2 && $y == 1) {
                    $image = "9034";
                    $fieldtype = "0";
                    $oasistype = "99";
                } elseif ($x == 3 && $y == 1) {
                    $image = "9044";
                    $fieldtype = "0";
                    $oasistype = "99";
                }

                $x = $xo + $x1;
                $y = $yo + $y1;

                $this->setField($this->xy2id($x, $y), $image, $fieldtype, $oasistype);
            }
        }
    }

    private function setField($id, $image = '0', $field = '0', $oasis = '0', $bonus = '0') {
        global $engine;
        if (is_array($id)) {
            $id = $this->xy2id($id[0], $id[1]);
        }
        $num = query("SELECT * FROM `{$engine->server->prefix}world` WHERE `id`=?", array($id))->rowCount();
        if ($num == 1) {
            query("UPDATE `{$engine->server->prefix}world` SET `fieldtype`=?,`oasistype`=?,`image`=?,`bonus`=? WHERE `id`=?", array($field, $oasis, $image, $bonus, $id));
        } else {
            $xy = $this->id2xy($id);
            $array = array($id, $xy[0], $xy[1], $field, $oasis, $image, $bonus);
            $sql = "INSERT INTO `{$engine->server->prefix}world` (`id`,`x`,`y`,`fieldtype`,`oasistype`,`image`,`bonus`) VALUE (?,?,?,?,?,?,?);";
            query($sql, $array);
        }
    }

    public function getWWTile() {
        global $engine;
        $r = [];
        echo "adasdf";
        foreach ($engine->server->ww_position as $ww) {
            $x = $ww[0];
            $y = $ww[1];
            for ($x1 = -$this->ww_radius; $x1 < $this->ww_radius; $x1++)
                for ($y1 = -$this->ww_radius; $y1 < $this->ww_radius; $y1++)
                    if ($this->getDistance($x + $x1, $y + $y1) <= $this->ww_radius)
                        $r[] = [$x + $x1, $y + $y1];
        }
        return $r;
    }

    public function getDistance($w1, $w2) {
        if (!is_array($w1)) {
            $w1 = $this->id2xy($w1);
        }
        if (!is_array($w2)) {
            $w2 = $this->id2xy($w2);
        }
        return sqrt(pow($w1[0] - $w2[0], 2) + pow($w1[1] - $w2[1], 2));
    }

    public function getDuration($speed = 1, $w1, $w2) {
        global $engine;

        $dist = $this->getDistance($w1, $w2);
        $duration = $dist / ($speed * $engine->server->speed_unit) * 3600;
        return $duration;
    }

    public function oasisGenerate() {
        global $engine;

        $fs = query("SELECT * FROM `{$engine->server->prefix}world` WHERE `oasistype`=?", [0])->fetchAll(PDO::FETCH_ASSOC);
        $wwr = $this->getWWTile();

        foreach ($fs as $f) {
            $x = $f['x'];
            $y = $f['y'];
            $id = $this->xy2id($f['x'], $f['y']);
            $rand = rand(0, 100);

            if (!in_array([$x, $y], $wwr)) {
                // Set field data
                if ($this->percent_spawn_oasis >= $rand) {
                    $oasistype = rand(1, 4);
                    //Add troops
                    $troop = [];
                    for ($i = 1; $i <= 10; $i++) {
                        if (rand(0, 10) == 0) { // 10% to spawn animals
                            $troop[$i] = rand(5, 20); // random 5 to 20 animals of type will add to oasis
                        }
                    }
                    $unit = $engine->unit->createUnit($id, $troop);
                    $engine->unit->addStay($id, 0, $unit);
                    if ($oasistype == 1) {
                        $image = rand(0, 9);
                        $bonus = array(0, 25, 25, 25, 50);
                        if ($image == 0) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '1055', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 1) {
                            if (
                                    $this->isField($this->xy2id($x - 1, $y)) &&
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y))
                            ) {
                                $this->setField($this->xy2id($x - 1, $y), '1145', '0', $oasistype);
                                $this->setField($this->xy2id($x, $y), '1155', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x + 1, $y), '1165', '0', $oasistype);
                            }
                        } elseif ($image == 2) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x, $y + 1)) &&
                                    $this->isField($this->xy2id($x + 1, $y))
                            ) {
                                $this->setField($this->xy2id($x, $y), '1255', '0', $oasistype);
                                $this->setField($this->xy2id($x, $y + 1), '1256', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x + 1, $y), '1265', '0', $oasistype);
                            }
                        } elseif ($image == 3) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y)) &&
                                    $this->isField($this->xy2id($x, $y - 1)) &&
                                    $this->isField($this->xy2id($x + 1, $y - 1))
                            ) {
                                $this->setField($this->xy2id($x, $y), '1355', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x + 1, $y), '1365', '0', $oasistype);
                                $this->setField($this->xy2id($x, $y - 1), '1354', '0', $oasistype);
                                $this->setField($this->xy2id($x + 1, $y - 1), '1364', '0', $oasistype);
                            }
                        } elseif ($image == 4) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x, $y - 1)) &&
                                    $this->isField($this->xy2id($x + 1, $y))
                            ) {
                                $this->setField($this->xy2id($x, $y), '1455', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x, $y - 1), '1454', '0', $oasistype);
                                $this->setField($this->xy2id($x + 1, $y), '1465', '0', $oasistype);
                            }
                        } elseif ($image == 5) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '1555', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 6) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '1655', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 7) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x, $y + 1)) &&
                                    $this->isField($this->xy2id($x + 1, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y - 1)) &&
                                    $this->isField($this->xy2id($x + 1, $y + 1))
                            ) {
                                $this->setField($this->xy2id($x, $y), '1755', '0', $oasistype);
                                $this->setField($this->xy2id($x, $y + 1), '1756', '0', $oasistype);
                                $this->setField($this->xy2id($x + 1, $y), '1765', '0', $oasistype);
                                $this->setField($this->xy2id($x + 1, $y - 1), '1764', '0', $oasistype);
                                $this->setField($this->xy2id($x + 1, $y + 1), '1766', '0', $oasistype);
                            }
                        } elseif ($image == 8) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x, $y + 1)) &&
                                    $this->isField($this->xy2id($x + 1, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y - 1))
                            ) {
                                $this->setField($this->xy2id($x, $y), '1855', '0', $oasistype);
                                $this->setField($this->xy2id($x, $y + 1), '1856', '0', $oasistype);
                                $this->setField($this->xy2id($x + 1, $y), '1865', '0', $oasistype);
                                $this->setField($this->xy2id($x + 1, $y - 1), '1864', '0', $oasistype);
                            }
                        } elseif ($image == 9) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x, $y + 1)) &&
                                    $this->isField($this->xy2id($x + 1, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y - 1))
                            ) {
                                $this->setField($this->xy2id($x, $y), '1955', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x, $y + 1), '1956', '0', $oasistype);
                                $this->setField($this->xy2id($x + 1, $y), '1965', '0', $oasistype);
                                $this->setField($this->xy2id($x + 1, $y - 1), '1964', '0', $oasistype);
                            }
                        }
                    } elseif ($oasistype == 2) {
                        $image = rand(0, 7);
                        $bonus = array(25, 25, 25, 50);
                        if ($image == 0) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '2055', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 1) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '2155', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 2) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '2255', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 3) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '2355', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 4) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '2455', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 5) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '2555', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 6) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y))
                            ) {
                                $this->setField($this->xy2id($x, $y), '2655', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x + 1, $y), '2665', '0', $oasistype);
                            }
                        } elseif ($image == 7) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y)) &&
                                    $this->isField($this->xy2id($x, $y + 1))
                            ) {
                                $this->setField($this->xy2id($x, $y), '2755', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x + 1, $y), '2765', '0', $oasistype);
                                $this->setField($this->xy2id($x, $y + 1), '2756', '0', $oasistype);
                            }
                        }
                    } elseif ($oasistype == 3) {
                        $image = rand(0, 9);
                        $bonus = array(0, 0, 0, 25, 25, 25, 50);
                        if ($image == 0) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '3055', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 1) {
                            if (
                                    $this->isField($this->xy2id($x, $y + 1)) &&
                                    $this->isField($this->xy2id($x, $y))
                            ) {
                                $this->setField($this->xy2id($x, $y + 1), '3156', '0', $oasistype);
                                $this->setField($this->xy2id($x, $y), '3155', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 2) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y))
                            ) {
                                $this->setField($this->xy2id($x, $y), '3255', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x + 1, $y), '3265', '0', $oasistype);
                            }
                        } elseif ($image == 3) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y + 1))
                            ) {
                                $this->setField($this->xy2id($x, $y), '3355', '0', $oasistype);
                                $this->setField($this->xy2id($x + 1, $y), '3365', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x + 1, $y + 1), '3366', '0', $oasistype);
                            }
                        } elseif ($image == 4) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '3455', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 5) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '3555', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 6) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '3655', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 7) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x, $y + 1))
                            ) {
                                $this->setField($this->xy2id($x, $y), '3755', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x, $y + 1), '3756', '0', $oasistype);
                            }
                        } elseif ($image == 8) {
                            if (
                                    $this->isField($this->xy2id($x, $y + 1)) &&
                                    $this->isField($this->xy2id($x + 1, $y + 1))
                            ) {
                                $this->setField($this->xy2id($x, $y + 1), '3855', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x + 1, $y + 1), '3865', '0', $oasistype);
                            }
                        } elseif ($image == 8) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y + 1))
                            ) {
                                $this->setField($this->xy2id($x, $y), '3955', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x + 1, $y), '3965', '0', $oasistype);
                                $this->setField($this->xy2id($x + 1, $y + 1), '3966', '0', $oasistype);
                            }
                        }
                    }if ($oasistype == 4) {
                        $image = rand(0, 9);
                        $bonus = array(25, 25, 25, 50);
                        if ($image == 0) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '4055', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 1) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x - 1, $y))
                            ) {
                                #Lake#
                                $this->setField($this->xy2id($x, $y), '4155', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x - 1, $y), '4145', '0', $oasistype);
                            }
                        } elseif ($image == 2) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y)) &&
                                    $this->isField($this->xy2id($x, $y + 1))
                            ) {
                                #Lake#
                                $this->setField($this->xy2id($x, $y), '4255', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x + 1, $y), '4265', '0', $oasistype);
                                $this->setField($this->xy2id($x, $y + 1), '4256', '0', $oasistype);
                            }
                        } elseif ($image == 3) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '4355', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 4) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '4455', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 5) {
                            if ($this->isField($id)) {
                                #Lake#
                                $this->setField($this->xy2id($x, $y), '4555', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 6) {
                            if ($this->isField($id)) {
                                $this->setField($this->xy2id($x, $y), '4655', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                            }
                        } elseif ($image == 7) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x - 1, $y))
                            ) {
                                $this->setField($this->xy2id($x, $y), '4755', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x - 1, $y), '4745', '0', $oasistype);
                            }
                        } elseif ($image == 8) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x - 1, $y))
                            ) {
                                $this->setField($this->xy2id($x, $y), '4855', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x - 1, $y), '4845', '0', $oasistype);
                            }
                        } elseif ($image == 9) {
                            if (
                                    $this->isField($this->xy2id($x, $y)) &&
                                    $this->isField($this->xy2id($x + 1, $y)) &&
                                    $this->isField($this->xy2id($x, $y + 1))
                            ) {
                                $this->setField($this->xy2id($x, $y), '4955', '0', $oasistype, $bonus[rand(0, count($bonus) - 1)]);
                                $this->setField($this->xy2id($x + 1, $y), '4965', '0', $oasistype);
                                $this->setField($this->xy2id($x, $y + 1), '4956', '0', $oasistype);
                            }
                        }
                    }
                }
            }
        }
    }

    private function isField($id) {
        global $engine;
        $f = query("SELECT * FROM `{$engine->server->prefix}world` WHERE `id`=?", [$id])->fetch(PDO::FETCH_ASSOC);
        if ($f['oasistype'] == "0" && $f['image'] < 9000)
            return true;
        else
            return false;
    }

    public function id2xy($id) {
        return 0 > $id || null === $id ? array(0, 0) : array($id % 32768 - 16384, ((int) ($id / 32768)) - 16384);
    }

    public function xy2id($x, $y = 0) {
        if (is_array($x)) {
            $y = $x[1];
            $x = $x[0];
        }
        return $x + 16384 + 32768 * ($y + 16384);
    }

    public function bestPosition($sector = 0) {
        global $engine;

        $xm = $ym = 0;
        $queryit = '';

        if ($sector == 0) {
            $sector = round(rand(1, 4));
        }

        $unselect_village = "AND `id` NOT IN (SELECT `wid` FROM `{$engine->server->prefix}village`)";
        switch ($sector) {
            case 1: $queryit = "0 > `x` AND `y` > 0 AND `fieldtype` = '4446' " . $unselect_village . " ORDER BY `x` DESC, `y` ASC";
                break;
            case 2: $queryit = "0 < `x` AND `y` > 0 AND `fieldtype` = '4446' " . $unselect_village . " ORDER BY `x` ASC, `y` ASC";
                break;
            case 3: $queryit = "0 < `x` AND `y` < 0 AND `fieldtype` = '4446' " . $unselect_village . " ORDER BY `x` ASC, `y` DESC";
                break;
            case 4: $queryit = "0 > `x` AND `y` < 0 AND `fieldtype` = '4446' " . $unselect_village . " ORDER BY `x` DESC, `y` DESC";
                break;
        }
        $q = "SELECT `id` FROM `{$engine->server->prefix}world` WHERE " . $queryit . " LIMIT 1";
        $dbarray = query($q)->fetch(PDO::FETCH_ASSOC);
        return array($dbarray['id'], $q);
    }

    public function getRegionDetail1($id = null) {
        global $engine;
        $id == null ? $id = $this->xy2id(0, 0) : false;
        $b = $this->id2xy($id);
        $b[0] = $b[0] * 5;
        $b[1] = $b[1] * 5;

        //var_dump($b);
        $r = [];
        $p = [];
        $k = [];

        $player = query("SELECT * FROM `" . $engine->server->prefix . "user` WHERE `uid`=?", [$_SESSION[$engine->server->prefix . 'uid']])->fetch(PDO::FETCH_ASSOC);

        if ($id != "") {
            for ($x = 0; $x < 7; $x++) {
                for ($y = 0; $y < 7; $y++) {

                    $now_x = $b[0] + $x;
                    $now_y = $b[1] + $y;
                    $now_wid = $this->xy2id($now_x, $now_y);

                    $landscape = query("SELECT * FROM `{$engine->server->prefix}world` WHERE `id`=?", [$now_wid])->fetch(PDO::FETCH_ASSOC);
                    $v = query("SELECT * FROM `{$engine->server->prefix}village` WHERE `wid`=?", [$now_wid])->fetch(PDO::FETCH_ASSOC);

                    if ($player['tutorial'] > 21) {
                        //Not tutorial
                        if ($v) {

                            //Get Player data
                            $pD = $engine->account->getByVillage($v['wid']);

                            //Prepare Kingdom data
                            if ($pD['kingdom'] != 0) {
                                $kD = $engine->kingdom->getData($pD['kingdom']);
                                $k[$pD['kingdom']] = [
                                    "tag" => $kD['tag']
                                ];
                                $pre_r['owner'] = $pD['kingdom'];
                            }

                            //Prepare field data
                            $pre_r = [
                                'id' => $now_wid,
                                'resType' => $landscape['fieldtype'],
                                'landscape' => $landscape['image'],
                                'owner' => 0,
                                'playerId' => $v['owner'],
                                'village' => [
                                    'villageId' => $v['wid'],
                                    'name' => $v['vname'],
                                    'population' => $v['pop'],
                                    'type' => ($v['town'] == 1 ? 2 : 1),
                                    'hasActiveTreasury' => $v['area'] != -1 ? false : true,
                                ]
                            ];

                            if ($v['area'] == -1) {
                                $infSize = 4.2;
                                if ($v['pop'] < 500) {
                                    $infSize = 3.2;
                                }
                                if ($v['pop'] < 250) {
                                    $infSize = 2.3;
                                }
                                if ($v['pop'] < 100) {
                                    $infSize = 1.3;
                                }
                                $pre_r['village']['treasures'] = 1;
                                $pre_r['village']['influenceSize'] = $infSize;
                            }

                            //Get influence data
                            $inf = $this->getInf($now_wid, 'owner');
                            $infs = $this->getInf($now_wid, 'kingdom');
                            $pre_r['owner'] = $inf;
                            $pre_r['influence'] = $infs;
                            $pre_r['tributeInfluences'] = $infs;

                            //Prepare player data
                            $p[$pD['uid']] = [
                                'name' => $pD['username'],
                                'tribeId' => $pD['tribe'],
                                "kingdomRole" => $pD['kingdom'] != 0 ? ($engine->kingdom->getRole($pD['kingdom'], $pD['uid']) != 0 ? 1 : 0) : '0',
                                "kingStatus" => $pD['uid'] == $kD['king'] ? true : false,
                                "kingdomId" => $pD['kingdom'] != 0 ? $kD['id'] : '0',
                                "kingId" => $pD['kingdom'] != 0 ? $kD['king'] : '0',
                                "spawnedOnMap" => "1471436593",
                                "active" => "1"
                            ];
                        } else {
                            if ($landscape['fieldtype'] == "0") {
                                if ($landscape['oasistype'] != "0" && $landscape['bonus'] != "0") {
                                    $pre_r = [
                                        'id' => $now_wid,
                                        'landscape' => $landscape['image'],
                                        'oasis' => [
                                            "bonus" => [
                                                "1" => ($landscape['oasistype'] == 1 && ($landscape['bonus'] == "25" || $landscape['bonus'] == "50")) ? 25 : 0,
                                                "2" => ($landscape['oasistype'] == 2 && ($landscape['bonus'] == "25" || $landscape['bonus'] == "50")) ? 25 : 0,
                                                "3" => ($landscape['oasistype'] == 3 && ($landscape['bonus'] == "25" || $landscape['bonus'] == "50")) ? 25 : 0,
                                                "4" => ($landscape['bonus'] == "50") ? (($landscape['oasistype'] == 4) ? 50 : 25) : (($landscape['bonus'] == "25" && $landscape['oasistype'] == 4 ? 25 : 0)),
                                            ],
                                            "units" => [],
                                            "type" => $landscape['oasistype'] . (($landscape['bonus'] == "50") ? "1" : "0"),
                                            "oasisStatus" => "3",
                                            "kingdomId" => "0",
                                            "kingId" => "0",
                                        ],
                                        'owner' => 0,
                                    ];
                                } else {
                                    $pre_r = [
                                        'id' => $now_wid,
                                        'landscape' => $landscape['image'],
                                        'owner' => 0,
                                    ];
                                }
                            } else {
                                if (isset($landscape['image'])) {
                                    $pre_r = [
                                        'id' => $now_wid,
                                        'resType' => $landscape['fieldtype'],
                                        'landscape' => $landscape['image'],
                                        'owner' => 0,
                                    ];
                                } else {
                                    $images = array("1055", "1555", "1655", "3055", "3455", "3555", "3655", "1055", "1555", "1655");
                                    $image = $images[($this->xy2id($b[0] + $x, $b[1] - $y) % 10)];
                                    $pre_r = array(
                                        'id' => $now_wid,
                                        'landscape' => $image,
                                        'owner' => 0,
                                    );
                                }
                            }
                            //Get influence data
                            $inf = $this->getInf($now_wid, 'owner');
                            $infs = $this->getInf($now_wid, 'kingdom');
                            $pre_r['owner'] = $inf;
                            $pre_r['influence'] = $infs;
                            $pre_r['tributeInfluences'] = $infs;
                        }

                        //Add field data to region
                        array_push($r, $pre_r);
                    } else {
                        // In tutorial
                        if ($b[0] + $x == 0 && $b[1] - $y == 0) {
                            if ($player['tutorial'] >= 4) {
                                $pre_r = array(
                                    'id' => $now_wid,
                                    'resType' => '4446',
                                    'landscape' => '1',
                                    'owner' => 0,
                                    'playerId' => $player['uid'],
                                    'village' => array(
                                        'villageId' => $_COOKIE['village'],
                                        'name' => $player['username'] . "'s village",
                                        'population' => '5',
                                        'type' => 1,
                                        'hasActiveTreasury' => false,
                                        "influenceSize" => "0",
                                        "treasures" => "0"
                                    )
                                );
                            } else {
                                $pre_r = [
                                    'id' => $now_wid,
                                    'landscape' => 0,
                                    'owner' => 0,
                                    'playerId' => 0,
                                    'village' => [
                                        'villageId' => 1,
                                        'name' => "Your village",
                                        'population' => 1,
                                    ]
                                ];
                            }
                        } else {
                            $pre_r = [
                                "id" => $now_wid,
                                "landscape" => "0",
                                "owner" => 0
                            ];
                        }
                        array_push($r, $pre_r);
                    }
                }
            }
        }

        //var_dump($inf);

        if ($player['tutorial'] < 256) {
            return [
                'region' => $r,
                'player' => [
                    $_SESSION[$engine->server->prefix . 'uid'] => [
                        "name" => "",
                        "tribeId" => $_SESSION[$engine->server->prefix . 'tribe'],
                        "kingdomId" => 0,
                        "kingStatus" => 0
                    ],
                    "-1" => [
                        "name" => "Robber",
                        "tribeId" => 1,
                        "kingdomId" => 0,
                        "kingStatus" => 0
                    ]
                ],
                'kingdom' => [],
            ];
        } else {
            return [
                'region' => $r,
                'player' => $p,
                'kingdom' => $k,
            ];
        }
    }

    public function getRegionDetail3($id) {
        global $engine;
        $b = $this->id2xy($id);
        $b[0] = $b[0] * 21;
        $b[1] = $b[1] * 21;

        //var_dump($b);
        $r = [];
        $p = [];
        $k = [];

        $player = query("SELECT * FROM `" . $engine->server->prefix . "user` WHERE `uid`=?", [$_SESSION[$engine->server->prefix . 'uid']])->fetch(PDO::FETCH_ASSOC);

        if ($id != "") {
            for ($x = 0; $x < 21; $x++) {
                $r[$x] = [];
                for ($y = 0; $y < 21; $y++) {

                    $now_x = $b[0] + $x;
                    $now_y = $b[1] + $y;
                    $now_wid = $this->xy2id($now_x, $now_y);

                    $landscape = query("SELECT * FROM `{$engine->server->prefix}world` WHERE `id`=?", [$now_wid])->fetch(PDO::FETCH_ASSOC);
                    $v = query("SELECT * FROM `{$engine->server->prefix}village` WHERE `wid`=?", [$now_wid])->fetch(PDO::FETCH_ASSOC);

                    if ($v) {

                        //Get Player data
                        $pD = $engine->account->getByVillage($v['wid']);

                        //Prepare Kingdom data
                        if ($pD['kingdom'] != 0) {
                            $kD = $engine->kingdom->getData($pD['kingdom']);
                            $k[$pD['kingdom']] = [
                                "tag" => $kD['tag']
                            ];
                        }

                        //Prepare field data
                        $pre_r = [
                            'id' => $now_wid,
                            'resType' => $landscape['fieldtype'],
                            'landscape' => $landscape['image'],
                            'owner' => 0,
                            'playerId' => $v['owner'],
                            'village' => [
                                'villageId' => $v['wid'],
                                'name' => $v['vname'],
                                'population' => $v['pop'],
                                'type' => ($v['town'] == 1 ? 2 : 1),
                                'hasActiveTreasury' => $v['area'] != -1 ? false : true,
                            ]
                        ];
                        $pre_r = [0, 0, $pD['kingdom'], 0, $pD['uid']];

                        //Get influence owner
                        $inf = $this->getInf($now_wid, 'owner');

                        //Prepare player data
                        $pre_r = [0, $inf, $pD['kingdom'], 0, $pD['uid']];
                    } else {
                        if ($landscape['fieldtype'] == "0") {
                            if ($landscape['oasistype'] != "0" && $landscape['bonus'] != "0") {
                                $pre_r = [$landscape['image'], 0, 0, 0];
                            } else {
                                $pre_r = [$landscape['image'], 0, 0, 0];
                            }
                        } else {
                            if (isset($landscape['image'])) {
                                $pre_r = [$landscape['image'], 0, 0, 0];
                            } else {
                                $images = ["1055", "1555", "1655", "3055", "3455", "3555", "3655", "1055", "1555", "1655"];
                                $image = $images[($this->xy2id($b[0] + $x, $b[1] - $y) % 10)];
                                $pre_r = [$image, 0, 0, 0];
                            }
                        }

                        //Get influence owner
                        $inf = $this->getInf($now_wid, 'owner');
                        $pre_r[1] = $inf;
                    }

                    //Add field data to region
                    array_push($r[$x], $pre_r);
                }
            }
        }

        //var_dump($inf);

        return [
            'region' => $r,
            'player' => $p,
            'kingdom' => $k,
        ];
    }

    public function getMapDetail($id) {
        global $engine;
        $w = query("SELECT * FROM `{$engine->server->prefix}world` WHERE `id`=?", array($id))->fetch(PDO::FETCH_ASSOC);
        $v = query("SELECT * FROM `{$engine->server->prefix}village` WHERE `wid`=?", array($w['id']))->fetch(PDO::FETCH_ASSOC);
        if ($v) {
            $u = query("SELECT * FROM `{$engine->server->prefix}user` WHERE `uid`=?", array($v['owner']))->fetch(PDO::FETCH_ASSOC);
            return [
                "hasNPC" => 0,
                "hasVillage" => "1",
                "isHabitable" => 0,
                "isOasis" => false,
                "isWonder" => false,
                "oasisType" => "0",
                "landscape" => $w['image'],
                "resType" => $w['fieldtype'],
                "kingdomId" => "0",
                "playerId" => $u['uid'],
                "playerName" => $u['username'],
                "population" => $v['pop'],
                "village" => $v['vname'],
                "tribe" => $u['tribe'],
            ];
        } else {
            if ($w['fieldtype'] == "0") {
                if ($w['oasistype'] != "0" && $w['bonus'] != "0") {

                    $o = $engine->oasis->get($id);
                    $troop = [];
                    if ($o) {
                        if ($o['unit'] != 0) {
                            $troop = $engine->unit->getUnit($o['unit']);
                        }
                    }

                    return array(
                        "hasNPC" => 0,
                        "hasVillage" => 0,
                        "isHabitable" => 0,
                        "isOasis" => true,
                        "oasisType" => $w['oasistype'] . (($w['bonus'] == "50") ? "1" : "0"),
                        "oasisBonus" => array(
                            "1" => ($w['oasistype'] == 1 && ($w['bonus'] == "25" || $w['bonus'] == "50")) ? 25 : 0,
                            "2" => ($w['oasistype'] == 2 && ($w['bonus'] == "25" || $w['bonus'] == "50")) ? 25 : 0,
                            "3" => ($w['oasistype'] == 3 && ($w['bonus'] == "25" || $w['bonus'] == "50")) ? 25 : 0,
                            "4" => ($w['bonus'] == "50") ? (($w['oasistype'] == 4) ? 50 : 25) : (($w['bonus'] == "25" && $w['oasistype'] == 4 ? 25 : 0)),
                        ),
                        "troops" => $troop,
                        "landscape" => $w['image'],
                        "resType" => "0",
                        "kingdomId" => 0,
                        "ownKingdomInfluence" => 0,
                        "defBonus" => 0,
                        "ownRank" => 0,
                        "playersWithTroops" => array(),
                        "oasisStatus" => "1",
                        "ownTroops" => null,
                    );
                } else {
                    return array(
                        "hasNPC" => 0,
                        "hasVillage" => 0,
                        "isHabitable" => 0,
                        "isOasis" => false,
                        "oasisType" => "0",
                        "landscape" => $w['image'],
                        "resType" => $w['fieldtype'],
                    );
                }
            } else {
                if ($id == "536887296") {
                    return [
                        "hasNPC" => 0,
                        "hasVillage" => 0,
                        "isHabitable" => 0,
                        "isOasis" => false,
                        "isWonder" => true,
                        "oasisType" => "0",
                        "landscape" => $w['image'],
                        "resType" => $w['fieldtype'],
                    ];
                } else {
                    return [
                        "hasNPC" => 0,
                        "hasVillage" => 0,
                        "isHabitable" => $w['fieldtype'] == 0 ? 0 : 1,
                        "isOasis" => false,
                        "oasisType" => "0",
                        "landscape" => $w['image'],
                        "resType" => $w['fieldtype'],
                    ];
                }
            }
        }
    }

    public function calInf($wid) {
        global $engine;

        $v = query("SELECT * FROM `{$engine->server->prefix}village` WHERE `wid`=?", [$wid])->fetch(PDO::FETCH_ASSOC);

        $now_wid = $wid;
        $now_x = $this->id2xy($wid)[0];
        $now_y = $this->id2xy($wid)[1];
        $now_village = $v;

        //Get Player data
        $pD = $engine->account->getByVillage($v['wid']);

        //Prepare Kingdom data
        if ($pD['kingdom'] != 0) {
            $kD = $engine->kingdom->getData($pD['kingdom']);
            $k[$pD['kingdom']] = [
                "tag" => $kD['tag']
            ];

            //Prepare influence
            if ($now_village['area'] == -1) {
                $infSize = 4.2;
                if ($now_village['pop'] < 500) {
                    $infSize = 3.2;
                }
                if ($now_village['pop'] < 250) {
                    $infSize = 2.3;
                }
                if ($now_village['pop'] < 100) {
                    $infSize = 1.3;
                }
                $infPoint = $now_village['pop'];
            } else {
                $infSize = 0;
                $infPoint = 0;
            }

            //Calculate influence point & owner
            for ($xi = -$infSize; $xi < $infSize; $xi++) {
                for ($yi = -$infSize; $yi < $infSize; $yi++) {
                    $now_inf_wid = $this->xy2id(round($now_x + $xi), round($now_y + $yi));
                    $have_data = ($this->getInf($now_inf_wid)) ? true : false;
                    $field_in_inf = $this->getInf($now_inf_wid);
                    $owner = 0;
                    $point_inf_max = 0;

                    if ($this->getDistance($now_inf_wid, $now_wid) < $infSize) {
                        if ($now_village['area'] == -1) {
                            //Check for have king array
                            if (!isset($field_in_inf['kingdom'][$kD['king']])) {
                                $field_in_inf['kingdom'][$kD['king']] = [];
                            }
                            //Calculate this village influence point
                            $field_in_inf['kingdom'][$kD['king']][$now_wid] = ($infPoint == 0 || $this->getDistance($now_inf_wid, $now_wid) == 0) ? 0 : $infPoint / $this->getDistance($now_inf_wid, $now_wid);
                            $owner = $kD['king'];
                            $point_inf_max = $field_in_inf['kingdom'][$kD['king']][$now_wid];
                        } else {
                            //Delete village from influence list
                            if (isset($field_in_inf['kingdom'][$kD['king']])) {
                                if (isset($field_in_inf['kingdom'][$kD['king']][$now_wid])) {
                                    unset($field_in_inf['kingdom'][$kD['king']][$now_wid]);
                                }
                            }
                        }

                        //Calculate all village influence point
                        foreach ($field_in_inf['kingdom'] as $king => $villageIds) {
                            $king_inf_point = 0;
                            foreach ($villageIds as $villageId) {
                                $v = query("SELECT * FROM `{$engine->server->prefix}village` WHERE `wid`=?", [$villageId])->fetch(PDO::FETCH_ASSOC);
                                if ($v['area'] == -1) {
                                    $infPoint = $v['pop'];
                                    $field_in_inf['kingdom'][$king][$villageId] = ($infPoint == 0 || $this->getDistance($now_inf_wid, $now_wid) == 0) ? 0 : $infPoint / $this->getDistance($now_inf_wid, $villageId);
                                    $king_inf_point += $field_in_inf['kingdom'][$king][$villageId];
                                } else {
                                    unset($field_in_inf['kingdom'][$king][$villageId]);
                                }
                            }
                            if ($point_inf_max < $king_inf_point) {
                                $owner = $king;
                                $point_inf_max = $king_inf_point;
                            }
                        }
                        if ($have_data) {
                            query("UPDATE `{$engine->server->prefix}influence` SET `owner`=?,`kingdom`=? WHERE `wid`=?;", [$owner, json_encode($field_in_inf['kingdom']), $now_inf_wid]);
                        } else {
                            query("INSERT INTO `{$engine->server->prefix}influence` (`wid`,`owner`,`kingdom`) VALUES (?,?,?);", [$now_inf_wid, $owner, json_encode($field_in_inf['kingdom'])]);
                        }
                        if ($field_in_inf['owner'] != $owner) {
                            $engine->auto->emitEvent([
                                "name" => "invalidateCache",
                                "data" => "MapDetails:{$now_inf_wid}",
                            ]);
                            $engine->auto->emitEvent([
                                "name" => "mapChanged",
                                "data" => $now_inf_wid,
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function getInf($wid, $field = null) {
        global $engine;

        $r = query("SELECT * FROM `{$engine->server->prefix}influence` WHERE `wid`=?;", [$wid])->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $r['kingdom'] = json_decode($r['kingdom'], true);
            if (!$r['kingdom']) {
                $r['kingdom'] = [];
            }
        }
        if ($field === null) {
            return $r;
        } else {
            if (isset($r[$field])) {
                return $r[$field];
            } else {
                if ($field == 'owner') {
                    return 0;
                } elseif ($field == 'kingdom') {
                    return [];
                }
            }
        }
    }

}
