<?php
use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\gallery\models\entities\GalleryAlbumTranslation;
use bl\multilang\entities\Language;
use dosamigos\tinymce\TinyMce;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var GalleryAlbum $album
 * @var GalleryAlbumTranslation $albumTranslation
 * @var Language $currentLanguage
 * @var Language[] $languages
 */

$languages = Language::findAll(['active' => true]);

?>

<?php $form = ActiveForm::begin(['method'=>'post', 'options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= Yii::t('blcms-gallery/backend/album', 'Album') ?>
                <?php if(count($languages) > 1): ?>
                    <div class="dropdown pull-right">
                        <button class="btn btn-warning btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?= $currentLanguage->name ?>
                            <span class="caret"></span>
                        </button>
                        <?php if(count($languages) > 1): ?>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <?php foreach($languages as $language): ?>
                                    <li>
                                        <a href="
                                            <?= Url::to([
                                            '/' . Yii::$app->controller->getRoute(),
                                            'id' => $album->id,
                                            'langId' => $language->id])?>
                                            ">
                                            <?= $language->name?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($albumTranslation, 'title', [
                                        'inputOptions' => [
                                            'class' => 'form-control'
                                        ]
                                    ])
                                ?>
                            </div>
                            <div class="col-md-12">
                                <?= $form->field($album, 'show')->checkbox(['class' => 'i-checks']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php if(!empty($album->image_name)): ?>
                            <?= Html::img(GalleryAlbum::getImageSrc($album->image_name, 'thumb'), ['class' => 'img-thumbnail']) ?>
                        <?php endif; ?>
                        <?= $form->field($album, 'image_file')->fileInput() ?>
                    </div>
                </div>
                <?= Html::submitButton(Yii::t('blcms-gallery/backend/album', 'Save Album'), ['class' => 'btn btn-primary pull-right']) ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= 'Seo Data' ?>
            </div>
            <div class="panel-body">
                <?= $form->field($albumTranslation, 'seoUrl', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ]
                ])->label('Seo Url')
                ?>

                <?= $form->field($albumTranslation, 'seoTitle', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ]
                ])->label('Seo Title')
                ?>

                <?= $form->field($albumTranslation, 'seoDescription', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ]
                ])->textarea(['rows' => 3])->label('Seo Description')
                ?>

                <?= $form->field($albumTranslation, 'seoKeywords', [
                    'inputOptions' => [
                        'class' => 'form-control'
                    ]
                ])->textarea(['rows' => 3])->label('Seo Keywords')
                ?>
                <?= Html::submitButton(Yii::t('blcms-gallery/backend/album', 'Save Album'), ['class' => 'btn btn-primary pull-right']) ?>
            </div>
        </div>
    </div>
</div>

<?php $form->end() ?>