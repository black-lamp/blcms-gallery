<?php
namespace bl\cms\gallery\frontend\widgets;

use bl\cms\gallery\frontend\BlcmsGalleryAsset;
use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\gallery\models\entities\GalleryImage;
use dosamigos\gallery\GalleryAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Gallery renders a BlueImp Gallery items
 *
 * @author Vyacheslav Nozhenko <vv.nojenko@gmail.com>
 */
class Gallery extends \dosamigos\gallery\Gallery
{
    /**
     * @var GalleryImage[] Gallery images.
     */
    public $items;

    /**
     * @var array HTML attributes of the link.
     */
    public $itemOptions = [];

    /**
     * @var array HTML attributes of the image to be displayed.
     */
    public $imageOptions = [];

    /**
     * @var array HTML attributes of the image container.
     */
    public $itemContainerOptions = [];

    /**
     * @var bool Randomize items.
     */
    public $random = false;

    /**
     * @var bool
     */
    public $showDownloadButton = false;

    /**
     * @var array HTML attributes of the download button.
     */
    public $downloadButtonOptions = [];

    /**
     * @var string
     */
    public $downloadButtonIcon = '<i class="glyphicon glyphicon-download-alt"></i>';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        $this->templateOptions['id'] = ArrayHelper::getValue($this->templateOptions, 'id', 'blueimp-gallery');
        Html::addCssClass($this->templateOptions, 'blueimp-gallery');
        if ($this->showControls) {
            Html::addCssClass($this->templateOptions, 'blueimp-gallery-controls');
        }

        foreach($this->clientEvents as $key => $event) {
            if(!($event instanceof JsExpression)) {
                $this->clientOptions[$key] = new JsExpression($event);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function renderItems()
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = $this->renderItem($item);
        }
        if ($this->random) {
            shuffle($items);
        }

        return Html::tag('div', implode("\n", array_filter($items)), $this->options);
    }

    /**
     * @param GalleryImage $item
     * @return null|string the item to render
     */
    public function renderItem($item)
    {
        if (is_string($item)) {
            return Html::a(Html::img($item), $item, ['class' => 'gallery-item']);
        }

        $thumb = GalleryAlbum::getImageSrc($item->file_name, 'thumb');
        if ($thumb === null) {
            return null;
        }

        $original = GalleryAlbum::getImageSrc($item->file_name, 'original');
        $url = (!empty($original)) ? $original : $thumb;

        $this->itemOptions['title'] = $item->translation->title;
        Html::addCssClass($this->itemOptions, 'gallery-item');
        Html::addCssClass($this->itemContainerOptions, 'gallery-item-container');
        $this->imageOptions['alt'] = $item->translation->alt;
        $this->downloadButtonOptions['download'] = $url;
        Html::addCssClass($this->downloadButtonOptions, 'download-gallery-item');

        $item = Html::a(Html::img($thumb, $this->imageOptions), $url, $this->itemOptions);

        if($this->showDownloadButton) {;
            $item .= Html::a($this->downloadButtonIcon, $url, $this->downloadButtonOptions);
        }

        return Html::tag('div', $item, $this->itemContainerOptions);
    }

    /**
     * @inheritdoc
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        GalleryAsset::register($view);
        BlcmsGalleryAsset::register($view);

        $id = $this->options['id'];
        $options = Json::encode($this->clientOptions);
        $js = "blcms.gallery.registerLightBoxHandlers('#$id a.gallery-item', $options);";
        $view->registerJs($js);

        if (!empty($this->clientEvents)) {
            $js = [];
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('$id').on('$event', $handler);";
            }
            $view->registerJs(implode("\n", $js));
        }
    }

}
