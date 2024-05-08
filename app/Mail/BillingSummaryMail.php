<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillingSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tableHtml;
    public $totalPriceWithoutTax;
    public $totalTaxPayable;
    public $totalNetPrice;
    public $totalRoundedPrice;
    public $totalBalance;

    
    public function __construct($tableHtml, $totalPriceWithoutTax, $totalTaxPayable, $totalNetPrice, $totalRoundedPrice, $totalBalance)
    {
        $this->tableHtml             = $tableHtml;
        $this->totalPriceWithoutTax  = $totalPriceWithoutTax;
        $this->totalTaxPayable       = $totalTaxPayable;
        $this->totalNetPrice         = $totalNetPrice;
        $this->totalRoundedPrice     = $totalRoundedPrice;
        $this->totalBalance          = $totalBalance;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       

        return $this->view('email.billing_summary')
            ->subject('Billing Summary');
    }
}
