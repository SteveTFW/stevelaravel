<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Midtrans\CallbackService;
use Illuminate\Support\Facades\DB;

class PaymentCallbackController extends Controller
{
    public function receive()
    {
        $callback = new CallbackService;

        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $order = $callback->getOrder();

            if ($callback->isSuccess()) {
                DB::table('pesanan')
                    ->where('kode', $order->kode)
                    ->update(['status_pembayaran' => 'Sudah Dibayar']);
                // Order::where('id', $order->id)->update([
                //     'payment_status' => 2,
                // ]);
            }

            if ($callback->isExpire()) {
                DB::table('pesanan')
                    ->where('kode', $order->kode)
                    ->update(['status_pembayaran' => 'Kadaluarsa']);
                // Order::where('id', $order->id)->update([
                //     'payment_status' => 3,
                // ]);
            }

            if ($callback->isCancelled()) {
                DB::table('pesanan')
                    ->where('kode', $order->kode)
                    ->update(['status_pembayaran' => 'Sudah Dibayar']);
                // Order::where('id', $order->id)->update([
                //     'payment_status' => 4,
                // ]);
            }

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil diproses',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }
    }
}
