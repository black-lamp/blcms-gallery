<?php

use yii\db\Migration;

/**
 * Handles the creation for table `gallery_album_tables`.
 */
class m160521_111517_create_gallery_album_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('gallery_album', [
            'id' => $this->primaryKey(),
            'position' => $this->integer(),
            'image_name' => $this->string(),
            'show' => $this->boolean()
        ]);

        $this->createTable('gallery_album_translation', [
            'id' => $this->primaryKey(),
            'album_id' => $this->integer(),
            'language_id' => $this->integer(),
            'title' => $this->string()
        ]);

        $this->addForeignKey(
            'gallery_album_translation:album_id',
            'gallery_album_translation',
            'album_id',
            'gallery_album',
            'id'
        );

        $this->addForeignKey(
            'gallery_album_translation:language_id',
            'gallery_album_translation',
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
        $this->dropForeignKey('gallery_album_translation:album_id', 'gallery_album_translation');
        $this->dropForeignKey('gallery_album_translation:language_id', 'gallery_album_translation');
        $this->dropTable('gallery_album');
        $this->dropTable('gallery_album_translation');
    }
}
