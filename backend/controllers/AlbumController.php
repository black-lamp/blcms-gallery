<?php
namespace bl\cms\gallery\backend\controllers;

use yii\web\Controller;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class AlbumController extends Controller
{
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
            'save' => [
                'class' => 'bl\cms\gallery\backend\actions\album\SaveAction'
            ],
            'list' => [
                'class' => 'bl\cms\gallery\backend\actions\album\ListAction'
            ]
        ];
    }

}