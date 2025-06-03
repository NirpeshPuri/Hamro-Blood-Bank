<?php

namespace App\Http\Controllers;


use App\Models\BloodBank;
use App\Models\BloodRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EsewaController extends Controller
{
    public function showPaymentPage()
    {
        if (!session()->has('blood_request')) {
            return redirect()->route('request.blood')->with('error', 'Please submit a blood request first');
        }

        $requestData = session('blood_request');

        return view('receiver.payment', [
            'request' => $requestData,
            'bloodBank' => BloodBank::find($requestData['admin_id'])
        ]);
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'blood_quantity' => 'required|integer|min:1|max:5',
            'payment_amount' => 'required|numeric|min:0|max:1500',
        ]);

        // Update the session data
        $bloodRequest = session('blood_request');
        $bloodRequest['blood_quantity'] = $request->blood_quantity;
        $bloodRequest['payment_amount'] = $request->payment_amount;
        session(['blood_request' => $bloodRequest]);

        // Generate a unique transaction ID
        $transaction_uuid = uniqid('txn_') . time();

        // Prepare eSewa parameters
        $secret_key = "8gBm/:&EnhH.1/q";
        $product_code = "EPAYTEST";
        $success_url = route('esewa.success');
        $failure_url = route('esewa.failure');

        $signature_string = "total_amount={$request->payment_amount},transaction_uuid={$transaction_uuid},product_code={$product_code}";
        $signature = base64_encode(hash_hmac('sha256', $signature_string, $secret_key, true));

        return view('receiver.esewa_payment', [
            'amount' => $request->payment_amount,
            'tax_amount' => 0,
            'total_amount' => $request->payment_amount,
            'transaction_uuid' => $transaction_uuid,
            'product_code' => $product_code,
            'success_url' => $success_url,
            'failure_url' => $failure_url,
            'signature' => $signature,
            'signed_field_names' => 'total_amount,transaction_uuid,product_code',
            'request' => $bloodRequest
        ]);
    }

}
