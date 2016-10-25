# blcms-gallery
Image gallery extention for Black-Lamp CMS

yii migrate --migrationPath=@vendor/black-lamp/blcms-gallery/migrations


**Roles and its permissions:**

_Image manager_
- viewImageList
- createImage
- editImage
- removeImage

_Album manager_
- viewAlbumList
- createAlbum
- editAlbum
- removeAlbum

_Gallery manager_
extends image and album manager's permissions. 
