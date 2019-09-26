<?php
/**
 * Furbo Renderer plugin for Craft CMS 3.x
 *
 * Prerenders pages / entries
 *
 * @link      https://furbo.ch/tonio-seiler-dipl-ing-fh-informatik
 * @copyright Copyright (c) 2019 Tonio Seiler
 */

namespace furbo\furborenderer\assetbundles\FurboRenderer;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Tonio Seiler
 * @package   FurboRenderer
 * @since     1.0.0
 */
class FurboRendererAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@furbo/furborenderer/assetbundles/furborenderer/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/FurboRenderer.js',
        ];

        $this->css = [
            'css/FurboRenderer.css',
        ];

        parent::init();
    }
}
