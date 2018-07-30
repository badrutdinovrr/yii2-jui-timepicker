<?php

namespace yii\jui\timepicker;

use yii\web\AssetBundle;

class TimePickerAsset extends AssetBundle
{

    public $sourcePath = '@bower/jqueryui-timepicker-addon/dist';

    public $depends = ['yii\jui\datepicker\DatePickerAsset'];

    public $js = ['jquery-ui-timepicker-addon.min.js'];

    public $css = ['jquery-ui-timepicker-addon.min.css'];
}
