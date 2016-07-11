<?php
/**
 * Created by PhpStorm.
 * User: romani
 * Date: 11/07/16
 * Time: 14:33
 */

namespace YodaEventBundle\Util;


class DateUtil
{

    public static function ago(\DateTime $dt){

        return "postada em " . $dt->format("d/M/Y");

    }

}