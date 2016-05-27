<?php
namespace bl\cms\gallery\backend\actions\image;
use bl\cms\gallery\models\entities\GalleryImage;
use yii\base\Action;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class ListAction extends Action
{
    public function run($albumId = null) {
        $images = GalleryImage::find();

        if(!empty($albumId)) {
            $images->where(['album_id' => $albumId]);
        }

        $images = $images->all();

        return $this->controller->render('list', [
            'images' => $images
        ]);
    }
}