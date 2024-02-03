<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'brand_name',
        'abbreviation',
        'description',
        'unit',
        'type',
        'retail_price'
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return $array;
    }

    public function getFormattedRetailPriceAttribute()
    {
        return '₱ ' . number_format($this->attributes['retail_price'], 2);
    }

    function salesOrder(){
        return $this->belongsToMany(SalesOrder::class)
                    ->using(ProductSalesOrderPivot::class)
                    ->withPivot(['unit_price', 'quantity', 'discount', 'amount'])
                    ->withTimestamps();
    }

    function deliveryReceipts(){
        return $this->hasManyThrough(
            DeliveryReceipt::class, 
            DeliveryReceiptProductPivot::class, 
            'product_id', 
            'id', 
            'id', 
            'delivery_receipt_id'
            )->latest();
    }
    
    function pricingPerCustomer($customerId, $salesOrderIdExcept = null){
        return DB::table("products")
                ->join("delivery_receipt_product", "products.id", "=", "delivery_receipt_product.product_id")
                ->join("delivery_receipts", "delivery_receipt_product.delivery_receipt_id", "=", "delivery_receipts.id")
                ->join("sales_orders", "delivery_receipts.sales_order_id", "=", "sales_orders.id")
                ->selectRaw(DB::raw('products.description as product_description, products.id as product_id, delivery_receipt_product.unit_price as unit_price, delivery_receipts.id as delivery_receipt_id, delivery_receipts.dr_number as delivery_receipt_number, delivery_receipts.created_at as created_at'))
                // ->groupBy("delivery_receipt_product.product_id")
                ->where("delivery_receipt_product.product_id", $this->id)
                ->where("sales_orders.customer_id", $customerId);
                // ->when($salesOrderIdExcept, fn($q) => $q->where("sales_orders.id", $salesOrderIdExcept));
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

}
