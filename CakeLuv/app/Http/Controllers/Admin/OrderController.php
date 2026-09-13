<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items.product')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,expired',
            'production_status' => 'required|in:waiting,processing,ready,completed,cancelled'
        ]);

        $order->update([
            'payment_status' => $request->payment_status,
            'production_status' => $request->production_status
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
