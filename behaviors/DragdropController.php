<?php

namespace Allekslar\DragDropAjaxShopaholic\Behaviors;

use Flash;
use Lovata\Shopaholic\Models\Product;

class DragdropController extends \October\Rain\Extension\ExtensionBase
{
    /**
     * @var
     */
    protected $parent;

    /**
     * Constructor
     */
    public function __construct($parent)
    {

        $this->parent = $parent;

        // add the dragdropajaxshopaholic requirements
        $parent->addJs('https://code.jquery.com/ui/1.12.0/jquery-ui.min.js');
        $parent->addJs('/plugins/allekslar/dragdropajaxshopaholic/assets/js/sort.js');

    }

    public function listExtendQuery($query, $definition = null)
    {
        $query->orderBy('sort_drag', 'asc');
    }

    public function onSort()
    {
        $request = \Request::all();
        //sort initialization
        if (0 == $request['min'] && 0 == $request['max']) {

            $position = 1;
            Product::chunkById(100, function ($productList) use (&$position) {
                foreach ($productList as $product) {
                    $product->sort_drag = $position;
                    $product->save();
                    $position++;
                }
            });
            Flash::success('Sort initialization successful.');
            return $this->parent->listRefresh();
        }

        $productList = Product::find($request['id']);
        foreach ($productList as $product) {

            $position = $request['min'];
            foreach ($request['id'] as $data) {
                if ($position >= $request['min'] && $position <= $request['max']) {
                    if ($data == $product->id) {
                        if ($product->sort_drag != $position) {
                            $product->sort_drag = $position;
                            $product->save();
                        }
                    }
                }
                $position++;
            }
        }
        Flash::success('Successfully updated.');
        return $this->parent->listRefresh();
    }

}
