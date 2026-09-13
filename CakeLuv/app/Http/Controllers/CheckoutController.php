<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect('/cart')->with('error', 'Keranjang Anda kosong.');
        }

        $total = 0;
        foreach ($cart->items as $item) {
            $total += $item->product->price * $item->quantity * 1000;
        }

        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $now = now()->setTimezone('Asia/Jakarta');
        $hour = $now->hour;
        if ($hour < 8 || $hour >= 20) {
            return back()->with('error', 'Toko tutup. Jam operasional kami 08:00 - 20:00 WIB.');
        }

        $request->validate([
            'target_date' => 'required|date|after:today',
            'delivery_type' => 'required|in:pickup,delivery',
            'shipping_address' => 'required_if:delivery_type,delivery'
        ]);

        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect('/cart')->with('error', 'Keranjang Anda kosong.');
        }

        $totalAmount = 0;
        // Verify stock first
        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->daily_stock) {
                return redirect('/cart')->with('error', "Stok {$item->product->name} tidak mencukupi.");
            }
            $totalAmount += $item->product->price * $item->quantity * 1000;
        }

        // Add delivery fee if applicable
        $shippingFee = 0;
        if ($request->delivery_type == 'delivery') {
            $shippingFee = 50000;
            $totalAmount += $shippingFee;
        }

        try {
            DB::beginTransaction();

            $orderNumber = 'ORD-' . strtoupper(Str::random(10));

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount,
                'target_date' => $request->target_date,
                'delivery_type' => $request->delivery_type,
                'shipping_address' => $request->delivery_type == 'delivery' ? $request->shipping_address : null,
                'payment_status' => 'pending',
                'production_status' => 'waiting'
            ]);

            $itemDetails = [];

            foreach ($cart->items as $item) {
                $priceIdr = $item->product->price * 1000;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product_id = $item->product->id,
                    'price_at_purchase' => $item->product->price,
                    'quantity' => $item->quantity,
                    'custom_message' => $item->custom_message
                ]);

                // Deduct stock
                $product = Product::find($item->product_id);
                $product->decrement('daily_stock', $item->quantity);

                // Midtrans item format
                $itemDetails[] = [
                    'id' => $item->product->id,
                    'price' => $priceIdr,
                    'quantity' => $item->quantity,
                    'name' => substr($item->product->name, 0, 50)
                ];
            }

            if ($shippingFee > 0) {
                $itemDetails[] = [
                    'id' => 'SHIPPING',
                    'price' => $shippingFee,
                    'quantity' => 1,
                    'name' => 'Ongkos Kirim'
                ];
            }

            // Generate Midtrans Snap Token
            $serverKey = env('MIDTRANS_SERVER_KEY');
            $isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            
            if ($serverKey) {
                $apiUrl = $isProduction ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
                
                $payload = [
                    'transaction_details' => [
                        'order_id' => $orderNumber,
                        'gross_amount' => $totalAmount,
                    ],
                    'item_details' => $itemDetails,
                    'customer_details' => [
                        'first_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'phone' => Auth::user()->phone ?? '08123456789'
                    ]
                ];

                $response = Http::withBasicAuth($serverKey, '')
                                ->post($apiUrl, $payload);

                if ($response->successful()) {
                    $snapToken = $response->json()['token'];
                    $order->update(['snap_token' => $snapToken]);
                } else {
                    DB::rollBack();
                    return back()->with('error', 'Gagal memproses pembayaran: ' . $response->body());
                }
            } else {
                // If no midtrans key, just mock it (Local/Portfolio mode)
                $order->update(['snap_token' => 'MOCK_TOKEN_' . Str::random(10)]);
            }

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('checkout.status', ['order_number' => $orderNumber]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function status($order_number)
    {
        $order = Order::where('order_number', $order_number)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        return view('checkout.status', compact('order'));
    }

    // This is a fallback/mock for finishing local payment if Midtrans isn't fully configured
    public function finishLocalPayment(Request $request)
    {
        $orderNumber = $request->order_id;
        $order = Order::where('order_number', $orderNumber)->first();
        if($order && $order->payment_status == 'pending') {
            $order->update(['payment_status' => 'paid']);
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error'], 400);
    }
}
