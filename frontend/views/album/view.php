<?php
use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\gallery\models\entities\GalleryImage;
use yii\helpers\Html;

/**
 * @var GalleryAlbum $album
 * @var GalleryImage[] $images
 * @var GalleryAlbum[] $albums
 * @var integer $albumId
 */


?>

<div class="col-md-3">
    <div class="row">
        <div class="list-group">
            <?php foreach ($albums as $galleryAlbum) : ?>
                <?= Html::a($galleryAlbum->translation->title, ['view', 'id' => $galleryAlbum->id], [
                    'class' => 'list-group-item' . ($galleryAlbum->isActive($albumId) ? ' active' : ''),
                ]) ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="col-md-9">
    <div class="row">
        <?php if (!empty($album)): ?>
            <div class="panel-body">
                <?php $albumImage = GalleryAlbum::getImageSrc($album->image_name, 'original'); ?>

                <div class="jumbotron" style="background-image: url(<?= !empty($albumImage) ? $albumImage : ''; ?>); background-position: center;">
                    <h1 class="text-center"><?= $album->translation->title ?></h1>
                </div>
            </div>
        <?php endif; ?>

        <div class="panel-body">
            <?= \bl\cms\gallery\frontend\widgets\Gallery::widget([
                'items' => $images,
                'itemOptions' => [
                    'class' => 'thumbnail col-md-4',
                    'style' => [
                        'margin' => '5px 5px',
                    ]
                ]
            ]); ?>
        </div>
    </div>
</div>