<?php
use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\gallery\models\entities\GalleryImage;
use bl\multilang\entities\Language;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @var GalleryImage[] $images
 * @var Language[] $languages
 */

$languages = Language::findAll(['active' => true]);

?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= Yii::t('blcms-gallery/backend/image', 'Images List') ?>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <?php if (!empty($images)): ?>
                                <thead>
                                <tr>
                                    <th class="col-lg-1"><?= Yii::t('blcms-gallery/backend/main', 'Image') ?></th>
                                    <th class="col-lg-2"><?= Yii::t('blcms-gallery/backend/album', 'Album') ?></th>
                                    <th class="col-lg-3"><?= Yii::t('blcms-gallery/backend/image', 'Image Title') ?></th>
                                    <th class="col-lg-3"><?= Yii::t('blcms-gallery/backend/image', 'Alternative Text') ?></th>
                                    <?php if(count($languages) > 1): ?>
                                        <th class="col-lg-3"><?= Yii::t('blcms-gallery/backend/main', 'Translations') ?></th>
                                    <?php endif; ?>
                                    <th><?= Yii::t('blcms-gallery/backend/main', 'Show') ?></th>
                                    <th><?= Yii::t('blcms-gallery/backend/main', 'Edit') ?></th>
                                    <th><?= Yii::t('blcms-gallery/backend/main', 'Delete') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($images as $image): ?>
                                    <tr>
                                        <td>
                                            <?= Html::img(GalleryAlbum::getImageSrc($image->file_name, 'thumb'), ['height' => '50']) ?>
                                        </td>
                                        <td>
                                            <?php if(!empty($image->album)): ?>
                                                <?php if(!empty($image->album->translation)): ?>
                                                    <?= $image->album->translation->title ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(!empty($image->translation)): ?>
                                                <?= $image->translation->title ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(!empty($image->translation)): ?>
                                                <?= $image->translation->alt ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(count($languages) > 1): ?>
                                                <?php $translations = ArrayHelper::index($image->translations, 'language_id') ?>
                                                <?php foreach ($languages as $language): ?>
                                                    <?= Html::a(
                                                        $language->name,
                                                        ['edit', 'id' => $image->id, 'langId' => $language->id],
                                                        ['class' => 'btn btn-xs btn-' . (empty($translations[$language->id]) ? 'danger' : 'primary')]
                                                    ) ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center">
                                            <?= Html::a('',
                                                ['switch-show', 'id' => $image->id],
                                                [
                                                    'class' => $image->show ?
                                                    'glyphicon glyphicon-ok text-primary' :
                                                    'glyphicon glyphicon-minus text-danger'
                                                ]
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= Html::a('',
                                                ['edit', 'id' => $image->id, 'langId' => Language::getCurrent()->id],
                                                ['class' => 'glyphicon glyphicon-edit text-warning btn btn-default btn-sm']
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= Html::a('',
                                                ['remove', 'id' => $image->id],
                                                ['class' => 'glyphicon glyphicon-remove text-danger btn btn-default btn-sm']
                                            ) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            <?php endif; ?>
                        </table>
                        <?= Html::a(
                            Yii::t('blcms-gallery/backend/image', 'Add Image'),
                            ['create'],
                            ['class' => 'btn btn-primary pull-right']
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
