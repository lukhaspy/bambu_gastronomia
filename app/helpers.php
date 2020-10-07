<?php

function format_money($money){
    if(!$money) {
        return 'Gs. 0.00';
    }

    $money = number_format($money, 0,'','.');

    if(strpos($money, '-') !== false) {
        $formatted = explode('-', $money);
        return "-Gs. $formatted[1]";
    }

    return "Gs. $money";
}
