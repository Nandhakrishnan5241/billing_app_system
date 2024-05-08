<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Billing Calculation</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        nav {
            background-color: #333;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            display: inline;
        }

        nav ul li a {
            display: inline-block;
            color: white;
            text-decoration: none;
            padding: 14px 16px;
        }

        nav ul li a:hover {
            background-color: #555;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        form {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="number"] {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        #productsContainer {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
        }

        .product-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .product-group input {
            flex: 1;
            margin-right: 10px;
        }

        .product-group button {
            flex-shrink: 0;
            margin-left: 10px;
        }

        .separator {
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        .btn-danger,
        .removeProduct {
            background-color: #fc3333;
        }

        .btn-danger:hover,
        .removeProduct:hover {
            background-color: #fd0505;
        }

        button:hover {
            background-color: #0056b3;
        }

        #addProduct {
            margin-top: 10px;
        }

        #addNewProduct {
            background-color: #0202e1;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 2px;
            cursor: pointer;
            border-radius: 8px;
            float: right;
            margin: 20px;
        }

        #addNewProduct a {
            color: white;
            text-decoration: none;
        }

        #addNewProduct:hover {
            background-color: #4c4cdd;
        }
    </style>
</head>

<body>

    <button id="addNewProduct"><a href="{{ route('products') }}">Manage Products</a></button>

    <div class="container">
        <h1>Billing Calculation</h1>
        <form id="billingForm" action="/save" method="POST">
            @csrf
            <div class="form-group">
                <label for="customerEmail">Customer Email:</label>
                <input type="email" id="customerEmail" name="customerEmail" required>
            </div>
            <div id="productsContainer">
                <div class="product-group">
                    <input type="text" class="productID" name="productID[]" placeholder="Product ID" required>
                    <input type="number" class="quantity" name="quantity[]" placeholder="Quantity" required>
                    <button type="button" class="removeProduct btn-danger">Remove</button>
                </div>
            </div>
            <button type="button" id="addProduct">Add New</button>
            <div class="separator"></div>
            <button type="submit">Generate Bill</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#addProduct').click(function() {
                const productGroup = $('<div>').addClass('product-group');
                productGroup.html(`
                    <input type="text" class="productID" name="productID[]" placeholder="Product ID" required>
                    <input type="number" class="quantity" name="quantity[]" placeholder="Quantity" required>
                    <button type="button" class="removeProduct">Remove</button>
                `);
                $('#productsContainer').append(productGroup);
            });

            $('#productsContainer').on('click', '.removeProduct', function() {
                $(this).closest('.product-group').remove();
            });
        });
    </script>
</body>

</html>
