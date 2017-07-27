<?php

$colors = array('black', 'brown', 'grey', 'red', 'yellow', 'whiteblonde', 'brightbrown', 'blueblack');
$sexs = array("female", "male");
$attrs_male = array('hair', 'nose', 'beard', 'mouth', 'eyebrow', 'eye', 'ear');
$attrs_female = array('hair', 'nose', 'mouth', 'eyebrow', 'eye', 'ear');
$sizes = array("125x125", "350x350");

$homedir = __DIR__ . '/heroNew/';

foreach ($sexs as $sex) {
    if (!file_exists($homedir . $sex)) {
        mkdir($homedir . $sex);
        mkdir($homedir . $sex . '/head');
    }
    foreach ($sizes as $size) {
        if (!file_exists($homedir . $sex . '/head/' . $size)) {
            mkdir($homedir . $sex . '/head/' . $size);
        }
        if ($sex == "female") {
            $attrs = $attrs_female;
        } else {
            $attrs = $attrs_male;
        }
        foreach ($attrs as $attr) {
            if (!file_exists($homedir . $sex . '/head/' . $size . '/' . $attr)) {
                mkdir($homedir . $sex . '/head/' . $size . '/' . $attr);
            }

            if ($attr == "hair") {
                $num = 12;
                $Hcolor = true;
            } elseif ($attr == "nose") {
                $num = 12;
                $Hcolor = false;
            } elseif ($attr == "mouth") {
                $num = 12;
                $Hcolor = false;
            } elseif ($attr == "eyebrow") {
                $num = 12;
                $Hcolor = false;
            } elseif ($attr == "eye") {
                $num = 12;
                $Hcolor = false;
            } elseif ($attr == "ear") {
                $num = 12;
                $Hcolor = false;
            } elseif ($attr == "beard") {
                $num = 11;
                $Hcolor = false;
                if ($sex == "female")
                    $num = 0;
            }

            for ($i = 0; $i < $num; $i++) {
                if ($Hcolor) {
                    foreach ($colors as $color) {
                        $link = 'http://cdn.traviantools.net/game/0.66/layout/images/source/heroNEW/' . $sex . '/head/' . $size . '/' . $attr . '/' . $attr . $i . '-' . $color . '.png';
                        $fname = $homedir . $sex . '/head/' . $size . '/' . $attr . '/' . $attr . $i . '-' . $color . '.png';

                        if (!file_exists($fname) || filesize($fname) != 0) {
                            file_put_contents($fname, file_get_contents($link));
                        }
                    }
                } else {
                    $link = 'http://cdn.traviantools.net/game/0.66/layout/images/source/heroNEW/' . $sex . '/head/' . $size . '/' . $attr . '/' . $attr . $i . '.png';
                    $fname = $homedir . $sex . '/head/' . $size . '/' . $attr . '/' . $attr . $i . '.png';

                    if (!file_exists($fname) || filesize($fname) != 0) {
                        file_put_contents($fname, file_get_contents($link));
                    }
                }
            }
        }
    }
}
echo "Success";
