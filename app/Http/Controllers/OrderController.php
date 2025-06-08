<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function FinalInvoice(Request $request)
    {
        // 1. Validate incoming request
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'order_status' => 'required|string',
            'total_products' => 'required|integer',
            'sub_total' => 'required|numeric',
            'vat' => 'required|numeric',
            'total' => 'required|numeric',
            'payment_status' => 'required|string',
            'pay' => 'required|numeric',
            'due' => 'required|numeric',
        ]);

        DB::beginTransaction(); // 🔁 Start transaction

        try {
            // 2. Insert into `orders` table
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_date' => date('Y-m-d', strtotime($request->order_date)),
                'order_status' => $request->order_status,
                'total_products' => $request->total_products,
                'sub_total' => $request->sub_total,
                'vat' => $request->vat,
                'total' => $request->total,
                'payment_status' => $request->payment_status,
                'pay' => $request->pay,
                'due' => $request->due,
                'invoice_no' => 'EPOS' . mt_rand(10000000, 99999999),
                'created_at' => Carbon::now(),
            ]);

            // 3. Get all cart items from session
            $contents = session()->get('own_cart', []);

            // 4. Save each item to `order_details` table
            foreach ($contents as $item) {
                $subtotal = $item['subtotal'];
                $vatAmount = $subtotal * 0.05;
                $totalWithVat = $subtotal + $vatAmount;
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'unitcost' => $item['price'],
                    'vat' => $vatAmount,
                    'total' => $totalWithVat,
                ]);
            }

            // 5. Clear cart from session
            session()->forget('own_cart');

            DB::commit(); // ✅ Commit transaction

            // 6. Redirect with success message
            return redirect()->route('dashboard')->with([
                'message' => 'Order Complete Successfully',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // ❌ Rollback on error

            // Optional: Log the error
            \Log::error('Order Processing Failed: ' . $e->getMessage());

            return redirect()->back()->with([
                'message' => 'Something went wrong. Please try again.',
                'alert-type' => 'error'
            ]);
        }
    }


    public function PendingOrder()
    {
        //Provide Array of Objects (Eloquent Collection)
        $orders = Order::where('order_status', 'pending')->get();
        //return $orders;
        return view('backend.order.pending_order', compact('orders'));
    }// End Method


    public function OrderDetails($order_id)
    {

        $order = Order::where('id', $order_id)->first();

        //$orderItem = OrderDetail::with('product')->where('order_id',$order_id)->orderBy('id','DESC')->get();
        $orderItem = OrderDetail::where('order_id', $order_id)->orderBy('id', 'DESC')->get();
        //return $orderItem;
        return view('backend.order.order_details', compact('order', 'orderItem'));

    }// End Method


    public function OrderStatusUpdate(Request $request)
    {

        $order_id = $request->id;

        // 1. Update order status
        Order::findOrFail($order_id)->update(['order_status' => 'complete']);

        // 2. Get all related OrderDetails
        $orderItems = OrderDetail::where('order_id', $order_id)->get();

        // 3. Loop through each item and reduce product stock
        foreach ($orderItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->product_store = $product->product_store - $item->quantity;
                $product->save();
            }
        }

        $notification = array(
            'message' => 'Order Done Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('pending.order')->with($notification);


    }// End Method


    public function CompleteOrder(){

        $orders = Order::where('order_status','complete')->get();
        return view('backend.order.complete_order',compact('orders'));

    }// End Method

    public function StockManage(){

    $product = Product::latest()->get();
    return view('backend.stock.all_stock',compact('product'));

    }// End Method


    public function OrderInvoice($order_id)
    {
        // Fetch the order with details
        $order = Order::findOrFail($order_id);

        // Fetch order items along with product information
        $orderItem = OrderDetail::with('product')
            ->where('order_id', $order_id)
            ->orderBy('id', 'DESC')
            ->get();

        // Generate PDF using the view
        $pdf = Pdf::loadView('backend.order.order_invoice', compact('order', 'orderItem'))
            ->setPaper('a4');

        // Optional: Set options (only if needed for file path issues)
        // DOMPDF uses these if your view includes images or fonts from `public/`
        $pdf->setOptions([
            'tempDir' => public_path(),
            'chroot'  => public_path(),
        ]);

        // Download the PDF
        return $pdf->download('invoice.pdf');
    }



}
