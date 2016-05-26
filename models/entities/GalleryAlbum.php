<?php

namespace bl\cms\gallery\models\entities;

use bl\multilang\behaviors\TranslationBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "gallery_album".
 *
 * @property integer $id
 * @property integer $position
 * @property integer $show
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
            [['position', 'show'], 'integer'],
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
            'position' => 'Position',
            'show' => 'Show',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(GalleryAlbumTranslation::className(), ['album_id' => 'id']);
    }
}
