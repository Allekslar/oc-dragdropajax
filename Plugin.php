<?php

namespace Allekslar\DragDropAjaxShopaholic;

use Event;
use System\Classes\PluginBase;
use Allekslar\DragDropAjaxShopaholic\Classes\Event\ExtendController;
use Allekslar\DragDropAjaxShopaholic\Classes\Event\ProductModelHandler;

/**
 * Class Plugin
 * @package Allekslar\DragDropAjaxShopaholic
 */
class Plugin extends PluginBase
{

    /** @var array Plugin dependencies */
    public $require = ['Lovata.Shopaholic', 'Lovata.Toolbox'];

    /**
     * Plugin boot method
     */
    public function boot()
    {
        Event::subscribe(ExtendController::class);
        Event::subscribe(ProductModelHandler::class);
    }
}