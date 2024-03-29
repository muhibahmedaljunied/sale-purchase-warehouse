<?php

namespace App\Repository\StockInventury;
use App\RepositoryInterface\InventuryStockRepositoryInterface;
use App\Services\CoreService;
use App\Models\PurchaseDetail;
use App\Models\Stock;
class StockPurchaseRepository implements InventuryStockRepositoryInterface
{

   
    public function __construct(protected CoreService $core)
    {
    }
   public function Stock()
    {

        $this->refresh_price(); //this make refresh for cost of product

        $this->init_stock_table();
    }

    function refresh_stock_table($type_refresh = null)
    {

        if ($this->core->stock_f != 0) {
            return 0;
        }

        $type = ($type_refresh) ? $type_refresh : $this->core->data['type_refresh'];

        // return $type;
        $stock_f = DB::table('stocks')
            ->where('type_operation', $this->core->data['type'])
            ->where('unit_id', $this->core->data['unit'][$this->core->value][0])
            ->$type('quantity', $this->core->micro_unit_qty);

        $this->core->stock_f = $stock_f;
        return $this;
    }

    function init_stock_table()
    {

        if ($this->core->stock_f != 0) {
            return 0;
        }
        // dd($this->core->data['unit']);
        $stocks = new Stock();
        $stocks->store_product_id = $this->core->id_store_product;
        $stocks->unit_id = $this->core->unit_value;
        $stocks->type_operation = $this->core->data['type'];
        $stocks->quantity = $this->core->micro_unit_qty;
        $stocks->date = $this->core->data['date'];
        $stocks->save();


        // }
    }

    function refresh_price()
    {

        $qty = 0;
        $total = 0;
        $cost = 0;

        $data = PurchaseDetail::where('purchase_details.store_product_id', $this->core->id_store_product)
            ->select('purchase_details.*')
            ->get();

        if (count($data) > 1) {

            foreach ($data as $key => $value) {

                $qty += $value->qty;
                $total += $value->total;
            }

            $cost = $total / $qty;
            // dd($cost);

            DB::table('store_products')->where('store_products.id', $this->core->id_store_product)
                ->update(['cost' => $cost]);
        }
    }
    
   
}
