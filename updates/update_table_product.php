<?php

namespace Allekslar\DragdropAjax\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class UpdateTAbleProduct
 * @package Allekslar\Dragdrop\Updates
 */
class UpdateTAbleProduct extends Migration
{
    /**
     * Apply migration
     */
    public function up()
    {
        if (!Schema::hasTable('lovata_shopaholic_products') || Schema::hasColumn('lovata_shopaholic_products', 'sort_drag')) {
            return;
        }

        Schema::table('lovata_shopaholic_products', function (Blueprint $obTable) {
            $obTable->integer('sort_drag')->default(0)->after('active');;
        });
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        if (!Schema::hasTable('lovata_shopaholic_products') || !Schema::hasColumn('lovata_shopaholic_products', 'sort_drag')) {
            return;
        }

        Schema::table('lovata_shopaholic_products', function (Blueprint $obTable) {
            $obTable->dropColumn(['sort_drag']);
        });
    }
}
