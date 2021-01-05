<?php

namespace Allekslar\DragdropAjax;

use Event;
use System\Classes\PluginBase;
use Allekslar\DragdropAjax\Classes\Event\ExtendController;
use Allekslar\DragdropAjax\Classes\Event\ProductModelHandler;

/**
 * Class Plugin
 * @package Allekslar\DragdropAjax
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