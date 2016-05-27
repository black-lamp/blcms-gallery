<?php

use yii\db\Migration;

/**
 * Handles the creation for table `gallery_album_images_tables`.
 */
class m160521_112215_create_gallery_album_images_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('gallery_album_image', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string(),
            'show' => $this->boolean(),
            'album_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'gallery_album_image:album_id',
            'gallery_album_image',
            'album_id',
            'gallery_album',
            'id',
            'cascade'
        );

        $this->createTable('gallery_album_image_translation', [
            'id' => $this->primaryKey(),
            'image_id' => $this->integer(),
            'language_id' => $this->integer(),
            'title' => $this->string(),
            'alt' => $this->string()
        ]);

        $this->addForeignKey(
            'gallery_album_image_translation:image_id',
            'gallery_album_image_translation',
            'image_id',
            'gallery_album_image',
            'id',
            'cascade'
        );

        $this->addForeignKey(
            'gallery_album_image_translation:language_id',
            'gallery_album_image_translation',
            'language_id',
            'language',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('gallery_album_image_translation:image_id', 'gallery_album_image_translation');
        $this->dropForeignKey('gallery_album_image_translation:language_id', 'gallery_album_image_translation');
        $this->dropTable('gallery_album_image');
        $this->dropTable('gallery_album_image_translation');
    }
}
