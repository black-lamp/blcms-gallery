<?php
namespace bl\cms\gallery\backend;
use Yii;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'bl\cms\gallery\backend\controllers';
    public $imagesPath = '@frontend/web/images/gallery';

    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }


    public function registerTranslations()
    {
        Yii::$app->i18n->translations['blcms-gallery/backend*'] = [
            'class'          => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath'       => '@vendor/black-lamp/blcms-gallery/messages',
            'fileMap'        => [
                'blcms-gallery/backend/album' => 'album.php',
                'blcms-gallery/backend/image' => 'image.php',
            ],
        ];
    }
}