<?php

namespace yii\jui\timepicker;

use DateTime;
use DateTimeInterface;
use yii\helpers\Html;
use yii\widgets\InputWidget;
use yii\base\InvalidParamException;
use yii\web\JsExpression;
use yii\helpers\Json;
use Yii;

class TimePicker extends InputWidget
{

    /**
     * @var string
     * @see http://trentrichardson.com/examples/timepicker/#tp-options
     * @see http://www.yiiframework.com/doc-2.0/yii-i18n-formatter.html#$timeFormat-detail
     * @uses \yii\i18n\Formatter::$timeFormat
     */
    public $timeFormat;

    /**
     * @var string
     * @see http://trentrichardson.com/examples/timepicker/#tp-options
     * @see http://www.yiiframework.com/doc-2.0/yii-i18n-formatter.html#$timeFormat-detail
     */
    public $altTimeFormat;

    /**
     * @var bool
     * @see http://api.jqueryui.com/datepicker/#option-showButtonPanel
     */
    public $showButtonPanel = true;

    /**
     * @var array
     */
    public $altOptions = [];

    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (is_null($this->timeFormat)) {
            $this->timeFormat = Yii::$app->getFormatter()->timeFormat;
            if (is_null($this->timeFormat)) {
                $this->timeFormat = 'medium';
            }
        }
        if (is_null($this->altTimeFormat)) {
            $this->altTimeFormat = 'HH:mm:ss';
        }
        Html::addCssClass($this->options, 'form-control');
        $this->altOptions['id'] = $this->options['id'] . '-alt';
        $this->clientOptions = array_merge(array_diff_assoc([
            'showButtonPanel' => $this->showButtonPanel
        ], get_class_vars(__CLASS__)), $this->clientOptions, [
            'timeFormat' => FormatConverter::convertDatePhpOrIcuToJui($this->timeFormat, 'time'),
            'altField' => '#' . $this->altOptions['id'],
            'altFieldTimeOnly' => false,
            'altTimeFormat' => FormatConverter::convertDatePhpOrIcuToJui($this->altTimeFormat, 'time')
        ]);
        if (array_key_exists('readonly', $this->options) && $this->options['readonly']) {
            if (!array_key_exists('beforeShow', $this->clientOptions)) {
                $this->clientOptions['beforeShow'] = new JsExpression('function (input, inst) { return false; }');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $hasModel = $this->hasModel();
        if ($hasModel) {
            if (array_key_exists('value', $this->options)) {
                $value = $this->options['value'];
            } else {
                $value = Html::getAttributeValue($this->model, $this->attribute);
            }
        } else {
            $value = $this->value;
        }
        if (is_int($value) || (is_string($value) && strlen($value))
            || ($value instanceof DateTime) || ($value instanceof DateTimeInterface)
        ) {
            $formatter = Yii::$app->getFormatter();
            try {
                $altValue = $formatter->asTime($value, $this->altTimeFormat);
                $value = $formatter->asTime($value, $this->timeFormat);
            } catch (InvalidParamException $e) {
                $altValue = $value;
            }
        } else {
            $altValue = $value;
        }
        if ($hasModel) {
            $this->options = array_merge($this->options, [
                'name' => false,
                'value' => $value
            ]);
            $this->altOptions['value'] = $altValue;
            $output = Html::activeTextInput($this->model, $this->attribute, $this->options);
            $output .= Html::activeHiddenInput($this->model, $this->attribute, $this->altOptions);
        } else {
            $output = Html::textInput(false, $value, $this->options);
            $output .= Html::hiddenInput($this->name, $altValue, $this->altOptions);
        }
        $js = 'jQuery(\'#' . $this->options['id'] . '\').timepicker(' . Json::htmlEncode($this->clientOptions) . ');';
        if (Yii::$app->getRequest()->getIsAjax()) {
            $output .= Html::script($js);
        } else {
            $view = $this->getView();
            TimePickerAsset::register($view);
            TimePickerLanguageAsset::register($view);
            $view->registerJs($js);
        }
        return $output;
    }
}
