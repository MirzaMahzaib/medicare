<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseInvoice;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchases = PurchaseInvoice::all();

        return view('admin.purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // abort_if(Gate::denies('purchase_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $products = Product::all();
        return view('admin.purchases.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['p_invoice'] = 'P'.random_int(100000, 999999);
        $request->validate([
            'supplier'=>'required',
            'p_invoice'=>'required|unique:purchase_invoices'
        ]);

        $purchaseInvoice = PurchaseInvoice::create([
            'p_invoice'=>$request->p_invoice,
            'supplier'=>$request->supplier,
            'total'=>array_sum($request->med_price)
        ]);

        for ($row=0; $row < count($request->product_id); $row++) {
            Purchase::create([
                'invoice_id'=>$purchaseInvoice->id,
                'product_id'=>$request->product_id[$row],
                'pack'=>$request['med_pack'][$row],
                'qty'=>$request['med_qty'][$row],
                'price'=>$request['med_price'][$row]
            ]);
            Product::where('id',$request->product_id[$row])->update([
                'med_price'=>$request->med_price[$row],
                'med_qty'=>DB::raw('med_qty + '.$request->med_qty[$row]),
                'med_pack'=>DB::raw('med_pack + '.$request->med_pack[$row]),
            ]);
        }
        return redirect(route('admin.purchases.index'))->with('success','Record Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseInvoice $purchaseInvoice)
    {
        $products = Purchase::where('invoice_id',$purchaseInvoice->id)->get();
        dd($purchaseInvoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        return view('admin.purchases.edit',compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        $purchase->update($request->all());
        return redirect(route('admin.purchases.index'))->with('success','Record Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->destroy($purchase->id);
        return redirect(route('admin.purchases.index'))->with('success','Record Deleted Successfully!');
    }

    public function massDestroy(Request $request)
    {
        Purchase::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
