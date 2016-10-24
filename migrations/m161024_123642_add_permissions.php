<?php

use yii\db\Migration;

class m161024_123642_add_permissions extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        /*Add permissions*/
        /*For ImageController*/
        $viewImageList = $auth->createPermission('viewImageList');
        $viewImageList->description = 'View image list';
        $auth->add($viewImageList);

        $createImage = $auth->createPermission('createImage');
        $createImage->description = 'Create image';
        $auth->add($createImage);

        $editImage = $auth->createPermission('editImage');
        $editImage->description = 'Edit image';
        $auth->add($editImage);

        $switchShowImage = $auth->createPermission('switchShowImage');
        $switchShowImage->description = 'Switch show for image';
        $auth->add($switchShowImage);

        $removeImage = $auth->createPermission('removeImage');
        $removeImage->description = 'Remove image';
        $auth->add($removeImage);

        /*For AlbumController*/
        $viewAlbumList = $auth->createPermission('viewAlbumList');
        $viewAlbumList->description = 'View album list';
        $auth->add($viewAlbumList);

        $createAlbum = $auth->createPermission('createAlbum');
        $createAlbum->description = 'Create image';
        $auth->add($createAlbum);

        $editAlbum = $auth->createPermission('editAlbum');
        $editAlbum->description = 'Edit image';
        $auth->add($editAlbum);

        $switchShowAlbum = $auth->createPermission('switchShowAlbum');
        $switchShowAlbum->description = 'Switch show for album';
        $auth->add($switchShowAlbum);

        $removeAlbum = $auth->createPermission('removeAlbum');
        $removeAlbum->description = 'Remove image';
        $auth->add($removeAlbum);


        /*Add roles*/
        $imageManager = $auth->createRole('imageManager');
        $imageManager->description = 'Image manager';
        $auth->add($imageManager);

        $albumManager = $auth->createRole('albumManager');
        $albumManager->description = 'Album manager';
        $auth->add($albumManager);

        $galleryManager = $auth->createRole('galleryManager');
        $galleryManager->description = 'Gallery manager';
        $auth->add($galleryManager);

        /*Add childs*/
        $auth->addChild($imageManager, $viewImageList);
        $auth->addChild($imageManager, $createImage);
        $auth->addChild($imageManager, $editImage);
        $auth->addChild($imageManager, $switchShowImage);
        $auth->addChild($imageManager, $removeImage);

        $auth->addChild($albumManager, $viewAlbumList);
        $auth->addChild($albumManager, $createAlbum);
        $auth->addChild($albumManager, $editAlbum);
        $auth->addChild($albumManager, $switchShowAlbum);
        $auth->addChild($albumManager, $removeAlbum);


        $auth->addChild($galleryManager, $imageManager);
        $auth->addChild($galleryManager, $albumManager);

    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $viewImageList = $auth->getPermission('viewImageList');
        $createImage = $auth->getPermission('createImage');
        $editImage = $auth->getPermission('editImage');
        $switchShowImage = $auth->getPermission('switchShowImage');
        $removeImage = $auth->getPermission('removeImage');

        $viewAlbumList = $auth->getPermission('viewAlbumList');
        $createAlbum = $auth->getPermission('createAlbum');
        $editAlbum = $auth->getPermission('editAlbum');
        $switchShowAlbum = $auth->getPermission('switchShowAlbum');
        $removeAlbum = $auth->getPermission('removeAlbum');


        $imageManager = $auth->getRole('imageManager');
        $albumManager = $auth->getRole('albumManager');
        $galleryManager = $auth->getRole('galleryManager');

        $auth->removeChildren($imageManager);
        $auth->removeChildren($albumManager);
        $auth->removeChildren($galleryManager);

        $auth->remove($viewImageList);
        $auth->remove($createImage);
        $auth->remove($editImage);
        $auth->remove($switchShowImage);
        $auth->remove($removeImage);
        $auth->remove($viewAlbumList);
        $auth->remove($createAlbum);
        $auth->remove($editAlbum);
        $auth->remove($switchShowAlbum);
        $auth->remove($removeAlbum);

        $auth->remove($galleryManager);
        $auth->remove($albumManager);
        $auth->remove($imageManager);
    }

}
