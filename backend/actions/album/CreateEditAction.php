<?php
namespace bl\cms\gallery\backend\actions\album;
use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\gallery\models\entities\GalleryAlbumTranslation;
use bl\multilang\entities\Language;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Gd\Imagine;
use Yii;
use yii\base\Action;
use yii\web\UploadedFile;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class CreateEditAction extends Action
{
    public function run($id = null, $langId = null) {
        /* @var GalleryAlbum $album */
        /* @var GalleryAlbumTranslation $albumTranslation */

        $language = $langId == null ? Language::getDefault() : Language::findOne($langId);

        if(empty($id)) {
            $album = new GalleryAlbum();
            $album->show = true;
            $albumTranslation = new GalleryAlbumTranslation();
        }
        else {
            $album = GalleryAlbum::findOne($id);
            if(empty($album)) {
                return $this->controller->redirect('/gallery/album/list');
            }

            $albumTranslation = $album->getTranslation($language->id);
            if(empty($albumTranslation)) {
                $albumTranslation = new GalleryAlbumTranslation();
            }
        }

        if(Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if($album->load($post) && $albumTranslation->load($post)) {
                $album->image_file = UploadedFile::getInstance($album, 'image_file');

                if(!empty($album->image_file)) {
                    try {
                        // save image
                        $fileName = $this->generateFileName($album->image_file->baseName);
                        $imagine = new Imagine();
                        $imagine->open($album->image_file->tempName)
                            ->save(Yii::getAlias($this->controller->module->imagesPath . '/' . $fileName . '-original.jpg'))
                            ->thumbnail(new Box(400, 400), ImageInterface::THUMBNAIL_OUTBOUND)
                            ->save(Yii::getAlias($this->controller->module->imagesPath . '/' . $fileName . '-thumb.jpg'));

                        $album->image_name = $fileName;
                    }
                    catch(\Exception $ex) {
                        die($ex);
                        $album->addError('image_file', 'File save failed');
                    }
                }

                if($album->validate() && $albumTranslation->validate()) {
                    $album->save();
                    $albumTranslation->album_id = $album->id;
                    $albumTranslation->language_id = $language->id;
                    $albumTranslation->save();

                    $this->controller->redirect([
                        'edit',
                        'id' => $album->id,
                        'langId' => $language->id
                    ]);
                }
            }
        }

        return $this->controller->render('create-edit', [
            'album' => $album,
            'albumTranslation' => $albumTranslation,
            'currentLanguage' => $language
        ]);
    }

    private function generateFileName($baseName) {
        $fileName = hash('crc32', $baseName . time());
        if(file_exists(Yii::getAlias($this->controller->module->imagesPath . '/' . $fileName . '-original.jpg'))) {
            return $this->generateFileName($baseName);
        }
        return $fileName;
    }
}