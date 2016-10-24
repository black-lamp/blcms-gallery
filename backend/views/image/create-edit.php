<?php
use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\gallery\models\entities\GalleryAlbumTranslation;
use bl\cms\gallery\models\entities\GalleryImage;
use bl\cms\gallery\models\entities\GalleryImageTranslation;
use bl\multilang\entities\Language;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var GalleryImage $image
 * @var GalleryImageTranslation $imageTranslation
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
                <?= Yii::t('blcms-gallery/backend/image', 'Album Image') ?>
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
                                            'id' => $image->id,
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
                                <?= $form->field($image, 'album_id', [
                                        'inputOptions' => [
                                            'class' => 'form-control'
                                        ]
                                    ])->dropDownList(
                                        ['' => '-- ' . Yii::t('blcms-gallery/backend/image', 'no album') . ' --'] +
                                        ArrayHelper::map(GalleryAlbumTranslation::find()->groupBy('album_id')->all(), 'album_id', 'title')
                                    )
                                ?>
                            </div>
                            <div class="col-md-12">
                                <?= $form->field($imageTranslation, 'title', [
                                        'inputOptions' => [
                                            'class' => 'form-control'
                                        ]
                                    ])
                                ?>
                            </div>
                            <div class="col-md-12">
                                <?= $form->field($imageTranslation, 'alt', [
                                        'inputOptions' => [
                                            'class' => 'form-control'
                                        ]
                                    ])
                                ?>
                            </div>
                            <div class="col-md-12">
                                <?= $form->field($image, 'show')->checkbox(['class' => 'i-checks']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php if(!empty($image->file_name)): ?>
                            <?= Html::img(GalleryAlbum::getImageSrc($image->file_name, 'thumb'), ['class' => 'img-thumbnail']) ?>
                        <?php endif; ?>
                        <?= $form->field($image, 'image_file')->fileInput() ?>
                    </div>
                </div>
                <?= Html::submitButton(Yii::t('blcms-gallery/backend/image', 'Save Image'), ['class' => 'btn btn-primary pull-right']) ?>
            </div>
        </div>
    </div>
</div>

<?php $form->end() ?>