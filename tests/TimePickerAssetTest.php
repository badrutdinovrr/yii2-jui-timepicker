<?php

namespace yii\jui\timepicker\tests;

use yii\helpers\FileHelper;
use yii\phpunit\TestCase;
use yii\jui\timepicker\TimePickerAsset;
use Yii;

class TimePickerAssetTest extends TestCase
{

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        foreach (glob(Yii::$app->getAssetManager()->basePath . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) as $dir) {
            FileHelper::removeDirectory($dir);
            $this->assertFalse(is_dir($dir));
        }
    }

    public function testBundle()
    {
        $bundle = Yii::$app->getAssetManager()->getBundle(TimePickerAsset::className());
        $this->assertInstanceOf('yii\jui\timepicker\TimePickerAsset', $bundle);
        $this->assertArrayHasKey(0, $bundle->depends);
        $this->assertEquals('yii\jui\datepicker\DatePickerAsset', $bundle->depends[0]);
        $this->assertArrayHasKey(0, $bundle->js);
        $this->assertFileExists($bundle->basePath . DIRECTORY_SEPARATOR . $bundle->js[0]);
        $this->assertArrayHasKey(0, $bundle->css);
        $this->assertFileExists($bundle->basePath . DIRECTORY_SEPARATOR . $bundle->css[0]);
    }
}
