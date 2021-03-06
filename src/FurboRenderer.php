<?php
/**
 * Furbo Renderer plugin for Craft CMS 3.x
 *
 * Prerenders pages / entries
 *
 * @link      https://furbo.ch/tonio-seiler-dipl-ing-fh-informatik
 * @copyright Copyright (c) 2019 Tonio Seiler
 */

namespace furbo\furborenderer;

use furbo\furborenderer\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\web\View;
use craft\events\PluginEvent;
use craft\events\TemplateEvent;

use yii\base\Event;

use Furbo\Renderer\HtmlRenderer;
use Furbo\Renderer\RendererExption;


/**
 * Class FurboRenderer
 *
 * @author    Tonio Seiler
 * @package   FurboRenderer
 * @since     1.0.0
 *
 */
class FurboRenderer extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var FurboRenderer
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'furbo-renderer',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );

        Event::on(
            View::class,
            View::EVENT_BEFORE_RENDER_TEMPLATE,
            function (TemplateEvent $event) {
                $request = Craft::$app->request;
                if ($request->isSiteRequest && $request->isGet && !$request->isAjax) {
                    $userAgent = $request->getUserAgent();
                    // is bot
                    if (preg_match('/bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit/i', $userAgent)) {
                        $cacheKey = 'furbo.furborenderer.'.$request->absoluteUrl;
                        $html = Craft::$app->cache->get($cacheKey);

                        FurboRenderer::log($userAgent.' accessing url: '.$request->absoluteUrl, LogLevel::Info);

                        if ($html === false && !empty($this->getSettings()->cacheExpiry)) {
                            $url = $request->absoluteUrl;
                            $renderer = new HtmlRenderer();
                            $apiKey = $this->getSettings()->apiKey;
                            $renderer->setApiKey($apiKey);
                            $html = $renderer->render($url);
                            Craft::$app->cache->set($cacheKey, $html, $this->getSettings()->cacheExpiry);
                            FurboRenderer::log('Furbo Render Portal returned html code.', LogLevel::Info);
                        } else {
                            FurboRenderer::log('Loaded from cache.', LogLevel::Info);
                        }

                        echo $html;
                        exit(-1);
                    }
                }
            }
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'furbo-renderer/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
