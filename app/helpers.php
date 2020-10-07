<?php

<<<<<<< HEAD
function format_money($money)
{
    if (!$money) {
        return "Gs 0.00";
=======
function format_money($money){
    if(!$money) {
        return 'Gs. 0.00';
>>>>>>> 0dae02f8d989b73dd0b8a0202da00f40693a0729
    }

    $money = number_format($money, 0,'','.');

    if (strpos($money, '-') !== false) {
        $formatted = explode('-', $money);
<<<<<<< HEAD
        return "Gs $formatted[1]";
    }

    return "\$$money";
=======
        return "-Gs. $formatted[1]";
    }

    return "Gs. $money";
>>>>>>> 0dae02f8d989b73dd0b8a0202da00f40693a0729
}
