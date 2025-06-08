<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function Pos()
    {
        $product = Product::latest()->get();
        $customer = Customer::latest()->get();
        return view('backend.pos.pos_page', compact('product', 'customer'));
    } // End Method


    public function AddCart(Request $request)
    {

        Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'weight' => 20,
            'options' => ['size' => 'large']]);

        $notification = array(
            'message' => 'Product Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function AllItem()
    {
        $product_item = Cart::content();

        return view('backend.pos.text_item', compact('product_item'));

    } // End Method More actions

    public function CartUpdate(Request $request, $rowId)
    {

        $qty = $request->qty;
        $update = Cart::update($rowId, $qty);

        $notification = array(
            'message' => 'Cart Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    //cart item remove from cart
    public function CartRemove($rowId)
    {

        Cart::remove($rowId);

        $notification = array(
            'message' => 'Cart Remove Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method


    ///////////////////////////////////////////////////////////Own POS///////////////////////////////////////////////
    //this will show all product,customer,all cart data if exit;
    public function OwnPos()
    {
        $product = Product::latest()->get();
        $customer = Customer::latest()->get();
        $cart = session()->get('own_cart', []);

        $cartTotalQty = 0;
        $cartSubTotal = 0;

        foreach ($cart as $item) {
            $cartTotalQty += $item['qty'];
            $cartSubTotal += $item['qty'] * $item['price'];
        }

        $vat = $cartSubTotal * 0.05;
        $total = $cartSubTotal + $vat;

        return view('backend.pos.own_pos_page', compact(
            'product',
            'customer',
            'cart',
            'cartTotalQty',
            'cartSubTotal',
            'vat',
            'total'
        ));
    }


    //this will add item in cart
    public function OwnAddCart(Request $request)
    {
        //$cart = session()->get('cart', []);
        $cart = session()->get('own_cart', []);

        $productId = $request->id;

        // If item already in cart, increase qty
        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += $request->qty;
            $cart[$productId]['subtotal'] = $cart[$productId]['qty'] * $cart[$productId]['price'];
        } else {
            $cart[$productId] = [
                'id' => $productId,
                'name' => $request->name,
                'qty' => $request->qty,
                'price' => $request->price,
                'subtotal' => $request->qty * $request->price,
            ];
        }

        //session()->put('cart', $cart);
        session()->put('own_cart', $cart);//give own cart name; not to interfere with global cart

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    //this will update cart item,price
    public function OwnCartUpdate(Request $request, $productId)
    {
        //$cart = session()->get('cart', []);
        $cart = session()->get('own_cart', []);//own cart; for not conflict with global cart

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] = $request->qty;
            $cart[$productId]['subtotal'] = $request->qty * $cart[$productId]['price'];
            //session()->put('cart', $cart);
            session()->put('own_cart', $cart);//give own cart name; not to interfere with global cart
        }

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    //this will remove item from cart
    public function OwnCartRemove($productId)
    {
        //$cart = session()->get('cart', []);
        $cart = session()->get('own_cart', []);//give own cart name; not to interfere with global cart
        unset($cart[$productId]);
        //session()->put('cart', $cart);
        session()->put('own_cart', $cart);//give own cart name; not to interfere with global cart

        return redirect()->back()->with('success', 'Cart item removed successfully.');
    }


    //testing puropose; showing cart data
    public function OwnAllItem()
    {
        //$product_item = session()->get('cart', []);
        $product_item = session()->get('own_cart', []);//give own cart name; not to interfere with global cart


        return view('backend.pos.own_text_item', compact('product_item'));

    } // End Method More actions

    public function OwnDestroyCart()
    {
        //session()->forget('cart'); // Remove the entire cart session
        //session()->forget('own_cart'); // Remove the entire cart session

        $notification = array(
            'message' => 'All Cart Items Removed Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    /////////////////////////////////////invoice////////////////////////////////////////
    public function CreateInvoice(Request $request)
    {
        //get all cart value
        $contents = session()->get('own_cart', []);
        $cust_id = $request->customer_id;
        $customer = Customer::where('id', $cust_id)->first();
        return view('backend.invoice.product_invoice', compact('contents', 'customer'));

    } // End Method


}
