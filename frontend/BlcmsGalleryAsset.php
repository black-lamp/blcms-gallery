<?php
namespace bl\cms\gallery\frontend;

use yii\web\AssetBundle;

/**
 * GalleryAsset
 *
 * @author Vyacheslav Nozhenko <vv.nojenko@gmail.com>
 */
class BlcmsGalleryAsset extends AssetBundle
{
    public $js = [
        'js/blcms-blueimp-gallery.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
        parent::init();
    }
}
