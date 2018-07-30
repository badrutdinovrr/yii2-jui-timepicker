<?php

namespace yii\jui\timepicker;

use yii\jui\datepicker\FormatConverter as BaseFormatConverter;

class FormatConverter extends BaseFormatConverter
{

    /**
     * @inheritdoc
     */
    public static function convertDatePhpOrIcuToJui($pattern, $type = 'date', $locale = null)
    {
        if ($type == 'time') {
            if (strncmp($pattern, 'php:', 4) === 0) {
                return static::convertTimePhpToJui(substr($pattern, 4));
            } else {
                return static::convertTimePhpToJui(static::convertDateIcuToPhp($pattern, $type, $locale));
            }
        } else {
            return parent::convertDatePhpOrIcuToJui($pattern, $type, $locale);
        }
    }

    /**
     * @param string $pattern
     * @return string
     * @see http://php.net/manual/en/function.date.php
     * @see http://trentrichardson.com/examples/timepicker/#tp-formatting
     */
    public static function convertTimePhpToJui($pattern)
    {
        return strtr(preg_replace('~[^GHghisaAeP\W]~', '', $pattern), [
            'G' => 'H', // Hour with no leading 0 (24 hour)
            'H' => 'HH', // Hour with leading 0 (24 hour)
            'g' => 'h', // Hour with no leading 0 (12 hour)
            'h' => 'hh', // Hour with leading 0 (12 hour)
            'i' => 'mm', // Minute with leading 0
            's' => 'ss', // Second with leading 0
            'a' => 'tt', // am or pm for AM/PM
            'A' => 'TT', // AM or PM for AM/PM
            'e' => 'z', // Timezone as defined by timezoneList
            'P' => 'Z' // Timezone in Iso 8601 format (+04:45)
        ]);
    }
}
