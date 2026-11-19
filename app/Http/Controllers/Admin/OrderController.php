<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $orders = Order::with('user')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest('ordered_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'user', 'shippingService', 'validator']);

        return view('admin.orders.show', compact('order'));
    }

    public function confirm(Order $order): RedirectResponse
    {
        abort_if($order->status !== 'pending', 400, 'Pesanan hanya dapat divalidasi jika berstatus pending.');

        $order->update([
            'status' => 'confirmed',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
        ]);

        return back()->with('success', 'Pesanan berhasil divalidasi dan dikonfirmasi.');
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:processed,shipped,completed',
        ]);

        abort_if(in_array($order->status, ['cancelled', 'completed']), 400, 'Status pesanan tidak dapat diubah.');

        $order->update([
            'status' => $request->string('status')->toString(),
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function cancel(Order $order): RedirectResponse
    {
        abort_if(in_array($order->status, ['cancelled', 'completed']), 400, 'Pesanan sudah tidak dapat dibatalkan.');

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);

                        StockMovement::create([
                            'product_id' => $product->id,
                            'user_id' => auth()->id(),
                            'type' => 'IN',
                            'quantity' => $item->quantity,
                            'reference' => $order->code,
                            'note' => 'Pembatalan pesanan ' . $order->code,
                            'movement_at' => now(),
                        ]);
                    }
                }
            }

            $order->update([
                'status' => 'cancelled',
            ]);
        });

        return back()->with('success', 'Pesanan berhasil dibatalkan dan stok produk telah dikembalikan (rollback).');
    }
}