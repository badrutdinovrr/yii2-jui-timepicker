<?php

namespace yii\jui\timepicker\tests;

use yii\jui\timepicker\FormatConverter;
use yii\phpunit\TestCase;

class FormatConverterTest extends TestCase
{

    /**
     * @return array
     */
    public function formatsDataProvider()
    {
        return [
            ['php:H:i:s', 'HH:mm:ss', 'HH:mm:ss'], // 01:49:09
            ['php:h:i a', 'hh:mm a', 'hh:mm tt'], // 01:49 am
            ['php:G:i:s', 'H:mm:ss', 'H:mm:ss'], // 1:49:09
            ['php:g:i a', 'h:mm a', 'h:mm tt'] // 1:49 am
        ];
    }

    /**
     * @param string $phpFormat
     * @param string $icuFormat
     * @param string $juiFormat
     * @dataProvider formatsDataProvider
     */
    public function testConvertDatePhpOrIcuToJui($phpFormat, $icuFormat, $juiFormat)
    {
        $this->assertEquals($juiFormat, FormatConverter::convertDatePhpOrIcuToJui($phpFormat, 'time'));
        $this->assertEquals($juiFormat, FormatConverter::convertDatePhpOrIcuToJui($icuFormat, 'time'));
    }

    /**
     * @return array
     * @see http://php.net/manual/en/function.date.php
     * @see http://trentrichardson.com/examples/timepicker/#tp-formatting
     */
    public function charactersDataProvider()
    {
        $characters = array_merge(array_fill_keys(array_merge(range('A', 'Z'), range('a', 'z')), ''), [
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
        array_walk($characters, function (&$value, $key) {
            $value = [$key, $value];
        });
        return array_values($characters);
    }

    /**
     * @param string $phpCharacter
     * @param string $juiCharacter
     * @dataProvider charactersDataProvider
     */
    public function testConvertTimePhpToJui($phpCharacter, $juiCharacter)
    {
        $this->assertEquals($juiCharacter, FormatConverter::convertTimePhpToJui($phpCharacter));
    }
}
