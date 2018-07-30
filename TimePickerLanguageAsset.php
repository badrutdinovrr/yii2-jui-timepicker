<?php

namespace yii\jui\timepicker;

use yii\web\AssetBundle;
use Yii;

class TimePickerLanguageAsset extends AssetBundle
{

    public $sourcePath = '@bower/jqueryui-timepicker-addon/dist/i18n';

    public $depends = [
        'yii\jui\timepicker\TimePickerAsset',
        'yii\jui\datepicker\DatePickerLanguageAsset',
        'yii\jui\datepicker\DatePickerLanguageFixAsset'
    ];

    /**
     * @var string
     * @see http://www.yiiframework.com/doc-2.0/yii-base-application.html#$language-detail
     * @uses \yii\base\Application::$language
     */
    public $language;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (is_null($this->language)) {
            $this->language = Yii::$app->language;
            if (is_null($this->language)) {
                $this->language = 'en-US';
            }
        }
        if (($this->language != 'en-US') && ($this->language != 'en')) {
            $sourcePath = Yii::getAlias($this->sourcePath);
            $jsFile = 'jquery-ui-timepicker-' . $this->language . '.js';
            if (is_file($sourcePath . DIRECTORY_SEPARATOR . $jsFile)) {
                $this->js[] = $jsFile;
            } elseif ((strlen($this->language) == 5) && (strncmp($this->language, 'en', 2) != 0)) {
                $jsFile = 'jquery-ui-timepicker-' . substr($this->language, 0, 2) . '.js';
                if (is_file($sourcePath . DIRECTORY_SEPARATOR . $jsFile)) {
                    $this->js[] = $jsFile;
                }
            }
        }
    }
}
