<?php
use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\gallery\models\entities\GalleryImage;
use bl\multilang\entities\Language;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @var GalleryAlbum[] $albums
 * @var Language[] $languages
 */

$languages = Language::findAll(['active' => true]);

?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= Yii::t('blcms-gallery/backend/album', 'Albums List') ?>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <? if (!empty($albums)): ?>
                                <thead>
                                <tr>
                                    <th class="col-lg-1"><?= Yii::t('blcms-gallery/backend/main', 'Image') ?></th>
                                    <th class="col-lg-5"><?= Yii::t('blcms-gallery/backend/album', 'Album Title') ?></th>
                                    <? if(count($languages) > 1): ?>
                                        <th class="col-lg-3"><?= Yii::t('blcms-gallery/backend/main', 'Translations') ?></th>
                                    <? endif; ?>
                                    <th><?= Yii::t('blcms-gallery/backend/main', 'Show') ?></th>
                                    <th><?= Yii::t('blcms-gallery/backend/main', 'Edit') ?></th>
                                    <th><?= Yii::t('blcms-gallery/backend/main', 'Delete') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <? foreach ($albums as $album): ?>
                                    <tr>
                                        <td>
                                            <?= Html::img(GalleryAlbum::getImageSrc($album->image_name, 'thumb'), ['height' => '50']) ?>
                                        </td>
                                        <td>
                                            <?= $album->translation->title ?>
                                        </td>
                                        <td>
                                            <? if(count($languages) > 1): ?>
                                                <? $translations = ArrayHelper::index($album->translations, 'language_id') ?>
                                                <? foreach ($languages as $language): ?>
                                                    <?= Html::a(
                                                        $language->name,
                                                        ['edit', 'id' => $album->id, 'langId' => $language->id],
                                                        ['class' => 'btn btn-xs btn-' . (empty($translations[$language->id]) ? 'danger' : 'primary')]
                                                    ) ?>
                                                <? endforeach; ?>
                                            <? endif; ?>
                                        </td>

                                        <td class="text-center">
                                            <?= Html::a('',
                                                ['switch-show', 'id' => $album->id],
                                                [
                                                    'class' => $album->show ?
                                                    'glyphicon glyphicon-ok text-primary' :
                                                    'glyphicon glyphicon-minus text-danger'
                                                ]
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= Html::a('',
                                                ['edit', 'id' => $album->id, 'langId' => $album->translation->language->id],
                                                ['class' => 'glyphicon glyphicon-edit text-warning btn btn-default btn-sm']
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= Html::a('',
                                                ['remove', 'id' => $album->id],
                                                ['class' => 'glyphicon glyphicon-remove text-danger btn btn-default btn-sm']
                                            ) ?>
                                        </td>
                                    </tr>
                                <? endforeach; ?>
                                </tbody>
                            <? endif; ?>
                        </table>
                        <?= Html::a(
                            Yii::t('blcms-gallery/backend/album', 'Add Album'),
                            ['create'],
                            ['class' => 'btn btn-primary pull-right']
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
