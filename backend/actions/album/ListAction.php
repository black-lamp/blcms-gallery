<?php
namespace bl\cms\gallery\backend\actions\album;
use bl\cms\gallery\models\entities\GalleryAlbum;
use yii\base\Action;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class ListAction extends Action
{
    public function run() {
        return $this->controller->render('list', [
            'albums' => GalleryAlbum::find()->all()
        ]);
    }
}