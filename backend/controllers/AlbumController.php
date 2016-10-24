<?php
namespace bl\cms\gallery\backend\controllers;
use bl\cms\gallery\models\entities\GalleryAlbum;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class AlbumController extends Controller
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
                        'actions' => ['list'],
                        'roles' => ['viewAlbumList'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create'],
                        'roles' => ['createAlbum'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['edit', 'switchShow'],
                        'roles' => ['editAlbum'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['remove'],
                        'roles' => ['removeAlbum'],
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
                'class' => 'bl\cms\gallery\backend\actions\album\CreateEditAction'
            ],
            'edit' => [
                'class' => 'bl\cms\gallery\backend\actions\album\CreateEditAction'
            ],
            'list' => [
                'class' => 'bl\cms\gallery\backend\actions\album\ListAction'
            ]
        ];
    }

    public function actionSwitchShow($id) {
        /* @var GalleryAlbum $album */
        $album = GalleryAlbum::findOne($id);
        if(!empty($album)) {
            $album->show = !$album->show;
            $album->save();
        }
        return $this->goBack(Url::to(['list']));
    }

    public function actionRemove($id) {
        GalleryAlbum::deleteAll(['id' => $id]);
        return $this->goBack(Url::to(['list']));
    }

}