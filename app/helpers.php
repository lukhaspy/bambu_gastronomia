<?php

function format_money($money){
    if (!$money) {
        return "Gs 0.00";
    }

    $money = number_format($money, 0, '', '.');

    if (strpos($money, '-') !== false) {
        $formatted = explode('-', $money);
        return "Gs $formatted[1]";
    }

    return "Gs $money";
}

function getUnity($id){
    $text = '';
    switch ($id) {
        case 0:
            $text = 'Unitario';
            break;
        case 1:
            $text = 'Gramos';
            break;
        case 2:
            $text = 'Kilogramos';
            break;
        case 3:
            $text = 'Mililitro';
            break;
        case 4:
            $text = 'Litros';
            break;
    }

    return $text;
}

function getUnities(){
    return ['0' => 'Unidad', '1' => 'Gramos', '2' => 'Kilogramos', '3' => 'Mililitros', '4' => 'Litros'];
}
