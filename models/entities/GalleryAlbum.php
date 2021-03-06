<?php

namespace bl\cms\gallery\models\entities;

use bl\multilang\behaviors\TranslationBehavior;
use bl\seo\behaviors\SeoDataBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "gallery_album".
 *
 * @property integer $id
 * @property integer $position
 * @property boolean $show
 * @property string $image_name
 *
 * @property GalleryAlbumTranslation[] $translations
 * @property GalleryAlbumTranslation $translation
 *
 * @method GalleryAlbumTranslation|null getTranslation(int $languageId = null) Returns translation
 */
class GalleryAlbum extends ActiveRecord
{
    public $image_file;

    public function behaviors()
    {
        return [
            'translation' => [
                'class' => TranslationBehavior::className(),
                'translationClass' => GalleryAlbumTranslation::className(),
                'relationColumn' => 'album_id'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_album';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position'], 'integer'],
            [['image_file'], 'file'],
            [['show'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => 'Position',
            'show' => Yii::t('blcms-gallery/backend/album', 'Show Album'),
            'image_file' => Yii::t('blcms-gallery/backend/album', 'Set Album Image')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(GalleryAlbumTranslation::className(), ['album_id' => 'id']);
    }

    // TODO: remove this method
    public static function getImageSrc($imageName, $type) {
        return '/images/gallery/' . $imageName . '-' . $type . '.jpg';
    }

    /**
     * @param int $albumId Current album id.
     * @return bool
     */
    public function isActive($albumId)
    {
        return ($albumId == $this->id);
    }
}
