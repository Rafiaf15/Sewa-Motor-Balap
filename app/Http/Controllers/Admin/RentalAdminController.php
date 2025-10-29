<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Motor;
use App\Models\Joki;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RentalAdminController extends Controller
{
    public function active()
    {
        $orders = Order::with('user')
            ->whereIn('status', ['paid','active'])
            ->orderByDesc('created_at')
            ->get();
        return view('admin.rentals.active', compact('orders'));
    }

    public function returnItem(Order $order)
    {
        if (!in_array($order->status, ['paid','active'])) {
            return back()->with('error', 'Order tidak dalam status aktif.');
        }

        // mark item available again
        if ($order->item_type === 'motor') {
            $item = Motor::find($order->item_id);
            if ($item) {
                $item->update(['available' => true]);
            }
        } elseif ($order->item_type === 'joki') {
            $item = Joki::find($order->item_id);
            if ($item) {
                $item->update(['available' => true]);
            }
        }

        $order->update([
            'status' => 'completed',
            'end_date' => now(),
        ]);

        return back()->with('success', 'Pengembalian berhasil diproses.');
    }

    public function history(User $user)
    {
        $orders = Order::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
        return view('admin.rentals.history', compact('user','orders'));
    }
}


