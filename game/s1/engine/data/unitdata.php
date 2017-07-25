<?php

class UnitData {

    public static function get($type, $a = null) {
        $name = "u" . $type;
        if ($a === null) {
            if (isset(self::$$name)) {
                return self::$$name;
            } else {
                return array('atk' => 0, 'di' => 0, 'dc' => 0, 'wood' => 0, 'clay' => 0, 'iron' => 0, 'crop' => 0, 'pop' => 0, 'speed' => 0, 'time' => 0, 'cap' => 0);
            }
        } else {
            if (isset(self::$$name)) {
                $r = self::$$name;
                if (isset($r[$a])) {
                    return $r[$a];
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }
    }

    public static $unitsbytype = array('infantry' => array(1, 2, 3, 11, 12, 13, 14, 21, 22, 31, 32, 33, 34, 41, 42, 43, 44), 'cavalry' => array(4, 5, 6, 15, 16, 23, 24, 25, 26, 35, 36, 45, 46), 'siege' => array(7, 8, 17, 18, 27, 28, 37, 38, 47, 48), 'ram' => array(7, 17, 27, 47), 'catapult' => array(8, 18, 28, 48), 'expansion' => array(9, 10, 19, 20, 29, 30, 39, 40, 49, 50), 'scout' => array(4, 14, 23, 44), 'chief' => array(9, 19, 29, 49));
    
    //Romans
    public static $u1 = array('atk' => 40, 'di' => 35, 'dc' => 50, 'wood' => 75, 'clay' => 50, 'iron' => 100, 'crop' => 0, 'pop' => 1, 'speed' => 6, 'time' => 1600, 'cap' => 50);
    public static $u2 = array('atk' => 30, 'di' => 65, 'dc' => 35, 'wood' => 80, 'clay' => 100, 'iron' => 160, 'crop' => 0, 'pop' => 1, 'speed' => 5, 'time' => 1760, 'cap' => 20);
    public static $u3 = array('atk' => 70, 'di' => 40, 'dc' => 25, 'wood' => 100, 'clay' => 110, 'iron' => 140, 'crop' => 0, 'pop' => 1, 'speed' => 7, 'time' => 1920, 'cap' => 50);
    public static $u4 = array('atk' => 0, 'di' => 20, 'dc' => 10, 'wood' => 100, 'clay' => 140, 'iron' => 10, 'crop' => 0, 'pop' => 2, 'speed' => 16, 'time' => 1360, 'cap' => 0);
    public static $u5 = array('atk' => 120, 'di' => 65, 'dc' => 50, 'wood' => 350, 'clay' => 260, 'iron' => 180, 'crop' => 0, 'pop' => 3, 'speed' => 14, 'time' => 2640, 'cap' => 100);
    public static $u6 = array('atk' => 180, 'di' => 80, 'dc' => 105, 'wood' => 280, 'clay' => 340, 'iron' => 600, 'crop' => 0, 'pop' => 4, 'speed' => 10, 'time' => 3520, 'cap' => 70);
    public static $u7 = array('atk' => 60, 'di' => 30, 'dc' => 75, 'wood' => 700, 'clay' => 180, 'iron' => 400, 'crop' => 0, 'pop' => 3, 'speed' => 4, 'time' => 4600, 'cap' => 0);
    public static $u8 = array('atk' => 75, 'di' => 60, 'dc' => 10, 'wood' => 690, 'clay' => 1000, 'iron' => 4000, 'crop' => 0, 'pop' => 6, 'speed' => 3, 'time' => 9000, 'cap' => 0);
    public static $u9 = array('atk' => 50, 'di' => 40, 'dc' => 30, 'wood' => 30750, 'clay' => 27200, 'iron' => 45000, 'crop' => 0, 'pop' => 5, 'speed' => 5, 'time' => 90700, 'cap' => 0);
    
    //Teutons
    public static $u10 = array('atk' => 0, 'di' => 80, 'dc' => 80, 'wood' => 3000, 'clay' => 3000, 'iron' => 4500, 'crop' => 0, 'pop' => 1, 'speed' => 5, 'time' => 26900, 'cap' => 3000);
    public static $u11 = array('atk' => 40, 'di' => 20, 'dc' => 5, 'wood' => 85, 'clay' => 65, 'iron' => 30, 'crop' => 0, 'pop' => 1, 'speed' => 7, 'time' => 720, 'cap' => 60);
    public static $u12 = array('atk' => 10, 'di' => 35, 'dc' => 60, 'wood' => 125, 'clay' => 50, 'iron' => 65, 'crop' => 0, 'pop' => 1, 'speed' => 7, 'time' => 1120, 'cap' => 40);
    public static $u13 = array('atk' => 60, 'di' => 30, 'dc' => 30, 'wood' => 80, 'clay' => 65, 'iron' => 130, 'crop' => 0, 'pop' => 1, 'speed' => 6, 'time' => 1200, 'cap' => 50);
    public static $u14 = array('atk' => 0, 'di' => 10, 'dc' => 5, 'wood' => 140, 'clay' => 80, 'iron' => 30, 'crop' => 0, 'pop' => 1, 'speed' => 9, 'time' => 1120, 'cap' => 0);
    public static $u15 = array('atk' => 55, 'di' => 100, 'dc' => 40, 'wood' => 330, 'clay' => 170, 'iron' => 200, 'crop' => 0, 'pop' => 2, 'speed' => 10, 'time' => 2400, 'cap' => 110);
    public static $u16 = array('atk' => 150, 'di' => 50, 'dc' => 75, 'wood' => 280, 'clay' => 320, 'iron' => 260, 'crop' => 0, 'pop' => 3, 'speed' => 9, 'time' => 2960, 'cap' => 80);
    public static $u17 = array('atk' => 65, 'di' => 30, 'dc' => 80, 'wood' => 800, 'clay' => 150, 'iron' => 250, 'crop' => 0, 'pop' => 3, 'speed' => 4, 'time' => 4200, 'cap' => 0);
    public static $u18 = array('atk' => 50, 'di' => 60, 'dc' => 10, 'wood' => 660, 'clay' => 900, 'iron' => 370, 'crop' => 0, 'pop' => 6, 'speed' => 3, 'time' => 9000, 'cap' => 0);
    public static $u19 = array('atk' => 40, 'di' => 60, 'dc' => 40, 'wood' => 35500, 'clay' => 26600, 'iron' => 25000, 'crop' => 0, 'pop' => 4, 'speed' => 5, 'time' => 70500, 'cap' => 0);
    public static $u20 = array('atk' => 10, 'di' => 80, 'dc' => 80, 'wood' => 4000, 'clay' => 3500, 'iron' => 3200, 'crop' => 0, 'pop' => 1, 'speed' => 5, 'time' => 31000, 'cap' => 3000);
    
    //Gauls
    public static $u21 = array('atk' => 15, 'di' => 40, 'dc' => 50, 'wood' => 85, 'clay' => 100, 'iron' => 50, 'crop' => 0, 'pop' => 1, 'speed' => 7, 'time' => 1040, 'cap' => 35);
    public static $u22 = array('atk' => 65, 'di' => 35, 'dc' => 20, 'wood' => 95, 'clay' => 60, 'iron' => 140, 'crop' => 0, 'pop' => 1, 'speed' => 6, 'time' => 1440, 'cap' => 45);
    public static $u23 = array('atk' => 0, 'di' => 20, 'dc' => 10, 'wood' => 140, 'clay' => 110, 'iron' => 20, 'crop' => 0, 'pop' => 2, 'speed' => 17, 'time' => 1360, 'cap' => 0);
    public static $u24 = array('atk' => 90, 'di' => 25, 'dc' => 40, 'wood' => 200, 'clay' => 280, 'iron' => 130, 'crop' => 0, 'pop' => 2, 'speed' => 19, 'time' => 2480, 'cap' => 75);
    public static $u25 = array('atk' => 45, 'di' => 115, 'dc' => 55, 'wood' => 300, 'clay' => 270, 'iron' => 190, 'crop' => 0, 'pop' => 2, 'speed' => 16, 'time' => 2560, 'cap' => 35);
    public static $u26 = array('atk' => 140, 'di' => 50, 'dc' => 165, 'wood' => 300, 'clay' => 380, 'iron' => 440, 'crop' => 0, 'pop' => 3, 'speed' => 13, 'time' => 3120, 'cap' => 65);
    public static $u27 = array('atk' => 50, 'di' => 30, 'dc' => 105, 'wood' => 750, 'clay' => 370, 'iron' => 220, 'crop' => 0, 'pop' => 3, 'speed' => 4, 'time' => 5000, 'cap' => 0);
    public static $u28 = array('atk' => 70, 'di' => 45, 'dc' => 10, 'wood' => 590, 'clay' => 1200, 'iron' => 220, 'crop' => 0, 'pop' => 6, 'speed' => 3, 'time' => 9000, 'cap' => 0);
    public static $u29 = array('atk' => 40, 'di' => 50, 'dc' => 50, 'wood' => 30750, 'clay' => 45400, 'iron' => 31000, 'crop' => 0, 'pop' => 4, 'speed' => 4, 'time' => 90700, 'cap' => 0);
    public static $u30 = array('atk' => 0, 'di' => 80, 'dc' => 80, 'wood' => 3000, 'clay' => 4000, 'iron' => 3000, 'crop' => 0, 'pop' => 1, 'speed' => 5, 'time' => 22700, 'cap' => 3000);
    
    //Nature
    public static $u31 = array('atk' => 10, 'di' => 25, 'dc' => 20, 'wood' => 85, 'clay' => 75, 'iron' => 120, 'crop' => 0, 'speed' => 7, 'pop' => 1, 'time' => 1600, 'cap' => 45);
    public static $u32 = array('atk' => 20, 'di' => 35, 'dc' => 40, 'wood' => 125, 'clay' => 130, 'iron' => 60, 'crop' => 0, 'speed' => 7, 'pop' => 1, 'time' => 1800, 'cap' => 65);
    public static $u33 = array('atk' => 60, 'di' => 40, 'dc' => 60, 'wood' => 140, 'clay' => 150, 'iron' => 40, 'crop' => 0, 'speed' => 6, 'pop' => 1, 'time' => 1900, 'cap' => 80);
    public static $u34 = array('atk' => 10, 'di' => 66, 'dc' => 50, 'wood' => 95, 'clay' => 120, 'iron' => 65, 'crop' => 0, 'speed' => 9, 'pop' => 1, 'time' => 2000, 'cap' => 0);
    public static $u35 = array('atk' => 50, 'di' => 70, 'dc' => 33, 'wood' => 250, 'clay' => 200, 'iron' => 125, 'crop' => 0, 'speed' => 10, 'pop' => 2, 'time' => 2000, 'cap' => 120);
    public static $u36 = array('atk' => 100, 'di' => 80, 'dc' => 70, 'wood' => 250, 'clay' => 125, 'iron' => 250, 'crop' => 0, 'speed' => 9, 'pop' => 2, 'time' => 2000, 'cap' => 150);
    public static $u37 = array('atk' => 250, 'di' => 140, 'dc' => 200, 'wood' => 250, 'clay' => 220, 'iron' => 135, 'crop' => 0, 'speed' => 4, 'pop' => 3, 'time' => 2000, 'cap' => 125);
    public static $u38 = array('atk' => 450, 'di' => 380, 'dc' => 240, 'wood' => 125, 'clay' => 250, 'iron' => 300, 'crop' => 0, 'speed' => 3, 'pop' => 3, 'time' => 2000, 'cap' => 0);
    public static $u39 = array('atk' => 200, 'di' => 170, 'dc' => 250, 'wood' => 350, 'clay' => 350, 'iron' => 125, 'crop' => 0, 'speed' => 5, 'pop' => 3, 'time' => 70500, 'cap' => 0);
    public static $u40 = array('atk' => 600, 'di' => 440, 'dc' => 520, 'wood' => 350, 'clay' => 250, 'iron' => 135, 'crop' => 0, 'speed' => 5, 'pop' => 5, 'time' => 31000, 'cap' => 3000);
    
    //Natar
    public static $u41 = array('atk' => 20, 'di' => 35, 'dc' => 50, 'wood' => 105, 'clay' => 110, 'iron' => 85, 'crop' => 0, 'pop' => 1, 'speed' => 10, 'time' => 1100, 'cap' => 25);
    public static $u42 = array('atk' => 65, 'di' => 30, 'dc' => 10, 'wood' => 95, 'clay' => 145, 'iron' => 100, 'crop' => 0, 'pop' => 1, 'speed' => 9, 'time' => 1300, 'cap' => 55);
    public static $u43 = array('atk' => 100, 'di' => 90, 'dc' => 75, 'wood' => 125, 'clay' => 165, 'iron' => 130, 'crop' => 0, 'pop' => 1, 'speed' => 15, 'time' => 1500, 'cap' => 60);
    public static $u44 = array('atk' => 0, 'di' => 10, 'dc' => 0, 'wood' => 50, 'clay' => 25, 'iron' => 20, 'crop' => 0, 'pop' => 2, 'speed' => 20, 'time' => 2200, 'cap' => 0);
    public static $u45 = array('atk' => 155, 'di' => 80, 'dc' => 50, 'wood' => 150, 'clay' => 205, 'iron' => 135, 'crop' => 0, 'pop' => 2, 'speed' => 22, 'time' => 3000, 'cap' => 80);
    public static $u46 = array('atk' => 170, 'di' => 140, 'dc' => 80, 'wood' => 175, 'clay' => 230, 'iron' => 200, 'crop' => 0, 'pop' => 2, 'speed' => 20, 'time' => 3450, 'cap' => 45);
    public static $u47 = array('atk' => 250, 'di' => 120, 'dc' => 150, 'wood' => 225, 'clay' => 255, 'iron' => 230, 'crop' => 0, 'pop' => 3, 'speed' => 17, 'time' => 4000, 'cap' => 55);
    public static $u48 = array('atk' => 60, 'di' => 45, 'dc' => 10, 'wood' => 1500, 'clay' => 760, 'iron' => 890, 'crop' => 0, 'pop' => 0, 'speed' => 0, 'time' => 0, 'cap' => 0);
    public static $u49 = array('atk' => 80, 'di' => 50, 'dc' => 50, 'wood' => 37000, 'clay' => 30000, 'iron' => 32000, 'crop' => 0, 'pop' => 0, 'speed' => 0, 'time' => 0, 'cap' => 0);
    public static $u50 = array('atk' => 30, 'di' => 40, 'dc' => 40, 'wood' => 3000, 'clay' => 3500, 'iron' => 4000, 'crop' => 0, 'pop' => 0, 'speed' => 0, 'time' => 0, 'cap' => 0);

}
