<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifier
 */


function smarty_modifier_number($number, $tipoMoneda = null)
{
    if(!(string)$number){
        return null;
    }
    $number = floatval((string)$number);

    $coinSymbol = '$';
    if($tipoMoneda == 'EUR') {
        $coinSymbol = '€';
    }

    return $coinSymbol.number_format($number, 2, '.', ',');
}

?>
