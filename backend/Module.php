<?php
namespace bl\cms\gallery\backend;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'bl\cms\gallery\backend\controllers';
    public $imagesPath = '@vendor/black-lamp/blcms-gallery/images';
}