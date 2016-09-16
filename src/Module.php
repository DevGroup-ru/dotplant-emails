<?php

namespace DotPlant\Emails;

class Module extends \yii\base\Module
{
    /**
     * @var bool some property
     */
    public $someProperty = false;

    /**
     * @return self Module instance in application
     */
    public static function module()
    {
        $module = \Yii::$app->getModule('emails');
        if ($module === null) {
            $module = \Yii::createObject(self::class, ['emails']);
        }
        return $module;
    }
}
