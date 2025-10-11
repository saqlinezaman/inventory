<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function createInvoice(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {

            $userId = $request->header('userId');
            $data = [
                'user_id' => $userId,
                'customer_id' => $request->customer_id,
                'total' => $request->total,
                'discount' => $request->discount,
                'vat' => $request->vat,
                'payable' => $request->payable
            ];

            $invoice = Invoice::create($data);

            $products = $request->input('products');
            foreach ($products as $product) {
                $existUnit = Product::where('id', $product['id'])->first();
                if (!$existUnit) {
                    return response()->json([
                        'status' => 'failed',
                        "message" => 'Product not found with id: ' . $product['id'],
                    ], 404);
                }
                if ($existUnit->unit < $product['unit']) {
                    return response()->json([
                        'status' => 'failed',
                        "message" => 'Insufficient stock for product id: ' . $product['id'],
                    ], 400);
                }

                InvoiceProduct::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product['id'],
                    'user_id' => $userId,
                    'qty' => $product['unit'],
                    'sale_price' => $product['price']
                ]);
                Product::where('id', $product['id'])->update([
                    'unit' => $existUnit->unit - $product['unit']
                ]);
            } //end foreach


            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Invoice created successfully',
                'invoice_id' => $invoice->id
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => 'Invoice creation failed: ' . $e->getMessage()
            ], 500);
        } //end method
    } //end method

    public function listInvoice()
    {
        $userId = request()->header('userId');
        $invoices = Invoice::with(['customer'])->where('user_id', $userId)->get();
        return $invoices;
    } //end method
    public function invoiceDetails(Request $request)
    {
        $user_id = request()->header('userId');

        $customerDetails = Customer::where('user_id', $user_id)->where('id', $request->customer_id)->first();

        $invoiceDetails = Invoice::where('user_id', $user_id)->where('id', $request->invoice_id)->first();

        $invoiceProduct = InvoiceProduct::where('invoice_id', $request->invoice_id)
            ->where('user_id', $user_id)->with('product')
            ->get();
        return [
            'customer' => $customerDetails,
            'invoice' => $invoiceDetails,
            'product' => $invoiceProduct
        ];
    } //end method

    

}
