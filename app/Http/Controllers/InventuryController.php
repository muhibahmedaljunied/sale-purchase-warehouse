<?php

namespace App\Http\Controllers;

// use Illuminate\Foundation\Auth\Access\Store as s;
use App\Traits\GeneralTrait;
use App\Traits\Temporale\TemporaleTrait;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\Details\DetailsTrait;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\OpeningInventury;
use App\Models\Temporale;
use App\Models\Status;
use App\Models\ProductUnit;
use App\Models\SaleDetail;
use App\Models\StoreProduct;
use DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Foreach_;

class InventuryController extends Controller
{
    use TemporaleTrait, InvoiceTrait, DetailsTrait, GeneralTrait;

    public function index()
    {

        $temporale = DB::table('opening_inventuries')
            ->join('stores', 'opening_inventuries.store_id', '=', 'stores.id')
            ->join('statuses', 'opening_inventuries.status_id', '=', 'statuses.id')
            ->join('products', 'products.id', '=', 'opening_inventuries.product_id')
            ->join('units', 'units.id', '=', 'opening_inventuries.unit_id')
            ->select('products.text as product', 'opening_inventuries.qty as tem_qty', 'opening_inventuries.desc', 'opening_inventuries.*', 'stores.text as store', 'statuses.name as status', 'units.name as unit')
            ->paginate(20);

        $statuses = Status::all();

        return response()->json(['temporales' => $temporale, 'statuses' => $statuses]);
    }


    public function store(Request $request)
    {





        foreach ($request->post('count') as $value) {

            if ($value !== null) {

                $stock_f = 0;
                $store_product_f = 0;


                // return response()->json(['rrx' =>$request->all()]);
                $array_unit_after_decode =json_decode($request['unit_id'][$value]);
                $micro_unit_qty = $this->set_unit($request, $value, $array_unit_after_decode);
                
         
                $store_product_f = $this->refresh_store_from_opening($value, $request->all(), $micro_unit_qty);
        
                //  --------------------------------------------------------------------------
                $id_store_product = $this->get($value, $request->all());
         
                foreach ($id_store_product as $values) {

                    // return response()->json(['rrx' =>$values['id'] ]);
                    $id_store_product = $values['id'];
                }

                if ($store_product_f == 0) {

                    $id_store_product = $this->init_store($value, 'Opening', $request->all(), $micro_unit_qty);
                }


               
                // --------------------------------------------------------------------------------------------------------------

                $r = $this->init_details(null, $id_store_product, $value, 'Opening', $request->all());

                // return response()->json(['rrx' =>$r ]);
                // --------------------------------------------------------------------------------------------------------------
                $stock_f = $this->refresh_stock(null, $value, 'Opening', 'increment', $request->all());
                // -----------------------------------------------------

                // return response()->json(['rrx' =>$stock_f ]);
                if ($stock_f == 0) {


                    $this->init_stock(null, $value, 'Opening', $request->post('date'), $request->all());
                }
            }
        }
        return response()->json(['message' => 'success']);
    }


    public function show(Request $request)
    {
        $sales = DB::table('sales')
            ->join('customers', 'customers.id', '=', 'sales.customer_id')
            ->join('payment_sales', 'payment_sales.sale_id', '=', 'sales.id')
            ->select('sales.*', 'sales.id as sale_id', 'customers.*', 'payment_sales.*')
            ->paginate(10);

        return response()->json(['sales' => $sales]);
    }

    public function destroy(Request $request)
    {
        if ($request->id) {
            Temporale::where('type_process', 'sale')->where('temporales.product_id', $request->id)->delete();
        } else {
            Temporale::where('type_process', 'sale')->delete();
        }


        return response()->json('successfully deleted');
    }
}