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
    public $ww_radius = 9;
    public $percent_spawn_oasis = 12;

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
                    if ($rand < 10) {
                        $fieldtype = "4437";
                    } elseif ($rand < 90) {
                        $fieldtype = "3447";
                    } elseif ($rand < 400) {
                        $fieldtype = "4446";
                    } elseif ($rand < 480) {
                        $fieldtype = "3456";
                    } elseif ($rand < 560) {
                        $fieldtype = "11115";
                    } elseif ($rand < 570) {
                        $fieldtype = "4356";
                    } elseif ($rand < 600) {
                        $fieldtype = "3339";
                    } elseif ($rand < 630) {
                        $fieldtype = "4347";
                    } elseif ($rand < 670) {
                        $fieldtype = "5346";
                    } elseif ($rand < 740) {
                        $fieldtype = "5436";
                    } elseif ($rand < 820) {
                        $fieldtype = "4536";
                    } else {
                        $fieldstype = "4446";
                    }
                    $image = rand(0, 31);
                    $this->setField($this->xy2id($x, $y), $image, $fieldtype, 0);
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

                $fieldtype = "0";
                $oasistype = "99";
                if ($x == -1 && $y == -3) {
                    $image = "9000";
                } elseif ($x == 0 && $y == -3) {
                    $image = "9010";
                } elseif ($x == 1 && $y == -3) {
                    $image = "9020";
                } elseif ($x == 2 && $y == -3) {
                    $image = "9030";
                } elseif ($x == 3 && $y == -3) {
                    $image = "9040";
                } elseif ($x == -1 && $y == -2) {
                    $image = "9001";
                } elseif ($x == 0 && $y == -2) {
                    $image = "9011";
                } elseif ($x == 1 && $y == -2) {
                    $image = "9021";
                } elseif ($x == 2 && $y == -2) {
                    $image = "9031";
                } elseif ($x == 3 && $y == -2) {
                    $image = "9041";
                } elseif ($x == -1 && $y == -1) {
                    $image = "9002";
                } elseif ($x == 0 && $y == -1) {
                    $image = "9012";
                } elseif ($x == 1 && $y == -1) {
                    $image = "9022";
                } elseif ($x == 2 && $y == -1) {
                    $image = "9032";
                } elseif ($x == 3 && $y == -1) {
                    $image = "9042";
                } elseif ($x == -1 && $y == 0) {
                    $image = "9003";
                } elseif ($x == 0 && $y == 0) {
                    $image = "9013";
                } elseif ($x == 1 && $y == 0) {
                    $image = "9023";
                } elseif ($x == 2 && $y == 0) {
                    $image = "9033";
                } elseif ($x == 3 && $y == 0) {
                    $image = "9043";
                } elseif ($x == -1 && $y == 1) {
                    $image = "9004";
                } elseif ($x == 0 && $y == 1) {
                    $image = "9014";
                } elseif ($x == 1 && $y == 1) {
                    $image = "9024";
                } elseif ($x == 2 && $y == 1) {
                    $image = "9034";
                } elseif ($x == 3 && $y == 1) {
                    $image = "9044";
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
        foreach ($engine->server->ww_position as $ww) {
            $x = $ww[0];
            $y = $ww[1];
            for ($x1 = -$this->ww_radius; $x1 <= $this->ww_radius; $x1++)
                for ($y1 = -$this->ww_radius; $y1 <= $this->ww_radius; $y1++)
                    if ($this->getDistance([$x + $x1, $y + $y1], [0, 0]) <= $this->ww_radius)
                        $r[] = $this->xy2id($x + $x1, $y + $y1);
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

            if (!in_array($id, $wwr)) {
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

}
