<?php

namespace App\Repository\StockInventury;
use App\RepositoryInterface\InventuryStockRepositoryInterface;
use App\Services\CoreService;
use App\Models\Stock;
class StockSaleReturnRepository implements InventuryStockRepositoryInterface
{

    public function __construct(protected CoreService $core)
    {
    }

   public function Stock()
    {

        $this->init_stock_table();
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
    


       // function refresh_stock_table($type_refresh = null)
    // {

    //     if ($this->core->stock_f != 0) {
    //         return 0;
    //     }

    //     $type = ($type_refresh) ? $type_refresh : $this->core->data['type_refresh'];

    //     // return $type;
    //     $stock_f = DB::table('stocks')
    //         ->where('type_operation', $this->core->data['type'])
    //         ->where('unit_id', $this->core->data['unit'][$this->core->value][0])
    //         ->$type('quantity', $this->core->micro_unit_qty);

    //     $this->core->stock_f = $stock_f;
    //     return $this;
    // }

    
}
