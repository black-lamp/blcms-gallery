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
            'list' => [
                'class' => 'bl\cms\gallery\backend\actions\album\ListAction'
            ]
        ];
    }

}