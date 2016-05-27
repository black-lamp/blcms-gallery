<?php
namespace bl\cms\gallery\frontend\controllers;
use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\gallery\models\entities\GalleryImage;
use yii\web\Controller;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class AlbumController extends Controller
{
    public function actionView($id = null) {
        $images = GalleryImage::find()
            ->from('gallery_album_image image')
            ->joinWith('album album')
            ->where([
                'image.show' => true,
                'album.show' => true,
            ]);

        if(!empty($id)) {

            $album = GalleryAlbum::findOne($id);

            if(!empty($album)) {
                $images->andWhere([
                    'album.id' => $id
                ]);

                $albumTranslation = $album->translation;

                if(!empty($albumTranslation)) {
                    $this->view->title = $albumTranslation->seoTitle;
                    $this->view->registerMetaTag([
                        'name' => 'description',
                        'content' => html_entity_decode($albumTranslation->seoDescription)
                    ]);
                    $this->view->registerMetaTag([
                        'name' => 'keywords',
                        'content' => html_entity_decode($albumTranslation->seoKeywords)
                    ]);
                }

            }

        }

        return $this->render('view', [
            'images' => $images->all(),
            'albums' => GalleryAlbum::findAll(['show' => true]),
            'albumId' => $id
        ]);
    }
}