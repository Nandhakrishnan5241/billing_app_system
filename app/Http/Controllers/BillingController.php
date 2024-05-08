<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\BillingSummaryMail;
use Illuminate\Support\Facades\Mail;

class BillingController extends Controller
{
    public function save(Request $request)
    {
        $data           = $request->all();
        $customerEmail  = $data["customerEmail"];
        $productIDs     = $request->input('productID');
        $quantities     = $request->input('quantity');
        $productDetails = [];
        foreach ($productIDs as $index => $productID) {
            $productDetails[$productID] = (int) $quantities[$index];
        }
        $productDetailsJson = json_encode($productDetails);

        
        DB::table('customers')->insert([
            'customer_email' => $customerEmail,
            'customer_details' => $productDetailsJson,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return view("/billing", ["customerEmail" => $customerEmail, "productIDs" => $productIDs, "quantities" => $quantities, "productDetails" => $productDetails,]);

    }

    public function getProductData(Request $request)
    {
        $productIDs = $request->input('productids');
        $products = DB::table('products')->whereIn('product_id', $productIDs)->get();
        return $products;
    }
    public function sendEmail(Request $request)
    {
        try {
            $customerEmail          = $request->input('customerEmail');
            $tableHtml              = $request->input('tableHtml');
            $totalPriceWithoutTax   = $request->input('totalPriceWithoutTax');
            $totalTaxPayable        = $request->input('totalTaxPayable');
            $totalNetPrice          = $request->input('totalNetPrice');
            $totalRoundedPrice      = $request->input('totalRoundedPrice');
            $totalBalance           = $request->input('totalBalance');
            \Log::info('Customer Email: ' . $customerEmail);
            \Log::info('Table HTML: ' . $tableHtml);
            \Log::info('Total Price Without Tax: ' . $totalPriceWithoutTax);
            \Log::info('Total Tax Payable: ' . $totalTaxPayable);
            \Log::info('Total Net Price: ' . $totalNetPrice);
            \Log::info('Total Rounded Price: ' . $totalRoundedPrice);
            \Log::info('Total Balance: ' . $totalBalance);
           
            if (!$customerEmail || !$tableHtml || !$totalPriceWithoutTax || !$totalTaxPayable || !$totalNetPrice || !$totalRoundedPrice || !$totalBalance) {
                throw new \Exception('Invalid input data.');
            }
        
            Mail::to($customerEmail)->send(new BillingSummaryMail(
                $tableHtml,
                $totalPriceWithoutTax,
                $totalTaxPayable,
                $totalNetPrice,
                $totalRoundedPrice,
                $totalBalance
            ));
        
            return response()->json(['message' => 'Email sent successfully']);
        } catch (\Exception $e) {
            \Log::error('Error sending email: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send email. Please try again later.'], 500);
        }
        
    }

}
