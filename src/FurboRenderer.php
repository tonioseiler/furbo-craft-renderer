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
use craft\events\PluginEvent;

use yii\base\Event;

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
