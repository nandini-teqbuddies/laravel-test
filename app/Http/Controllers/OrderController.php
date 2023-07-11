<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $products = Product::get(['id','name','price']);
        $vouchers = Voucher::get(['id','description']);
        $data = [
            'products' => $products,
            'vouchers' => $vouchers
        ];
        dump(session('cart'));
       // session()->forget('cart');
       //$this->applyDiscount();
       return view('order', $data);
    }

    public function addToCart(Request $request)
    {
        $data = $request->all();
        $product = Product::find($data['productId']);
        $cart = session('cart');
        $products = $cart['products'] ?? [];
        if(isset($product)){
            $productKey = array_search($data['productId'], array_column($products, 'id'));
                if($productKey !== false){
                    $qty = $products[$productKey]['qty'];
                    $products[$productKey]['qty'] = ++$qty;
                }else{
                    $product = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'qty' => 1
                    ];
                    array_push($products, $product);
                }
            $cart['products'] = $products;
        }
       // dd($cart);
        session(['cart' => $cart]);
        return redirect(route('order.index'));
    }

    public function removeFromCart(Request $request)
    {
        $data = $request->all();
        $cart = session('cart');
        $products = $cart['products'] ?? [];
        $key = array_search($data['productId'], array_column($products, 'id'));
        if ($key !== false) {
            if($data['action'] == "removeOneFromCart" && $products[$key]['qty'] > 1){
                --$products[$key]['qty']; 
            }else {
                unset($products[$key]);
                $products = array_values($products);
            }
        }
        $cart['products'] = $products;
        session(['cart' => $cart]);
        return redirect(route('order.index'));
    }


    public function applyVoucher(Request $request)
    {
        $data = $request->all();
        $voucher = Voucher::find($data['voucherId']);
        $cart = session('cart');
        $vouchers = $cart['vouchers'] ?? [];
        if(isset($voucher)){
            $voucherKey = array_search($data['voucherId'], $vouchers);
            if($voucherKey === false){
                array_push($vouchers,$voucher->id);
            }
            $cart['vouchers'] = $vouchers;
        }
        session(['cart' => $cart]);
        return redirect(route('order.index'));
    }
    
    public function removeVoucher(Request $request)
    {
        $data = $request->all();
        $cart = session('cart');
        $vouchers = $cart['vouchers'] ?? [];
        $voucherKey = array_search($data['voucherId'], $vouchers);
        if($voucherKey !== false){
            unset($vouchers[$voucherKey]);
        }
        $cart['vouchers'] = array_values($vouchers);
        session(['cart' => $cart]);
        return redirect(route('order.index'));
    }

    public function applyDiscount()
    {
        $discounts = [
            ["id" => 1, "value" => 0],
            ["id" => 2, "value" => 0],
            ["id" => 3, "value" => 0],
        ];

        $cart = session('cart');
        $vouchers = $cart['vouchers'] ?? [];
        $products = $cart['products'] ?? [];
        if(count($vouchers) > 0 && count($products)>0){
            foreach($products as $product){
                if ($product['id'] == 1 && $product['quantity'] > 1 && in_array(1, $vouchers)) {
                    $discountPrice = ($product['price'] * 10) / 100;
                    $discounts[0]['value'] = $discountPrice;
                }

                if ($product['id'] == 2 && in_array(2, $vouchers)) {
                    // Total of 5€ discount on Product B.
                    $discountPrice = 5;
                    $discounts[1]['value'] = $discountPrice;
                }

                $cartTotal = array_sum(array_map(function ($product) {
                    return ($product['qty'] * $product['price']);
                }, $products));
                $totalDiscount = array_sum(array_column($discounts, 'value'));
                $currentCartValue = $cartTotal - $totalDiscount;
    
                if (in_array(3, $vouchers) && ($currentCartValue) > 40) {
                    $discountPrice = (($currentCartValue) * 5) / 100;
                    $discounts[2]['value'] = $discountPrice;
                }

            }
        }
        array_push($cart, [
            "totalDiscount" => $totalDiscount,
            "cartTotal" => $cartTotal,
            "discounts" => $discounts
        ]);
        session(['cart', $cart]);
    }
}
