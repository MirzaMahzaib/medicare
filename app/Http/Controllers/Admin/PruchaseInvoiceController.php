<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PruchaseInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseInvoice $purchaseinvoice)
    {
        $products = PurchaseInvoice::select('purchase_invoices.*','purchases.*','products.med_name')->join('purchases','purchases.invoice_id','=','purchase_invoices.id')->join('products','purchases.product_id','=','products.id')->where('purchase_invoices.id','=',$purchaseinvoice->id)->get();
        return view('admin.purchases.show',compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseInvoice $purchaseinvoice)
    {
        $invoices = PurchaseInvoice::select('purchase_invoices.*','purchases.product_id','purchases.qty','purchases.price','purchases.pack','products.med_name')->join('purchases','purchases.invoice_id','=','purchase_invoices.id')->join('products','purchases.product_id','=','products.id')->where('purchase_invoices.id','=',$purchaseinvoice->id)->get();
        $products = Product::all();
        return view('admin.purchases.edit',compact('invoices','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseInvoice $purchaseinvoice)
    {
        $request->validate([
            'supplier'=>'required',
        ]);
        // dd($request->all(),$purchaseinvoice);
        PurchaseInvoice::where('id',$purchaseinvoice->id)->update([
            'supplier'=>$request->supplier,
            'total'=>array_sum($request->med_price)
        ]);

        for ($row=0; $row < count($request->product_id); $row++) {
            Purchase::where('product_id',$request->product_id[$row])->update([
                'invoice_id'=>$purchaseinvoice->id,
                'product_id'=>$request->product_id[$row],
                'pack'=>$request['med_pack'][$row],
                'qty'=>$request['med_qty'][$row],
                'price'=>$request['med_price'][$row]
            ]);
        }
        return redirect(route('admin.purchases.index'))->with('success','Record Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
