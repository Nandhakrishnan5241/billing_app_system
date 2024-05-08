<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manage Products</title>
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

    button a {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        color: #fff;
        background-color: #4CAF50;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button a:hover {
        background-color: #45a049;
    }

    .edit-link {
        display: inline-block;
        padding: 5px 10px;
        background-color: #4CAF50;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .delete-link {
        display: inline-block;
        padding: 5px 10px;
        background-color: #e91010;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }
</style>

<body>
    <button><a href="/add">Add New Product</a></button>
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Product ID</th>
                <th>Available Stocks</th>
                <th>Price</th>
                <th>Tax Percentage</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $key => $value)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $value['name'] }}</td>
                    <td>{{ $value['product_id'] }}</td>
                    <td>{{ $value['available_stocks'] }}</td>
                    <td>{{ $value['price'] }}</td>
                    <td>{{ $value['tax_percentage'] }}</td>
                    <td><a href="edit/{{ $value->id }}" class="edit-link">Edit</a></td>
                    <td><a href="delete/{{ $value->id }}" class="delete-link">Delete</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
