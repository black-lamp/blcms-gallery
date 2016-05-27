<?php

namespace bl\cms\gallery\models\entities;

use bl\multilang\behaviors\TranslationBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "gallery_album_image".
 *
 * @property integer $id
 * @property string $file_name
 *
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
            [['image_file'], 'file']
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(GalleryAlbumTranslation::className(), ['image_id' => 'id']);
    }
}
