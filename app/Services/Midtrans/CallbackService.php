<?php

namespace App\Services\Midtrans;

// use App\Models\Pesanan;
use App\Services\Midtrans\Midtrans;
use Illuminate\Support\Facades\DB;
use Midtrans\Notification;

class CallbackService extends Midtrans
{
    protected $notification;
    protected $order;
    protected $serverKey;

    public function __construct()
    {
        parent::__construct();

        $this->serverKey = config('midtrans.server_key');
        $this->_handleNotification();
    }

    public function isSignatureKeyVerified()
    {
        return ($this->_createLocalSignatureKey() == $this->notification->signature_key);
    }

    public function isSuccess()
    {
        $statusCode = $this->notification->status_code;
        $transactionStatus = $this->notification->transaction_status;
        $fraudStatus = !empty($this->notification->fraud_status) ? ($this->notification->fraud_status == 'accept') : true;

        // DB::table('pesanan')
        //     ->where('pesanan_id', session('pesanan_id'))
        //     ->update(['status_pembayaran' => 'Sudah Dibayar']);

        return ($statusCode == 200 && $fraudStatus && ($transactionStatus == 'capture' || $transactionStatus == 'settlement'));
    }

    public function isExpire()
    {
        // DB::table('pesanan')
        //     ->where('pesanan_id', session('pesanan_id'))
        //     ->update(['status_pembayaran' => 'Kadaluarsa']);

        return ($this->notification->transaction_status == 'expire');
    }

    public function isCancelled()
    {
        // DB::table('pesanan')
        //     ->where('pesanan_id', session('pesanan_id'))
        //     ->update(['status_pembayaran' => 'Batal']);
        return ($this->notification->transaction_status == 'cancel');
    }

    public function getNotification()
    {
        return $this->notification;
    }

    public function getOrder()
    {
        return $this->order;
    }

    protected function _createLocalSignatureKey()
    {
        return hash(
            'sha512',
            $this->notification->order_id . $this->notification->status_code .
                $this->notification->gross_amount . $this->serverKey
        );
    }

    protected function _handleNotification()
    {
        $notification = new Notification();

        $orderNumber = $notification->order_id;
        $order = DB::table('pesanan')
            ->where('kode', $orderNumber)->first();
        // $order = Pesanan::where('number', $orderNumber)->first();

        $this->notification = $notification;
        $this->order = $order;
    }
}
