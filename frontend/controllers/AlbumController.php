<?php
namespace bl\cms\gallery\frontend\controllers;
use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\gallery\models\entities\GalleryImage;
use bl\cms\seo\StaticPageBehavior;
use yii\web\Controller;
/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class AlbumController extends Controller
{
    public function behaviors()
    {
        return [
            'staticPage' => [
                'class' => StaticPageBehavior::className(),
                'key' => 'gallery'
            ]
        ];
    }
    
    public function actionView($id = null) {
        $images = GalleryImage::find()
            ->from('gallery_album_image image')
            ->joinWith('album album')
            ->where([
                'image.show' => true,
                'album.show' => true,
            ]);

        $album = null;

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
        else {
            $this->registerStaticSeoData();
        }
        return $this->render('view', [
            'album' => $album,
            'images' => $images->all(),
            'albums' => GalleryAlbum::findAll(['show' => true]),
            'albumId' => $id
        ]);
    }
}