<?php namespace Allekslar\DragdropAjax\Classes\Event;

use Lovata\Shopaholic\Classes\Item\ProductItem;
use Lovata\Shopaholic\Models\Product;
use Lovata\Toolbox\Classes\Event\ModelHandler;
use Lovata\Shopaholic\Controllers\Products;

/**
 * Class class ProductModelHandler
 * @package Allekslar\Dragdrop\Classes\Event
 */
class ProductModelHandler extends ModelHandler
{
    /** @var  Product */
    protected $obElement;

    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        Product::extend(function ($obElement) {
            /** @var Product $obElement */
            $obElement->fillable[] = 'sort_drag';
        });

        $obEvent->listen('shopaholic.sorting.get.list', function ($sSorting) {
            return $this->getSortingList($sSorting);
        });

        $obEvent->listen('backend.form.extendFields', function ($obWidget) {
            $this->extendProductFields($obWidget);
        });
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return Product::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return ProductItem::class;
    }

    /**
     * After create event handler
     */
    protected function afterCreate()
    {
        $this->obElement->sort_drag = $this->obElement->id;
        $this->obElement->save();
    }

    /**
     * Get sorting by sort_drag
     * @param string $sSorting
     * @return array|null
     */
    protected function getSortingList($sSorting)
    {
        if (empty($sSorting) || $sSorting != 'sort_drag|asc') {
            return null;
        }
        $arResultIDList = (array) Product::orderBy('sort_drag', 'asc')->lists('id');
        return $arResultIDList;
    }

    /**
     * Extend Product fields
     * @param \Backend\Widgets\Form $obWidget
     */
    protected function extendProductFields($obWidget)
    {
        if (!$obWidget->getController() instanceof Products || $obWidget->isNested || empty($obWidget->context)) {
            return;
        }

        if (!$obWidget->model instanceof Product) {
            return;
        }

        $arFieldList = [
            '_sort_drag_enable' => [
                'label' => 'allekslar.dragdropajax::lang.field.position_enable',
                'tab' => 'lovata.toolbox::lang.tab.settings',
                'span' => 'left',
                'default' => 0,
                'type' => 'switch',
                'default' => 0,

            ],
            'sort_drag' => [
                'label' => 'allekslar.dragdropajax::lang.field.position',
                'tab' => 'lovata.toolbox::lang.tab.settings',
                'span' => 'left',
                'default' => 0,
                'type' => 'number',
                'trigger' => [
                    'action' => 'show',
                    'field' => '_sort_drag_enable',
                    'condition' => 'checked',
                ],
            ],
        ];

        $obWidget->addTabFields($arFieldList);
    }

}
