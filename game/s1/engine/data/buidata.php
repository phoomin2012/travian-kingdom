<?php

class BuildingData {

    public static function get($type, $level = null) {
        $name = "bid" . $type;
        if ($level === null) {
            if (isset(self::$$name)) {
                return self::$$name;
            } else {
                return false;
            }
        } else {
            if (isset(self::$$name)) {
                $d = self::$$name;
                if (isset($d[$level])) {
                    return $d[$level];
                } else {
                    return array(
                        'wood' => 0,
                        'clay' => 0,
                        'iron' => 0,
                        'crop' => 0,
                        'pop' => 0,
                        'cp' => 0,
                        'effect' => 0,
                        'time' => 0
                    );
                }
            } else {
                return false;
            }
        }
    }

    public static $bid1 = array(
        array(
            'wood' => 0,
            'clay' => 0,
            'iron' => 0,
            'crop' => 0,
            'pop' => 0,
            'cp' => 0,
            'effect' => 2,
            'time' => 0
        ),
        array(
            'wood' => 40,
            'clay' => 100,
            'iron' => 50,
            'crop' => 60,
            'pop' => 2,
            'cp' => 1,
            'effect' => 5,
            'time' => 260
        ),
        array(
            'wood' => 65,
            'clay' => 165,
            'iron' => 85,
            'crop' => 100,
            'pop' => 1,
            'cp' => 1,
            'effect' => 9,
            'time' => 615
        ),
        array(
            'wood' => 110,
            'clay' => 280,
            'iron' => 140,
            'crop' => 165,
            'pop' => 1,
            'cp' => 2,
            'effect' => 15,
            'time' => 1185
        ),
        array(
            'wood' => 185,
            'clay' => 465,
            'iron' => 235,
            'crop' => 280,
            'pop' => 1,
            'cp' => 2,
            'effect' => 22,
            'time' => 2097
        ),
        array(
            'wood' => 310,
            'clay' => 780,
            'iron' => 390,
            'crop' => 465,
            'pop' => 1,
            'cp' => 2,
            'effect' => 33,
            'time' => 3555
        ),
        array(
            'wood' => 520,
            'clay' => 1300,
            'iron' => 650,
            'crop' => 780,
            'pop' => 2,
            'cp' => 3,
            'effect' => 50,
            'time' => 5889
        ),
        array(
            'wood' => 870,
            'clay' => 2170,
            'iron' => 1085,
            'crop' => 1300,
            'pop' => 2,
            'cp' => 4,
            'effect' => 70,
            'time' => 9621
        ),
        array(
            'wood' => 1450,
            'clay' => 3625,
            'iron' => 1810,
            'crop' => 2175,
            'pop' => 2,
            'cp' => 4,
            'effect' => 100,
            'time' => 15594
        ),
        array(
            'wood' => 2420,
            'clay' => 6050,
            'iron' => 3025,
            'crop' => 3630,
            'pop' => 2,
            'cp' => 5,
            'effect' => 145,
            'time' => 25150
        ),
        array(
            'wood' => 4040,
            'clay' => 10105,
            'iron' => 5050,
            'crop' => 6060,
            'pop' => 2,
            'cp' => 6,
            'effect' => 200,
            'time' => 40440
        ),
        array(
            'wood' => 6750,
            'clay' => 16870,
            'iron' => 8435,
            'crop' => 10125,
            'pop' => 2,
            'cp' => 7,
            'effect' => 280,
            'time' => 64905
        ),
        array(
            'wood' => 11270,
            'clay' => 28175,
            'iron' => 14090,
            'crop' => 16905,
            'pop' => 2,
            'cp' => 9,
            'effect' => 375,
            'time' => 104046
        ),
        array(
            'wood' => 18820,
            'clay' => 47055,
            'iron' => 23525,
            'crop' => 28230,
            'pop' => 2,
            'cp' => 11,
            'effect' => 495,
            'time' => 166674
        ),
        array(
            'wood' => 31430,
            'clay' => 78580,
            'iron' => 39290,
            'crop' => 47150,
            'pop' => 2,
            'cp' => 13,
            'effect' => 635,
            'time' => 266880
        ),
        array(
            'wood' => 52490,
            'clay' => 131230,
            'iron' => 65615,
            'crop' => 78740,
            'pop' => 2,
            'cp' => 15,
            'effect' => 800,
            'time' => 427210
        ),
        array(
            'wood' => 87660,
            'clay' => 219155,
            'iron' => 109575,
            'crop' => 131490,
            'pop' => 3,
            'cp' => 18,
            'effect' => 1000,
            'time' => 683732
        ),
        array(
            'wood' => 146395,
            'clay' => 365985,
            'iron' => 182995,
            'crop' => 219590,
            'pop' => 3,
            'cp' => 22,
            'effect' => 1300,
            'time' => 1094173
        ),
        array(
            'wood' => 244480,
            'clay' => 611195,
            'iron' => 305600,
            'crop' => 366715,
            'pop' => 3,
            'cp' => 27,
            'effect' => 1600,
            'time' => 1750877
        ),
        array(
            'wood' => 408280,
            'clay' => 1020695,
            'iron' => 510350,
            'crop' => 612420,
            'pop' => 3,
            'cp' => 32,
            'effect' => 2000,
            'time' => 2801603
        ),
        array(
            'wood' => 681825,
            'clay' => 1704565,
            'iron' => 852280,
            'crop' => 1022740,
            'pop' => 3,
            'cp' => 38,
            'effect' => 2450,
            'time' => 4482767
        )
    );
    public static $bid2 = array(
        array(
            'wood' => 0,
            'clay' => 0,
            'iron' => 0,
            'crop' => 0,
            'pop' => 0,
            'cp' => 0,
            'effect' => 2,
            'time' => 0
        ),
        array(
            'wood' => 80,
            'clay' => 40,
            'iron' => 80,
            'crop' => 50,
            'pop' => 2,
            'cp' => 1,
            'effect' => 5,
            'time' => 220
        ),
        array(
            'wood' => 135,
            'clay' => 65,
            'iron' => 135,
            'crop' => 85,
            'pop' => 1,
            'cp' => 1,
            'effect' => 9,
            'time' => 550
        ),
        array(
            'wood' => 225,
            'clay' => 110,
            'iron' => 225,
            'crop' => 140,
            'pop' => 1,
            'cp' => 2,
            'effect' => 15,
            'time' => 1080
        ),
        array(
            'wood' => 375,
            'clay' => 185,
            'iron' => 375,
            'crop' => 235,
            'pop' => 1,
            'cp' => 2,
            'effect' => 22,
            'time' => 1930
        ),
        array(
            'wood' => 620,
            'clay' => 310,
            'iron' => 620,
            'crop' => 390,
            'pop' => 1,
            'cp' => 2,
            'effect' => 33,
            'time' => 3290
        ),
        array(
            'wood' => 1040,
            'clay' => 520,
            'iron' => 1040,
            'crop' => 650,
            'pop' => 2,
            'cp' => 3,
            'effect' => 50,
            'time' => 5470
        ),
        array(
            'wood' => 1735,
            'clay' => 870,
            'iron' => 1735,
            'crop' => 1085,
            'pop' => 2,
            'cp' => 4,
            'effect' => 70,
            'time' => 8950
        ),
        array(
            'wood' => 2900,
            'clay' => 1450,
            'iron' => 2900,
            'crop' => 1810,
            'pop' => 2,
            'cp' => 4,
            'effect' => 100,
            'time' => 14520
        ),
        array(
            'wood' => 4840,
            'clay' => 2420,
            'iron' => 4840,
            'crop' => 3025,
            'pop' => 2,
            'cp' => 5,
            'effect' => 145,
            'time' => 23430
        ),
        array(
            'wood' => 8080,
            'clay' => 4040,
            'iron' => 8080,
            'crop' => 5050,
            'pop' => 2,
            'cp' => 6,
            'effect' => 200,
            'time' => 37690
        ),
        array(
            'wood' => 13500,
            'clay' => 6750,
            'iron' => 13500,
            'crop' => 8435,
            'pop' => 2,
            'cp' => 7,
            'effect' => 280,
            'time' => 60510
        ),
        array(
            'wood' => 22540,
            'clay' => 11270,
            'iron' => 22540,
            'crop' => 14090,
            'pop' => 2,
            'cp' => 9,
            'effect' => 375,
            'time' => 97010
        ),
        array(
            'wood' => 37645,
            'clay' => 18820,
            'iron' => 37645,
            'crop' => 23525,
            'pop' => 2,
            'cp' => 11,
            'effect' => 495,
            'time' => 155420
        ),
        array(
            'wood' => 62865,
            'clay' => 31430,
            'iron' => 62865,
            'crop' => 39290,
            'pop' => 2,
            'cp' => 13,
            'effect' => 635,
            'time' => 248870
        ),
        array(
            'wood' => 104985,
            'clay' => 52490,
            'iron' => 104985,
            'crop' => 65615,
            'pop' => 2,
            'cp' => 15,
            'effect' => 800,
            'time' => 398390
        ),
        array(
            'wood' => 175320,
            'clay' => 87660,
            'iron' => 175320,
            'crop' => 109575,
            'pop' => 3,
            'cp' => 18,
            'effect' => 1000,
            'time' => 637620
        ),
        array(
            'wood' => 292790,
            'clay' => 146395,
            'iron' => 292790,
            'crop' => 182995,
            'pop' => 3,
            'cp' => 22,
            'effect' => 1300,
            'time' => 1020390
        ),
        array(
            'wood' => 488955,
            'clay' => 244480,
            'iron' => 488955,
            'crop' => 305600,
            'pop' => 3,
            'cp' => 27,
            'effect' => 1600,
            'time' => 1632820
        ),
        array(
            'wood' => 816555,
            'clay' => 408280,
            'iron' => 816555,
            'crop' => 510350,
            'pop' => 3,
            'cp' => 32,
            'effect' => 2000,
            'time' => 2612710
        ),
        array(
            'wood' => 1363650,
            'clay' => 681825,
            'iron' => 1363650,
            'crop' => 852280,
            'pop' => 3,
            'cp' => 38,
            'effect' => 2450,
            'time' => 4180540
        )
    );
    public static $bid3 = array(
        array(
            'wood' => 0,
            'clay' => 0,
            'iron' => 0,
            'crop' => 0,
            'pop' => 0,
            'cp' => 0,
            'effect' => 2,
            'time' => 0
        ),
        array(
            'wood' => 100,
            'clay' => 80,
            'iron' => 30,
            'crop' => 60,
            'pop' => 3,
            'cp' => 1,
            'effect' => 5,
            'time' => 450
        ),
        array(
            'wood' => 165,
            'clay' => 135,
            'iron' => 50,
            'crop' => 100,
            'pop' => 2,
            'cp' => 1,
            'effect' => 9,
            'time' => 920
        ),
        array(
            'wood' => 280,
            'clay' => 225,
            'iron' => 85,
            'crop' => 165,
            'pop' => 2,
            'cp' => 2,
            'effect' => 15,
            'time' => 1670
        ),
        array(
            'wood' => 465,
            'clay' => 375,
            'iron' => 140,
            'crop' => 280,
            'pop' => 2,
            'cp' => 2,
            'effect' => 22,
            'time' => 2880
        ),
        array(
            'wood' => 780,
            'clay' => 620,
            'iron' => 235,
            'crop' => 465,
            'pop' => 2,
            'cp' => 2,
            'effect' => 33,
            'time' => 4800
        ),
        array(
            'wood' => 1300,
            'clay' => 1040,
            'iron' => 390,
            'crop' => 780,
            'pop' => 2,
            'cp' => 3,
            'effect' => 50,
            'time' => 7880
        ),
        array(
            'wood' => 2170,
            'clay' => 1735,
            'iron' => 650,
            'crop' => 1300,
            'pop' => 2,
            'cp' => 4,
            'effect' => 70,
            'time' => 12810
        ),
        array(
            'wood' => 3625,
            'clay' => 2900,
            'iron' => 1085,
            'crop' => 2175,
            'pop' => 2,
            'cp' => 4,
            'effect' => 100,
            'time' => 20690
        ),
        array(
            'wood' => 6050,
            'clay' => 4840,
            'iron' => 1815,
            'crop' => 3630,
            'pop' => 2,
            'cp' => 5,
            'effect' => 145,
            'time' => 33310
        ),
        array(
            'wood' => 10105,
            'clay' => 8080,
            'iron' => 3030,
            'crop' => 6060,
            'pop' => 2,
            'cp' => 6,
            'effect' => 200,
            'time' => 53500
        ),
        array(
            'wood' => 16870,
            'clay' => 13500,
            'iron' => 5060,
            'crop' => 10125,
            'pop' => 3,
            'cp' => 7,
            'effect' => 280,
            'time' => 85800
        ),
        array(
            'wood' => 28175,
            'clay' => 22540,
            'iron' => 8455,
            'crop' => 16905,
            'pop' => 3,
            'cp' => 9,
            'effect' => 375,
            'time' => 137470
        ),
        array(
            'wood' => 47055,
            'clay' => 37645,
            'iron' => 14115,
            'crop' => 28230,
            'pop' => 3,
            'cp' => 11,
            'effect' => 495,
            'time' => 220160
        ),
        array(
            'wood' => 78580,
            'clay' => 62865,
            'iron' => 23575,
            'crop' => 47150,
            'pop' => 3,
            'cp' => 13,
            'effect' => 635,
            'time' => 352450
        ),
        array(
            'wood' => 131230,
            'clay' => 104985,
            'iron' => 39370,
            'crop' => 78740,
            'pop' => 3,
            'cp' => 15,
            'effect' => 800,
            'time' => 564120
        ),
        array(
            'wood' => 219155,
            'clay' => 175320,
            'iron' => 65745,
            'crop' => 131490,
            'pop' => 3,
            'cp' => 18,
            'effect' => 1000,
            'time' => 902760
        ),
        array(
            'wood' => 365985,
            'clay' => 292790,
            'iron' => 109795,
            'crop' => 219590,
            'pop' => 3,
            'cp' => 22,
            'effect' => 1300,
            'time' => 145546
        ),
        array(
            'wood' => 611195,
            'clay' => 488955,
            'iron' => 183360,
            'crop' => 366715,
            'pop' => 3,
            'cp' => 27,
            'effect' => 1600,
            'time' => 2311660
        ),
        array(
            'wood' => 1020695,
            'clay' => 816555,
            'iron' => 306210,
            'crop' => 612420,
            'pop' => 3,
            'cp' => 32,
            'effect' => 2000,
            'time' => 3698850
        ),
        array(
            'wood' => 1704565,
            'clay' => 1363650,
            'iron' => 511370,
            'crop' => 1022740,
            'pop' => 3,
            'cp' => 38,
            'effect' => 2450,
            'time' => 5918370
        )
    );
    public static $bid4 = array(
        array(
            'wood' => 0,
            'clay' => 0,
            'iron' => 0,
            'crop' => 0,
            'pop' => 0,
            'cp' => 0,
            'effect' => 2,
            'time' => 0
        ),
        array(
            'wood' => 70,
            'clay' => 90,
            'iron' => 70,
            'crop' => 20,
            'pop' => 0,
            'cp' => 1,
            'effect' => 5,
            'time' => 150
        ),
        array(
            'wood' => 115,
            'clay' => 150,
            'iron' => 115,
            'crop' => 35,
            'pop' => 0,
            'cp' => 1,
            'effect' => 9,
            'time' => 440
        ),
        array(
            'wood' => 195,
            'clay' => 250,
            'iron' => 195,
            'crop' => 55,
            'pop' => 0,
            'cp' => 2,
            'effect' => 15,
            'time' => 900
        ),
        array(
            'wood' => 325,
            'clay' => 420,
            'iron' => 325,
            'crop' => 95,
            'pop' => 0,
            'cp' => 2,
            'effect' => 22,
            'time' => 1650
        ),
        array(
            'wood' => 545,
            'clay' => 700,
            'iron' => 545,
            'crop' => 155,
            'pop' => 0,
            'cp' => 2,
            'effect' => 33,
            'time' => 2830
        ),
        array(
            'wood' => 910,
            'clay' => 1170,
            'iron' => 910,
            'crop' => 260,
            'pop' => 1,
            'cp' => 3,
            'effect' => 50,
            'time' => 4730
        ),
        array(
            'wood' => 1520,
            'clay' => 1950,
            'iron' => 1520,
            'crop' => 435,
            'pop' => 1,
            'cp' => 4,
            'effect' => 70,
            'time' => 7780
        ),
        array(
            'wood' => 2535,
            'clay' => 3260,
            'iron' => 2535,
            'crop' => 725,
            'pop' => 1,
            'cp' => 4,
            'effect' => 100,
            'time' => 12190
        ),
        array(
            'wood' => 4235,
            'clay' => 5445,
            'iron' => 4235,
            'crop' => 1210,
            'pop' => 1,
            'cp' => 5,
            'effect' => 145,
            'time' => 19690
        ),
        array(
            'wood' => 7070,
            'clay' => 9095,
            'iron' => 7070,
            'crop' => 2020,
            'pop' => 1,
            'cp' => 6,
            'effect' => 200,
            'time' => 31700
        ),
        array(
            'wood' => 11810,
            'clay' => 15185,
            'iron' => 11810,
            'crop' => 3375,
            'pop' => 1,
            'cp' => 7,
            'effect' => 280,
            'time' => 50910
        ),
        array(
            'wood' => 19725,
            'clay' => 25360,
            'iron' => 19725,
            'crop' => 5635,
            'pop' => 1,
            'cp' => 9,
            'effect' => 375,
            'time' => 84700
        ),
        array(
            'wood' => 32940,
            'clay' => 42350,
            'iron' => 32940,
            'crop' => 9410,
            'pop' => 1,
            'cp' => 11,
            'effect' => 495,
            'time' => 135710
        ),
        array(
            'wood' => 55005,
            'clay' => 70720,
            'iron' => 55005,
            'crop' => 15715,
            'pop' => 1,
            'cp' => 13,
            'effect' => 635,
            'time' => 217340
        ),
        array(
            'wood' => 91860,
            'clay' => 118105,
            'iron' => 91860,
            'crop' => 26245,
            'pop' => 1,
            'cp' => 15,
            'effect' => 800,
            'time' => 347950
        ),
        array(
            'wood' => 153405,
            'clay' => 197240,
            'iron' => 153405,
            'crop' => 43830,
            'pop' => 2,
            'cp' => 18,
            'effect' => 1000,
            'time' => 556910
        ),
        array(
            'wood' => 256190,
            'clay' => 329385,
            'iron' => 256190,
            'crop' => 73195,
            'pop' => 2,
            'cp' => 22,
            'effect' => 1300,
            'time' => 891260
        ),
        array(
            'wood' => 427835,
            'clay' => 550075,
            'iron' => 427835,
            'crop' => 122240,
            'pop' => 2,
            'cp' => 27,
            'effect' => 1600,
            'time' => 1426210
        ),
        array(
            'wood' => 714485,
            'clay' => 918625,
            'iron' => 714485,
            'crop' => 204140,
            'pop' => 2,
            'cp' => 32,
            'effect' => 2000,
            'time' => 2282140
        ),
        array(
            'wood' => 1193195,
            'clay' => 1534105,
            'iron' => 1193195,
            'crop' => 340915,
            'pop' => 2,
            'cp' => 38,
            'effect' => 2450,
            'time' => 3651630
        )
    );
    public static $bid5 = array(
        array(
            'wood' => 52,
            'clay' => 38,
            'iron' => 29,
            'crop' => 9,
            'pop' => 4,
            'cp' => 0,
            'effect' => 0,
            'time' => 60
        ),
        array(
            'wood' => 520,
            'clay' => 380,
            'iron' => 290,
            'crop' => 90,
            'pop' => 4,
            'cp' => 1,
            'effect' => 5,
            'time' => 3000
        ),
        array(
            'wood' => 935,
            'clay' => 685,
            'iron' => 520,
            'crop' => 160,
            'pop' => 2,
            'cp' => 1,
            'effect' => 10,
            'time' => 5700
        ),
        array(
            'wood' => 1685,
            'clay' => 1230,
            'iron' => 940,
            'crop' => 290,
            'pop' => 2,
            'cp' => 2,
            'effect' => 15,
            'time' => 9750
        ),
        array(
            'wood' => 3035,
            'clay' => 2215,
            'iron' => 1690,
            'crop' => 525,
            'pop' => 2,
            'cp' => 2,
            'effect' => 20,
            'time' => 15825
        ),
        array(
            'wood' => 5460,
            'clay' => 3990,
            'iron' => 3045,
            'crop' => 945,
            'pop' => 2,
            'cp' => 2,
            'effect' => 25,
            'time' => 24939
        )
    );
    public static $bid6 = array(
        array(
            'wood' => 44,
            'clay' => 48,
            'iron' => 32,
            'crop' => 50,
            'pop' => 3,
            'cp' => 0,
            'effect' => 0,
            'time' => 57
        ),
        array(
            'wood' => 440,
            'clay' => 480,
            'iron' => 320,
            'crop' => 50,
            'pop' => 3,
            'cp' => 1,
            'effect' => 5,
            'time' => 2841
        ),
        array(
            'wood' => 790,
            'clay' => 865,
            'iron' => 575,
            'crop' => 90,
            'pop' => 2,
            'cp' => 1,
            'effect' => 10,
            'time' => 5460
        ),
        array(
            'wood' => 1425,
            'clay' => 1555,
            'iron' => 1035,
            'crop' => 160,
            'pop' => 2,
            'cp' => 2,
            'effect' => 15,
            'time' => 9390
        ),
        array(
            'wood' => 2565,
            'clay' => 2800,
            'iron' => 1865,
            'crop' => 290,
            'pop' => 2,
            'cp' => 2,
            'effect' => 20,
            'time' => 15285
        ),
        array(
            'wood' => 4620,
            'clay' => 5040,
            'iron' => 3360,
            'crop' => 525,
            'pop' => 2,
            'cp' => 2,
            'effect' => 25,
            'time' => 24129
        )
    );
    public static $bid7 = array(
        array(
            'wood' => 20,
            'clay' => 45,
            'iron' => 51,
            'crop' => 12,
            'pop' => 6,
            'cp' => 1,
            'effect' => 0,
            'time' => 40
        ),
        array(
            'wood' => 200,
            'clay' => 450,
            'iron' => 510,
            'crop' => 120,
            'pop' => 6,
            'cp' => 1,
            'effect' => 5,
            'time' => 4080
        ),
        array(
            'wood' => 360,
            'clay' => 810,
            'iron' => 920,
            'crop' => 215,
            'pop' => 3,
            'cp' => 1,
            'effect' => 10,
            'time' => 7320
        ),
        array(
            'wood' => 650,
            'clay' => 1460,
            'iron' => 1650,
            'crop' => 390,
            'pop' => 3,
            'cp' => 2,
            'effect' => 15,
            'time' => 12180
        ),
        array(
            'wood' => 1165,
            'clay' => 2625,
            'iron' => 2975,
            'crop' => 700,
            'pop' => 3,
            'cp' => 2,
            'effect' => 20,
            'time' => 19470
        ),
        array(
            'wood' => 2100,
            'clay' => 4725,
            'iron' => 5355,
            'crop' => 1260,
            'pop' => 3,
            'cp' => 2,
            'effect' => 25,
            'time' => 30405
        )
    );
    public static $bid8 = array(
        array(
            'wood' => 50,
            'clay' => 44,
            'iron' => 38,
            'crop' => 124,
            'pop' => 3,
            'cp' => 1,
            'effect' => 0,
            'time' => 19
        ),
        array(
            'wood' => 500,
            'clay' => 440,
            'iron' => 380,
            'crop' => 1240,
            'pop' => 3,
            'cp' => 1,
            'effect' => 5,
            'time' => 1839
        ),
        array(
            'wood' => 900,
            'clay' => 790,
            'iron' => 685,
            'crop' => 2230,
            'pop' => 2,
            'cp' => 1,
            'effect' => 10,
            'time' => 3960
        ),
        array(
            'wood' => 1620,
            'clay' => 1425,
            'iron' => 1230,
            'crop' => 4020,
            'pop' => 2,
            'cp' => 2,
            'effect' => 15,
            'time' => 7140
        ),
        array(
            'wood' => 2915,
            'clay' => 2565,
            'iron' => 2215,
            'crop' => 7230,
            'pop' => 2,
            'cp' => 2,
            'effect' => 20,
            'time' => 11910
        ),
        array(
            'wood' => 5250,
            'clay' => 4620,
            'iron' => 3990,
            'crop' => 13015,
            'pop' => 2,
            'cp' => 2,
            'effect' => 25,
            'time' => 19065
        )
    );
    public static $bid9 = array(
        array(
            'wood' => 120,
            'clay' => 148,
            'iron' => 87,
            'crop' => 160,
            'pop' => 4,
            'cp' => 1,
            'effect' => 0,
            'time' => 37
        ),
        array(
            'wood' => 1200,
            'clay' => 1480,
            'iron' => 870,
            'crop' => 1600,
            'pop' => 4,
            'cp' => 1,
            'effect' => 5,
            'time' => 3681
        ),
        array(
            'wood' => 2160,
            'clay' => 2665,
            'iron' => 1565,
            'crop' => 2880,
            'pop' => 2,
            'cp' => 1,
            'effect' => 10,
            'time' => 6720
        ),
        array(
            'wood' => 3890,
            'clay' => 4795,
            'iron' => 2820,
            'crop' => 5185,
            'pop' => 2,
            'cp' => 2,
            'effect' => 15,
            'time' => 11280
        ),
        array(
            'wood' => 7000,
            'clay' => 8630,
            'iron' => 5075,
            'crop' => 9330,
            'pop' => 2,
            'cp' => 2,
            'effect' => 20,
            'time' => 18120
        ),
        array(
            'wood' => 12595,
            'clay' => 15535,
            'iron' => 9135,
            'crop' => 16795,
            'pop' => 2,
            'cp' => 2,
            'effect' => 25,
            'time' => 28380
        )
    );
    public static $bid10 = array(
        array(
            'wood' => 13,
            'clay' => 16,
            'iron' => 9,
            'crop' => 4,
            'pop' => 1,
            'cp' => 1,
            'effect' => 800,
            'time' => 20
        ),
        array(
            'wood' => 130,
            'clay' => 160,
            'iron' => 90,
            'crop' => 40,
            'pop' => 1,
            'cp' => 1,
            'effect' => 1200,
            'time' => 2001
        ),
        array(
            'wood' => 165,
            'clay' => 205,
            'iron' => 115,
            'crop' => 50,
            'pop' => 1,
            'cp' => 1,
            'effect' => 1700,
            'time' => 2619
        ),
        array(
            'wood' => 215,
            'clay' => 260,
            'iron' => 145,
            'crop' => 65,
            'pop' => 1,
            'cp' => 2,
            'effect' => 2300,
            'time' => 3339
        ),
        array(
            'wood' => 275,
            'clay' => 335,
            'iron' => 190,
            'crop' => 85,
            'pop' => 1,
            'cp' => 2,
            'effect' => 3100,
            'time' => 4170
        ),
        array(
            'wood' => 350,
            'clay' => 430,
            'iron' => 240,
            'crop' => 105,
            'pop' => 1,
            'cp' => 2,
            'effect' => 4000,
            'time' => 5140
        ),
        array(
            'wood' => 445,
            'clay' => 550,
            'iron' => 310,
            'crop' => 135,
            'pop' => 1,
            'cp' => 3,
            'effect' => 5000,
            'time' => 6260
        ),
        array(
            'wood' => 570,
            'clay' => 705,
            'iron' => 395,
            'crop' => 175,
            'pop' => 1,
            'cp' => 4,
            'effect' => 6300,
            'time' => 7570
        ),
        array(
            'wood' => 730,
            'clay' => 900,
            'iron' => 505,
            'crop' => 225,
            'pop' => 1,
            'cp' => 4,
            'effect' => 7700,
            'time' => 9080
        ),
        array(
            'wood' => 935,
            'clay' => 1115,
            'iron' => 650,
            'crop' => 290,
            'pop' => 1,
            'cp' => 5,
            'effect' => 9600,
            'time' => 10830
        ),
        array(
            'wood' => 1200,
            'clay' => 1475,
            'iron' => 830,
            'crop' => 370,
            'pop' => 1,
            'cp' => 6,
            'effect' => 12000,
            'time' => 12860
        ),
        array(
            'wood' => 1535,
            'clay' => 1890,
            'iron' => 1065,
            'crop' => 470,
            'pop' => 2,
            'cp' => 7,
            'effect' => 14400,
            'time' => 15220
        ),
        array(
            'wood' => 1965,
            'clay' => 2420,
            'iron' => 1360,
            'crop' => 605,
            'pop' => 2,
            'cp' => 9,
            'effect' => 18000,
            'time' => 17950
        ),
        array(
            'wood' => 2515,
            'clay' => 3095,
            'iron' => 1740,
            'crop' => 775,
            'pop' => 2,
            'cp' => 11,
            'effect' => 22000,
            'time' => 21130
        ),
        array(
            'wood' => 3220,
            'clay' => 3960,
            'iron' => 2230,
            'crop' => 990,
            'pop' => 2,
            'cp' => 13,
            'effect' => 26000,
            'time' => 24810
        ),
        array(
            'wood' => 4120,
            'clay' => 5070,
            'iron' => 2850,
            'crop' => 1270,
            'pop' => 2,
            'cp' => 15,
            'effect' => 32000,
            'time' => 29080
        ),
        array(
            'wood' => 5275,
            'clay' => 6490,
            'iron' => 3650,
            'crop' => 1625,
            'pop' => 2,
            'cp' => 18,
            'effect' => 38000,
            'time' => 34030
        ),
        array(
            'wood' => 6750,
            'clay' => 8310,
            'iron' => 4675,
            'crop' => 2075,
            'pop' => 2,
            'cp' => 22,
            'effect' => 45000,
            'time' => 39770
        ),
        array(
            'wood' => 8640,
            'clay' => 10635,
            'iron' => 5980,
            'crop' => 2660,
            'pop' => 2,
            'cp' => 27,
            'effect' => 55000,
            'time' => 46440
        ),
        array(
            'wood' => 11060,
            'clay' => 13610,
            'iron' => 7655,
            'crop' => 3405,
            'pop' => 2,
            'cp' => 32,
            'effect' => 66000,
            'time' => 54170
        ),
        array(
            'wood' => 14155,
            'clay' => 17420,
            'iron' => 9800,
            'crop' => 4355,
            'pop' => 2,
            'cp' => 38,
            'effect' => 80000,
            'time' => 63130
        )
    );
    public static $bid11 = array(
        array(
            'wood' => 8,
            'clay' => 10,
            'iron' => 7,
            'crop' => 2,
            'pop' => 1,
            'cp' => 1,
            'effect' => 1200,
            'time' => 16
        ),
        array(
            'wood' => 80,
            'clay' => 100,
            'iron' => 70,
            'crop' => 20,
            'pop' => 1,
            'cp' => 1,
            'effect' => 1200,
            'time' => 1600
        ),
        array(
            'wood' => 100,
            'clay' => 130,
            'iron' => 90,
            'crop' => 25,
            'pop' => 1,
            'cp' => 1,
            'effect' => 1700,
            'time' => 2160
        ),
        array(
            'wood' => 130,
            'clay' => 165,
            'iron' => 115,
            'crop' => 35,
            'pop' => 1,
            'cp' => 2,
            'effect' => 2300,
            'time' => 2800
        ),
        array(
            'wood' => 170,
            'clay' => 210,
            'iron' => 145,
            'crop' => 40,
            'pop' => 1,
            'cp' => 2,
            'effect' => 3100,
            'time' => 3550
        ),
        array(
            'wood' => 215,
            'clay' => 270,
            'iron' => 190,
            'crop' => 55,
            'pop' => 1,
            'cp' => 2,
            'effect' => 4000,
            'time' => 4420
        ),
        array(
            'wood' => 275,
            'clay' => 345,
            'iron' => 240,
            'crop' => 70,
            'pop' => 1,
            'cp' => 3,
            'effect' => 5000,
            'time' => 5420
        ),
        array(
            'wood' => 350,
            'clay' => 440,
            'iron' => 310,
            'crop' => 90,
            'pop' => 1,
            'cp' => 4,
            'effect' => 6300,
            'time' => 6590
        ),
        array(
            'wood' => 450,
            'clay' => 565,
            'iron' => 395,
            'crop' => 115,
            'pop' => 1,
            'cp' => 4,
            'effect' => 7700,
            'time' => 7950
        ),
        array(
            'wood' => 575,
            'clay' => 720,
            'iron' => 505,
            'crop' => 145,
            'pop' => 1,
            'cp' => 5,
            'effect' => 9600,
            'time' => 9520
        ),
        array(
            'wood' => 740,
            'clay' => 920,
            'iron' => 645,
            'crop' => 185,
            'pop' => 1,
            'cp' => 6,
            'effect' => 12000,
            'time' => 11340
        ),
        array(
            'wood' => 945,
            'clay' => 1180,
            'iron' => 825,
            'crop' => 235,
            'pop' => 2,
            'cp' => 7,
            'effect' => 14400,
            'time' => 13450
        ),
        array(
            'wood' => 1210,
            'clay' => 1510,
            'iron' => 1060,
            'crop' => 300,
            'pop' => 2,
            'cp' => 9,
            'effect' => 18000,
            'time' => 15910
        ),
        array(
            'wood' => 1545,
            'clay' => 1935,
            'iron' => 1355,
            'crop' => 385,
            'pop' => 2,
            'cp' => 11,
            'effect' => 22000,
            'time' => 18750
        ),
        array(
            'wood' => 1980,
            'clay' => 2475,
            'iron' => 1735,
            'crop' => 495,
            'pop' => 2,
            'cp' => 13,
            'effect' => 26000,
            'time' => 22050
        ),
        array(
            'wood' => 2535,
            'clay' => 3170,
            'iron' => 2220,
            'crop' => 635,
            'pop' => 2,
            'cp' => 15,
            'effect' => 32000,
            'time' => 25880
        ),
        array(
            'wood' => 3245,
            'clay' => 4055,
            'iron' => 2840,
            'crop' => 810,
            'pop' => 2,
            'cp' => 18,
            'effect' => 38000,
            'time' => 30320
        ),
        array(
            'wood' => 4155,
            'clay' => 5190,
            'iron' => 3635,
            'crop' => 1040,
            'pop' => 2,
            'cp' => 22,
            'effect' => 45000,
            'time' => 35470
        ),
        array(
            'wood' => 5315,
            'clay' => 6645,
            'iron' => 4650,
            'crop' => 1330,
            'pop' => 2,
            'cp' => 27,
            'effect' => 55000,
            'time' => 41450
        ),
        array(
            'wood' => 6805,
            'clay' => 8505,
            'iron' => 5955,
            'crop' => 1700,
            'pop' => 2,
            'cp' => 32,
            'effect' => 66000,
            'time' => 48380
        ),
        array(
            'wood' => 8710,
            'clay' => 10890,
            'iron' => 7620,
            'crop' => 2180,
            'pop' => 2,
            'cp' => 38,
            'effect' => 80000,
            'time' => 56420
        )
    );
    public static $bid13 = array(
        array(
            'wood' => 18,
            'clay' => 25,
            'iron' => 50,
            'crop' => 13,
            'pop' => 4,
            'cp' => 2,
            'effect' => 100,
            'time' => 20
        ),
        array(
            'wood' => 180,
            'clay' => 250,
            'iron' => 500,
            'crop' => 130,
            'pop' => 4,
            'cp' => 2,
            'effect' => 100,
            'time' => 2001
        ),
        array(
            'wood' => 230,
            'clay' => 320,
            'iron' => 640,
            'crop' => 205,
            'pop' => 2,
            'cp' => 3,
            'effect' => 96.4,
            'time' => 2619
        ),
        array(
            'wood' => 295,
            'clay' => 410,
            'iron' => 820,
            'crop' => 260,
            'pop' => 2,
            'cp' => 3,
            'effect' => 92.93,
            'time' => 3340
        ),
        array(
            'wood' => 375,
            'clay' => 525,
            'iron' => 1050,
            'crop' => 335,
            'pop' => 2,
            'cp' => 4,
            'effect' => 89.58,
            'time' => 4173
        ),
        array(
            'wood' => 485,
            'clay' => 670,
            'iron' => 1340,
            'crop' => 430,
            'pop' => 2,
            'cp' => 5,
            'effect' => 86.36,
            'time' => 5143
        ),
        array(
            'wood' => 620,
            'clay' => 860,
            'iron' => 1720,
            'crop' => 550,
            'pop' => 3,
            'cp' => 6,
            'effect' => 83.25,
            'time' => 6264
        ),
        array(
            'wood' => 790,
            'clay' => 1100,
            'iron' => 2200,
            'crop' => 705,
            'pop' => 3,
            'cp' => 7,
            'effect' => 80.25,
            'time' => 7566
        ),
        array(
            'wood' => 1015,
            'clay' => 1405,
            'iron' => 2815,
            'crop' => 900,
            'pop' => 3,
            'cp' => 9,
            'effect' => 77.36,
            'time' => 9078
        ),
        array(
            'wood' => 1295,
            'clay' => 1800,
            'iron' => 3605,
            'crop' => 1155,
            'pop' => 3,
            'cp' => 10,
            'effect' => 74.58,
            'time' => 10830
        ),
        array(
            'wood' => 1660,
            'clay' => 2305,
            'iron' => 4610,
            'crop' => 1475,
            'pop' => 3,
            'cp' => 12,
            'effect' => 71.89,
            'time' => 12861
        ),
        array(
            'wood' => 2125,
            'clay' => 2950,
            'iron' => 5905,
            'crop' => 1890,
            'pop' => 3,
            'cp' => 15,
            'effect' => 69.31,
            'time' => 15219
        ),
        array(
            'wood' => 2720,
            'clay' => 3780,
            'iron' => 7555,
            'crop' => 2420,
            'pop' => 3,
            'cp' => 18,
            'effect' => 66.81,
            'time' => 17955
        ),
        array(
            'wood' => 3480,
            'clay' => 4835,
            'iron' => 9670,
            'crop' => 3095,
            'pop' => 3,
            'cp' => 21,
            'effect' => 64.41,
            'time' => 21126
        ),
        array(
            'wood' => 4455,
            'clay' => 6190,
            'iron' => 12380,
            'crop' => 3960,
            'pop' => 3,
            'cp' => 26,
            'effect' => 62.09,
            'time' => 24807
        ),
        array(
            'wood' => 5705,
            'clay' => 7925,
            'iron' => 15845,
            'crop' => 5070,
            'pop' => 3,
            'cp' => 31,
            'effect' => 59.85,
            'time' => 29076
        ),
        array(
            'wood' => 7300,
            'clay' => 10140,
            'iron' => 20280,
            'crop' => 6490,
            'pop' => 4,
            'cp' => 37,
            'effect' => 57.70,
            'time' => 34029
        ),
        array(
            'wood' => 9345,
            'clay' => 12980,
            'iron' => 25960,
            'crop' => 8310,
            'pop' => 4,
            'cp' => 44,
            'effect' => 55.62,
            'time' => 39774
        ),
        array(
            'wood' => 11965,
            'clay' => 16615,
            'iron' => 33230,
            'crop' => 10635,
            'pop' => 4,
            'cp' => 53,
            'effect' => 53.62,
            'time' => 46437
        ),
        array(
            'wood' => 15315,
            'clay' => 21270,
            'iron' => 42535,
            'crop' => 13610,
            'pop' => 4,
            'cp' => 64,
            'effect' => 51.69,
            'time' => 54168
        ),
        array(
            'wood' => 19600,
            'clay' => 27225,
            'iron' => 54445,
            'crop' => 17420,
            'pop' => 4,
            'cp' => 77,
            'effect' => 49.83,
            'time' => 63135
        )
    );
    public static $bid14 = array(
        array(
            'wood' => 175,
            'clay' => 225,
            'iron' => 153,
            'crop' => 24,
            'pop' => 1,
            'cp' => 1,
            'effect' => 110,
            'time' => 35
        ),
        array(
            'wood' => 1750,
            'clay' => 2250,
            'iron' => 1530,
            'crop' => 240,
            'pop' => 1,
            'cp' => 1,
            'effect' => 110,
            'time' => 3499
        ),
        array(
            'wood' => 2240,
            'clay' => 2880,
            'iron' => 1960,
            'crop' => 305,
            'pop' => 1,
            'cp' => 1,
            'effect' => 120,
            'time' => 4359
        ),
        array(
            'wood' => 2865,
            'clay' => 3685,
            'iron' => 2505,
            'crop' => 395,
            'pop' => 1,
            'cp' => 2,
            'effect' => 130,
            'time' => 5358
        ),
        array(
            'wood' => 3670,
            'clay' => 4720,
            'iron' => 3210,
            'crop' => 505,
            'pop' => 1,
            'cp' => 2,
            'effect' => 140,
            'time' => 6516
        ),
        array(
            'wood' => 4700,
            'clay' => 6040,
            'iron' => 4105,
            'crop' => 645,
            'pop' => 1,
            'cp' => 2,
            'effect' => 150,
            'time' => 7857
        ),
        array(
            'wood' => 6015,
            'clay' => 7730,
            'iron' => 5255,
            'crop' => 825,
            'pop' => 1,
            'cp' => 3,
            'effect' => 160,
            'time' => 9414
        ),
        array(
            'wood' => 7695,
            'clay' => 9895,
            'iron' => 6730,
            'crop' => 1055,
            'pop' => 1,
            'cp' => 4,
            'effect' => 170,
            'time' => 11220
        ),
        array(
            'wood' => 9850,
            'clay' => 12665,
            'iron' => 8615,
            'crop' => 1350,
            'pop' => 1,
            'cp' => 4,
            'effect' => 180,
            'time' => 13317
        ),
        array(
            'wood' => 12610,
            'clay' => 16215,
            'iron' => 11025,
            'crop' => 1730,
            'pop' => 1,
            'cp' => 5,
            'effect' => 190,
            'time' => 15747
        ),
        array(
            'wood' => 16140,
            'clay' => 20755,
            'iron' => 14110,
            'crop' => 2215,
            'pop' => 1,
            'cp' => 6,
            'effect' => 200,
            'time' => 18570
        ),
        array(
            'wood' => 20660,
            'clay' => 26565,
            'iron' => 18065,
            'crop' => 2835,
            'pop' => 2,
            'cp' => 7,
            'effect' => 210,
            'time' => 21837
        ),
        array(
            'wood' => 26445,
            'clay' => 34000,
            'iron' => 23120,
            'crop' => 3625,
            'pop' => 2,
            'cp' => 9,
            'effect' => 220,
            'time' => 25629
        ),
        array(
            'wood' => 33850,
            'clay' => 43520,
            'iron' => 29595,
            'crop' => 4640,
            'pop' => 2,
            'cp' => 11,
            'effect' => 230,
            'time' => 30030
        ),
        array(
            'wood' => 43330,
            'clay' => 55705,
            'iron' => 37880,
            'crop' => 5940,
            'pop' => 2,
            'cp' => 13,
            'effect' => 240,
            'time' => 35136
        ),
        array(
            'wood' => 55460,
            'clay' => 71305,
            'iron' => 48490,
            'crop' => 7605,
            'pop' => 2,
            'cp' => 15,
            'effect' => 250,
            'time' => 41058
        ),
        array(
            'wood' => 70990,
            'clay' => 91270,
            'iron' => 62065,
            'crop' => 9735,
            'pop' => 2,
            'cp' => 18,
            'effect' => 260,
            'time' => 47928
        ),
        array(
            'wood' => 90865,
            'clay' => 116825,
            'iron' => 79440,
            'crop' => 12460,
            'pop' => 2,
            'cp' => 22,
            'effect' => 270,
            'time' => 55896
        ),
        array(
            'wood' => 116305,
            'clay' => 149540,
            'iron' => 101685,
            'crop' => 15950,
            'pop' => 2,
            'cp' => 27,
            'effect' => 280,
            'time' => 65139
        ),
        array(
            'wood' => 148875,
            'clay' => 191410,
            'iron' => 130160,
            'crop' => 20415,
            'pop' => 2,
            'cp' => 32,
            'effect' => 290,
            'time' => 75861
        ),
        array(
            'wood' => 190560,
            'clay' => 245005,
            'iron' => 166600,
            'crop' => 26135,
            'pop' => 2,
            'cp' => 38,
            'effect' => 300,
            'time' => 88299
        )
    );
    public static $bid15 = array(
        array(
            'wood' => 15,
            'clay' => 20,
            'iron' => 15,
            'crop' => 5,
            'pop' => 0,
            'cp' => 0,
            'effect' => 0,
            'time' => 25
        ),
        array(
            'wood' => 70,
            'clay' => 40,
            'iron' => 60,
            'crop' => 20,
            'pop' => 2,
            'cp' => 2,
            'effect' => 100,
            'time' => 2620
        ),
        array(
            'wood' => 90,
            'clay' => 50,
            'iron' => 75,
            'crop' => 25,
            'pop' => 1,
            'cp' => 3,
            'effect' => 96.4,
            'time' => 3220
        ),
        array(
            'wood' => 115,
            'clay' => 65,
            'iron' => 100,
            'crop' => 35,
            'pop' => 1,
            'cp' => 3,
            'effect' => 92.93,
            'time' => 3880
        ),
        array(
            'wood' => 145,
            'clay' => 85,
            'iron' => 125,
            'crop' => 40,
            'pop' => 1,
            'cp' => 4,
            'effect' => 89.58,
            'time' => 4610
        ),
        array(
            'wood' => 190,
            'clay' => 105,
            'iron' => 160,
            'crop' => 55,
            'pop' => 1,
            'cp' => 5,
            'effect' => 86.36,
            'time' => 5410
        ),
        array(
            'wood' => 240,
            'clay' => 135,
            'iron' => 205,
            'crop' => 70,
            'pop' => 2,
            'cp' => 6,
            'effect' => 83.25,
            'time' => 6300
        ),
        array(
            'wood' => 310,
            'clay' => 175,
            'iron' => 265,
            'crop' => 90,
            'pop' => 2,
            'cp' => 7,
            'effect' => 80.25,
            'time' => 7280
        ),
        array(
            'wood' => 395,
            'clay' => 225,
            'iron' => 340,
            'crop' => 115,
            'pop' => 2,
            'cp' => 9,
            'effect' => 77.36,
            'time' => 8380
        ),
        array(
            'wood' => 505,
            'clay' => 290,
            'iron' => 430,
            'crop' => 145,
            'pop' => 2,
            'cp' => 10,
            'effect' => 74.58,
            'time' => 9590
        ),
        array(
            'wood' => 645,
            'clay' => 370,
            'iron' => 555,
            'crop' => 185,
            'pop' => 2,
            'cp' => 12,
            'effect' => 71.89,
            'time' => 10940
        ),
        array(
            'wood' => 825,
            'clay' => 470,
            'iron' => 710,
            'crop' => 235,
            'pop' => 2,
            'cp' => 15,
            'effect' => 69.31,
            'time' => 12440
        ),
        array(
            'wood' => 1060,
            'clay' => 605,
            'iron' => 905,
            'crop' => 300,
            'pop' => 2,
            'cp' => 18,
            'effect' => 66.81,
            'time' => 14120
        ),
        array(
            'wood' => 1355,
            'clay' => 775,
            'iron' => 1160,
            'crop' => 385,
            'pop' => 2,
            'cp' => 21,
            'effect' => 64.41,
            'time' => 15980
        ),
        array(
            'wood' => 1735,
            'clay' => 990,
            'iron' => 1485,
            'crop' => 495,
            'pop' => 2,
            'cp' => 26,
            'effect' => 62.09,
            'time' => 18050
        ),
        array(
            'wood' => 2220,
            'clay' => 1270,
            'iron' => 1900,
            'crop' => 635,
            'pop' => 2,
            'cp' => 31,
            'effect' => 59.85,
            'time' => 20370
        ),
        array(
            'wood' => 2840,
            'clay' => 1625,
            'iron' => 2435,
            'crop' => 810,
            'pop' => 3,
            'cp' => 37,
            'effect' => 57.70,
            'time' => 22950
        ),
        array(
            'wood' => 3635,
            'clay' => 2075,
            'iron' => 3115,
            'crop' => 1040,
            'pop' => 3,
            'cp' => 44,
            'effect' => 55.62,
            'time' => 25830
        ),
        array(
            'wood' => 4650,
            'clay' => 2660,
            'iron' => 3990,
            'crop' => 1330,
            'pop' => 3,
            'cp' => 53,
            'effect' => 53.62,
            'time' => 29040
        ),
        array(
            'wood' => 5955,
            'clay' => 3405,
            'iron' => 5105,
            'crop' => 1700,
            'pop' => 3,
            'cp' => 64,
            'effect' => 51.69,
            'time' => 32630
        ),
        array(
            'wood' => 7620,
            'clay' => 4355,
            'iron' => 6535,
            'crop' => 2180,
            'pop' => 3,
            'cp' => 77,
            'effect' => 49.83,
            'time' => 36320
        )
    );
    public static $bid16 = array(
        array(
            'wood' => 11,
            'clay' => 16,
            'iron' => 9,
            'crop' => 7,
            'pop' => 1,
            'cp' => 1,
            'effect' => 0,
            'time' => 67
        ),
        array(
            'wood' => 110,
            'clay' => 160,
            'iron' => 90,
            'crop' => 70,
            'pop' => 1,
            'cp' => 1,
            'effect' => 0,
            'time' => 670
        ),
        array(
            'wood' => 140,
            'clay' => 205,
            'iron' => 115,
            'crop' => 90,
            'pop' => 1,
            'cp' => 1,
            'effect' => 0,
            'time' => 870
        ),
        array(
            'wood' => 180,
            'clay' => 260,
            'iron' => 145,
            'crop' => 115,
            'pop' => 1,
            'cp' => 2,
            'effect' => 0,
            'time' => 1110
        ),
        array(
            'wood' => 230,
            'clay' => 335,
            'iron' => 190,
            'crop' => 145,
            'pop' => 1,
            'cp' => 2,
            'effect' => 0,
            'time' => 1390
        ),
        array(
            'wood' => 295,
            'clay' => 430,
            'iron' => 240,
            'crop' => 190,
            'pop' => 1,
            'cp' => 2,
            'effect' => 0,
            'time' => 1710
        ),
        array(
            'wood' => 380,
            'clay' => 550,
            'iron' => 310,
            'crop' => 240,
            'pop' => 1,
            'cp' => 3,
            'effect' => 0,
            'time' => 2090
        ),
        array(
            'wood' => 485,
            'clay' => 705,
            'iron' => 395,
            'crop' => 310,
            'pop' => 1,
            'cp' => 4,
            'effect' => 0,
            'time' => 2520
        ),
        array(
            'wood' => 620,
            'clay' => 900,
            'iron' => 505,
            'crop' => 395,
            'pop' => 1,
            'cp' => 4,
            'effect' => 0,
            'time' => 3030
        ),
        array(
            'wood' => 795,
            'clay' => 1155,
            'iron' => 650,
            'crop' => 505,
            'pop' => 1,
            'cp' => 5,
            'effect' => 0,
            'time' => 3610
        ),
        array(
            'wood' => 1015,
            'clay' => 1475,
            'iron' => 830,
            'crop' => 645,
            'pop' => 1,
            'cp' => 6,
            'effect' => 0,
            'time' => 4290
        ),
        array(
            'wood' => 1300,
            'clay' => 1890,
            'iron' => 1065,
            'crop' => 825,
            'pop' => 2,
            'cp' => 7,
            'effect' => 0,
            'time' => 5070
        ),
        array(
            'wood' => 1660,
            'clay' => 2420,
            'iron' => 1360,
            'crop' => 1060,
            'pop' => 2,
            'cp' => 9,
            'effect' => 0,
            'time' => 5980
        ),
        array(
            'wood' => 2130,
            'clay' => 3095,
            'iron' => 1740,
            'crop' => 1355,
            'pop' => 2,
            'cp' => 11,
            'effect' => 0,
            'time' => 7040
        ),
        array(
            'wood' => 2725,
            'clay' => 3960,
            'iron' => 2230,
            'crop' => 1735,
            'pop' => 2,
            'cp' => 13,
            'effect' => 0,
            'time' => 8270
        ),
        array(
            'wood' => 3485,
            'clay' => 5070,
            'iron' => 2850,
            'crop' => 2220,
            'pop' => 2,
            'cp' => 15,
            'effect' => 0,
            'time' => 9690
        ),
        array(
            'wood' => 4460,
            'clay' => 6490,
            'iron' => 3650,
            'crop' => 2840,
            'pop' => 2,
            'cp' => 18,
            'effect' => 0,
            'time' => 11340
        ),
        array(
            'wood' => 5710,
            'clay' => 8310,
            'iron' => 4675,
            'crop' => 3635,
            'pop' => 2,
            'cp' => 22,
            'effect' => 0,
            'time' => 13260
        ),
        array(
            'wood' => 7310,
            'clay' => 10635,
            'iron' => 5980,
            'crop' => 4650,
            'pop' => 2,
            'cp' => 27,
            'effect' => 0,
            'time' => 15480
        ),
        array(
            'wood' => 9360,
            'clay' => 13610,
            'iron' => 7655,
            'crop' => 5955,
            'pop' => 2,
            'cp' => 32,
            'effect' => 0,
            'time' => 18060
        ),
        array(
            'wood' => 11980,
            'clay' => 17420,
            'iron' => 9800,
            'crop' => 7620,
            'pop' => 2,
            'cp' => 38,
            'effect' => 0,
            'time' => 21040
        )
    );
    public static $bid17 = array(
        array(
            'wood' => 80,
            'clay' => 70,
            'iron' => 120,
            'crop' => 70,
            'pop' => 4,
            'cp' => 4,
            'effect' => 1,
            'time' => 18
        ),
        array(
            'wood' => 80,
            'clay' => 70,
            'iron' => 120,
            'crop' => 70,
            'pop' => 4,
            'cp' => 4,
            'effect' => 1,
            'time' => 1800
        ),
        array(
            'wood' => 100,
            'clay' => 90,
            'iron' => 155,
            'crop' => 90,
            'pop' => 2,
            'cp' => 4,
            'effect' => 2,
            'time' => 2388
        ),
        array(
            'wood' => 130,
            'clay' => 115,
            'iron' => 195,
            'crop' => 115,
            'pop' => 2,
            'cp' => 5,
            'effect' => 3,
            'time' => 3069
        ),
        array(
            'wood' => 170,
            'clay' => 145,
            'iron' => 250,
            'crop' => 145,
            'pop' => 2,
            'cp' => 6,
            'effect' => 4,
            'time' => 3861
        ),
        array(
            'wood' => 215,
            'clay' => 190,
            'iron' => 320,
            'crop' => 190,
            'pop' => 2,
            'cp' => 7,
            'effect' => 5,
            'time' => 4779
        ),
        array(
            'wood' => 275,
            'clay' => 240,
            'iron' => 410,
            'crop' => 240,
            'pop' => 3,
            'cp' => 9,
            'effect' => 6,
            'time' => 5840
        ),
        array(
            'wood' => 350,
            'clay' => 310,
            'iron' => 530,
            'crop' => 310,
            'pop' => 3,
            'cp' => 11,
            'effect' => 7,
            'time' => 7080
        ),
        array(
            'wood' => 450,
            'clay' => 395,
            'iron' => 675,
            'crop' => 395,
            'pop' => 3,
            'cp' => 13,
            'effect' => 8,
            'time' => 8510
        ),
        array(
            'wood' => 575,
            'clay' => 505,
            'iron' => 865,
            'crop' => 505,
            'pop' => 3,
            'cp' => 15,
            'effect' => 9,
            'time' => 10170
        ),
        array(
            'wood' => 740,
            'clay' => 645,
            'iron' => 1105,
            'crop' => 645,
            'pop' => 3,
            'cp' => 19,
            'effect' => 10,
            'time' => 12100
        ),
        array(
            'wood' => 945,
            'clay' => 825,
            'iron' => 1415,
            'crop' => 825,
            'pop' => 3,
            'cp' => 22,
            'effect' => 11,
            'time' => 14340
        ),
        array(
            'wood' => 1210,
            'clay' => 1060,
            'iron' => 1815,
            'crop' => 1060,
            'pop' => 3,
            'cp' => 27,
            'effect' => 12,
            'time' => 16930
        ),
        array(
            'wood' => 1545,
            'clay' => 1355,
            'iron' => 2320,
            'crop' => 1355,
            'pop' => 3,
            'cp' => 32,
            'effect' => 13,
            'time' => 19940
        ),
        array(
            'wood' => 1980,
            'clay' => 1735,
            'iron' => 2970,
            'crop' => 1735,
            'pop' => 3,
            'cp' => 39,
            'effect' => 14,
            'time' => 23430
        ),
        array(
            'wood' => 2535,
            'clay' => 2220,
            'iron' => 3805,
            'crop' => 2220,
            'pop' => 3,
            'cp' => 46,
            'effect' => 15,
            'time' => 27480
        ),
        array(
            'wood' => 3245,
            'clay' => 2840,
            'iron' => 4870,
            'crop' => 2840,
            'pop' => 4,
            'cp' => 55,
            'effect' => 16,
            'time' => 32180
        ),
        array(
            'wood' => 4155,
            'clay' => 3635,
            'iron' => 6230,
            'crop' => 3635,
            'pop' => 4,
            'cp' => 67,
            'effect' => 17,
            'time' => 37620
        ),
        array(
            'wood' => 5315,
            'clay' => 4650,
            'iron' => 7975,
            'crop' => 4650,
            'pop' => 4,
            'cp' => 80,
            'effect' => 18,
            'time' => 43940
        ),
        array(
            'wood' => 6805,
            'clay' => 5955,
            'iron' => 10210,
            'crop' => 5955,
            'pop' => 4,
            'cp' => 96,
            'effect' => 19,
            'time' => 51270
        ),
        array(
            'wood' => 8710,
            'clay' => 7620,
            'iron' => 13065,
            'crop' => 7620,
            'pop' => 4,
            'cp' => 115,
            'effect' => 20,
            'time' => 59780
        )
    );
    public static $bid18 = array(
        array(
            'wood' => 180,
            'clay' => 130,
            'iron' => 150,
            'crop' => 80,
            'pop' => 3,
            'cp' => 5,
            'effect' => 0,
            'time' => 20
        ),
        array(
            'wood' => 180,
            'clay' => 130,
            'iron' => 150,
            'crop' => 80,
            'pop' => 3,
            'cp' => 5,
            'effect' => 0,
            'time' => 2000
        ),
        array(
            'wood' => 230,
            'clay' => 165,
            'iron' => 190,
            'crop' => 100,
            'pop' => 2,
            'cp' => 6,
            'effect' => 0,
            'time' => 2620
        ),
        array(
            'wood' => 295,
            'clay' => 215,
            'iron' => 245,
            'crop' => 130,
            'pop' => 2,
            'cp' => 7,
            'effect' => 9,
            'time' => 3340
        ),
        array(
            'wood' => 375,
            'clay' => 275,
            'iron' => 315,
            'crop' => 170,
            'pop' => 2,
            'cp' => 8,
            'effect' => 12,
            'time' => 4170
        ),
        array(
            'wood' => 485,
            'clay' => 350,
            'iron' => 405,
            'crop' => 215,
            'pop' => 2,
            'cp' => 10,
            'effect' => 15,
            'time' => 5140
        ),
        array(
            'wood' => 620,
            'clay' => 445,
            'iron' => 515,
            'crop' => 275,
            'pop' => 2,
            'cp' => 12,
            'effect' => 18,
            'time' => 6260
        ),
        array(
            'wood' => 790,
            'clay' => 570,
            'iron' => 660,
            'crop' => 350,
            'pop' => 2,
            'cp' => 14,
            'effect' => 21,
            'time' => 7570
        ),
        array(
            'wood' => 1015,
            'clay' => 730,
            'iron' => 845,
            'crop' => 450,
            'pop' => 2,
            'cp' => 17,
            'effect' => 24,
            'time' => 9080
        ),
        array(
            'wood' => 1295,
            'clay' => 935,
            'iron' => 1080,
            'crop' => 575,
            'pop' => 2,
            'cp' => 21,
            'effect' => 27,
            'time' => 10830
        ),
        array(
            'wood' => 1660,
            'clay' => 1200,
            'iron' => 1385,
            'crop' => 740,
            'pop' => 2,
            'cp' => 25,
            'effect' => 30,
            'time' => 12860
        ),
        array(
            'wood' => 2125,
            'clay' => 1535,
            'iron' => 1770,
            'crop' => 945,
            'pop' => 3,
            'cp' => 30,
            'effect' => 33,
            'time' => 15220
        ),
        array(
            'wood' => 2720,
            'clay' => 1965,
            'iron' => 2265,
            'crop' => 1210,
            'pop' => 3,
            'cp' => 36,
            'effect' => 36,
            'time' => 17950
        ),
        array(
            'wood' => 3480,
            'clay' => 2515,
            'iron' => 2900,
            'crop' => 1545,
            'pop' => 3,
            'cp' => 43,
            'effect' => 39,
            'time' => 21130
        ),
        array(
            'wood' => 4455,
            'clay' => 3220,
            'iron' => 3715,
            'crop' => 1980,
            'pop' => 3,
            'cp' => 51,
            'effect' => 42,
            'time' => 24810
        ),
        array(
            'wood' => 5705,
            'clay' => 4120,
            'iron' => 4755,
            'crop' => 2535,
            'pop' => 3,
            'cp' => 62,
            'effect' => 45,
            'time' => 29080
        ),
        array(
            'wood' => 7300,
            'clay' => 5275,
            'iron' => 6085,
            'crop' => 3245,
            'pop' => 3,
            'cp' => 74,
            'effect' => 48,
            'time' => 34030
        ),
        array(
            'wood' => 9345,
            'clay' => 6750,
            'iron' => 7790,
            'crop' => 4155,
            'pop' => 3,
            'cp' => 89,
            'effect' => 51,
            'time' => 39770
        ),
        array(
            'wood' => 11965,
            'clay' => 8640,
            'iron' => 9970,
            'crop' => 5315,
            'pop' => 3,
            'cp' => 106,
            'effect' => 54,
            'time' => 46440
        ),
        array(
            'wood' => 15315,
            'clay' => 11060,
            'iron' => 12760,
            'crop' => 6805,
            'pop' => 3,
            'cp' => 128,
            'effect' => 57,
            'time' => 54170
        ),
        array(
            'wood' => 19600,
            'clay' => 14155,
            'iron' => 16335,
            'crop' => 8710,
            'pop' => 3,
            'cp' => 153,
            'effect' => 60,
            'time' => 63130
        )
    );
    public static $bid19 = array(
        array(
            'wood' => 210,
            'clay' => 140,
            'iron' => 260,
            'crop' => 120,
            'pop' => 4,
            'cp' => 1,
            'effect' => 100,
            'time' => 20
        ),
        array(
            'wood' => 210,
            'clay' => 140,
            'iron' => 260,
            'crop' => 120,
            'pop' => 4,
            'cp' => 1,
            'effect' => 100,
            'time' => 2000
        ),
        array(
            'wood' => 270,
            'clay' => 180,
            'iron' => 335,
            'crop' => 155,
            'pop' => 2,
            'cp' => 1,
            'effect' => 90,
            'time' => 2620
        ),
        array(
            'wood' => 345,
            'clay' => 230,
            'iron' => 425,
            'crop' => 195,
            'pop' => 2,
            'cp' => 2,
            'effect' => 81,
            'time' => 3340
        ),
        array(
            'wood' => 440,
            'clay' => 295,
            'iron' => 545,
            'crop' => 250,
            'pop' => 2,
            'cp' => 2,
            'effect' => 72.9,
            'time' => 4170
        ),
        array(
            'wood' => 565,
            'clay' => 375,
            'iron' => 700,
            'crop' => 320,
            'pop' => 2,
            'cp' => 2,
            'effect' => 65.61,
            'time' => 5140
        ),
        array(
            'wood' => 720,
            'clay' => 480,
            'iron' => 895,
            'crop' => 410,
            'pop' => 3,
            'cp' => 3,
            'effect' => 59.05,
            'time' => 6260
        ),
        array(
            'wood' => 925,
            'clay' => 615,
            'iron' => 1145,
            'crop' => 530,
            'pop' => 3,
            'cp' => 4,
            'effect' => 53.14,
            'time' => 7570
        ),
        array(
            'wood' => 1180,
            'clay' => 790,
            'iron' => 1465,
            'crop' => 675,
            'pop' => 3,
            'cp' => 4,
            'effect' => 47.83,
            'time' => 9080
        ),
        array(
            'wood' => 1515,
            'clay' => 1010,
            'iron' => 1875,
            'crop' => 865,
            'pop' => 3,
            'cp' => 5,
            'effect' => 43.05,
            'time' => 10830
        ),
        array(
            'wood' => 1935,
            'clay' => 1290,
            'iron' => 2400,
            'crop' => 1105,
            'pop' => 3,
            'cp' => 6,
            'effect' => 38.74,
            'time' => 12860
        ),
        array(
            'wood' => 2480,
            'clay' => 1655,
            'iron' => 3070,
            'crop' => 1415,
            'pop' => 3,
            'cp' => 7,
            'effect' => 34.87,
            'time' => 15220
        ),
        array(
            'wood' => 3175,
            'clay' => 2115,
            'iron' => 3930,
            'crop' => 1815,
            'pop' => 3,
            'cp' => 9,
            'effect' => 31.38,
            'time' => 17950
        ),
        array(
            'wood' => 4060,
            'clay' => 2710,
            'iron' => 5030,
            'crop' => 2320,
            'pop' => 3,
            'cp' => 11,
            'effect' => 28.24,
            'time' => 21130
        ),
        array(
            'wood' => 5200,
            'clay' => 3465,
            'iron' => 6435,
            'crop' => 2970,
            'pop' => 3,
            'cp' => 13,
            'effect' => 25.42,
            'time' => 24810
        ),
        array(
            'wood' => 6655,
            'clay' => 4435,
            'iron' => 8240,
            'crop' => 3805,
            'pop' => 3,
            'cp' => 15,
            'effect' => 22.88,
            'time' => 29080
        ),
        array(
            'wood' => 8520,
            'clay' => 5680,
            'iron' => 10545,
            'crop' => 4870,
            'pop' => 4,
            'cp' => 18,
            'effect' => 20.59,
            'time' => 34030
        ),
        array(
            'wood' => 10905,
            'clay' => 7270,
            'iron' => 13500,
            'crop' => 6230,
            'pop' => 4,
            'cp' => 22,
            'effect' => 18.53,
            'time' => 39770
        ),
        array(
            'wood' => 13955,
            'clay' => 9305,
            'iron' => 17280,
            'crop' => 7975,
            'pop' => 4,
            'cp' => 27,
            'effect' => 16.68,
            'time' => 46440
        ),
        array(
            'wood' => 17865,
            'clay' => 11910,
            'iron' => 22120,
            'crop' => 10210,
            'pop' => 4,
            'cp' => 32,
            'effect' => 15.01,
            'time' => 54170
        ),
        array(
            'wood' => 22865,
            'clay' => 15245,
            'iron' => 28310,
            'crop' => 13065,
            'pop' => 4,
            'cp' => 38,
            'effect' => 13.51,
            'time' => 63130
        )
    );
    public static $bid20 = array(
        array(
            'wood' => 260,
            'clay' => 140,
            'iron' => 220,
            'crop' => 100,
            'pop' => 5,
            'cp' => 2,
            'effect' => 100,
            'time' => 22
        ),
        array(
            'wood' => 260,
            'clay' => 140,
            'iron' => 220,
            'crop' => 100,
            'pop' => 5,
            'cp' => 2,
            'effect' => 100,
            'time' => 2200
        ),
        array(
            'wood' => 335,
            'clay' => 180,
            'iron' => 280,
            'crop' => 130,
            'pop' => 3,
            'cp' => 3,
            'effect' => 90,
            'time' => 2850
        ),
        array(
            'wood' => 425,
            'clay' => 230,
            'iron' => 360,
            'crop' => 165,
            'pop' => 3,
            'cp' => 3,
            'effect' => 81,
            'time' => 3610
        ),
        array(
            'wood' => 545,
            'clay' => 295,
            'iron' => 460,
            'crop' => 210,
            'pop' => 3,
            'cp' => 4,
            'effect' => 72.9,
            'time' => 4490
        ),
        array(
            'wood' => 700,
            'clay' => 375,
            'iron' => 590,
            'crop' => 270,
            'pop' => 3,
            'cp' => 5,
            'effect' => 65.61,
            'time' => 5500
        ),
        array(
            'wood' => 895,
            'clay' => 480,
            'iron' => 755,
            'crop' => 345,
            'pop' => 3,
            'cp' => 6,
            'effect' => 59.05,
            'time' => 6680
        ),
        array(
            'wood' => 1145,
            'clay' => 615,
            'iron' => 970,
            'crop' => 440,
            'pop' => 3,
            'cp' => 7,
            'effect' => 53.14,
            'time' => 8050
        ),
        array(
            'wood' => 1465,
            'clay' => 790,
            'iron' => 1240,
            'crop' => 565,
            'pop' => 3,
            'cp' => 9,
            'effect' => 47.83,
            'time' => 9640
        ),
        array(
            'wood' => 1875,
            'clay' => 1010,
            'iron' => 1585,
            'crop' => 720,
            'pop' => 3,
            'cp' => 10,
            'effect' => 43.05,
            'time' => 11480
        ),
        array(
            'wood' => 2400,
            'clay' => 1290,
            'iron' => 2030,
            'crop' => 920,
            'pop' => 3,
            'cp' => 12,
            'effect' => 38.74,
            'time' => 13620
        ),
        array(
            'wood' => 3070,
            'clay' => 1655,
            'iron' => 2595,
            'crop' => 1180,
            'pop' => 4,
            'cp' => 15,
            'effect' => 34.87,
            'time' => 16100
        ),
        array(
            'wood' => 3930,
            'clay' => 2115,
            'iron' => 3325,
            'crop' => 1510,
            'pop' => 4,
            'cp' => 18,
            'effect' => 31.38,
            'time' => 18980
        ),
        array(
            'wood' => 5030,
            'clay' => 2710,
            'iron' => 4255,
            'crop' => 1935,
            'pop' => 4,
            'cp' => 21,
            'effect' => 28.24,
            'time' => 22310
        ),
        array(
            'wood' => 6435,
            'clay' => 3465,
            'iron' => 5445,
            'crop' => 2475,
            'pop' => 4,
            'cp' => 26,
            'effect' => 25.42,
            'time' => 26180
        ),
        array(
            'wood' => 8240,
            'clay' => 4435,
            'iron' => 6970,
            'crop' => 3170,
            'pop' => 4,
            'cp' => 31,
            'effect' => 22.88,
            'time' => 30670
        ),
        array(
            'wood' => 10545,
            'clay' => 5680,
            'iron' => 8925,
            'crop' => 4055,
            'pop' => 4,
            'cp' => 37,
            'effect' => 20.59,
            'time' => 35880
        ),
        array(
            'wood' => 13500,
            'clay' => 7270,
            'iron' => 11425,
            'crop' => 5190,
            'pop' => 4,
            'cp' => 44,
            'effect' => 18.53,
            'time' => 41920
        ),
        array(
            'wood' => 17280,
            'clay' => 9305,
            'iron' => 14620,
            'crop' => 6645,
            'pop' => 4,
            'cp' => 53,
            'effect' => 16.68,
            'time' => 48930
        ),
        array(
            'wood' => 22120,
            'clay' => 11910,
            'iron' => 18715,
            'crop' => 8505,
            'pop' => 4,
            'cp' => 64,
            'effect' => 15.01,
            'time' => 57060
        ),
        array(
            'wood' => 28310,
            'clay' => 15245,
            'iron' => 23955,
            'crop' => 10890,
            'pop' => 4,
            'cp' => 77,
            'effect' => 13.51,
            'time' => 66490
        )
    );
    public static $bid21 = array(
        array(
            'wood' => 460,
            'clay' => 510,
            'iron' => 600,
            'crop' => 320,
            'pop' => 3,
            'cp' => 4,
            'effect' => 100,
            'time' => 30
        ),
        array(
            'wood' => 460,
            'clay' => 510,
            'iron' => 600,
            'crop' => 320,
            'pop' => 3,
            'cp' => 4,
            'effect' => 100,
            'time' => 3000
        ),
        array(
            'wood' => 590,
            'clay' => 655,
            'iron' => 770,
            'crop' => 410,
            'pop' => 2,
            'cp' => 4,
            'effect' => 90,
            'time' => 3780
        ),
        array(
            'wood' => 755,
            'clay' => 835,
            'iron' => 985,
            'crop' => 525,
            'pop' => 2,
            'cp' => 5,
            'effect' => 81,
            'time' => 4680
        ),
        array(
            'wood' => 965,
            'clay' => 1070,
            'iron' => 1260,
            'crop' => 670,
            'pop' => 2,
            'cp' => 6,
            'effect' => 72.9,
            'time' => 5730
        ),
        array(
            'wood' => 1235,
            'clay' => 1370,
            'iron' => 1610,
            'crop' => 860,
            'pop' => 2,
            'cp' => 7,
            'effect' => 65.61,
            'time' => 6950
        ),
        array(
            'wood' => 1580,
            'clay' => 1750,
            'iron' => 2060,
            'crop' => 1100,
            'pop' => 2,
            'cp' => 9,
            'effect' => 59.05,
            'time' => 8360
        ),
        array(
            'wood' => 2025,
            'clay' => 2245,
            'iron' => 2640,
            'crop' => 1405,
            'pop' => 2,
            'cp' => 11,
            'effect' => 53.14,
            'time' => 10000
        ),
        array(
            'wood' => 2590,
            'clay' => 2870,
            'iron' => 3380,
            'crop' => 1800,
            'pop' => 2,
            'cp' => 13,
            'effect' => 47.83,
            'time' => 11900
        ),
        array(
            'wood' => 3315,
            'clay' => 3675,
            'iron' => 4325,
            'crop' => 2305,
            'pop' => 2,
            'cp' => 15,
            'effect' => 43.05,
            'time' => 14110
        ),
        array(
            'wood' => 4245,
            'clay' => 4705,
            'iron' => 5535,
            'crop' => 2950,
            'pop' => 2,
            'cp' => 19,
            'effect' => 38.74,
            'time' => 16660
        ),
        array(
            'wood' => 5430,
            'clay' => 6020,
            'iron' => 7085,
            'crop' => 3780,
            'pop' => 3,
            'cp' => 22,
            'effect' => 34.87,
            'time' => 19630
        ),
        array(
            'wood' => 6950,
            'clay' => 7705,
            'iron' => 9065,
            'crop' => 4835,
            'pop' => 3,
            'cp' => 27,
            'effect' => 31.38,
            'time' => 23070
        ),
        array(
            'wood' => 8900,
            'clay' => 9865,
            'iron' => 11605,
            'crop' => 6190,
            'pop' => 3,
            'cp' => 32,
            'effect' => 28.24,
            'time' => 27060
        ),
        array(
            'wood' => 11390,
            'clay' => 12625,
            'iron' => 14855,
            'crop' => 7925,
            'pop' => 3,
            'cp' => 39,
            'effect' => 25.42,
            'time' => 31690
        ),
        array(
            'wood' => 14580,
            'clay' => 16165,
            'iron' => 19015,
            'crop' => 10140,
            'pop' => 3,
            'cp' => 46,
            'effect' => 22.88,
            'time' => 37060
        ),
        array(
            'wood' => 18660,
            'clay' => 20690,
            'iron' => 24340,
            'crop' => 12980,
            'pop' => 3,
            'cp' => 55,
            'effect' => 20.59,
            'time' => 43290
        ),
        array(
            'wood' => 23885,
            'clay' => 26480,
            'iron' => 31155,
            'crop' => 16615,
            'pop' => 3,
            'cp' => 67,
            'effect' => 18.53,
            'time' => 50520
        ),
        array(
            'wood' => 30570,
            'clay' => 33895,
            'iron' => 39875,
            'crop' => 21270,
            'pop' => 3,
            'cp' => 80,
            'effect' => 16.68,
            'time' => 58900
        ),
        array(
            'wood' => 39130,
            'clay' => 43385,
            'iron' => 51040,
            'crop' => 27225,
            'pop' => 3,
            'cp' => 96,
            'effect' => 15.01,
            'time' => 68630
        ),
        array(
            'wood' => 50090,
            'clay' => 55535,
            'iron' => 65335,
            'crop' => 34845,
            'pop' => 3,
            'cp' => 115,
            'effect' => 13.51,
            'time' => 79910
        )
    );
    public static $bid22 = array(
        array(
            'wood' => 220,
            'clay' => 160,
            'iron' => 90,
            'crop' => 40,
            'pop' => 4,
            'cp' => 5,
            'effect' => 100,
            'time' => 30
        ),
        array(
            'wood' => 220,
            'clay' => 160,
            'iron' => 90,
            'crop' => 40,
            'pop' => 4,
            'cp' => 5,
            'effect' => 100,
            'time' => 2000
        ),
        array(
            'wood' => 280,
            'clay' => 205,
            'iron' => 115,
            'crop' => 50,
            'pop' => 2,
            'cp' => 6,
            'effect' => 96.4,
            'time' => 2620
        ),
        array(
            'wood' => 360,
            'clay' => 260,
            'iron' => 145,
            'crop' => 65,
            'pop' => 2,
            'cp' => 7,
            'effect' => 92.93,
            'time' => 3340
        ),
        array(
            'wood' => 460,
            'clay' => 335,
            'iron' => 190,
            'crop' => 85,
            'pop' => 2,
            'cp' => 8,
            'effect' => 89.58,
            'time' => 4170
        ),
        array(
            'wood' => 590,
            'clay' => 430,
            'iron' => 240,
            'crop' => 105,
            'pop' => 2,
            'cp' => 10,
            'effect' => 86.36,
            'time' => 5140
        ),
        array(
            'wood' => 755,
            'clay' => 550,
            'iron' => 310,
            'crop' => 135,
            'pop' => 3,
            'cp' => 12,
            'effect' => 83.25,
            'time' => 6260
        ),
        array(
            'wood' => 970,
            'clay' => 705,
            'iron' => 395,
            'crop' => 175,
            'pop' => 3,
            'cp' => 14,
            'effect' => 80.25,
            'time' => 7570
        ),
        array(
            'wood' => 1240,
            'clay' => 900,
            'iron' => 505,
            'crop' => 225,
            'pop' => 3,
            'cp' => 17,
            'effect' => 77.36,
            'time' => 9080
        ),
        array(
            'wood' => 1585,
            'clay' => 1155,
            'iron' => 650,
            'crop' => 290,
            'pop' => 3,
            'cp' => 21,
            'effect' => 74.58,
            'time' => 10830
        ),
        array(
            'wood' => 2030,
            'clay' => 1475,
            'iron' => 830,
            'crop' => 370,
            'pop' => 3,
            'cp' => 25,
            'effect' => 71.89,
            'time' => 12860
        ),
        array(
            'wood' => 2595,
            'clay' => 1890,
            'iron' => 1065,
            'crop' => 470,
            'pop' => 3,
            'cp' => 30,
            'effect' => 69.31,
            'time' => 15220
        ),
        array(
            'wood' => 3325,
            'clay' => 2420,
            'iron' => 1360,
            'crop' => 605,
            'pop' => 3,
            'cp' => 36,
            'effect' => 66.81,
            'time' => 17950
        ),
        array(
            'wood' => 4255,
            'clay' => 3095,
            'iron' => 1740,
            'crop' => 775,
            'pop' => 3,
            'cp' => 43,
            'effect' => 64.41,
            'time' => 21130
        ),
        array(
            'wood' => 5445,
            'clay' => 3960,
            'iron' => 2230,
            'crop' => 990,
            'pop' => 3,
            'cp' => 51,
            'effect' => 62.09,
            'time' => 24810
        ),
        array(
            'wood' => 6970,
            'clay' => 5070,
            'iron' => 2850,
            'crop' => 1270,
            'pop' => 3,
            'cp' => 62,
            'effect' => 59.85,
            'time' => 29080
        ),
        array(
            'wood' => 8925,
            'clay' => 6490,
            'iron' => 3650,
            'crop' => 1625,
            'pop' => 4,
            'cp' => 74,
            'effect' => 57.70,
            'time' => 34030
        ),
        array(
            'wood' => 11425,
            'clay' => 8310,
            'iron' => 4675,
            'crop' => 2075,
            'pop' => 4,
            'cp' => 89,
            'effect' => 55.62,
            'time' => 39770
        ),
        array(
            'wood' => 14620,
            'clay' => 10635,
            'iron' => 5980,
            'crop' => 2660,
            'pop' => 4,
            'cp' => 106,
            'effect' => 53.62,
            'time' => 46440
        ),
        array(
            'wood' => 18715,
            'clay' => 13610,
            'iron' => 7655,
            'crop' => 3405,
            'pop' => 4,
            'cp' => 128,
            'effect' => 51.69,
            'time' => 54170
        ),
        array(
            'wood' => 23955,
            'clay' => 17420,
            'iron' => 9800,
            'crop' => 4355,
            'pop' => 4,
            'cp' => 153,
            'effect' => 49.83,
            'time' => 0
        )
    );
    public static $bid23 = array(
        array(
            'wood' => 40,
            'clay' => 50,
            'iron' => 30,
            'crop' => 10,
            'pop' => 0,
            'cp' => 1,
            'effect' => 100,
            'time' => 8
        ),
        array(
            'wood' => 40,
            'clay' => 50,
            'iron' => 30,
            'crop' => 10,
            'pop' => 0,
            'cp' => 1,
            'effect' => 100,
            'time' => 750
        ),
        array(
            'wood' => 50,
            'clay' => 65,
            'iron' => 40,
            'crop' => 15,
            'pop' => 0,
            'cp' => 1,
            'effect' => 130,
            'time' => 1170
        ),
        array(
            'wood' => 65,
            'clay' => 80,
            'iron' => 50,
            'crop' => 15,
            'pop' => 0,
            'cp' => 2,
            'effect' => 170,
            'time' => 1660
        ),
        array(
            'wood' => 85,
            'clay' => 105,
            'iron' => 65,
            'crop' => 20,
            'pop' => 0,
            'cp' => 2,
            'effect' => 220,
            'time' => 2220
        ),
        array(
            'wood' => 105,
            'clay' => 135,
            'iron' => 80,
            'crop' => 25,
            'pop' => 0,
            'cp' => 2,
            'effect' => 280,
            'time' => 2880
        ),
        array(
            'wood' => 135,
            'clay' => 170,
            'iron' => 105,
            'crop' => 35,
            'pop' => 1,
            'cp' => 3,
            'effect' => 360,
            'time' => 3640
        ),
        array(
            'wood' => 175,
            'clay' => 220,
            'iron' => 130,
            'crop' => 45,
            'pop' => 1,
            'cp' => 4,
            'effect' => 460,
            'time' => 4520
        ),
        array(
            'wood' => 225,
            'clay' => 280,
            'iron' => 170,
            'crop' => 55,
            'pop' => 1,
            'cp' => 4,
            'effect' => 600,
            'time' => 5540
        ),
        array(
            'wood' => 290,
            'clay' => 360,
            'iron' => 215,
            'crop' => 70,
            'pop' => 1,
            'cp' => 5,
            'effect' => 770,
            'time' => 6730
        ),
        array(
            'wood' => 370,
            'clay' => 460,
            'iron' => 275,
            'crop' => 90,
            'pop' => 1,
            'cp' => 6,
            'effect' => 1000,
            'time' => 8110
        )
    );
    public static $bid24 = array(
        array(
            'wood' => 125,
            'clay' => 111,
            'iron' => 126,
            'crop' => 60,
            'pop' => 4,
            'cp' => 6,
            'effect' => 100.00,
            'time' => 125
        ),
        array(
            'wood' => 1250,
            'clay' => 1110,
            'iron' => 1260,
            'crop' => 600,
            'pop' => 4,
            'cp' => 6,
            'effect' => 100.00,
            'time' => 12500
        ),
        array(
            'wood' => 1600,
            'clay' => 1420,
            'iron' => 1615,
            'crop' => 770,
            'pop' => 2,
            'cp' => 7,
            'effect' => 96.40,
            'time' => 14800
        ),
        array(
            'wood' => 2050,
            'clay' => 1820,
            'iron' => 2065,
            'crop' => 985,
            'pop' => 2,
            'cp' => 9,
            'effect' => 92.93,
            'time' => 17468
        ),
        array(
            'wood' => 2620,
            'clay' => 2330,
            'iron' => 2640,
            'crop' => 1260,
            'pop' => 2,
            'cp' => 10,
            'effect' => 89.58,
            'time' => 20563
        ),
        array(
            'wood' => 3355,
            'clay' => 2980,
            'iron' => 3380,
            'crop' => 1610,
            'pop' => 2,
            'cp' => 12,
            'effect' => 86.36,
            'time' => 24153
        ),
        array(
            'wood' => 4295,
            'clay' => 3815,
            'iron' => 4330,
            'crop' => 2060,
            'pop' => 3,
            'cp' => 15,
            'effect' => 83.25,
            'time' => 28317
        ),
        array(
            'wood' => 5500,
            'clay' => 4880,
            'iron' => 5540,
            'crop' => 2640,
            'pop' => 3,
            'cp' => 18,
            'effect' => 80.25,
            'time' => 33148
        ),
        array(
            'wood' => 7035,
            'clay' => 6250,
            'iron' => 7095,
            'crop' => 3380,
            'pop' => 3,
            'cp' => 21,
            'effect' => 77.36,
            'time' => 38752
        ),
        array(
            'wood' => 9005,
            'clay' => 8000,
            'iron' => 9080,
            'crop' => 4325,
            'pop' => 3,
            'cp' => 26,
            'effect' => 74.58,
            'time' => 45252
        ),
        array(
            'wood' => 11530,
            'clay' => 10240,
            'iron' => 11620,
            'crop' => 5535,
            'pop' => 3,
            'cp' => 31,
            'effect' => 71.89,
            'time' => 52793
        ),
        array(
            'wood' => 14755,
            'clay' => 13105,
            'iron' => 14875,
            'crop' => 7085,
            'pop' => 3,
            'cp' => 37,
            'effect' => 69.31,
            'time' => 61539
        ),
        array(
            'wood' => 18890,
            'clay' => 16775,
            'iron' => 19040,
            'crop' => 9065,
            'pop' => 3,
            'cp' => 45,
            'effect' => 66.81,
            'time' => 71686
        ),
        array(
            'wood' => 24180,
            'clay' => 21470,
            'iron' => 24370,
            'crop' => 11605,
            'pop' => 3,
            'cp' => 53,
            'effect' => 64.41,
            'time' => 83455
        ),
        array(
            'wood' => 30950,
            'clay' => 27480,
            'iron' => 31195,
            'crop' => 14855,
            'pop' => 3,
            'cp' => 64,
            'effect' => 62.09,
            'time' => 10708
        ),
        array(
            'wood' => 39615,
            'clay' => 35175,
            'iron' => 39930,
            'crop' => 19015,
            'pop' => 3,
            'cp' => 77,
            'effect' => 59.85,
            'time' => 26546
        ),
        array(
            'wood' => 50705,
            'clay' => 45025,
            'iron' => 51110,
            'crop' => 24340,
            'pop' => 4,
            'cp' => 92,
            'effect' => 57.70,
            'time' => 44917
        ),
        array(
            'wood' => 64905,
            'clay' => 57635,
            'iron' => 65425,
            'crop' => 31155,
            'pop' => 4,
            'cp' => 111,
            'effect' => 55.62,
            'time' => 66228
        ),
        array(
            'wood' => 83075,
            'clay' => 73770,
            'iron' => 83740,
            'crop' => 39875,
            'pop' => 4,
            'cp' => 133,
            'effect' => 53.62,
            'time' => 4548
        ),
        array(
            'wood' => 106340,
            'clay' => 94430,
            'iron' => 107190,
            'crop' => 51040,
            'pop' => 4,
            'cp' => 160,
            'effect' => 51.69,
            'time' => 33224
        ),
        array(
            'wood' => 136115,
            'clay' => 120870,
            'iron' => 137200,
            'crop' => 65335,
            'pop' => 4,
            'cp' => 192,
            'effect' => 49.83,
            'time' => 66487
        )
    );
    public static $bid25 = array(
        array(
            'wood' => 580,
            'clay' => 460,
            'iron' => 350,
            'crop' => 180,
            'pop' => 1,
            'cp' => 2,
            'effect' => 100,
            'time' => 20
        ),
        array(
            'wood' => 580,
            'clay' => 460,
            'iron' => 350,
            'crop' => 180,
            'pop' => 1,
            'cp' => 2,
            'effect' => 100,
            'time' => 2000
        ),
        array(
            'wood' => 740,
            'clay' => 590,
            'iron' => 450,
            'crop' => 230,
            'pop' => 1,
            'cp' => 3,
            'effect' => 90,
            'time' => 2620
        ),
        array(
            'wood' => 950,
            'clay' => 755,
            'iron' => 575,
            'crop' => 295,
            'pop' => 1,
            'cp' => 3,
            'effect' => 81,
            'time' => 3340
        ),
        array(
            'wood' => 1215,
            'clay' => 965,
            'iron' => 735,
            'crop' => 375,
            'pop' => 1,
            'cp' => 4,
            'effect' => 72.9,
            'time' => 4170
        ),
        array(
            'wood' => 1555,
            'clay' => 1235,
            'iron' => 940,
            'crop' => 485,
            'pop' => 1,
            'cp' => 5,
            'effect' => 65.61,
            'time' => 5140
        ),
        array(
            'wood' => 1995,
            'clay' => 1580,
            'iron' => 1205,
            'crop' => 620,
            'pop' => 1,
            'cp' => 6,
            'effect' => 59.05,
            'time' => 6260
        ),
        array(
            'wood' => 2550,
            'clay' => 2025,
            'iron' => 1540,
            'crop' => 790,
            'pop' => 1,
            'cp' => 7,
            'effect' => 53.14,
            'time' => 7570
        ),
        array(
            'wood' => 3265,
            'clay' => 2590,
            'iron' => 1970,
            'crop' => 1015,
            'pop' => 1,
            'cp' => 9,
            'effect' => 47.83,
            'time' => 9080
        ),
        array(
            'wood' => 4180,
            'clay' => 3315,
            'iron' => 2520,
            'crop' => 1295,
            'pop' => 1,
            'cp' => 10,
            'effect' => 43.05,
            'time' => 10830
        ),
        array(
            'wood' => 5350,
            'clay' => 4245,
            'iron' => 3230,
            'crop' => 1660,
            'pop' => 1,
            'cp' => 12,
            'effect' => 38.74,
            'time' => 12860
        ),
        array(
            'wood' => 6845,
            'clay' => 5430,
            'iron' => 4130,
            'crop' => 2125,
            'pop' => 2,
            'cp' => 15,
            'effect' => 34.87,
            'time' => 15220
        ),
        array(
            'wood' => 8765,
            'clay' => 6950,
            'iron' => 5290,
            'crop' => 2720,
            'pop' => 2,
            'cp' => 18,
            'effect' => 31.38,
            'time' => 17950
        ),
        array(
            'wood' => 11220,
            'clay' => 8900,
            'iron' => 6770,
            'crop' => 3480,
            'pop' => 2,
            'cp' => 21,
            'effect' => 28.24,
            'time' => 21130
        ),
        array(
            'wood' => 14360,
            'clay' => 11390,
            'iron' => 8665,
            'crop' => 4455,
            'pop' => 2,
            'cp' => 26,
            'effect' => 25.42,
            'time' => 24810
        ),
        array(
            'wood' => 18380,
            'clay' => 14580,
            'iron' => 11090,
            'crop' => 5705,
            'pop' => 2,
            'cp' => 31,
            'effect' => 22.88,
            'time' => 29080
        ),
        array(
            'wood' => 23530,
            'clay' => 18660,
            'iron' => 14200,
            'crop' => 7300,
            'pop' => 2,
            'cp' => 37,
            'effect' => 20.59,
            'time' => 34030
        ),
        array(
            'wood' => 30115,
            'clay' => 23885,
            'iron' => 18175,
            'crop' => 9345,
            'pop' => 2,
            'cp' => 44,
            'effect' => 18.53,
            'time' => 39770
        ),
        array(
            'wood' => 38550,
            'clay' => 30570,
            'iron' => 23260,
            'crop' => 11965,
            'pop' => 2,
            'cp' => 53,
            'effect' => 16.68,
            'time' => 46440
        ),
        array(
            'wood' => 49340,
            'clay' => 39130,
            'iron' => 29775,
            'crop' => 15315,
            'pop' => 2,
            'cp' => 64,
            'effect' => 15.01,
            'time' => 54170
        ),
        array(
            'wood' => 63155,
            'clay' => 50090,
            'iron' => 38110,
            'crop' => 19600,
            'pop' => 2,
            'cp' => 77,
            'effect' => 13.51,
            'time' => 63130
        )
    );
    public static $bid26 = array(
        array(
            'wood' => 550,
            'clay' => 800,
            'iron' => 750,
            'crop' => 250,
            'pop' => 1,
            'cp' => 6,
            'effect' => 100,
            'time' => 50
        ),
        array(
            'wood' => 550,
            'clay' => 800,
            'iron' => 750,
            'crop' => 250,
            'pop' => 1,
            'cp' => 6,
            'effect' => 100,
            'time' => 5000
        ),
        array(
            'wood' => 705,
            'clay' => 1025,
            'iron' => 960,
            'crop' => 320,
            'pop' => 1,
            'cp' => 7,
            'effect' => 90,
            'time' => 6100
        ),
        array(
            'wood' => 900,
            'clay' => 1310,
            'iron' => 1230,
            'crop' => 410,
            'pop' => 1,
            'cp' => 9,
            'effect' => 81,
            'time' => 7380
        ),
        array(
            'wood' => 1155,
            'clay' => 1680,
            'iron' => 1575,
            'crop' => 525,
            'pop' => 1,
            'cp' => 10,
            'effect' => 72.9,
            'time' => 8860
        ),
        array(
            'wood' => 1475,
            'clay' => 2145,
            'iron' => 2015,
            'crop' => 670,
            'pop' => 1,
            'cp' => 12,
            'effect' => 65.61,
            'time' => 10570
        ),
        array(
            'wood' => 1890,
            'clay' => 2750,
            'iron' => 2575,
            'crop' => 860,
            'pop' => 1,
            'cp' => 15,
            'effect' => 59.05,
            'time' => 12560
        ),
        array(
            'wood' => 2420,
            'clay' => 3520,
            'iron' => 3300,
            'crop' => 1100,
            'pop' => 1,
            'cp' => 18,
            'effect' => 53.14,
            'time' => 14880
        ),
        array(
            'wood' => 3095,
            'clay' => 4505,
            'iron' => 4220,
            'crop' => 1405,
            'pop' => 1,
            'cp' => 21,
            'effect' => 47.83,
            'time' => 17560
        ),
        array(
            'wood' => 3965,
            'clay' => 5765,
            'iron' => 5405,
            'crop' => 1800,
            'pop' => 1,
            'cp' => 26,
            'effect' => 43.05,
            'time' => 20660
        ),
        array(
            'wood' => 5075,
            'clay' => 7380,
            'iron' => 6920,
            'crop' => 2305,
            'pop' => 1,
            'cp' => 31,
            'effect' => 38.74,
            'time' => 24270
        ),
        array(
            'wood' => 6495,
            'clay' => 9445,
            'iron' => 8855,
            'crop' => 2950,
            'pop' => 2,
            'cp' => 37,
            'effect' => 34.87,
            'time' => 28450
        ),
        array(
            'wood' => 8310,
            'clay' => 12090,
            'iron' => 11335,
            'crop' => 3780,
            'pop' => 2,
            'cp' => 45,
            'effect' => 31.38,
            'time' => 33306
        ),
        array(
            'wood' => 10640,
            'clay' => 15475,
            'iron' => 14505,
            'crop' => 4835,
            'pop' => 2,
            'cp' => 53,
            'effect' => 28.24,
            'time' => 38935
        ),
        array(
            'wood' => 13615,
            'clay' => 19805,
            'iron' => 18570,
            'crop' => 6190,
            'pop' => 2,
            'cp' => 64,
            'effect' => 25.42,
            'time' => 45465
        ),
        array(
            'wood' => 17430,
            'clay' => 25355,
            'iron' => 23770,
            'crop' => 7925,
            'pop' => 2,
            'cp' => 77,
            'effect' => 22.88,
            'time' => 53039
        ),
        array(
            'wood' => 22310,
            'clay' => 32450,
            'iron' => 30425,
            'crop' => 10140,
            'pop' => 2,
            'cp' => 92,
            'effect' => 20.59,
            'time' => 61825
        ),
        array(
            'wood' => 28560,
            'clay' => 41540,
            'iron' => 38940,
            'crop' => 12980,
            'pop' => 2,
            'cp' => 111,
            'effect' => 18.53,
            'time' => 72018
        ),
        array(
            'wood' => 36555,
            'clay' => 53170,
            'iron' => 49845,
            'crop' => 16615,
            'pop' => 2,
            'cp' => 133,
            'effect' => 16.68,
            'time' => 83840
        ),
        array(
            'wood' => 46790,
            'clay' => 68055,
            'iron' => 63805,
            'crop' => 21270,
            'pop' => 2,
            'cp' => 160,
            'effect' => 15.01,
            'time' => 97555
        ),
        array(
            'wood' => 59890,
            'clay' => 87110,
            'iron' => 81675,
            'crop' => 27225,
            'pop' => 2,
            'cp' => 192,
            'effect' => 13.51,
            'time' => 113464
        )
    );
    public static $bid27 = array(
        array(
            'wood' => 720,
            'clay' => 685,
            'iron' => 645,
            'crop' => 250,
            'pop' => 4,
            'cp' => 7,
            'effect' => 0,
            'time' => 2040
        ),
        array(
            'wood' => 720,
            'clay' => 685,
            'iron' => 645,
            'crop' => 250,
            'pop' => 4,
            'cp' => 7,
            'effect' => 100,
            'time' => 2040
        ),
        array(
            'wood' => 1815,
            'clay' => 1725,
            'iron' => 1625,
            'crop' => 625,
            'pop' => 2,
            'cp' => 9,
            'effect' => 200,
            'time' => 2520
        ),
        array(
            'wood' => 2285,
            'clay' => 2175,
            'iron' => 2050,
            'crop' => 785,
            'pop' => 2,
            'cp' => 10,
            'effect' => 300,
            'time' => 3120
        ),
        array(
            'wood' => 2880,
            'clay' => 2740,
            'iron' => 2580,
            'crop' => 990,
            'pop' => 2,
            'cp' => 12,
            'effect' => 400,
            'time' => 4080
        ),
        array(
            'wood' => 3630,
            'clay' => 3455,
            'iron' => 3250,
            'crop' => 1250,
            'pop' => 2,
            'cp' => 15,
            'effect' => 500,
            'time' => 6780
        ),
        array(
            'wood' => 4575,
            'clay' => 4350,
            'iron' => 4095,
            'crop' => 1570,
            'pop' => 3,
            'cp' => 18,
            'effect' => 600,
            'time' => 12900
        ),
        array(
            'wood' => 5760,
            'clay' => 5480,
            'iron' => 5160,
            'crop' => 1980,
            'pop' => 3,
            'cp' => 21,
            'effect' => 700,
            'time' => 18600
        ),
        array(
            'wood' => 7260,
            'clay' => 6905,
            'iron' => 6505,
            'crop' => 2495,
            'pop' => 3,
            'cp' => 26,
            'effect' => 800,
            'time' => 24600
        ),
        array(
            'wood' => 9150,
            'clay' => 8705,
            'iron' => 8195,
            'crop' => 3145,
            'pop' => 3,
            'cp' => 31,
            'effect' => 900,
            'time' => 29400
        ),
        array(
            'wood' => 11525,
            'clay' => 10965,
            'iron' => 10325,
            'crop' => 3960,
            'pop' => 3,
            'cp' => 37,
            'effect' => 1000,
            'time' => 33600
        ),
        array(
            'wood' => 14525,
            'clay' => 13815,
            'iron' => 13010,
            'crop' => 4990,
            'pop' => 3,
            'cp' => 45,
            'effect' => 1250,
            'time' => 40500
        ),
        array(
            'wood' => 18300,
            'clay' => 17410,
            'iron' => 16395,
            'crop' => 6290,
            'pop' => 3,
            'cp' => 53,
            'effect' => 1500,
            'time' => 43800
        ),
        array(
            'wood' => 23055,
            'clay' => 21935,
            'iron' => 20655,
            'crop' => 7925,
            'pop' => 3,
            'cp' => 64,
            'effect' => 1750,
            'time' => 55500
        ),
        array(
            'wood' => 29050,
            'clay' => 27640,
            'iron' => 26025,
            'crop' => 9985,
            'pop' => 3,
            'cp' => 77,
            'effect' => 2000,
            'time' => 62400
        ),
        array(
            'wood' => 36605,
            'clay' => 34825,
            'iron' => 32795,
            'crop' => 2585,
            'pop' => 3,
            'cp' => 92,
            'effect' => 2250,
            'time' => 72000
        ),
        array(
            'wood' => 46125,
            'clay' => 43880,
            'iron' => 41320,
            'crop' => 15855,
            'pop' => 4,
            'cp' => 111,
            'effect' => 2500,
            'time' => 80400
        ),
        array(
            'wood' => 58115,
            'clay' => 55290,
            'iron' => 52060,
            'crop' => 19975,
            'pop' => 4,
            'cp' => 133,
            'effect' => 2750,
            'time' => 92700
        ),
        array(
            'wood' => 73225,
            'clay' => 69665,
            'iron' => 65600,
            'crop' => 25170,
            'pop' => 4,
            'cp' => 160,
            'effect' => 3000,
            'time' => 109200
        ),
        array(
            'wood' => 92265,
            'clay' => 87780,
            'iron' => 82655,
            'crop' => 31715,
            'pop' => 4,
            'cp' => 192,
            'effect' => 3500,
            'time' => 125700
        ),
        array(
            'wood' => 116255,
            'clay' => 110600,
            'iron' => 104145,
            'crop' => 39960,
            'pop' => 4,
            'cp' => 230,
            'effect' => 1,
            'time' => 142200
        )
    );
    public static $bid28 = array(
        array(
            'wood' => 1400,
            'clay' => 1330,
            'iron' => 1200,
            'crop' => 400,
            'pop' => 3,
            'cp' => 4,
            'effect' => 110,
            'time' => 40
        ),
        array(
            'wood' => 1400,
            'clay' => 1330,
            'iron' => 1200,
            'crop' => 400,
            'pop' => 3,
            'cp' => 4,
            'effect' => 110,
            'time' => 3000
        ),
        array(
            'wood' => 1790,
            'clay' => 1700,
            'iron' => 1535,
            'crop' => 510,
            'pop' => 2,
            'cp' => 4,
            'effect' => 120,
            'time' => 3780
        ),
        array(
            'wood' => 2295,
            'clay' => 2180,
            'iron' => 1965,
            'crop' => 655,
            'pop' => 2,
            'cp' => 5,
            'effect' => 130,
            'time' => 4680
        ),
        array(
            'wood' => 2935,
            'clay' => 2790,
            'iron' => 2515,
            'crop' => 840,
            'pop' => 2,
            'cp' => 6,
            'effect' => 140,
            'time' => 5730
        ),
        array(
            'wood' => 3760,
            'clay' => 3570,
            'iron' => 3220,
            'crop' => 1075,
            'pop' => 2,
            'cp' => 7,
            'effect' => 150,
            'time' => 6950
        ),
        array(
            'wood' => 4810,
            'clay' => 4570,
            'iron' => 4125,
            'crop' => 1375,
            'pop' => 2,
            'cp' => 9,
            'effect' => 160,
            'time' => 8360
        ),
        array(
            'wood' => 6155,
            'clay' => 5850,
            'iron' => 5280,
            'crop' => 1760,
            'pop' => 2,
            'cp' => 11,
            'effect' => 170,
            'time' => 10000
        ),
        array(
            'wood' => 7880,
            'clay' => 7485,
            'iron' => 6755,
            'crop' => 2250,
            'pop' => 2,
            'cp' => 13,
            'effect' => 180,
            'time' => 11900
        ),
        array(
            'wood' => 10090,
            'clay' => 9585,
            'iron' => 8645,
            'crop' => 2880,
            'pop' => 2,
            'cp' => 15,
            'effect' => 190,
            'time' => 14110
        ),
        array(
            'wood' => 12915,
            'clay' => 12265,
            'iron' => 11070,
            'crop' => 3690,
            'pop' => 2,
            'cp' => 19,
            'effect' => 200,
            'time' => 16660
        ),
        array(
            'wood' => 16530,
            'clay' => 15700,
            'iron' => 14165,
            'crop' => 4720,
            'pop' => 3,
            'cp' => 22,
            'effect' => 210,
            'time' => 19630
        ),
        array(
            'wood' => 21155,
            'clay' => 20100,
            'iron' => 18135,
            'crop' => 6045,
            'pop' => 3,
            'cp' => 27,
            'effect' => 220,
            'time' => 23070
        ),
        array(
            'wood' => 27080,
            'clay' => 25725,
            'iron' => 23210,
            'crop' => 7735,
            'pop' => 3,
            'cp' => 32,
            'effect' => 230,
            'time' => 27060
        ),
        array(
            'wood' => 34660,
            'clay' => 32930,
            'iron' => 29710,
            'crop' => 9905,
            'pop' => 3,
            'cp' => 39,
            'effect' => 240,
            'time' => 31690
        ),
        array(
            'wood' => 44370,
            'clay' => 42150,
            'iron' => 38030,
            'crop' => 12675,
            'pop' => 3,
            'cp' => 46,
            'effect' => 250,
            'time' => 37060
        ),
        array(
            'wood' => 56790,
            'clay' => 53950,
            'iron' => 48680,
            'crop' => 16225,
            'pop' => 3,
            'cp' => 55,
            'effect' => 260,
            'time' => 43290
        ),
        array(
            'wood' => 72690,
            'clay' => 69060,
            'iron' => 62310,
            'crop' => 20770,
            'pop' => 3,
            'cp' => 67,
            'effect' => 270,
            'time' => 50520
        ),
        array(
            'wood' => 93045,
            'clay' => 88395,
            'iron' => 79755,
            'crop' => 26585,
            'pop' => 3,
            'cp' => 80,
            'effect' => 280,
            'time' => 58900
        ),
        array(
            'wood' => 119100,
            'clay' => 113145,
            'iron' => 102085,
            'crop' => 34030,
            'pop' => 3,
            'cp' => 96,
            'effect' => 290,
            'time' => 68630
        ),
        array(
            'wood' => 152445,
            'clay' => 144825,
            'iron' => 130670,
            'crop' => 43555,
            'pop' => 3,
            'cp' => 115,
            'effect' => 300,
            'time' => 79910
        )
    );
    public static $bid29 = array(
        array(
            'wood' => 630,
            'clay' => 420,
            'iron' => 780,
            'crop' => 360,
            'pop' => 4,
            'cp' => 1,
            'effect' => 100,
            'time' => 20
        ),
        array(
            'wood' => 630,
            'clay' => 420,
            'iron' => 780,
            'crop' => 360,
            'pop' => 4,
            'cp' => 1,
            'effect' => 100,
            'time' => 2000
        ),
        array(
            'wood' => 805,
            'clay' => 540,
            'iron' => 1000,
            'crop' => 460,
            'pop' => 2,
            'cp' => 1,
            'effect' => 90,
            'time' => 2619
        ),
        array(
            'wood' => 1030,
            'clay' => 690,
            'iron' => 1280,
            'crop' => 590,
            'pop' => 2,
            'cp' => 2,
            'effect' => 81,
            'time' => 3339
        ),
        array(
            'wood' => 1320,
            'clay' => 880,
            'iron' => 1635,
            'crop' => 755,
            'pop' => 2,
            'cp' => 2,
            'effect' => 72.9,
            'time' => 4170
        ),
        array(
            'wood' => 1690,
            'clay' => 1125,
            'iron' => 2095,
            'crop' => 965,
            'pop' => 2,
            'cp' => 2,
            'effect' => 65.61,
            'time' => 5140
        ),
        array(
            'wood' => 2165,
            'clay' => 1445,
            'iron' => 2680,
            'crop' => 1235,
            'pop' => 3,
            'cp' => 3,
            'effect' => 59.05,
            'time' => 6260
        ),
        array(
            'wood' => 2770,
            'clay' => 1845,
            'iron' => 3430,
            'crop' => 1585,
            'pop' => 3,
            'cp' => 4,
            'effect' => 53.14,
            'time' => 7570
        ),
        array(
            'wood' => 3545,
            'clay' => 2370,
            'iron' => 4395,
            'crop' => 2025,
            'pop' => 3,
            'cp' => 4,
            'effect' => 47.83,
            'time' => 9080
        ),
        array(
            'wood' => 4540,
            'clay' => 3025,
            'iron' => 5620,
            'crop' => 2595,
            'pop' => 3,
            'cp' => 5,
            'effect' => 43.05,
            'time' => 10830
        ),
        array(
            'wood' => 5810,
            'clay' => 3875,
            'iron' => 7195,
            'crop' => 3320,
            'pop' => 3,
            'cp' => 6,
            'effect' => 38.74,
            'time' => 12860
        ),
        array(
            'wood' => 7440,
            'clay' => 4960,
            'iron' => 9210,
            'crop' => 4250,
            'pop' => 3,
            'cp' => 7,
            'effect' => 34.87,
            'time' => 15220
        ),
        array(
            'wood' => 9520,
            'clay' => 6345,
            'iron' => 11785,
            'crop' => 5440,
            'pop' => 3,
            'cp' => 9,
            'effect' => 31.38,
            'time' => 17950
        ),
        array(
            'wood' => 12185,
            'clay' => 8125,
            'iron' => 15085,
            'crop' => 6965,
            'pop' => 3,
            'cp' => 11,
            'effect' => 28.24,
            'time' => 21130
        ),
        array(
            'wood' => 15600,
            'clay' => 10400,
            'iron' => 19310,
            'crop' => 8915,
            'pop' => 3,
            'cp' => 13,
            'effect' => 25.42,
            'time' => 24810
        ),
        array(
            'wood' => 19965,
            'clay' => 13310,
            'iron' => 24720,
            'crop' => 11410,
            'pop' => 3,
            'cp' => 15,
            'effect' => 22.88,
            'time' => 29080
        ),
        array(
            'wood' => 25555,
            'clay' => 17035,
            'iron' => 31640,
            'crop' => 14605,
            'pop' => 4,
            'cp' => 18,
            'effect' => 20.59,
            'time' => 34030
        ),
        array(
            'wood' => 32710,
            'clay' => 21810,
            'iron' => 40500,
            'crop' => 18690,
            'pop' => 4,
            'cp' => 22,
            'effect' => 18.53,
            'time' => 39770
        ),
        array(
            'wood' => 41870,
            'clay' => 27915,
            'iron' => 51840,
            'crop' => 23925,
            'pop' => 4,
            'cp' => 27,
            'effect' => 16.68,
            'time' => 46437
        ),
        array(
            'wood' => 53595,
            'clay' => 35730,
            'iron' => 66355,
            'crop' => 30625,
            'pop' => 4,
            'cp' => 32,
            'effect' => 15.01,
            'time' => 54170
        ),
        array(
            'wood' => 68600,
            'clay' => 45735,
            'iron' => 84935,
            'crop' => 39200,
            'pop' => 4,
            'cp' => 38,
            'effect' => 13.51,
            'time' => 63130
        )
    );
    public static $bid30 = array(
        array(
            'wood' => 780,
            'clay' => 420,
            'iron' => 660,
            'crop' => 300,
            'pop' => 5,
            'cp' => 2,
            'effect' => 100,
            'time' => 22
        ),
        array(
            'wood' => 780,
            'clay' => 420,
            'iron' => 660,
            'crop' => 300,
            'pop' => 5,
            'cp' => 2,
            'effect' => 100,
            'time' => 2200
        ),
        array(
            'wood' => 1000,
            'clay' => 540,
            'iron' => 845,
            'crop' => 385,
            'pop' => 3,
            'cp' => 3,
            'effect' => 90,
            'time' => 2850
        ),
        array(
            'wood' => 1280,
            'clay' => 690,
            'iron' => 1080,
            'crop' => 490,
            'pop' => 3,
            'cp' => 3,
            'effect' => 81,
            'time' => 3610
        ),
        array(
            'wood' => 1635,
            'clay' => 880,
            'iron' => 1385,
            'crop' => 630,
            'pop' => 3,
            'cp' => 4,
            'effect' => 72.9,
            'time' => 4490
        ),
        array(
            'wood' => 2095,
            'clay' => 1125,
            'iron' => 1770,
            'crop' => 805,
            'pop' => 3,
            'cp' => 5,
            'effect' => 65.61,
            'time' => 5500
        ),
        array(
            'wood' => 2680,
            'clay' => 1445,
            'iron' => 2270,
            'crop' => 1030,
            'pop' => 3,
            'cp' => 6,
            'effect' => 59.05,
            'time' => 6680
        ),
        array(
            'wood' => 3430,
            'clay' => 1845,
            'iron' => 2905,
            'crop' => 1320,
            'pop' => 3,
            'cp' => 7,
            'effect' => 53.14,
            'time' => 8050
        ),
        array(
            'wood' => 4390,
            'clay' => 2365,
            'iron' => 3715,
            'crop' => 1690,
            'pop' => 3,
            'cp' => 9,
            'effect' => 47.83,
            'time' => 9640
        ),
        array(
            'wood' => 5620,
            'clay' => 3025,
            'iron' => 4755,
            'crop' => 2160,
            'pop' => 3,
            'cp' => 10,
            'effect' => 43.05,
            'time' => 11480
        ),
        array(
            'wood' => 7195,
            'clay' => 3875,
            'iron' => 6085,
            'crop' => 2765,
            'pop' => 3,
            'cp' => 12,
            'effect' => 38.74,
            'time' => 13620
        ),
        array(
            'wood' => 9210,
            'clay' => 4960,
            'iron' => 7790,
            'crop' => 3540,
            'pop' => 4,
            'cp' => 15,
            'effect' => 34.87,
            'time' => 16100
        ),
        array(
            'wood' => 11785,
            'clay' => 6345,
            'iron' => 9975,
            'crop' => 4535,
            'pop' => 4,
            'cp' => 18,
            'effect' => 31.38,
            'time' => 18980
        ),
        array(
            'wood' => 15085,
            'clay' => 8125,
            'iron' => 12765,
            'crop' => 5805,
            'pop' => 4,
            'cp' => 21,
            'effect' => 28.24,
            'time' => 22310
        ),
        array(
            'wood' => 19310,
            'clay' => 10400,
            'iron' => 16340,
            'crop' => 7430,
            'pop' => 4,
            'cp' => 26,
            'effect' => 25.42,
            'time' => 26180
        ),
        array(
            'wood' => 24720,
            'clay' => 13310,
            'iron' => 20915,
            'crop' => 9505,
            'pop' => 4,
            'cp' => 31,
            'effect' => 22.88,
            'time' => 30670
        ),
        array(
            'wood' => 31640,
            'clay' => 17035,
            'iron' => 26775,
            'crop' => 12170,
            'pop' => 4,
            'cp' => 37,
            'effect' => 20.59,
            'time' => 35880
        ),
        array(
            'wood' => 40500,
            'clay' => 21810,
            'iron' => 34270,
            'crop' => 15575,
            'pop' => 4,
            'cp' => 44,
            'effect' => 18.53,
            'time' => 41920
        ),
        array(
            'wood' => 51840,
            'clay' => 27915,
            'iron' => 43865,
            'crop' => 19940,
            'pop' => 4,
            'cp' => 53,
            'effect' => 16.68,
            'time' => 48930
        ),
        array(
            'wood' => 66355,
            'clay' => 35730,
            'iron' => 56145,
            'crop' => 25520,
            'pop' => 4,
            'cp' => 64,
            'effect' => 15.01,
            'time' => 57060
        ),
        array(
            'wood' => 84935,
            'clay' => 45735,
            'iron' => 71870,
            'crop' => 32665,
            'pop' => 4,
            'cp' => 77,
            'effect' => 13.51,
            'time' => 66490
        )
    );
    public static $bid31 = array(
        array(
            'wood' => 70,
            'clay' => 90,
            'iron' => 170,
            'crop' => 70,
            'pop' => 0,
            'cp' => 1,
            'effect' => 3,
            'time' => 20
        ),
        array(
            'wood' => 70,
            'clay' => 90,
            'iron' => 170,
            'crop' => 70,
            'pop' => 0,
            'cp' => 1,
            'effect' => 3,
            'time' => 2000
        ),
        array(
            'wood' => 90,
            'clay' => 115,
            'iron' => 220,
            'crop' => 90,
            'pop' => 0,
            'cp' => 1,
            'effect' => 6,
            'time' => 2620
        ),
        array(
            'wood' => 115,
            'clay' => 145,
            'iron' => 280,
            'crop' => 115,
            'pop' => 0,
            'cp' => 2,
            'effect' => 9,
            'time' => 3340
        ),
        array(
            'wood' => 145,
            'clay' => 190,
            'iron' => 355,
            'crop' => 145,
            'pop' => 0,
            'cp' => 2,
            'effect' => 13,
            'time' => 4170
        ),
        array(
            'wood' => 190,
            'clay' => 240,
            'iron' => 455,
            'crop' => 190,
            'pop' => 0,
            'cp' => 2,
            'effect' => 16,
            'time' => 5140
        ),
        array(
            'wood' => 240,
            'clay' => 310,
            'iron' => 585,
            'crop' => 240,
            'pop' => 1,
            'cp' => 3,
            'effect' => 19,
            'time' => 6260
        ),
        array(
            'wood' => 310,
            'clay' => 395,
            'iron' => 750,
            'crop' => 310,
            'pop' => 1,
            'cp' => 4,
            'effect' => 23,
            'time' => 7570
        ),
        array(
            'wood' => 395,
            'clay' => 505,
            'iron' => 955,
            'crop' => 395,
            'pop' => 1,
            'cp' => 4,
            'effect' => 27,
            'time' => 9080
        ),
        array(
            'wood' => 505,
            'clay' => 650,
            'iron' => 1225,
            'crop' => 505,
            'pop' => 1,
            'cp' => 5,
            'effect' => 30,
            'time' => 10830
        ),
        array(
            'wood' => 645,
            'clay' => 830,
            'iron' => 1570,
            'crop' => 645,
            'pop' => 1,
            'cp' => 6,
            'effect' => 34,
            'time' => 12860
        ),
        array(
            'wood' => 825,
            'clay' => 1065,
            'iron' => 2005,
            'crop' => 825,
            'pop' => 1,
            'cp' => 7,
            'effect' => 38,
            'time' => 15220
        ),
        array(
            'wood' => 1060,
            'clay' => 1360,
            'iron' => 2570,
            'crop' => 1060,
            'pop' => 1,
            'cp' => 9,
            'effect' => 43,
            'time' => 17950
        ),
        array(
            'wood' => 1355,
            'clay' => 1740,
            'iron' => 3290,
            'crop' => 1355,
            'pop' => 1,
            'cp' => 11,
            'effect' => 47,
            'time' => 21130
        ),
        array(
            'wood' => 1735,
            'clay' => 2230,
            'iron' => 4210,
            'crop' => 1735,
            'pop' => 1,
            'cp' => 13,
            'effect' => 51,
            'time' => 24810
        ),
        array(
            'wood' => 2220,
            'clay' => 2850,
            'iron' => 5390,
            'crop' => 2220,
            'pop' => 1,
            'cp' => 15,
            'effect' => 56,
            'time' => 29080
        ),
        array(
            'wood' => 2840,
            'clay' => 3650,
            'iron' => 6895,
            'crop' => 2840,
            'pop' => 2,
            'cp' => 18,
            'effect' => 60,
            'time' => 34030
        ),
        array(
            'wood' => 3635,
            'clay' => 4675,
            'iron' => 8825,
            'crop' => 3635,
            'pop' => 2,
            'cp' => 22,
            'effect' => 65,
            'time' => 39770
        ),
        array(
            'wood' => 4650,
            'clay' => 5980,
            'iron' => 11300,
            'crop' => 4650,
            'pop' => 2,
            'cp' => 27,
            'effect' => 70,
            'time' => 46440
        ),
        array(
            'wood' => 5955,
            'clay' => 7655,
            'iron' => 14460,
            'crop' => 5955,
            'pop' => 2,
            'cp' => 32,
            'effect' => 75,
            'time' => 54170
        ),
        array(
            'wood' => 7620,
            'clay' => 9800,
            'iron' => 18510,
            'crop' => 7620,
            'pop' => 2,
            'cp' => 38,
            'effect' => 81,
            'time' => 63130
        )
    );
    public static $bid32 = array(
        array(
            'wood' => 120,
            'clay' => 200,
            'iron' => 0,
            'crop' => 80,
            'pop' => 0,
            'cp' => 1,
            'effect' => 2,
            'time' => 20
        ),
        array(
            'wood' => 120,
            'clay' => 200,
            'iron' => 0,
            'crop' => 80,
            'pop' => 0,
            'cp' => 1,
            'effect' => 2,
            'time' => 2000
        ),
        array(
            'wood' => 155,
            'clay' => 255,
            'iron' => 0,
            'crop' => 100,
            'pop' => 0,
            'cp' => 1,
            'effect' => 4,
            'time' => 2620
        ),
        array(
            'wood' => 195,
            'clay' => 330,
            'iron' => 0,
            'crop' => 130,
            'pop' => 0,
            'cp' => 2,
            'effect' => 6,
            'time' => 3340
        ),
        array(
            'wood' => 250,
            'clay' => 420,
            'iron' => 0,
            'crop' => 170,
            'pop' => 0,
            'cp' => 2,
            'effect' => 8,
            'time' => 4170
        ),
        array(
            'wood' => 320,
            'clay' => 535,
            'iron' => 0,
            'crop' => 215,
            'pop' => 0,
            'cp' => 2,
            'effect' => 10,
            'time' => 5140
        ),
        array(
            'wood' => 410,
            'clay' => 685,
            'iron' => 0,
            'crop' => 275,
            'pop' => 1,
            'cp' => 3,
            'effect' => 13,
            'time' => 6260
        ),
        array(
            'wood' => 530,
            'clay' => 880,
            'iron' => 0,
            'crop' => 350,
            'pop' => 1,
            'cp' => 4,
            'effect' => 15,
            'time' => 7570
        ),
        array(
            'wood' => 675,
            'clay' => 1125,
            'iron' => 0,
            'crop' => 450,
            'pop' => 1,
            'cp' => 4,
            'effect' => 17,
            'time' => 9080
        ),
        array(
            'wood' => 865,
            'clay' => 1440,
            'iron' => 0,
            'crop' => 575,
            'pop' => 1,
            'cp' => 5,
            'effect' => 20,
            'time' => 10830
        ),
        array(
            'wood' => 1105,
            'clay' => 1845,
            'iron' => 0,
            'crop' => 740,
            'pop' => 1,
            'cp' => 6,
            'effect' => 22,
            'time' => 12860
        ),
        array(
            'wood' => 1415,
            'clay' => 2360,
            'iron' => 0,
            'crop' => 945,
            'pop' => 1,
            'cp' => 7,
            'effect' => 24,
            'time' => 15220
        ),
        array(
            'wood' => 1815,
            'clay' => 3020,
            'iron' => 0,
            'crop' => 1210,
            'pop' => 1,
            'cp' => 9,
            'effect' => 27,
            'time' => 17950
        ),
        array(
            'wood' => 2320,
            'clay' => 3870,
            'iron' => 0,
            'crop' => 1545,
            'pop' => 1,
            'cp' => 11,
            'effect' => 29,
            'time' => 21130
        ),
        array(
            'wood' => 2970,
            'clay' => 4950,
            'iron' => 0,
            'crop' => 1980,
            'pop' => 1,
            'cp' => 13,
            'effect' => 32,
            'time' => 24810
        ),
        array(
            'wood' => 3805,
            'clay' => 6340,
            'iron' => 0,
            'crop' => 2535,
            'pop' => 1,
            'cp' => 15,
            'effect' => 35,
            'time' => 29080
        ),
        array(
            'wood' => 4870,
            'clay' => 8115,
            'iron' => 0,
            'crop' => 3245,
            'pop' => 2,
            'cp' => 18,
            'effect' => 37,
            'time' => 34030
        ),
        array(
            'wood' => 6230,
            'clay' => 10385,
            'iron' => 0,
            'crop' => 4155,
            'pop' => 2,
            'cp' => 22,
            'effect' => 40,
            'time' => 39770
        ),
        array(
            'wood' => 7975,
            'clay' => 13290,
            'iron' => 0,
            'crop' => 5315,
            'pop' => 2,
            'cp' => 27,
            'effect' => 43,
            'time' => 46440
        ),
        array(
            'wood' => 10210,
            'clay' => 17015,
            'iron' => 0,
            'crop' => 6805,
            'pop' => 2,
            'cp' => 32,
            'effect' => 46,
            'time' => 54170
        ),
        array(
            'wood' => 13065,
            'clay' => 21780,
            'iron' => 0,
            'crop' => 8710,
            'pop' => 2,
            'cp' => 38,
            'effect' => 49,
            'time' => 63130
        )
    );
    public static $bid33 = array(
        array(
            'wood' => 160,
            'clay' => 100,
            'iron' => 80,
            'crop' => 60,
            'pop' => 0,
            'cp' => 1,
            'effect' => 2,
            'time' => 20
        ),
        array(
            'wood' => 160,
            'clay' => 100,
            'iron' => 80,
            'crop' => 60,
            'pop' => 0,
            'cp' => 1,
            'effect' => 2,
            'time' => 2000
        ),
        array(
            'wood' => 205,
            'clay' => 130,
            'iron' => 100,
            'crop' => 75,
            'pop' => 0,
            'cp' => 1,
            'effect' => 5,
            'time' => 2620
        ),
        array(
            'wood' => 260,
            'clay' => 165,
            'iron' => 130,
            'crop' => 100,
            'pop' => 0,
            'cp' => 2,
            'effect' => 8,
            'time' => 3340
        ),
        array(
            'wood' => 335,
            'clay' => 210,
            'iron' => 170,
            'crop' => 125,
            'pop' => 0,
            'cp' => 2,
            'effect' => 10,
            'time' => 4170
        ),
        array(
            'wood' => 430,
            'clay' => 270,
            'iron' => 215,
            'crop' => 160,
            'pop' => 0,
            'cp' => 2,
            'effect' => 13,
            'time' => 5140
        ),
        array(
            'wood' => 550,
            'clay' => 345,
            'iron' => 275,
            'crop' => 205,
            'pop' => 1,
            'cp' => 3,
            'effect' => 16,
            'time' => 6260
        ),
        array(
            'wood' => 705,
            'clay' => 440,
            'iron' => 350,
            'crop' => 265,
            'pop' => 1,
            'cp' => 4,
            'effect' => 19,
            'time' => 7570
        ),
        array(
            'wood' => 900,
            'clay' => 565,
            'iron' => 450,
            'crop' => 340,
            'pop' => 1,
            'cp' => 4,
            'effect' => 22,
            'time' => 9080
        ),
        array(
            'wood' => 1155,
            'clay' => 720,
            'iron' => 575,
            'crop' => 430,
            'pop' => 1,
            'cp' => 5,
            'effect' => 25,
            'time' => 10830
        ),
        array(
            'wood' => 1475,
            'clay' => 920,
            'iron' => 740,
            'crop' => 555,
            'pop' => 1,
            'cp' => 6,
            'effect' => 28,
            'time' => 12860
        ),
        array(
            'wood' => 1890,
            'clay' => 1180,
            'iron' => 945,
            'crop' => 710,
            'pop' => 1,
            'cp' => 7,
            'effect' => 31,
            'time' => 15220
        ),
        array(
            'wood' => 2420,
            'clay' => 1510,
            'iron' => 1210,
            'crop' => 905,
            'pop' => 1,
            'cp' => 9,
            'effect' => 34,
            'time' => 17950
        ),
        array(
            'wood' => 3095,
            'clay' => 1935,
            'iron' => 1545,
            'crop' => 1160,
            'pop' => 1,
            'cp' => 11,
            'effect' => 38,
            'time' => 21130
        ),
        array(
            'wood' => 3960,
            'clay' => 2475,
            'iron' => 1980,
            'crop' => 1485,
            'pop' => 1,
            'cp' => 13,
            'effect' => 41,
            'time' => 24810
        ),
        array(
            'wood' => 5070,
            'clay' => 3170,
            'iron' => 2535,
            'crop' => 1900,
            'pop' => 1,
            'cp' => 15,
            'effect' => 45,
            'time' => 29080
        ),
        array(
            'wood' => 6490,
            'clay' => 4055,
            'iron' => 3245,
            'crop' => 2435,
            'pop' => 2,
            'cp' => 18,
            'effect' => 48,
            'time' => 34030
        ),
        array(
            'wood' => 8310,
            'clay' => 5190,
            'iron' => 4155,
            'crop' => 3115,
            'pop' => 2,
            'cp' => 22,
            'effect' => 52,
            'time' => 39770
        ),
        array(
            'wood' => 10635,
            'clay' => 6645,
            'iron' => 5315,
            'crop' => 3990,
            'pop' => 2,
            'cp' => 27,
            'effect' => 56,
            'time' => 46440
        ),
        array(
            'wood' => 13610,
            'clay' => 8505,
            'iron' => 6805,
            'crop' => 5105,
            'pop' => 2,
            'cp' => 32,
            'effect' => 60,
            'time' => 54170
        ),
        array(
            'wood' => 17420,
            'clay' => 10890,
            'iron' => 8710,
            'crop' => 6535,
            'pop' => 2,
            'cp' => 38,
            'effect' => 64,
            'time' => 63130
        )
    );
    public static $bid34 = array(
        array(
            'wood' => 155,
            'clay' => 130,
            'iron' => 125,
            'crop' => 70,
            'pop' => 2,
            'cp' => 1,
            'effect' => 110,
            'time' => 22
        ),
        array(
            'wood' => 155,
            'clay' => 130,
            'iron' => 125,
            'crop' => 70,
            'pop' => 2,
            'cp' => 1,
            'effect' => 110,
            'time' => 2200
        ),
        array(
            'wood' => 200,
            'clay' => 165,
            'iron' => 160,
            'crop' => 90,
            'pop' => 1,
            'cp' => 1,
            'effect' => 120,
            'time' => 3150
        ),
        array(
            'wood' => 255,
            'clay' => 215,
            'iron' => 205,
            'crop' => 115,
            'pop' => 1,
            'cp' => 2,
            'effect' => 130,
            'time' => 4260
        ),
        array(
            'wood' => 325,
            'clay' => 275,
            'iron' => 260,
            'crop' => 145,
            'pop' => 1,
            'cp' => 2,
            'effect' => 140,
            'time' => 5540
        ),
        array(
            'wood' => 415,
            'clay' => 350,
            'iron' => 335,
            'crop' => 190,
            'pop' => 1,
            'cp' => 2,
            'effect' => 150,
            'time' => 7020
        ),
        array(
            'wood' => 535,
            'clay' => 445,
            'iron' => 430,
            'crop' => 240,
            'pop' => 2,
            'cp' => 3,
            'effect' => 160,
            'time' => 8750
        ),
        array(
            'wood' => 680,
            'clay' => 570,
            'iron' => 550,
            'crop' => 310,
            'pop' => 2,
            'cp' => 4,
            'effect' => 170,
            'time' => 10750
        ),
        array(
            'wood' => 875,
            'clay' => 730,
            'iron' => 705,
            'crop' => 395,
            'pop' => 2,
            'cp' => 4,
            'effect' => 180,
            'time' => 13070
        ),
        array(
            'wood' => 1115,
            'clay' => 935,
            'iron' => 900,
            'crop' => 505,
            'pop' => 2,
            'cp' => 5,
            'effect' => 190,
            'time' => 15760
        ),
        array(
            'wood' => 1430,
            'clay' => 1200,
            'iron' => 1155,
            'crop' => 645,
            'pop' => 2,
            'cp' => 6,
            'effect' => 200,
            'time' => 18880
        ),
        array(
            'wood' => 1830,
            'clay' => 1535,
            'iron' => 1475,
            'crop' => 825,
            'pop' => 2,
            'cp' => 7,
            'effect' => 210,
            'time' => 22500
        ),
        array(
            'wood' => 2340,
            'clay' => 1965,
            'iron' => 1890,
            'crop' => 1060,
            'pop' => 2,
            'cp' => 9,
            'effect' => 220,
            'time' => 26700
        ),
        array(
            'wood' => 3000,
            'clay' => 2515,
            'iron' => 2420,
            'crop' => 1355,
            'pop' => 2,
            'cp' => 11,
            'effect' => 230,
            'time' => 31570
        ),
        array(
            'wood' => 3840,
            'clay' => 3220,
            'iron' => 3095,
            'crop' => 1735,
            'pop' => 2,
            'cp' => 13,
            'effect' => 240,
            'time' => 37220
        ),
        array(
            'wood' => 4910,
            'clay' => 4120,
            'iron' => 3960,
            'crop' => 2220,
            'pop' => 2,
            'cp' => 15,
            'effect' => 250,
            'time' => 43780
        ),
        array(
            'wood' => 6290,
            'clay' => 5275,
            'iron' => 5070,
            'crop' => 2840,
            'pop' => 3,
            'cp' => 18,
            'effect' => 260,
            'time' => 51380
        ),
        array(
            'wood' => 8050,
            'clay' => 6750,
            'iron' => 6490,
            'crop' => 3635,
            'pop' => 3,
            'cp' => 22,
            'effect' => 270,
            'time' => 60200
        ),
        array(
            'wood' => 10300,
            'clay' => 8640,
            'iron' => 8310,
            'crop' => 4650,
            'pop' => 3,
            'cp' => 27,
            'effect' => 280,
            'time' => 70430
        ),
        array(
            'wood' => 13185,
            'clay' => 11060,
            'iron' => 10635,
            'crop' => 5955,
            'pop' => 3,
            'cp' => 32,
            'effect' => 290,
            'time' => 82300
        ),
        array(
            'wood' => 16880,
            'clay' => 14155,
            'iron' => 13610,
            'crop' => 7620,
            'pop' => 3,
            'cp' => 38,
            'effect' => 300,
            'time' => 96070
        )
    );
    public static $bid35 = array(
        array(
            'wood' => 1460,
            'clay' => 930,
            'iron' => 1250,
            'crop' => 1740,
            'pop' => 6,
            'cp' => 5,
            'effect' => 1,
            'time' => 80
        ),
        array(
            'wood' => 1460,
            'clay' => 930,
            'iron' => 1250,
            'crop' => 1740,
            'pop' => 6,
            'cp' => 5,
            'effect' => 1,
            'time' => 8000
        ),
        array(
            'wood' => 2045,
            'clay' => 1300,
            'iron' => 1750,
            'crop' => 2435,
            'pop' => 3,
            'cp' => 6,
            'effect' => 2,
            'time' => 9880
        ),
        array(
            'wood' => 2860,
            'clay' => 1825,
            'iron' => 2450,
            'crop' => 3410,
            'pop' => 3,
            'cp' => 7,
            'effect' => 3,
            'time' => 12060
        ),
        array(
            'wood' => 4005,
            'clay' => 2550,
            'iron' => 3430,
            'crop' => 4775,
            'pop' => 3,
            'cp' => 8,
            'effect' => 4,
            'time' => 14590
        ),
        array(
            'wood' => 5610,
            'clay' => 3575,
            'iron' => 4800,
            'crop' => 6685,
            'pop' => 3,
            'cp' => 10,
            'effect' => 5,
            'time' => 17530
        ),
        array(
            'wood' => 7850,
            'clay' => 5000,
            'iron' => 6725,
            'crop' => 9360,
            'pop' => 4,
            'cp' => 12,
            'effect' => 6,
            'time' => 20930
        ),
        array(
            'wood' => 10995,
            'clay' => 7000,
            'iron' => 9410,
            'crop' => 13100,
            'pop' => 4,
            'cp' => 14,
            'effect' => 7,
            'time' => 24880
        ),
        array(
            'wood' => 15390,
            'clay' => 9805,
            'iron' => 13175,
            'crop' => 18340,
            'pop' => 4,
            'cp' => 17,
            'effect' => 8,
            'time' => 29460
        ),
        array(
            'wood' => 21545,
            'clay' => 13725,
            'iron' => 18445,
            'crop' => 25680,
            'pop' => 4,
            'cp' => 21,
            'effect' => 9,
            'time' => 34770
        ),
        array(
            'wood' => 30165,
            'clay' => 19215,
            'iron' => 25825,
            'crop' => 35950,
            'pop' => 4,
            'cp' => 25,
            'effect' => 10,
            'time' => 40930
        )
    );
    public static $bid36 = array(
        array(
            'wood' => 80,
            'clay' => 120,
            'iron' => 70,
            'crop' => 90,
            'pop' => 4,
            'cp' => 1,
            'trapcount' => 10,
            'effect' => 100,
            'time' => 20
        ),
        array(
            'wood' => 80,
            'clay' => 120,
            'iron' => 70,
            'crop' => 90,
            'pop' => 4,
            'cp' => 1,
            'trapcount' => 10,
            'effect' => 100,
            'time' => 2001
        ),
        array(
            'wood' => 100,
            'clay' => 155,
            'iron' => 90,
            'crop' => 115,
            'pop' => 2,
            'cp' => 1,
            'trapcount' => 22,
            'effect' => 100,
            'time' => 2319
        ),
        array(
            'wood' => 130,
            'clay' => 195,
            'iron' => 115,
            'crop' => 145,
            'pop' => 2,
            'cp' => 2,
            'trapcount' => 35,
            'effect' => 100,
            'time' => 2691
        ),
        array(
            'wood' => 170,
            'clay' => 250,
            'iron' => 145,
            'crop' => 190,
            'pop' => 2,
            'cp' => 2,
            'trapcount' => 49,
            'effect' => 100,
            'time' => 3123
        ),
        array(
            'wood' => 215,
            'clay' => 320,
            'iron' => 190,
            'crop' => 240,
            'pop' => 2,
            'cp' => 2,
            'trapcount' => 64,
            'effect' => 100,
            'time' => 3621
        ),
        array(
            'wood' => 275,
            'clay' => 410,
            'iron' => 240,
            'crop' => 310,
            'pop' => 3,
            'cp' => 3,
            'trapcount' => 80,
            'effect' => 100,
            'time' => 4200
        ),
        array(
            'wood' => 350,
            'clay' => 530,
            'iron' => 310,
            'crop' => 395,
            'pop' => 3,
            'cp' => 4,
            'trapcount' => 97,
            'effect' => 100,
            'time' => 4872
        ),
        array(
            'wood' => 450,
            'clay' => 675,
            'iron' => 395,
            'crop' => 505,
            'pop' => 3,
            'cp' => 4,
            'trapcount' => 115,
            'effect' => 100,
            'time' => 5652
        ),
        array(
            'wood' => 575,
            'clay' => 865,
            'iron' => 505,
            'crop' => 650,
            'pop' => 3,
            'cp' => 5,
            'trapcount' => 134,
            'effect' => 100,
            'time' => 6558
        ),
        array(
            'wood' => 740,
            'clay' => 1105,
            'iron' => 645,
            'crop' => 830,
            'pop' => 3,
            'cp' => 6,
            'trapcount' => 154,
            'effect' => 100,
            'time' => 7605
        ),
        array(
            'wood' => 945,
            'clay' => 1415,
            'iron' => 825,
            'crop' => 1065,
            'pop' => 3,
            'cp' => 7,
            'trapcount' => 175,
            'effect' => 100,
            'time' => 8823
        ),
        array(
            'wood' => 1210,
            'clay' => 1815,
            'iron' => 1060,
            'crop' => 1360,
            'pop' => 3,
            'cp' => 9,
            'trapcount' => 196,
            'effect' => 100,
            'time' => 10236
        ),
        array(
            'wood' => 1545,
            'clay' => 2320,
            'iron' => 1355,
            'crop' => 1740,
            'pop' => 3,
            'cp' => 11,
            'trapcount' => 218,
            'effect' => 100,
            'time' => 11871
        ),
        array(
            'wood' => 1980,
            'clay' => 2970,
            'iron' => 1735,
            'crop' => 2230,
            'pop' => 3,
            'cp' => 13,
            'trapcount' => 241,
            'effect' => 100,
            'time' => 13773
        ),
        array(
            'wood' => 2535,
            'clay' => 3805,
            'iron' => 2220,
            'crop' => 2850,
            'pop' => 3,
            'cp' => 15,
            'trapcount' => 265,
            'effect' => 100,
            'time' => 15975
        ),
        array(
            'wood' => 3245,
            'clay' => 4870,
            'iron' => 2840,
            'crop' => 3650,
            'pop' => 4,
            'cp' => 18,
            'trapcount' => 290,
            'effect' => 100,
            'time' => 18531
        ),
        array(
            'wood' => 4155,
            'clay' => 6230,
            'iron' => 3635,
            'crop' => 4675,
            'pop' => 4,
            'cp' => 22,
            'trapcount' => 316,
            'effect' => 100,
            'time' => 21495
        ),
        array(
            'wood' => 5315,
            'clay' => 7975,
            'iron' => 4650,
            'crop' => 5980,
            'pop' => 4,
            'cp' => 27,
            'trapcount' => 343,
            'effect' => 100,
            'time' => 24936
        ),
        array(
            'wood' => 6805,
            'clay' => 10210,
            'iron' => 5955,
            'crop' => 7655,
            'pop' => 4,
            'cp' => 32,
            'trapcount' => 371,
            'effect' => 100,
            'time' => 28926
        ),
        array(
            'wood' => 8710,
            'clay' => 13065,
            'iron' => 7620,
            'crop' => 9800,
            'pop' => 4,
            'cp' => 38,
            'trapcount' => 400,
            'effect' => 100,
            'time' => 33552
        )
    );
    public static $bid37 = array(
        array(
            'wood' => 700,
            'clay' => 670,
            'iron' => 700,
            'crop' => 240,
            'pop' => 2,
            'cp' => 1,
            'effect' => 0,
            'time' => 23
        ),
        array(
            'wood' => 700,
            'clay' => 670,
            'iron' => 700,
            'crop' => 240,
            'pop' => 2,
            'cp' => 1,
            'effect' => 0,
            'time' => 2300
        ),
        array(
            'wood' => 930,
            'clay' => 890,
            'iron' => 930,
            'crop' => 320,
            'pop' => 1,
            'cp' => 1,
            'effect' => 0,
            'time' => 2670
        ),
        array(
            'wood' => 1240,
            'clay' => 1185,
            'iron' => 1240,
            'crop' => 425,
            'pop' => 1,
            'cp' => 2,
            'effect' => 0,
            'time' => 3090
        ),
        array(
            'wood' => 1645,
            'clay' => 1575,
            'iron' => 1645,
            'crop' => 565,
            'pop' => 1,
            'cp' => 2,
            'effect' => 0,
            'time' => 3590
        ),
        array(
            'wood' => 2190,
            'clay' => 2095,
            'iron' => 2190,
            'crop' => 750,
            'pop' => 1,
            'cp' => 2,
            'effect' => 0,
            'time' => 4160
        ),
        array(
            'wood' => 2915,
            'clay' => 2790,
            'iron' => 2915,
            'crop' => 1000,
            'pop' => 2,
            'cp' => 3,
            'effect' => 0,
            'time' => 4830
        ),
        array(
            'wood' => 3875,
            'clay' => 3710,
            'iron' => 3875,
            'crop' => 1330,
            'pop' => 2,
            'cp' => 4,
            'effect' => 0,
            'time' => 5600
        ),
        array(
            'wood' => 5155,
            'clay' => 4930,
            'iron' => 5155,
            'crop' => 1765,
            'pop' => 2,
            'cp' => 4,
            'effect' => 0,
            'time' => 6500
        ),
        array(
            'wood' => 6855,
            'clay' => 6560,
            'iron' => 6855,
            'crop' => 2350,
            'pop' => 2,
            'cp' => 5,
            'effect' => 0,
            'time' => 7540
        ),
        array(
            'wood' => 9115,
            'clay' => 8725,
            'iron' => 9115,
            'crop' => 3125,
            'pop' => 2,
            'cp' => 6,
            'effect' => 1,
            'time' => 8750
        ),
        array(
            'wood' => 12125,
            'clay' => 11605,
            'iron' => 12125,
            'crop' => 4155,
            'pop' => 2,
            'cp' => 7,
            'effect' => 1,
            'time' => 10150
        ),
        array(
            'wood' => 16125,
            'clay' => 15435,
            'iron' => 16125,
            'crop' => 5530,
            'pop' => 2,
            'cp' => 9,
            'effect' => 1,
            'time' => 11770
        ),
        array(
            'wood' => 21445,
            'clay' => 20525,
            'iron' => 21445,
            'crop' => 7350,
            'pop' => 2,
            'cp' => 11,
            'effect' => 1,
            'time' => 13650
        ),
        array(
            'wood' => 28520,
            'clay' => 27300,
            'iron' => 28520,
            'crop' => 9780,
            'pop' => 2,
            'cp' => 13,
            'effect' => 1,
            'time' => 15840
        ),
        array(
            'wood' => 37935,
            'clay' => 36310,
            'iron' => 37935,
            'crop' => 13005,
            'pop' => 2,
            'cp' => 15,
            'effect' => 2,
            'time' => 18370
        ),
        array(
            'wood' => 50450,
            'clay' => 48290,
            'iron' => 50450,
            'crop' => 17300,
            'pop' => 3,
            'cp' => 18,
            'effect' => 2,
            'time' => 21310
        ),
        array(
            'wood' => 67100,
            'clay' => 64225,
            'iron' => 67100,
            'crop' => 23005,
            'pop' => 3,
            'cp' => 22,
            'effect' => 2,
            'time' => 24720
        ),
        array(
            'wood' => 89245,
            'clay' => 85420,
            'iron' => 89245,
            'crop' => 30600,
            'pop' => 3,
            'cp' => 27,
            'effect' => 2,
            'time' => 28680
        ),
        array(
            'wood' => 118695,
            'clay' => 113605,
            'iron' => 118695,
            'crop' => 40695,
            'pop' => 3,
            'cp' => 32,
            'effect' => 2,
            'time' => 33260
        ),
        array(
            'wood' => 157865,
            'clay' => 151095,
            'iron' => 157865,
            'crop' => 54125,
            'pop' => 3,
            'cp' => 38,
            'effect' => 3,
            'time' => 38590
        )
    );
    public static $bid38 = array(
        array(
            'wood' => 650,
            'clay' => 800,
            'iron' => 450,
            'crop' => 200,
            'pop' => 1,
            'cp' => 1,
            'effect' => 3600,
            'time' => 90
        ),
        array(
            'wood' => 650,
            'clay' => 800,
            'iron' => 450,
            'crop' => 200,
            'pop' => 1,
            'cp' => 1,
            'effect' => 3600,
            'time' => 9000
        ),
        array(
            'wood' => 830,
            'clay' => 1025,
            'iron' => 575,
            'crop' => 255,
            'pop' => 1,
            'cp' => 1,
            'effect' => 5100,
            'time' => 10740
        ),
        array(
            'wood' => 1065,
            'clay' => 1310,
            'iron' => 735,
            'crop' => 330,
            'pop' => 1,
            'cp' => 2,
            'effect' => 6900,
            'time' => 12760
        ),
        array(
            'wood' => 1365,
            'clay' => 1680,
            'iron' => 945,
            'crop' => 420,
            'pop' => 1,
            'cp' => 2,
            'effect' => 9300,
            'time' => 15100
        ),
        array(
            'wood' => 1745,
            'clay' => 2145,
            'iron' => 1210,
            'crop' => 535,
            'pop' => 1,
            'cp' => 2,
            'effect' => 12000,
            'time' => 17820
        ),
        array(
            'wood' => 2235,
            'clay' => 2750,
            'iron' => 1545,
            'crop' => 685,
            'pop' => 1,
            'cp' => 3,
            'effect' => 15000,
            'time' => 20970
        ),
        array(
            'wood' => 2860,
            'clay' => 3520,
            'iron' => 1980,
            'crop' => 880,
            'pop' => 1,
            'cp' => 4,
            'effect' => 18900,
            'time' => 24620
        ),
        array(
            'wood' => 3660,
            'clay' => 4505,
            'iron' => 2535,
            'crop' => 1125,
            'pop' => 1,
            'cp' => 4,
            'effect' => 23400,
            'time' => 28860
        ),
        array(
            'wood' => 4685,
            'clay' => 5765,
            'iron' => 3245,
            'crop' => 1440,
            'pop' => 1,
            'cp' => 5,
            'effect' => 28800,
            'time' => 33780
        ),
        array(
            'wood' => 5995,
            'clay' => 7380,
            'iron' => 4150,
            'crop' => 1845,
            'pop' => 1,
            'cp' => 6,
            'effect' => 35400,
            'time' => 39480
        ),
        array(
            'wood' => 7675,
            'clay' => 9445,
            'iron' => 5315,
            'crop' => 2360,
            'pop' => 2,
            'cp' => 7,
            'effect' => 43200,
            'time' => 46100
        ),
        array(
            'wood' => 9825,
            'clay' => 12090,
            'iron' => 6800,
            'crop' => 3020,
            'pop' => 2,
            'cp' => 9,
            'effect' => 52800,
            'time' => 53780
        ),
        array(
            'wood' => 12575,
            'clay' => 15475,
            'iron' => 8705,
            'crop' => 3870,
            'pop' => 2,
            'cp' => 11,
            'effect' => 64200,
            'time' => 62680
        ),
        array(
            'wood' => 16095,
            'clay' => 19805,
            'iron' => 11140,
            'crop' => 4950,
            'pop' => 2,
            'cp' => 13,
            'effect' => 77700,
            'time' => 73010
        ),
        array(
            'wood' => 20600,
            'clay' => 25355,
            'iron' => 14260,
            'crop' => 6340,
            'pop' => 2,
            'cp' => 15,
            'effect' => 93900,
            'time' => 84990
        ),
        array(
            'wood' => 26365,
            'clay' => 32450,
            'iron' => 18255,
            'crop' => 8115,
            'pop' => 2,
            'cp' => 18,
            'effect' => 113700,
            'time' => 98890
        ),
        array(
            'wood' => 33750,
            'clay' => 41540,
            'iron' => 23365,
            'crop' => 10385,
            'pop' => 2,
            'cp' => 22,
            'effect' => 137100,
            'time' => 115010
        ),
        array(
            'wood' => 43200,
            'clay' => 53170,
            'iron' => 29910,
            'crop' => 13290,
            'pop' => 2,
            'cp' => 27,
            'effect' => 165300,
            'time' => 133710
        ),
        array(
            'wood' => 55295,
            'clay' => 68055,
            'iron' => 38280,
            'crop' => 17015,
            'pop' => 2,
            'cp' => 32,
            'effect' => 199200,
            'time' => 155400
        ),
        array(
            'wood' => 70780,
            'clay' => 87110,
            'iron' => 49000,
            'crop' => 21780,
            'pop' => 2,
            'cp' => 38,
            'effect' => 240000,
            'time' => 180570
        )
    );
    public static $bid39 = array(
        array(
            'wood' => 400,
            'clay' => 500,
            'iron' => 350,
            'crop' => 100,
            'pop' => 1,
            'cp' => 1,
            'effect' => 3600,
            'time' => 70
        ),
        array(
            'wood' => 400,
            'clay' => 500,
            'iron' => 350,
            'crop' => 100,
            'pop' => 1,
            'cp' => 1,
            'effect' => 3600,
            'time' => 7000
        ),
        array(
            'wood' => 510,
            'clay' => 640,
            'iron' => 450,
            'crop' => 130,
            'pop' => 1,
            'cp' => 1,
            'effect' => 5100,
            'time' => 8420
        ),
        array(
            'wood' => 655,
            'clay' => 820,
            'iron' => 575,
            'crop' => 165,
            'pop' => 1,
            'cp' => 2,
            'effect' => 6900,
            'time' => 10070
        ),
        array(
            'wood' => 840,
            'clay' => 1050,
            'iron' => 735,
            'crop' => 210,
            'pop' => 1,
            'cp' => 2,
            'effect' => 9300,
            'time' => 11980
        ),
        array(
            'wood' => 1075,
            'clay' => 1340,
            'iron' => 940,
            'crop' => 270,
            'pop' => 1,
            'cp' => 2,
            'effect' => 12000,
            'time' => 14190
        ),
        array(
            'wood' => 1375,
            'clay' => 1720,
            'iron' => 1205,
            'crop' => 345,
            'pop' => 1,
            'cp' => 3,
            'effect' => 15000,
            'time' => 16770
        ),
        array(
            'wood' => 1760,
            'clay' => 2200,
            'iron' => 1540,
            'crop' => 440,
            'pop' => 1,
            'cp' => 4,
            'effect' => 18900,
            'time' => 19750
        ),
        array(
            'wood' => 2250,
            'clay' => 2815,
            'iron' => 1970,
            'crop' => 565,
            'pop' => 1,
            'cp' => 4,
            'effect' => 23400,
            'time' => 23210
        ),
        array(
            'wood' => 2880,
            'clay' => 3605,
            'iron' => 2520,
            'crop' => 720,
            'pop' => 1,
            'cp' => 5,
            'effect' => 28800,
            'time' => 27220
        ),
        array(
            'wood' => 3690,
            'clay' => 4610,
            'iron' => 3230,
            'crop' => 920,
            'pop' => 1,
            'cp' => 6,
            'effect' => 35400,
            'time' => 31880
        ),
        array(
            'wood' => 4720,
            'clay' => 5905,
            'iron' => 4130,
            'crop' => 1180,
            'pop' => 2,
            'cp' => 7,
            'effect' => 43200,
            'time' => 37280
        ),
        array(
            'wood' => 6045,
            'clay' => 7555,
            'iron' => 5290,
            'crop' => 1510,
            'pop' => 2,
            'cp' => 9,
            'effect' => 52800,
            'time' => 43540
        ),
        array(
            'wood' => 7735,
            'clay' => 9670,
            'iron' => 6770,
            'crop' => 1935,
            'pop' => 2,
            'cp' => 11,
            'effect' => 64200,
            'time' => 50810
        ),
        array(
            'wood' => 9905,
            'clay' => 12380,
            'iron' => 8665,
            'crop' => 2475,
            'pop' => 2,
            'cp' => 13,
            'effect' => 77700,
            'time' => 59240
        ),
        array(
            'wood' => 12675,
            'clay' => 15845,
            'iron' => 11090,
            'crop' => 3170,
            'pop' => 2,
            'cp' => 15,
            'effect' => 93900,
            'time' => 69010
        ),
        array(
            'wood' => 16225,
            'clay' => 20280,
            'iron' => 14200,
            'crop' => 4055,
            'pop' => 2,
            'cp' => 18,
            'effect' => 113700,
            'time' => 80360
        ),
        array(
            'wood' => 20770,
            'clay' => 25960,
            'iron' => 18175,
            'crop' => 5190,
            'pop' => 2,
            'cp' => 22,
            'effect' => 137100,
            'time' => 93510
        ),
        array(
            'wood' => 26585,
            'clay' => 33230,
            'iron' => 23260,
            'crop' => 6645,
            'pop' => 2,
            'cp' => 27,
            'effect' => 165300,
            'time' => 108780
        ),
        array(
            'wood' => 34030,
            'clay' => 42535,
            'iron' => 29775,
            'crop' => 8505,
            'pop' => 2,
            'cp' => 32,
            'effect' => 199200,
            'time' => 126480
        ),
        array(
            'wood' => 43555,
            'clay' => 54445,
            'iron' => 38110,
            'crop' => 10890,
            'pop' => 2,
            'cp' => 38,
            'effect' => 240000,
            'time' => 147020
        )
    );
    public static $bid40 = array(
        array(
            'wood' => 6670,
            'clay' => 6950,
            'iron' => 7220,
            'crop' => 1300,
            'pop' => 1,
            'cp' => 0,
            'effect' => 0,
            'time' => 180
        ),
        array(
            'wood' => 66700,
            'clay' => 69050,
            'iron' => 72200,
            'crop' => 13200,
            'pop' => 1,
            'cp' => 0,
            'effect' => 0,
            'time' => 18000
        ),
        array(
            'wood' => 68535,
            'clay' => 70950,
            'iron' => 74185,
            'crop' => 13565,
            'pop' => 1,
            'cp' => 0,
            'effect' => 0,
            'time' => 18850
        ),
        array(
            'wood' => 70420,
            'clay' => 72900,
            'iron' => 76225,
            'crop' => 13935,
            'pop' => 1,
            'cp' => 0,
            'effect' => 0,
            'time' => 19720
        ),
        array(
            'wood' => 72355,
            'clay' => 74905,
            'iron' => 78320,
            'crop' => 14320,
            'pop' => 1,
            'cp' => 0,
            'effect' => 0,
            'time' => 20590
        ),
        array(
            'wood' => 74345,
            'clay' => 76965,
            'iron' => 80475,
            'crop' => 14715,
            'pop' => 1,
            'cp' => 0,
            'effect' => 0,
            'time' => 21480
        ),
        array(
            'wood' => 76390,
            'clay' => 79080,
            'iron' => 82690,
            'crop' => 15120,
            'pop' => 1,
            'cp' => 0,
            'effect' => 0,
            'time' => 22380
        ),
        array(
            'wood' => 78490,
            'clay' => 81255,
            'iron' => 84965,
            'crop' => 15535,
            'pop' => 1,
            'cp' => 0,
            'effect' => 0,
            'time' => 23290
        ),
        array(
            'wood' => 80650,
            'clay' => 83490,
            'iron' => 87300,
            'crop' => 15960,
            'pop' => 1,
            'cp' => 0,
            'effect' => 0,
            'time' => 24220
        ),
        array(
            'wood' => 82865,
            'clay' => 85785,
            'iron' => 89700,
            'crop' => 16400,
            'pop' => 1,
            'cp' => 0,
            'effect' => 0,
            'time' => 25160
        ),
        array(
            'wood' => 85145,
            'clay' => 88145,
            'iron' => 92165,
            'crop' => 16850,
            'pop' => 1,
            'cp' => 0,
            'effect' => 0,
            'time' => 26110
        ),
        array(
            'wood' => 87485,
            'clay' => 90570,
            'iron' => 94700,
            'crop' => 17315,
            'pop' => 2,
            'cp' => 0,
            'effect' => 0,
            'time' => 27080
        ),
        array(
            'wood' => 89895,
            'clay' => 93060,
            'iron' => 97305,
            'crop' => 17790,
            'pop' => 2,
            'cp' => 0,
            'effect' => 0,
            'time' => 28060
        ),
        array(
            'wood' => 92365,
            'clay' => 95620,
            'iron' => 99980,
            'crop' => 18280,
            'pop' => 2,
            'cp' => 0,
            'effect' => 0,
            'time' => 29050
        ),
        array(
            'wood' => 94905,
            'clay' => 98250,
            'iron' => 102730,
            'crop' => 18780,
            'pop' => 2,
            'cp' => 0,
            'effect' => 0,
            'time' => 30060
        ),
        array(
            'wood' => 97515,
            'clay' => 100950,
            'iron' => 105555,
            'crop' => 19300,
            'pop' => 2,
            'cp' => 0,
            'effect' => 0,
            'time' => 31080
        ),
        array(
            'wood' => 100195,
            'clay' => 103725,
            'iron' => 108460,
            'crop' => 19830,
            'pop' => 2,
            'cp' => 0,
            'effect' => 0,
            'time' => 32110
        ),
        array(
            'wood' => 102950,
            'clay' => 106580,
            'iron' => 111440,
            'crop' => 20375,
            'pop' => 2,
            'cp' => 0,
            'effect' => 0,
            'time' => 33160
        ),
        array(
            'wood' => 105785,
            'clay' => 109510,
            'iron' => 114505,
            'crop' => 20935,
            'pop' => 2,
            'cp' => 0,
            'effect' => 0,
            'time' => 34230
        ),
        array(
            'wood' => 108690,
            'clay' => 112520,
            'iron' => 117655,
            'crop' => 21510,
            'pop' => 2,
            'cp' => 0,
            'effect' => 0,
            'time' => 35300
        ),
        array(
            'wood' => 111680,
            'clay' => 115615,
            'iron' => 120890,
            'crop' => 22100,
            'pop' => 2,
            'cp' => 0,
            'effect' => 0,
            'time' => 36400
        ),
        array(
            'wood' => 114755,
            'clay' => 118795,
            'iron' => 124215,
            'crop' => 22710,
            'pop' => 3,
            'cp' => 0,
            'effect' => 0,
            'time' => 37510
        ),
        array(
            'wood' => 117910,
            'clay' => 122060,
            'iron' => 127630,
            'crop' => 23335,
            'pop' => 3,
            'cp' => 0,
            'effect' => 0,
            'time' => 38630
        ),
        array(
            'wood' => 121150,
            'clay' => 125420,
            'iron' => 131140,
            'crop' => 23975,
            'pop' => 3,
            'cp' => 0,
            'effect' => 0,
            'time' => 39770
        ),
        array(
            'wood' => 124480,
            'clay' => 128870,
            'iron' => 134745,
            'crop' => 24635,
            'pop' => 3,
            'cp' => 0,
            'effect' => 0,
            'time' => 40930
        ),
        array(
            'wood' => 127905,
            'clay' => 132410,
            'iron' => 138455,
            'crop' => 25315,
            'pop' => 3,
            'cp' => 0,
            'effect' => 0,
            'time' => 42100
        ),
        array(
            'wood' => 131425,
            'clay' => 136055,
            'iron' => 142260,
            'crop' => 26010,
            'pop' => 3,
            'cp' => 0,
            'effect' => 0,
            'time' => 43290
        ),
        array(
            'wood' => 135035,
            'clay' => 139795,
            'iron' => 146170,
            'crop' => 26725,
            'pop' => 3,
            'cp' => 0,
            'effect' => 0,
            'time' => 44500
        ),
        array(
            'wood' => 138750,
            'clay' => 143640,
            'iron' => 150190,
            'crop' => 27460,
            'pop' => 3,
            'cp' => 0,
            'effect' => 0,
            'time' => 45720
        ),
        array(
            'wood' => 142565,
            'clay' => 147590,
            'iron' => 154320,
            'crop' => 28215,
            'pop' => 3,
            'cp' => 0,
            'effect' => 0,
            'time' => 46960
        ),
        array(
            'wood' => 146485,
            'clay' => 151650,
            'iron' => 158565,
            'crop' => 28990,
            'pop' => 3,
            'cp' => 0,
            'effect' => 0,
            'time' => 48220
        ),
        array(
            'wood' => 150515,
            'clay' => 155820,
            'iron' => 162925,
            'crop' => 29785,
            'pop' => 4,
            'cp' => 0,
            'effect' => 0,
            'time' => 49500
        ),
        array(
            'wood' => 154655,
            'clay' => 160105,
            'iron' => 167405,
            'crop' => 30605,
            'pop' => 4,
            'cp' => 0,
            'effect' => 0,
            'time' => 50790
        ),
        array(
            'wood' => 158910,
            'clay' => 164505,
            'iron' => 172010,
            'crop' => 31450,
            'pop' => 4,
            'cp' => 0,
            'effect' => 0,
            'time' => 52100
        ),
        array(
            'wood' => 163275,
            'clay' => 169030,
            'iron' => 176740,
            'crop' => 32315,
            'pop' => 4,
            'cp' => 0,
            'effect' => 0,
            'time' => 53430
        ),
        array(
            'wood' => 167770,
            'clay' => 173680,
            'iron' => 181600,
            'crop' => 33200,
            'pop' => 4,
            'cp' => 0,
            'effect' => 0,
            'time' => 54780
        ),
        array(
            'wood' => 172380,
            'clay' => 178455,
            'iron' => 186595,
            'crop' => 34115,
            'pop' => 4,
            'cp' => 0,
            'effect' => 0,
            'time' => 56140
        ),
        array(
            'wood' => 177120,
            'clay' => 183360,
            'iron' => 191725,
            'crop' => 35055,
            'pop' => 4,
            'cp' => 0,
            'effect' => 0,
            'time' => 57530
        ),
        array(
            'wood' => 181995,
            'clay' => 188405,
            'iron' => 197000,
            'crop' => 36015,
            'pop' => 4,
            'cp' => 0,
            'effect' => 0,
            'time' => 58940
        ),
        array(
            'wood' => 186995,
            'clay' => 193585,
            'iron' => 202415,
            'crop' => 37005,
            'pop' => 4,
            'cp' => 0,
            'effect' => 0,
            'time' => 60360
        ),
        array(
            'wood' => 192140,
            'clay' => 198910,
            'iron' => 207985,
            'crop' => 38025,
            'pop' => 4,
            'cp' => 0,
            'effect' => 0,
            'time' => 61810
        ),
        array(
            'wood' => 197425,
            'clay' => 204380,
            'iron' => 213705,
            'crop' => 39070,
            'pop' => 5,
            'cp' => 0,
            'effect' => 0,
            'time' => 63270
        ),
        array(
            'wood' => 202855,
            'clay' => 210000,
            'iron' => 219580,
            'crop' => 40145,
            'pop' => 5,
            'cp' => 0,
            'effect' => 0,
            'time' => 64760
        ),
        array(
            'wood' => 208430,
            'clay' => 215775,
            'iron' => 225620,
            'crop' => 41250,
            'pop' => 5,
            'cp' => 0,
            'effect' => 0,
            'time' => 66260
        ),
        array(
            'wood' => 214165,
            'clay' => 221710,
            'iron' => 231825,
            'crop' => 42385,
            'pop' => 5,
            'cp' => 0,
            'effect' => 0,
            'time' => 67790
        ),
        array(
            'wood' => 220055,
            'clay' => 227805,
            'iron' => 238200,
            'crop' => 43550,
            'pop' => 5,
            'cp' => 0,
            'effect' => 0,
            'time' => 69340
        ),
        array(
            'wood' => 226105,
            'clay' => 234070,
            'iron' => 244750,
            'crop' => 44745,
            'pop' => 5,
            'cp' => 0,
            'effect' => 0,
            'time' => 70910
        ),
        array(
            'wood' => 232320,
            'clay' => 240505,
            'iron' => 251480,
            'crop' => 45975,
            'pop' => 5,
            'cp' => 0,
            'effect' => 0,
            'time' => 72500
        ),
        array(
            'wood' => 238710,
            'clay' => 247120,
            'iron' => 258395,
            'crop' => 47240,
            'pop' => 5,
            'cp' => 0,
            'effect' => 0,
            'time' => 74120
        ),
        array(
            'wood' => 245275,
            'clay' => 253915,
            'iron' => 265500,
            'crop' => 48540,
            'pop' => 5,
            'cp' => 0,
            'effect' => 0,
            'time' => 75760
        ),
        array(
            'wood' => 252020,
            'clay' => 260900,
            'iron' => 272800,
            'crop' => 49875,
            'pop' => 5,
            'cp' => 0,
            'effect' => 0,
            'time' => 77420
        ),
        array(
            'wood' => 258950,
            'clay' => 268075,
            'iron' => 280305,
            'crop' => 51245,
            'pop' => 6,
            'cp' => 0,
            'effect' => 0,
            'time' => 79100
        ),
        array(
            'wood' => 266070,
            'clay' => 275445,
            'iron' => 288010,
            'crop' => 52655,
            'pop' => 6,
            'cp' => 0,
            'effect' => 0,
            'time' => 80810
        ),
        array(
            'wood' => 273390,
            'clay' => 283020,
            'iron' => 295930,
            'crop' => 54105,
            'pop' => 6,
            'cp' => 0,
            'effect' => 0,
            'time' => 82540
        ),
        array(
            'wood' => 280905,
            'clay' => 290805,
            'iron' => 304070,
            'crop' => 55590,
            'pop' => 6,
            'cp' => 0,
            'effect' => 0,
            'time' => 84290
        ),
        array(
            'wood' => 288630,
            'clay' => 298800,
            'iron' => 312430,
            'crop' => 57120,
            'pop' => 6,
            'cp' => 0,
            'effect' => 0,
            'time' => 86070
        ),
        array(
            'wood' => 296570,
            'clay' => 307020,
            'iron' => 321025,
            'crop' => 58690,
            'pop' => 6,
            'cp' => 0,
            'effect' => 0,
            'time' => 87880
        ),
        array(
            'wood' => 304725,
            'clay' => 315460,
            'iron' => 329850,
            'crop' => 60305,
            'pop' => 6,
            'cp' => 0,
            'effect' => 0,
            'time' => 89710
        ),
        array(
            'wood' => 313105,
            'clay' => 324135,
            'iron' => 338925,
            'crop' => 61965,
            'pop' => 6,
            'cp' => 0,
            'effect' => 0,
            'time' => 91570
        ),
        array(
            'wood' => 321715,
            'clay' => 333050,
            'iron' => 348245,
            'crop' => 63670,
            'pop' => 6,
            'cp' => 0,
            'effect' => 0,
            'time' => 93450
        ),
        array(
            'wood' => 330565,
            'clay' => 342210,
            'iron' => 357820,
            'crop' => 65420,
            'pop' => 6,
            'cp' => 0,
            'effect' => 0,
            'time' => 95360
        ),
        array(
            'wood' => 339655,
            'clay' => 351620,
            'iron' => 367660,
            'crop' => 67220,
            'pop' => 7,
            'cp' => 0,
            'effect' => 0,
            'time' => 97290
        ),
        array(
            'wood' => 348995,
            'clay' => 361290,
            'iron' => 377770,
            'crop' => 69065,
            'pop' => 7,
            'cp' => 0,
            'effect' => 0,
            'time' => 99250
        ),
        array(
            'wood' => 358590,
            'clay' => 371225,
            'iron' => 388160,
            'crop' => 70965,
            'pop' => 7,
            'cp' => 0,
            'effect' => 0,
            'time' => 101240
        ),
        array(
            'wood' => 368450,
            'clay' => 381435,
            'iron' => 398835,
            'crop' => 72915,
            'pop' => 7,
            'cp' => 0,
            'effect' => 0,
            'time' => 103260
        ),
        array(
            'wood' => 378585,
            'clay' => 391925,
            'iron' => 409800,
            'crop' => 74920,
            'pop' => 7,
            'cp' => 0,
            'effect' => 0,
            'time' => 105310
        ),
        array(
            'wood' => 388995,
            'clay' => 402700,
            'iron' => 421070,
            'crop' => 76985,
            'pop' => 7,
            'cp' => 0,
            'effect' => 0,
            'time' => 107380
        ),
        array(
            'wood' => 399695,
            'clay' => 413775,
            'iron' => 432650,
            'crop' => 79100,
            'pop' => 7,
            'cp' => 0,
            'effect' => 0,
            'time' => 109480
        ),
        array(
            'wood' => 410685,
            'clay' => 425155,
            'iron' => 444550,
            'crop' => 81275,
            'pop' => 7,
            'cp' => 0,
            'effect' => 0,
            'time' => 111620
        ),
        array(
            'wood' => 421980,
            'clay' => 436845,
            'iron' => 456775,
            'crop' => 83510,
            'pop' => 7,
            'cp' => 0,
            'effect' => 0,
            'time' => 113780
        ),
        array(
            'wood' => 433585,
            'clay' => 448860,
            'iron' => 469335,
            'crop' => 85805,
            'pop' => 7,
            'cp' => 0,
            'effect' => 0,
            'time' => 115970
        ),
        array(
            'wood' => 445505,
            'clay' => 461205,
            'iron' => 482240,
            'crop' => 88165,
            'pop' => 8,
            'cp' => 0,
            'effect' => 0,
            'time' => 118200
        ),
        array(
            'wood' => 457760,
            'clay' => 473885,
            'iron' => 495505,
            'crop' => 90590,
            'pop' => 8,
            'cp' => 0,
            'effect' => 0,
            'time' => 120450
        ),
        array(
            'wood' => 470345,
            'clay' => 486920,
            'iron' => 509130,
            'crop' => 93080,
            'pop' => 8,
            'cp' => 0,
            'effect' => 0,
            'time' => 122740
        ),
        array(
            'wood' => 483280,
            'clay' => 500310,
            'iron' => 523130,
            'crop' => 95640,
            'pop' => 8,
            'cp' => 0,
            'effect' => 0,
            'time' => 125060
        ),
        array(
            'wood' => 496570,
            'clay' => 514065,
            'iron' => 537520,
            'crop' => 98270,
            'pop' => 8,
            'cp' => 0,
            'effect' => 0,
            'time' => 127410
        ),
        array(
            'wood' => 510225,
            'clay' => 528205,
            'iron' => 552300,
            'crop' => 100975,
            'pop' => 8,
            'cp' => 0,
            'effect' => 0,
            'time' => 129790
        ),
        array(
            'wood' => 524260,
            'clay' => 542730,
            'iron' => 567490,
            'crop' => 103750,
            'pop' => 8,
            'cp' => 0,
            'effect' => 0,
            'time' => 132210
        ),
        array(
            'wood' => 538675,
            'clay' => 557655,
            'iron' => 583095,
            'crop' => 106605,
            'pop' => 8,
            'cp' => 0,
            'effect' => 0,
            'time' => 134660
        ),
        array(
            'wood' => 553490,
            'clay' => 572990,
            'iron' => 599130,
            'crop' => 109535,
            'pop' => 8,
            'cp' => 0,
            'effect' => 0,
            'time' => 137140
        ),
        array(
            'wood' => 568710,
            'clay' => 588745,
            'iron' => 615605,
            'crop' => 112550,
            'pop' => 8,
            'cp' => 0,
            'effect' => 0,
            'time' => 139660
        ),
        array(
            'wood' => 584350,
            'clay' => 604935,
            'iron' => 632535,
            'crop' => 115645,
            'pop' => 9,
            'cp' => 0,
            'effect' => 0,
            'time' => 142220
        ),
        array(
            'wood' => 600420,
            'clay' => 621575,
            'iron' => 649930,
            'crop' => 118825,
            'pop' => 9,
            'cp' => 0,
            'effect' => 0,
            'time' => 144810
        ),
        array(
            'wood' => 616930,
            'clay' => 638665,
            'iron' => 667800,
            'crop' => 122090,
            'pop' => 9,
            'cp' => 0,
            'effect' => 0,
            'time' => 147440
        ),
        array(
            'wood' => 633895,
            'clay' => 656230,
            'iron' => 686165,
            'crop' => 125450,
            'pop' => 9,
            'cp' => 0,
            'effect' => 0,
            'time' => 150100
        ),
        array(
            'wood' => 651330,
            'clay' => 674275,
            'iron' => 705035,
            'crop' => 128900,
            'pop' => 9,
            'cp' => 0,
            'effect' => 0,
            'time' => 152800
        ),
        array(
            'wood' => 669240,
            'clay' => 692820,
            'iron' => 724425,
            'crop' => 132445,
            'pop' => 9,
            'cp' => 0,
            'effect' => 0,
            'time' => 155540
        ),
        array(
            'wood' => 687645,
            'clay' => 711870,
            'iron' => 744345,
            'crop' => 136085,
            'pop' => 9,
            'cp' => 0,
            'effect' => 0,
            'time' => 158320
        ),
        array(
            'wood' => 706555,
            'clay' => 731445,
            'iron' => 764815,
            'crop' => 139830,
            'pop' => 9,
            'cp' => 0,
            'effect' => 0,
            'time' => 161140
        ),
        array(
            'wood' => 725985,
            'clay' => 751560,
            'iron' => 785850,
            'crop' => 143675,
            'pop' => 9,
            'cp' => 0,
            'effect' => 0,
            'time' => 163990
        ),
        array(
            'wood' => 745950,
            'clay' => 772230,
            'iron' => 807460,
            'crop' => 147625,
            'pop' => 9,
            'cp' => 0,
            'effect' => 0,
            'time' => 166890
        ),
        array(
            'wood' => 766460,
            'clay' => 793465,
            'iron' => 829665,
            'crop' => 151685,
            'pop' => 10,
            'cp' => 0,
            'effect' => 0,
            'time' => 169820
        ),
        array(
            'wood' => 787540,
            'clay' => 815285,
            'iron' => 852480,
            'crop' => 155855,
            'pop' => 10,
            'cp' => 0,
            'effect' => 0,
            'time' => 172800
        ),
        array(
            'wood' => 809195,
            'clay' => 837705,
            'iron' => 875920,
            'crop' => 160140,
            'pop' => 10,
            'cp' => 0,
            'effect' => 0,
            'time' => 175820
        ),
        array(
            'wood' => 831450,
            'clay' => 860745,
            'iron' => 900010,
            'crop' => 164545,
            'pop' => 10,
            'cp' => 0,
            'effect' => 0,
            'time' => 178880
        ),
        array(
            'wood' => 854315,
            'clay' => 884415,
            'iron' => 924760,
            'crop' => 169070,
            'pop' => 10,
            'cp' => 0,
            'effect' => 0,
            'time' => 181990
        ),
        array(
            'wood' => 877810,
            'clay' => 908735,
            'iron' => 950190,
            'crop' => 173720,
            'pop' => 10,
            'cp' => 0,
            'effect' => 0,
            'time' => 185130
        ),
        array(
            'wood' => 901950,
            'clay' => 933725,
            'iron' => 976320,
            'crop' => 178495,
            'pop' => 10,
            'cp' => 0,
            'effect' => 0,
            'time' => 188330
        ),
        array(
            'wood' => 926750,
            'clay' => 959405,
            'iron' => 1000000,
            'crop' => 183405,
            'pop' => 10,
            'cp' => 0,
            'effect' => 0,
            'time' => 191560
        ),
        array(
            'wood' => 952235,
            'clay' => 985785,
            'iron' => 1000000,
            'crop' => 188450,
            'pop' => 10,
            'cp' => 0,
            'effect' => 0,
            'time' => 194840
        ),
        array(
            'wood' => 1000000,
            'clay' => 1000000,
            'iron' => 1000000,
            'crop' => 193630,
            'pop' => 10,
            'cp' => 0,
            'effect' => 0,
            'time' => 198170
        )
    );
    public static $bid41 = array(
        array(
            'wood' => 780,
            'clay' => 420,
            'iron' => 660,
            'crop' => 540,
            'pop' => 5,
            'cp' => 2,
            'effect' => 1.00,
            'time' => 22
        ),
        array(
            'wood' => 780,
            'clay' => 420,
            'iron' => 660,
            'crop' => 540,
            'pop' => 5,
            'cp' => 2,
            'effect' => 1.01,
            'time' => 2200
        ),
        array(
            'wood' => 1000,
            'clay' => 540,
            'iron' => 845,
            'crop' => 690,
            'pop' => 3,
            'cp' => 3,
            'effect' => 1.02,
            'time' => 3152
        ),
        array(
            'wood' => 1280,
            'clay' => 690,
            'iron' => 1080,
            'crop' => 885,
            'pop' => 3,
            'cp' => 3,
            'effect' => 1.03,
            'time' => 4256
        ),
        array(
            'wood' => 1635,
            'clay' => 880,
            'iron' => 1385,
            'crop' => 1130,
            'pop' => 3,
            'cp' => 4,
            'effect' => 1.04,
            'time' => 5537
        ),
        array(
            'wood' => 2095,
            'clay' => 1125,
            'iron' => 1770,
            'crop' => 1450,
            'pop' => 3,
            'cp' => 5,
            'effect' => 1.05,
            'time' => 7023
        ),
        array(
            'wood' => 2680,
            'clay' => 1445,
            'iron' => 2270,
            'crop' => 1855,
            'pop' => 3,
            'cp' => 6,
            'effect' => 1.06,
            'time' => 8747
        ),
        array(
            'wood' => 3430,
            'clay' => 1845,
            'iron' => 2905,
            'crop' => 2375,
            'pop' => 3,
            'cp' => 7,
            'effect' => 1.08,
            'time' => 10747
        ),
        array(
            'wood' => 4390,
            'clay' => 2365,
            'iron' => 3715,
            'crop' => 3040,
            'pop' => 3,
            'cp' => 9,
            'effect' => 1.09,
            'time' => 13066
        ),
        array(
            'wood' => 5620,
            'clay' => 3025,
            'iron' => 4755,
            'crop' => 3890,
            'pop' => 3,
            'cp' => 10,
            'effect' => 1.10,
            'time' => 15757
        ),
        array(
            'wood' => 7195,
            'clay' => 3875,
            'iron' => 6085,
            'crop' => 4980,
            'pop' => 3,
            'cp' => 12,
            'effect' => 1.11,
            'time' => 18878
        ),
        array(
            'wood' => 9210,
            'clay' => 4960,
            'iron' => 7790,
            'crop' => 6375,
            'pop' => 4,
            'cp' => 15,
            'effect' => 1.12,
            'time' => 22498
        ),
        array(
            'wood' => 11785,
            'clay' => 6345,
            'iron' => 9975,
            'crop' => 8160,
            'pop' => 4,
            'cp' => 18,
            'effect' => 1.14,
            'time' => 26698
        ),
        array(
            'wood' => 15085,
            'clay' => 8125,
            'iron' => 12765,
            'crop' => 10445,
            'pop' => 4,
            'cp' => 21,
            'effect' => 1.15,
            'time' => 31569
        ),
        array(
            'wood' => 19310,
            'clay' => 10400,
            'iron' => 16340,
            'crop' => 13370,
            'pop' => 4,
            'cp' => 26,
            'effect' => 1.16,
            'time' => 37220
        ),
        array(
            'wood' => 24720,
            'clay' => 13310,
            'iron' => 20915,
            'crop' => 17115,
            'pop' => 4,
            'cp' => 31,
            'effect' => 1.18,
            'time' => 43776
        ),
        array(
            'wood' => 31640,
            'clay' => 17035,
            'iron' => 26775,
            'crop' => 21905,
            'pop' => 4,
            'cp' => 37,
            'effect' => 1.19,
            'time' => 51380
        ),
        array(
            'wood' => 40500,
            'clay' => 21810,
            'iron' => 34270,
            'crop' => 28040,
            'pop' => 4,
            'cp' => 44,
            'effect' => 1.2,
            'time' => 60201
        ),
        array(
            'wood' => 51840,
            'clay' => 27915,
            'iron' => 43865,
            'crop' => 35890,
            'pop' => 4,
            'cp' => 53,
            'effect' => 1.22,
            'time' => 70433
        ),
        array(
            'wood' => 66355,
            'clay' => 35730,
            'iron' => 56145,
            'crop' => 45940,
            'pop' => 4,
            'cp' => 64,
            'effect' => 1.23,
            'time' => 82302
        ),
        array(
            'wood' => 84935,
            'clay' => 45735,
            'iron' => 71870,
            'crop' => 58800,
            'pop' => 4,
            'cp' => 77,
            'effect' => 1.25,
            'time' => 96070
        )
    );
    public static $bid42 = array(
        array(
            'wood' => 740,
            'clay' => 850,
            'iron' => 960,
            'crop' => 620,
            'pop' => 4,
            'cp' => 4,
            'effect' => 0,
            'time' => 355
        ),
        array(
            'wood' => 740,
            'clay' => 850,
            'iron' => 960,
            'crop' => 620,
            'pop' => 4,
            'cp' => 4,
            'effect' => 1,
            'time' => 355
        ),
        array(
            'wood' => 945,
            'clay' => 1090,
            'iron' => 1230,
            'crop' => 795,
            'pop' => 2,
            'cp' => 4,
            'effect' => 2,
            'time' => 720
        ),
        array(
            'wood' => 1210,
            'clay' => 1395,
            'iron' => 1575,
            'crop' => 1015,
            'pop' => 2,
            'cp' => 5,
            'effect' => 3,
            'time' => 1200
        ),
        array(
            'wood' => 1550,
            'clay' => 1785,
            'iron' => 2015,
            'crop' => 1300,
            'pop' => 2,
            'cp' => 6,
            'effect' => 4,
            'time' => 2040
        ),
        array(
            'wood' => 1985,
            'clay' => 2280,
            'iron' => 2575,
            'crop' => 1665,
            'pop' => 2,
            'cp' => 7,
            'effect' => 5,
            'time' => 4320
        ),
        array(
            'wood' => 2545,
            'clay' => 2920,
            'iron' => 3300,
            'crop' => 2130,
            'pop' => 3,
            'cp' => 9,
            'effect' => 6,
            'time' => 9300
        ),
        array(
            'wood' => 3255,
            'clay' => 3740,
            'iron' => 4220,
            'crop' => 2725,
            'pop' => 3,
            'cp' => 11,
            'effect' => 7,
            'time' => 14100
        ),
        array(
            'wood' => 4165,
            'clay' => 4785,
            'iron' => 5405,
            'crop' => 3490,
            'pop' => 3,
            'cp' => 13,
            'effect' => 8,
            'time' => 19200
        ),
        array(
            'wood' => 5330,
            'clay' => 6125,
            'iron' => 6920,
            'crop' => 4470,
            'pop' => 3,
            'cp' => 15,
            'effect' => 9,
            'time' => 23100
        ),
        array(
            'wood' => 6825,
            'clay' => 7840,
            'iron' => 8855,
            'crop' => 5720,
            'pop' => 3,
            'cp' => 19,
            'effect' => 10,
            'time' => 26400
        ),
        array(
            'wood' => 8735,
            'clay' => 10035,
            'iron' => 11335,
            'crop' => 7320,
            'pop' => 3,
            'cp' => 22,
            'effect' => 11,
            'time' => 32100
        ),
        array(
            'wood' => 11185,
            'clay' => 12845,
            'iron' => 14505,
            'crop' => 9370,
            'pop' => 3,
            'cp' => 27,
            'effect' => 12,
            'time' => 37800
        ),
        array(
            'wood' => 14315,
            'clay' => 16440,
            'iron' => 18570,
            'crop' => 11195,
            'pop' => 3,
            'cp' => 32,
            'effect' => 13,
            'time' => 44700
        ),
        array(
            'wood' => 18320,
            'clay' => 21045,
            'iron' => 23770,
            'crop' => 15350,
            'pop' => 3,
            'cp' => 39,
            'effect' => 15,
            'time' => 50400
        ),
        array(
            'wood' => 23450,
            'clay' => 26940,
            'iron' => 30425,
            'crop' => 19650,
            'pop' => 3,
            'cp' => 46,
            'effect' => 17,
            'time' => 58500
        ),
        array(
            'wood' => 30020,
            'clay' => 34480,
            'iron' => 38940,
            'crop' => 25150,
            'pop' => 4,
            'cp' => 55,
            'effect' => 19,
            'time' => 65400
        ),
        array(
            'wood' => 38425,
            'clay' => 44135,
            'iron' => 49845,
            'crop' => 32190,
            'pop' => 4,
            'cp' => 67,
            'effect' => 21,
            'time' => 75600
        ),
        array(
            'wood' => 49180,
            'clay' => 56490,
            'iron' => 63805,
            'crop' => 41205,
            'pop' => 4,
            'cp' => 80,
            'effect' => 23,
            'time' => 89100
        ),
        array(
            'wood' => 62950,
            'clay' => 72310,
            'iron' => 81670,
            'crop' => 52745,
            'pop' => 4,
            'cp' => 96,
            'effect' => 25,
            'time' => 102900
        ),
        array(
            'wood' => 80580,
            'clay' => 92555,
            'iron' => 104535,
            'crop' => 67510,
            'pop' => 4,
            'cp' => 115,
            'effect' => 30,
            'time' => 116700
        )
    );
    public static $bid43 = array(
        array(
            'wood' => 120,
            'clay' => 200,
            'iron' => 0,
            'crop' => 80,
            'pop' => 0,
            'cp' => 1,
            'effect' => 2,
            'time' => 35
        ),
        array(
            'wood' => 120,
            'clay' => 200,
            'iron' => 0,
            'crop' => 80,
            'pop' => 0,
            'cp' => 1,
            'effect' => 2,
            'time' => 35
        ),
        array(
            'wood' => 155,
            'clay' => 255,
            'iron' => 0,
            'crop' => 100,
            'pop' => 0,
            'cp' => 1,
            'effect' => 4,
            'time' => 255
        ),
        array(
            'wood' => 195,
            'clay' => 330,
            'iron' => 0,
            'crop' => 130,
            'pop' => 0,
            'cp' => 2,
            'effect' => 6,
            'time' => 545
        ),
        array(
            'wood' => 250,
            'clay' => 420,
            'iron' => 0,
            'crop' => 170,
            'pop' => 0,
            'cp' => 2,
            'effect' => 8,
            'time' => 1020
        ),
        array(
            'wood' => 320,
            'clay' => 535,
            'iron' => 0,
            'crop' => 215,
            'pop' => 0,
            'cp' => 2,
            'effect' => 10,
            'time' => 2400
        ),
        array(
            'wood' => 410,
            'clay' => 685,
            'iron' => 0,
            'crop' => 275,
            'pop' => 1,
            'cp' => 3,
            'effect' => 13,
            'time' => 5460
        ),
        array(
            'wood' => 530,
            'clay' => 880,
            'iron' => 0,
            'crop' => 350,
            'pop' => 1,
            'cp' => 4,
            'effect' => 15,
            'time' => 8100
        ),
        array(
            'wood' => 675,
            'clay' => 1125,
            'iron' => 0,
            'crop' => 275,
            'pop' => 1,
            'cp' => 4,
            'effect' => 17,
            'time' => 11400
        ),
        array(
            'wood' => 865,
            'clay' => 1440,
            'iron' => 0,
            'crop' => 575,
            'pop' => 1,
            'cp' => 5,
            'effect' => 20,
            'time' => 13800
        ),
        array(
            'wood' => 1105,
            'clay' => 1845,
            'iron' => 0,
            'crop' => 740,
            'pop' => 1,
            'cp' => 6,
            'effect' => 22,
            'time' => 15600
        ),
        array(
            'wood' => 1415,
            'clay' => 2360,
            'iron' => 0,
            'crop' => 945,
            'pop' => 1,
            'cp' => 7,
            'effect' => 24,
            'time' => 19200
        ),
        array(
            'wood' => 1815,
            'clay' => 3020,
            'iron' => 0,
            'crop' => 1210,
            'pop' => 1,
            'cp' => 9,
            'effect' => 27,
            'time' => 22500
        ),
        array(
            'wood' => 2320,
            'clay' => 3870,
            'iron' => 0,
            'crop' => 1545,
            'pop' => 1,
            'cp' => 11,
            'effect' => 29,
            'time' => 26700
        ),
        array(
            'wood' => 2970,
            'clay' => 4950,
            'iron' => 0,
            'crop' => 1980,
            'pop' => 1,
            'cp' => 13,
            'effect' => 32,
            'time' => 30000
        ),
        array(
            'wood' => 3805,
            'clay' => 6340,
            'iron' => 0,
            'crop' => 2535,
            'pop' => 1,
            'cp' => 15,
            'effect' => 35,
            'time' => 34800
        ),
        array(
            'wood' => 4870,
            'clay' => 8115,
            'iron' => 0,
            'crop' => 3245,
            'pop' => 2,
            'cp' => 18,
            'effect' => 37,
            'time' => 39000
        ),
        array(
            'wood' => 6230,
            'clay' => 10385,
            'iron' => 0,
            'crop' => 4155,
            'pop' => 2,
            'cp' => 22,
            'effect' => 40,
            'time' => 45000
        ),
        array(
            'wood' => 7975,
            'clay' => 13290,
            'iron' => 0,
            'crop' => 5315,
            'pop' => 2,
            'cp' => 27,
            'effect' => 43,
            'time' => 61500
        ),
        array(
            'wood' => 10210,
            'clay' => 17015,
            'iron' => 0,
            'crop' => 6805,
            'pop' => 2,
            'cp' => 32,
            'effect' => 46,
            'time' => 68630
        ),
        array(
            'wood' => 13065,
            'clay' => 21780,
            'iron' => 0,
            'crop' => 8710,
            'pop' => 2,
            'cp' => 38,
            'effect' => 49,
            'time' => 79910
        )
    );
    public static $bid45 = array(
        array(
            'wood' => 720,
            'clay' => 685,
            'iron' => 645,
            'crop' => 250,
            'pop' => 4,
            'cp' => 7,
            'effect' => 0,
            'time' => 2040
        ),
        array(
            'wood' => 720,
            'clay' => 685,
            'iron' => 645,
            'crop' => 250,
            'pop' => 4,
            'cp' => 7,
            'effect' => 100,
            'time' => 2040
        ),
        array(
            'wood' => 1815,
            'clay' => 1725,
            'iron' => 1625,
            'crop' => 625,
            'pop' => 2,
            'cp' => 9,
            'effect' => 200,
            'time' => 2520
        ),
        array(
            'wood' => 2285,
            'clay' => 2175,
            'iron' => 2050,
            'crop' => 785,
            'pop' => 2,
            'cp' => 10,
            'effect' => 300,
            'time' => 3120
        ),
        array(
            'wood' => 2880,
            'clay' => 2740,
            'iron' => 2580,
            'crop' => 990,
            'pop' => 2,
            'cp' => 12,
            'effect' => 400,
            'time' => 4080
        ),
        array(
            'wood' => 3630,
            'clay' => 3455,
            'iron' => 3250,
            'crop' => 1250,
            'pop' => 2,
            'cp' => 15,
            'effect' => 500,
            'time' => 6780
        ),
        array(
            'wood' => 4575,
            'clay' => 4350,
            'iron' => 4095,
            'crop' => 1570,
            'pop' => 3,
            'cp' => 18,
            'effect' => 600,
            'time' => 12900
        ),
        array(
            'wood' => 5760,
            'clay' => 5480,
            'iron' => 5160,
            'crop' => 1980,
            'pop' => 3,
            'cp' => 21,
            'effect' => 700,
            'time' => 18600
        ),
        array(
            'wood' => 7260,
            'clay' => 6905,
            'iron' => 6505,
            'crop' => 2495,
            'pop' => 3,
            'cp' => 26,
            'effect' => 800,
            'time' => 24600
        ),
        array(
            'wood' => 9150,
            'clay' => 8705,
            'iron' => 8195,
            'crop' => 3145,
            'pop' => 3,
            'cp' => 31,
            'effect' => 900,
            'time' => 29400
        ),
        array(
            'wood' => 11525,
            'clay' => 10965,
            'iron' => 10325,
            'crop' => 3960,
            'pop' => 3,
            'cp' => 37,
            'effect' => 1000,
            'time' => 33600
        ),
        array(
            'wood' => 14525,
            'clay' => 13815,
            'iron' => 13010,
            'crop' => 4990,
            'pop' => 3,
            'cp' => 45,
            'effect' => 1250,
            'time' => 40500
        ),
        array(
            'wood' => 18300,
            'clay' => 17410,
            'iron' => 16395,
            'crop' => 6290,
            'pop' => 3,
            'cp' => 53,
            'effect' => 1500,
            'time' => 43800
        ),
        array(
            'wood' => 23055,
            'clay' => 21935,
            'iron' => 20655,
            'crop' => 7925,
            'pop' => 3,
            'cp' => 64,
            'effect' => 1750,
            'time' => 55500
        ),
        array(
            'wood' => 29050,
            'clay' => 27640,
            'iron' => 26025,
            'crop' => 9985,
            'pop' => 3,
            'cp' => 77,
            'effect' => 2000,
            'time' => 62400
        ),
        array(
            'wood' => 36605,
            'clay' => 34825,
            'iron' => 32795,
            'crop' => 2585,
            'pop' => 3,
            'cp' => 92,
            'effect' => 2250,
            'time' => 72000
        ),
        array(
            'wood' => 46125,
            'clay' => 43880,
            'iron' => 41320,
            'crop' => 15855,
            'pop' => 4,
            'cp' => 111,
            'effect' => 2500,
            'time' => 80400
        ),
        array(
            'wood' => 58115,
            'clay' => 55290,
            'iron' => 52060,
            'crop' => 19975,
            'pop' => 4,
            'cp' => 133,
            'effect' => 2750,
            'time' => 92700
        ),
        array(
            'wood' => 73225,
            'clay' => 69665,
            'iron' => 65600,
            'crop' => 25170,
            'pop' => 4,
            'cp' => 160,
            'effect' => 3000,
            'time' => 109200
        ),
        array(
            'wood' => 92265,
            'clay' => 87780,
            'iron' => 82655,
            'crop' => 31715,
            'pop' => 4,
            'cp' => 192,
            'effect' => 3500,
            'time' => 125700
        ),
        array(
            'wood' => 116255,
            'clay' => 110600,
            'iron' => 104145,
            'crop' => 39960,
            'pop' => 4,
            'cp' => 230,
            'effect' => 1,
            'time' => 142200
        )
    );

}

?>