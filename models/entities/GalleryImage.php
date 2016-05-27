<?php

namespace bl\cms\gallery\models\entities;

use bl\multilang\behaviors\TranslationBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "gallery_album_image".
 *
 * @property integer $id
 * @property integer $album_id
 * @property boolean $show
 * @property string $file_name
 *
 * @property GalleryAlbum $album
 * @property GalleryImageTranslation $translation
 * @property GalleryImageTranslation[] $translations
 */
class GalleryImage extends ActiveRecord
{
    public $image_file;

    public function behaviors()
    {
        return [
            'translation' => [
                'class' => TranslationBehavior::className(),
                'translationClass' => GalleryImageTranslation::className(),
                'relationColumn' => 'image_id'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_album_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_name'], 'string', 'max' => 255],
            [['album_id'], 'exist', 'targetClass' => GalleryAlbum::className(), 'targetAttribute' => 'id'],
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
            'file_name' => 'File Name',
            'show' => Yii::t('blcms-gallery/backend/image', 'Show Image'),
            'album_id' => Yii::t('blcms-gallery/backend/album', 'Album')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(GalleryAlbum::className(), ['id' => 'album_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(GalleryImageTranslation::className(), ['image_id' => 'id']);
    }
}
