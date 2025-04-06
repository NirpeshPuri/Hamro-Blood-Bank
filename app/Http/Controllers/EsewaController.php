<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RemoteMerge\Esewa\Client;
use RemoteMerge\Esewa\Config;

class EsewaController extends Controller
{
    // Initiate eSewa payment
    public function esewaPay(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'admin_id' => 'required|exists:admins,id',
            'blood_quantity' => 'required|integer|min:1',
            'blood_group' => 'required|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'request_type' => 'required|in:Emergency,Rare,Normal',
            'payment' => 'required|numeric',
            'request_form' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('request_form')) {
            $image = $request->file('request_form');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/request_forms', $imageName); // Save the image in the storage folder
            $imagePath = 'request_forms/' . $imageName; // Path to store in the database
        }

        // Generate a unique ID for the order
        $pid = uniqid();

        // Store the form data temporarily in the session
        $orderData = [
            'id' => $pid,
            'user_id' => $request->user_id,
            'admin_id' => $request->admin_id,
            'blood_quantity' => $request->blood_quantity,
            'blood_group' => $request->blood_group,
            'request_type' => $request->request_type,
            'status' => 'Pending', // Default status
            'payment' => $request->payment,
            'request_form' => $imagePath,
            'created_at' => Carbon::now(),
        ];
        BloodRequest::create($orderData);
        // Store the order data in the session
        session(['order_data' => $orderData]);

        // Set success and failure callback URLs
        $successUrl = route('esewa.success'); // Use named route for success callback
        $failureUrl = route('esewa.failure'); // Use named route for failure callback

        // Initialize eSewa configuration as an array
        $config = [
            'merchant_code' => 'EPAYTEST', // Replace with your eSewa merchant code
            'success_url' => $successUrl,
            'failure_url' => $failureUrl,
        ];

        // Initialize eSewa client
        $esewa = new Client($config);

        // Generate form inputs
        $formInputs = [
            'scd' => $esewa->getMerchantCode(),
            'su' => $esewa->getSuccessUrl(),
            'fu' => $esewa->getFailureUrl() . '?' . http_build_query(['pid' => $pid]),
            'pid' => $pid,
            'amt' => $request->payment,
            'txAmt' => 0.0,
            'psc' => 0.0,
            'pdc' => 0.0,
            'tAmt' => $request->payment,
        ];

        // Render the eSewa payment form
        return view('esewa_payment', [
            'esewaUrl' => $esewa->getApiUrl() . '/epay/main',
            'formInputs' => $formInputs,
        ]);
    }

    // Handle eSewa payment success
    public function esewaPaySuccess(Request $request)
    {
        // Retrieve payment details from the request
        $pid = $request->query('pid'); // Product ID
        $refId = $request->query('refId'); // Reference ID
        $amount = $request->query('amt'); // Amount

        // Retrieve the temporary order data from the session
        $orderData = session('order_data');

        if ($orderData && $orderData['id'] === $pid) {
            // Verify the payment using the reference ID
            $config = [
                'merchant_code' => 'EPAYTEST', // Replace with your eSewa merchant code
                'success_url' => route('esewa.success'),
                'failure_url' => route('esewa.failure'),
            ];

            $esewa = new Client($config);

            try {
                $isPaymentVerified = $esewa->verifyPayment($refId, $pid, (float) $amount);

                if ($isPaymentVerified) {
                    // Insert the order into the BloodRequest table
                    BloodRequest::create($orderData);

                    // Clear the temporary order data from the session
                    session()->forget('order_data');

                    // Send a success message to the user
                    $msg = 'Success';
                    $msg1 = 'Payment success. Thank you for making a purchase with us.';
                    return view('thankyou', compact('msg', 'msg1'));
                } else {
                    // Payment verification failed
                    $msg = 'Failed';
                    $msg1 = 'Payment verification failed. Please contact support.';
                    return view('thankyou', compact('msg', 'msg1'));
                }
            } catch (\Exception $e) {
                // Handle verification errors
                $msg = 'Error';
                $msg1 = 'Payment verification error: ' . $e->getMessage();
                return view('thankyou', compact('msg', 'msg1'));
            }
        }

        // If the order data is not found, show an error message
        $msg = 'Error';
        $msg1 = 'Order not found. Please contact support.';
        return view('thankyou', compact('msg', 'msg1'));
    }

    // Handle eSewa payment failure
    public function esewaPayFailed(Request $request)
    {
        // Retrieve payment details from the request
        $pid = $request->query('pid'); // Product ID

        // Clear the temporary order data from the session
        session()->forget('order_data');

        // Send a failure message to the user
        $msg = 'Failed';
        $msg1 = 'Payment failed. Please try again or contact support.';
        return view('thankyou', compact('msg', 'msg1'));
    }
}
