<?php

namespace Allekslar\DragdropAjax\Behaviors;

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

        // add the dragdropajax requirements
        $parent->addJs('https://code.jquery.com/ui/1.12.0/jquery-ui.min.js');
        $parent->addJs('/plugins/allekslar/dragdropajax/assets/js/sort.js');

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
            $productList = Product::all();
            $position = 1;
            foreach ($productList as $product) {
                $product->sort_drag = $position;
                $product->save();
                $position++;
            }
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
