<?php namespace Allekslar\DragDropAjaxShopaholic\Classes\Event;


use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Controllers\Products;
/**
 * Class ExtendController
 * @package Allekslar\DragDropAjaxShopaholic\Classes\Event
 */
class ExtendController 
{

    protected $iPriority = 1000;
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        Products::extend(function ($obController) {
            $this->extendConfig($obController);
            
        });
        Products::extendListColumns(function($obWidget, $obModel)
        {
            if (!$obModel instanceof Product) {
                return;
            } 
            $this->addColumn($obWidget);   
        });
    }

    /**
     * Extend products controller
     * @param Products $obController
     */
    protected function extendConfig($obController)
    {
        $obController->listConfig = $obController->mergeConfig(
            $obController->listConfig,
            '$/allekslar/dragdropajaxshopaholic/config/config_listdragdropajax.yaml'
        );
        $obController->implement[] = 'Allekslar.DragDropAjaxShopaholic.Behaviors.DragdropController';


    }


    /**
     * Add columns model
     * @param \Backend\Widgets\Lists $obWidget
     */
    protected function addColumn($obWidget)
    {
        $obWidget->addColumns([
            'sort_drag' => [
                'label' => 'allekslar.dragdropajaxshopaholic::lang.field.position',
            ],
        ]);
    }

}