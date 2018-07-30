<?php

namespace yii\jui\timepicker\tests;

use yii\helpers\FileHelper;
use yii\phpunit\TestCase;
use yii\jui\timepicker\TimePickerLanguageAsset;
use Yii;

class TimePickerLanguageAssetTest extends TestCase
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

    /**
     * @return array
     */
    public function defaultLanguageDataProvider()
    {
        return [
            ['en-US'], ['en-GB'], ['en']
        ];
    }

    /**
     * @param string $language
     * @dataProvider defaultLanguageDataProvider
     */
    public function testBundleNotHasFile1($language)
    {
        Yii::$app->language = $language;
        $bundle = Yii::$app->getAssetManager()->getBundle(TimePickerLanguageAsset::className());
        $this->assertInstanceOf('yii\jui\timepicker\TimePickerLanguageAsset', $bundle);
        $this->assertArrayHasKey(0, $bundle->depends);
        $this->assertEquals('yii\jui\timepicker\TimePickerAsset', $bundle->depends[0]);
        $this->assertArrayHasKey(1, $bundle->depends);
        $this->assertEquals('yii\jui\datepicker\DatePickerLanguageAsset', $bundle->depends[1]);
        $this->assertArrayHasKey(2, $bundle->depends);
        $this->assertEquals('yii\jui\datepicker\DatePickerLanguageFixAsset', $bundle->depends[2]);
        $this->assertArrayNotHasKey(0, $bundle->js);
    }

    /**
     * @param string $language
     * @dataProvider defaultLanguageDataProvider
     */
    public function testBundleNotHasFile2($language)
    {
        $assetManager = Yii::$app->getAssetManager();
        $assetManager->bundles[TimePickerLanguageAsset::className()] = ['language' => $language];
        $bundle = $assetManager->getBundle(TimePickerLanguageAsset::className());
        $this->assertInstanceOf('yii\jui\timepicker\TimePickerLanguageAsset', $bundle);
        $this->assertArrayHasKey(0, $bundle->depends);
        $this->assertEquals('yii\jui\timepicker\TimePickerAsset', $bundle->depends[0]);
        $this->assertArrayHasKey(1, $bundle->depends);
        $this->assertEquals('yii\jui\datepicker\DatePickerLanguageAsset', $bundle->depends[1]);
        $this->assertArrayHasKey(2, $bundle->depends);
        $this->assertEquals('yii\jui\datepicker\DatePickerLanguageFixAsset', $bundle->depends[2]);
        $this->assertArrayNotHasKey(0, $bundle->js);
    }

    /**
     * @return array
     */
    public function languageDataProvider()
    {
        return [
            ['af'], ['am'], ['bg'], ['ca'], ['cs'],
            ['da'], ['de'], ['el'], ['es'], ['et'],
            ['eu'], ['fa'], ['fi'], ['fr'], ['gl'],
            ['he'], ['hr'], ['hu'], ['id'], ['it'],
            ['ja'], ['ko'], ['lt'], ['lv'], ['mk'],
            ['nl'], ['no'], ['pl'], ['pt-BR'], ['pt'],
            ['ro'], ['ru'], ['sk'], ['sl'], ['sr-RS'],
            ['sr-YU'], ['sv'], ['th'], ['tr'], ['uk'],
            ['vi'], ['zh-CN'], ['zh-TW']
        ];
    }

    /**
     * @param string $language
     * @dataProvider languageDataProvider
     */
    public function testBundleHasFile1($language)
    {
        Yii::$app->language = $language;
        $bundle = Yii::$app->getAssetManager()->getBundle(TimePickerLanguageAsset::className());
        $this->assertInstanceOf('yii\jui\timepicker\TimePickerLanguageAsset', $bundle);
        $this->assertArrayHasKey(0, $bundle->depends);
        $this->assertEquals('yii\jui\timepicker\TimePickerAsset', $bundle->depends[0]);
        $this->assertArrayHasKey(1, $bundle->depends);
        $this->assertEquals('yii\jui\datepicker\DatePickerLanguageAsset', $bundle->depends[1]);
        $this->assertArrayHasKey(2, $bundle->depends);
        $this->assertEquals('yii\jui\datepicker\DatePickerLanguageFixAsset', $bundle->depends[2]);
        $this->assertArrayHasKey(0, $bundle->js);
        $this->assertFileExists($bundle->basePath . DIRECTORY_SEPARATOR . $bundle->js[0]);
    }

    /**
     * @param string $language
     * @dataProvider languageDataProvider
     */
    public function testBundleHasFile2($language)
    {
        $assetManager = Yii::$app->getAssetManager();
        $assetManager->bundles[TimePickerLanguageAsset::className()] = ['language' => $language];
        $bundle = $assetManager->getBundle(TimePickerLanguageAsset::className());
        $this->assertInstanceOf('yii\jui\timepicker\TimePickerLanguageAsset', $bundle);
        $this->assertArrayHasKey(0, $bundle->depends);
        $this->assertEquals('yii\jui\timepicker\TimePickerAsset', $bundle->depends[0]);
        $this->assertArrayHasKey(1, $bundle->depends);
        $this->assertEquals('yii\jui\datepicker\DatePickerLanguageAsset', $bundle->depends[1]);
        $this->assertArrayHasKey(2, $bundle->depends);
        $this->assertEquals('yii\jui\datepicker\DatePickerLanguageFixAsset', $bundle->depends[2]);
        $this->assertArrayHasKey(0, $bundle->js);
        $this->assertFileExists($bundle->basePath . DIRECTORY_SEPARATOR . $bundle->js[0]);
    }
}
