<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifier
 */


function smarty_modifier_number($number)
{
    if(!(string)$number){
        return null;
    }

    return "$".number_format((string)$number, 2, '.', ',');
}

?>
