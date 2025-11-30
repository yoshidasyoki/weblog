<?php

namespace App\Helpers;

use \DateTime;
use \DateTimeZone;

class TimeHelper
{
    function convertTimeJst($date, $formatType = 'Y-m-d'): string
    {
        $utc = new DateTime($date, new DateTimeZone('UTC'));
        $utc->setTimeZone(new DateTimeZone('Asia/Tokyo'));
        return $utc->format($formatType);
    }
}
