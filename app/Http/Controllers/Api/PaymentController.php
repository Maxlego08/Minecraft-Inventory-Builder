<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function notification(Request $request, string $payment, ?string $id = null) {
        return paymentManager()->process($request, $payment, $id);
    }
}
