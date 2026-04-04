<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('shipping_fee', 10, 2)->default(0)->after('subtotal');
            $table->string('shipping_city')->nullable()->after('shipping_fee');
            $table->string('shipping_district')->nullable()->after('shipping_city');
            $table->text('shipping_address')->nullable()->after('shipping_district');
            $table->text('seller_note')->nullable()->after('shipping_address');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_fee',
                'shipping_city',
                'shipping_district',
                'shipping_address',
                'seller_note',
            ]);
        });
    }
};
