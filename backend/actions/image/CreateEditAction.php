<?php
namespace bl\cms\gallery\backend\actions\image;

use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\gallery\models\entities\GalleryImage;
use bl\cms\gallery\models\entities\GalleryImageTranslation;
use bl\multilang\entities\Language;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Yii;
use yii\base\Action;
use yii\web\UploadedFile;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class CreateEditAction extends Action
{
    public function run($id = null, $langId = null) {
        /* @var GalleryImage $image */
        /* @var GalleryImageTranslation $imageTranslation */

        $language = $langId == null ? Language::getDefault() : Language::findOne($langId);

        if(empty($id)) {
            $image = new GalleryImage();
            $image->show = true;
            $imageTranslation = new GalleryImageTranslation();
        }
        else {
            $image = GalleryImage::findOne($id);
            if(empty($image)) {
                return $this->controller->redirect('/gallery/album/list');
            }

            $imageTranslation = $image->getTranslation($language->id)->one();
            if(empty($imageTranslation)) {
                $imageTranslation = new GalleryImageTranslation();
            }
        }

        if(Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if($image->load($post) && $imageTranslation->load($post)) {
                $image->image_file = UploadedFile::getInstance($image, 'image_file');

                if(!empty($image->image_file)) {
                    try {
                        // save image
                        $fileName = $this->generateFileName($image->image_file->baseName);
//                        die(\Imagick::getVersion());
                        $imagine = new Imagine();
                        $imagine->open($image->image_file->tempName)
                            ->save(Yii::getAlias($this->controller->module->imagesPath . '/' . $fileName . '-original.jpg'))
                            ->thumbnail(new Box(400, 400), ImageInterface::THUMBNAIL_OUTBOUND)
                            ->save(Yii::getAlias($this->controller->module->imagesPath . '/' . $fileName . '-thumb.jpg'));

                        $image->file_name = $fileName;
                    }
                    catch(\Exception $ex) {
                        $image->addError('image_file', 'File save failed');
                    }
                }

                if($image->validate() && $imageTranslation->validate()) {
                    $image->save();
                    $imageTranslation->image_id = $image->id;
                    $imageTranslation->language_id = $language->id;
                    $imageTranslation->save();

                    $this->controller->redirect([
                        'edit',
                        'id' => $image->id,
                        'langId' => $language->id
                    ]);
                }
            }
        }

        $albums = GalleryAlbum::find()->all();

        return $this->controller->render('create-edit', [
            'image' => $image,
            'imageTranslation' => $imageTranslation,
            'currentLanguage' => $language,
            'albums' => $albums
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