<?php
/**
 * Furbo Renderer plugin for Craft CMS 3.x
 *
 * Prerenders pages / entries
 *
 * @link      https://furbo.ch/tonio-seiler-dipl-ing-fh-informatik
 * @copyright Copyright (c) 2019 Tonio Seiler
 */

namespace furbo\furborenderer\models;

use furbo\furborenderer\FurboRenderer;

use Craft;
use craft\base\Model;

/**
 * @author    Tonio Seiler
 * @package   FurboRenderer
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $apiKey = '';


    /**
     * @var string
     */
    public $apiUrl = 'https://render.furbo.ch/api/v1.0/';


    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['apiKey', 'string'],
            ['apiUrl', 'string']
        ];
    }
}
