<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Summary</title>
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    table th,
    table td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: left;
    }

    table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
</style>
<body>
    <div>
        {!! $tableHtml !!}
    </div>
    <div>
       
        <p>Total price without tax: {{ $totalPriceWithoutTax }}</p>
        <p>Total tax payable: {{ $totalTaxPayable }}</p>
        <p>Net Price of the purchased item: {{ $totalNetPrice }}</p>
        <p>Rounded down value of the purchased item net price: {{ $totalRoundedPrice }}</p>
        <p>Balance payable to the customer: {{ $totalBalance }}</p>
    </div>
</body>
</html>
