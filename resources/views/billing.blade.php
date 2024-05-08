<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage Billing</title>
</head>
<style>
    #table-container {
        width: 100%;
        overflow-x: auto;
    }

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

    .customerEmail {
        font-family: Arial, sans-serif;
        font-size: 22px;
        color: #fafafa;
        background-color: #03012f;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .container {
        margin-top: 30px;
        float: right;
        font-size: 20px;
    }

    .separator {
        border-top: 1px solid #ccc;
        margin: 20px 0;
    }

    .denominations,
    .balanceDenominations {
        font-family: Arial, sans-serif;
        margin-bottom: 20px;
    }

    .denominations label,
    .balanceDenominations label {
        display: inline-block;
        width: 60px;
        margin-right: 10px;
        text-align: right;
    }

    .denominations input,
    .balanceDenominations input {
        width: 80px;
        padding: 5px;
        margin-bottom: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    #total,
    #balanceTotal {
        font-weight: bold;
    }

    #sendMail {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 10px;
        cursor: pointer;
        border-radius: 8px;
        justify-content: flex-end;
        float: right;
    }
</style>

<body>
    <div class="customerEmail">Customer Email : <b>{{ $customerEmail }}</b></div>
    <button id="sendMail">Send Mail</button>
    <div id="table-container">
    </div>
    <div style="width: 100%; margin-top: 15px; text-align: right;">
        <div class="totalPrice"></div>
        <div class="totalTax"></div>
        <div class="netPrice"></div>
        <div class="roundedPrice"></div>
        <div class="balance"></div>
    </div>
    <div class="separator"></div><br>
    <div class="row" style="width: 100%; display : flex;">

        <div class="col denominations" style="width: 50%">
            <h2>Denominations</h2>
            <label for="denomination500">500</label>
            <input type="number" id="denomination500" data-value="500"><br>

            <label for="denomination50">50</label>
            <input type="number" id="denomination50" data-value="50"><br>

            <label for="denomination20">20</label>
            <input type="number" id="denomination20" data-value="20"><br>

            <label for="denomination10">10</label>
            <input type="number" id="denomination10" data-value="10"><br>

            <label for="denomination5">5</label>
            <input type="number" id="denomination5" data-value="5"><br>

            <label for="denomination2">2</label>
            <input type="number" id="denomination2" data-value="2"><br>

            <label for="denomination1">1</label>
            <input type="number" id="denomination1" data-value="1"><br><br><br>
            <p>Total: <span id="total"></span></p>
        </div>


        <div class="col balanceDenominations" style="width: 50%">
            <h2>Balance Denominations</h2>
            <label for="denomination500">500</label>
            <input type="number" id="denomination500" data-value="500"><br>

            <label for="denomination50">50</label>
            <input type="number" id="denomination50" data-value="50"><br>

            <label for="denomination20">20</label>
            <input type="number" id="denomination20" data-value="20"><br>

            <label for="denomination10">10</label>
            <input type="number" id="denomination10" data-value="10"><br>

            <label for="denomination5">5</label>
            <input type="number" id="denomination5" data-value="5"><br>

            <label for="denomination2">2</label>
            <input type="number" id="denomination2" data-value="2"><br>

            <label for="denomination1">1</label>
            <input type="number" id="denomination1" data-value="1"><br><br><br>
            <p>Balance : <span id="balanceTotal"></span></p>
        </div>

    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var customerEmail = "{{ $customerEmail ?? '' }}";
        var productIDs = {!! json_encode($productIDs ?? []) !!};
        var quantities = {!! json_encode($quantities ?? []) !!};
        var productDetails = {!! json_encode($productDetails ?? []) !!};

        var totalPriceWithoutTax = 0;
        var totalTaxPayable = 0;
        var totalNetPrice = 0;
        var totalRoundedPrice = 0;
        var totalBalance = 0;
        $(document).ready(function() {
            $.ajax({
                url: 'getproductdata',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {
                    productids: productIDs
                },
                success: function(response) {
                    if (response) {
                        displayDataInTable(response);
                    } else {
                        console.log("error");
                    }
                }
            });
        });

        function displayDataInTable(data) {
            var tableHtml = '<table>';
            tableHtml +=
                '<thead><tr><th>Product ID</th><th>Product</th><th>Unit Price</th><th>Quantity</th><th>Purchase Price</th><th>Tax % for item</th><th>Tax Payable for item</th><th>Total Price</th></tr></thead>';
            tableHtml += '<tbody>';
            data.forEach(function(item, index) {
                var unitPrice = parseFloat(item.price);
                var quantity = parseInt(quantities[index]);
                var taxPercentage = parseFloat(item.tax_percentage);
                var totalPriceWithoutTaxItem = unitPrice * quantity;
                var taxPayableItem = (totalPriceWithoutTaxItem * taxPercentage) / 100;
                var netPriceItem = totalPriceWithoutTaxItem + taxPayableItem;
                var roundedDownPriceItem = Math.floor(netPriceItem);
                var balancePayableItem = netPriceItem - roundedDownPriceItem;

                totalPriceWithoutTax += totalPriceWithoutTaxItem;
                totalTaxPayable += taxPayableItem;
                totalNetPrice += netPriceItem;
                totalRoundedPrice += roundedDownPriceItem;
                // totalBalance += balancePayableItem;
                tableHtml += '<tr>';
                tableHtml += '<td>' + item.product_id + '</td>';
                tableHtml += '<td>' + item.name + '</td>';
                tableHtml += '<td>' + unitPrice.toFixed(2) + '</td>';
                tableHtml += '<td>' + quantity + '</td>';
                tableHtml += '<td>' + totalPriceWithoutTaxItem.toFixed(2) + '</td>';
                tableHtml += '<td>' + taxPercentage.toFixed(2) + '</td>';
                tableHtml += '<td>' + taxPayableItem.toFixed(2) + '</td>';
                tableHtml += '<td>' + netPriceItem.toFixed(2) + '</td>';

                tableHtml += '</tr>';
            });

            tableHtml += '</tbody></table>';
            $('.totalPrice').text('Total price without tax: ' + totalPriceWithoutTax.toFixed(2));
            $('.totalTax').text('Total tax payable: ' + totalTaxPayable.toFixed(2));
            $('.netPrice').text('Net Price of the purchased item: ' + totalNetPrice.toFixed(2));
            $('.roundedPrice').text('Rounded down value of the purchased item net price: ' + totalRoundedPrice.toFixed(2));
            $('.balance').text('Balance payable to the customer: ' + totalBalance.toFixed(2));
            $('#table-container').html(tableHtml);
        }

        $('#sendMail').click(function() {
            var customerEmail = "{{ $customerEmail }}";
            var tableHtml = $('#table-container').html();
            var totalPrice = $('#totalPrice').html();
            $.ajax({
                url: '/sendemail',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    customerEmail: customerEmail,
                    tableHtml: tableHtml,
                    totalPriceWithoutTax: totalPriceWithoutTax,
                    totalTaxPayable: totalTaxPayable,
                    totalNetPrice: totalNetPrice,
                    totalRoundedPrice: totalRoundedPrice,
                    totalBalance: totalBalance
                },
                success: function(response) {
                    console.log('Email sent successfully');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    console.log('Failed to send email');
                }
            });
        });
        // setTimeout(sendEmail, 5000);

        const inputs = document.querySelectorAll('.denominations input[type="number"]');
        const totalDisplay = document.getElementById('total');
        inputs.forEach(input => {
            input.addEventListener('input', calculateTotal);
        });

        function calculateTotal() {
            let total = 0;
            inputs.forEach(input => {
                const value = parseFloat(input.value);
                const denomination = parseFloat(input.dataset
                    .value);
                if (!isNaN(value)) {
                    total += value * denomination;
                }
            });

            totalBalance = total - totalRoundedPrice;
            totalDisplay.textContent = total.toFixed(2);
            $('.balance').text('Balance payable to the customer: ' + totalBalance.toFixed(2));
        }

        const balanceInputs = document.querySelectorAll('.balanceDenominations input[type="number"]');
        const balanceTotalDisplay = document.getElementById('balanceTotal');
        balanceInputs.forEach(input => {
            input.addEventListener('input', calculateBalanceTotal);
        });

        function calculateBalanceTotal() {
            let total = 0;
            balanceInputs.forEach(input => {
                const value = parseFloat(input.value);
                const balanceDenominations = parseFloat(input.dataset
                    .value);
                if (!isNaN(value)) {
                    total += value * balanceDenominations;
                }
            });
            balanceTotalDisplay.textContent = total.toFixed(2);

        }
    </script>

</body>

</html>
