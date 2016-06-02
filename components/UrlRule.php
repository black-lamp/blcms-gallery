<?php
namespace bl\cms\gallery\components;

use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\gallery\models\entities\GalleryAlbumTranslation;
use bl\multilang\entities\Language;
use bl\seo\entities\SeoData;
use common\entities\Album;
use Yii;
use yii\base\Object;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRuleInterface;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class UrlRule extends Object implements UrlRuleInterface
{
    public $prefix = '';
    public $disableDefault = true;

    private $pathInfo;
    private $routes;
    private $routesCount;
    private $currentLanguage;

    private $albumsRoute = 'gallery/album/view';

    /**
     * Parses the given request and returns the corresponding route and parameters.
     * @param UrlManager $manager the URL manager
     * @param Request $request the request component
     * @return array|bool the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     * @throws NotFoundHttpException
     */
    public function parseRequest($manager, $request) {
        $this->currentLanguage = Language::getCurrent();
        $this->pathInfo = $request->getPathInfo();

        if($this->pathInfo == $this->albumsRoute) {
            if($this->disableDefault) {
                throw new NotFoundHttpException();
            }

            if(!empty($request->getQueryParams()['id'])) {
                $id = $request->getQueryParams()['id'];
                $album = GalleryAlbum::findOne($id);
                if(!$album) {
                    return false;
                }

                $translation = $album->getTranslation($this->currentLanguage->id);
                if($translation) {
                    if(!empty($translation->seoUrl)) {
                        throw new NotFoundHttpException();
                    }
                }
            }

        }

        if(!empty($this->prefix)) {
            if(strpos($this->pathInfo, $this->prefix) === 0) {
                $this->pathInfo = substr($this->pathInfo, strlen($this->prefix));
            }
            else {
                return false;
            }
        }

        $this->initRoutes($this->pathInfo);

        if(!empty($this->prefix) && $this->routesCount == 1) {
            return [$this->albumsRoute, []];
        }
        else if($this->routesCount == 2) {
            $seoUrl = $this->routes[1];

            /* @var SeoData $seoData */
            $seoData = SeoData::find()
                ->where([
                    'entity_name' => GalleryAlbumTranslation::className(),
                    'seo_url' => $seoUrl
                ])->one();

            if($seoData) {
                /* @var GalleryAlbum $album */
                $album = GalleryAlbum::find()
                    ->joinWith('translations translation')
                    ->where([
                        'translation.id' => $seoData->entity_id,
                        'translation.language_id' => $this->currentLanguage->id
                    ])->one();

                if($album) {
                    return [
                        $this->albumsRoute,
                        ['id' => $album->id]
                    ];
                }
            }
        }

        return false;
    }

    private function initRoutes($pathInfo) {
        $this->routes = explode('/', $pathInfo);
        $this->routesCount = count($this->routes);
    }

    /**
     * Creates a URL according to the given route and parameters.
     * @param UrlManager $manager the URL manager
     * @param string $route the route. It should not have slashes at the beginning or the end.
     * @param array $params the parameters
     * @return string|boolean the created URL, or false if this rule cannot be used for creating this URL.
     */
    public function createUrl($manager, $route, $params)
    {
        if($route == $this->albumsRoute) {
            if(empty($params['id'])) {
                return $this->prefix;
            }
            else {
                $id = $params['id'];
                $language = Language::findOne([
                    'lang_id' => $manager->language
                ]);

                $album = GalleryAlbum::findOne($id);
                if($album) {
                    $translation = $album->getTranslation($language->id);
                    if(!empty($translation)) {
                        if(!empty($translation->seoUrl)) {
                            return $this->prefix . '/' . $translation->seoUrl;
                        }
                    }
                }
            }
        }

        return false;
    }
}