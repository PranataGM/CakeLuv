<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = null;
        if (Auth::check()) {
            $cart = Cart::with(['items.product'])->firstOrCreate(['user_id' => Auth::id()]);
        }

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $now = now()->setTimezone('Asia/Jakarta');
        $hour = $now->hour;
        // dinonaktifkan sementara untuk testing:
        // if ($hour < 8 || $hour >= 20) {
        if (false) {
            return response()->json([
                'status' => 'closed',
                'message' => 'Toko tutup. Jam operasional kami 08:00 - 20:00 WIB.'
            ]);
        }

        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Harap login terlebih dahulu.',
                'redirect' => true
            ]);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'custom_message' => 'nullable|string|max:100'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->daily_stock < $request->quantity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stok produk tidak mencukupi.'
            ]);
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $product->id)
                            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($newQuantity > $product->daily_stock) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Total kuantitas di keranjang melebihi batas stok harian.'
                ]);
            }
            $cartItem->quantity = $newQuantity;
            if ($request->has('custom_message')) {
                $cartItem->custom_message = $request->custom_message;
            }
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'custom_message' => $request->custom_message
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Produk ditambahkan ke keranjang belanja.'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::findOrFail($request->item_id);
        $product = $cartItem->product;

        if ($request->quantity > $product->daily_stock) {
            return back()->with('error', 'Kuantitas melebihi batas stok harian.');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id'
        ]);

        CartItem::destroy($request->item_id);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
