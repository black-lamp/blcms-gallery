<?php
namespace bl\cms\gallery\backend\controllers;
use bl\cms\gallery\models\entities\GalleryImage;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class ImageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['list'],
                        'roles' => ['viewImageList'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create'],
                        'roles' => ['createImage'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['edit', 'switchShow'],
                        'roles' => ['editImage'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['remove'],
                        'roles' => ['removeImage'],
                        'allow' => true,
                    ],
                ],
            ]
        ];
    }

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