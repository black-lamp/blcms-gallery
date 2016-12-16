<?php

namespace bl\cms\gallery\frontend\widgets;

use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\gallery\models\entities\GalleryImage;
use yii\helpers\Html;

/**
 * Gallery renders a BlueImp Gallery items
 *
 * @author Vyacheslav Nozhenko <vv.nojenko@gmail.com>
 */
class Gallery extends \dosamigos\gallery\Gallery
{
    /**
     * @var GalleryImage[] Gallery images.
     */
    public $items;

    /**
     * @var array HTML attributes of the link.
     */
    public $itemOptions;

    /**
     * @var array HTML attributes of the image to be displayed.
     */
    public $imageOptions;


    /**
     * @param GalleryImage $item
     * @return null|string the item to render
     */
    public function renderItem($item)
    {
        if (is_string($item)) {
            return Html::a(Html::img($item), $item, ['class' => 'gallery-item']);
        }

        $thumb = GalleryAlbum::getImageSrc($item->file_name, 'thumb');
        if ($thumb === null) {
            return null;
        }

        $original = GalleryAlbum::getImageSrc($item->file_name, 'original');

        $url = (!empty($original)) ? $original : $thumb;
        $this->itemOptions['title'] = $item->translation->title;
        $this->imageOptions['alt'] = $item->translation->alt;
        Html::addCssClass($this->itemOptions, 'gallery-item');

        return Html::a(Html::img($thumb, $this->imageOptions), $url, $this->itemOptions);
    }

}
