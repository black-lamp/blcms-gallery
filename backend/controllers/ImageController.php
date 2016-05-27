<?php
namespace bl\cms\gallery\backend\controllers;
use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\gallery\models\entities\GalleryImage;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class ImageController extends Controller
{
    public $defaultAction = 'list';

    public function actions()
    {
        return [
            'create' => [
                'class' => 'bl\cms\gallery\backend\actions\image\CreateEditAction'
            ],
            'edit' => [
                'class' => 'bl\cms\gallery\backend\actions\image\CreateEditAction'
            ],
            'list' => [
                'class' => 'bl\cms\gallery\backend\actions\image\ListAction'
            ]
        ];
    }

    public function actionSwitchShow($id) {
        /* @var GalleryImage $image */
        $image = GalleryImage::findOne($id);
        if(!empty($image)) {
            $image->show = !$image->show;
            $image->save();
        }
        return $this->goBack(Url::to(['list']));
    }

    public function actionRemove($id) {
        GalleryImage::deleteAll(['id' => $id]);
        return $this->goBack(Url::to(['list']));
    }
}