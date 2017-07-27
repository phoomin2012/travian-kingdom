<?php

/*
 * Develop by Phumin Chanthalert from Thailand
 * Facebook : http://fb.com/phoomin2012
 * Tel. : 091-8585234 (Thai mobile)
 * Copy Rigth © Phumin Chanthalert.
 */

class Generater {

    public function getTimeFormat($sec) {
        $min = 0;
        $hr = 0;
        $days = 0;
        while ($sec >= 60) :
            $sec -= 60;
            $min += 1;
        endwhile;
        while ($min >= 60) :
            $min -= 60;
            $hr += 1;
        endwhile;
        if ($min < 10) {
            $min = "0" . round($min);
        }
        if ($sec < 10) {
            $sec = "0" . round($sec);
        }
        return $hr . ":" . $min . ":" . $sec;
    }

}

?>