<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Product</title>
</head>
<style>
    /* styles.css */

/* Style the form container */
form {
    width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

/* Style form labels */
form label {
    display: block;
    margin-bottom: 5px;
}


form input[type=text],
form input[type=number] {
    width: calc(100% - 10px);
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}


form input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin-top: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
}

form input[type=submit]:hover {
    background-color: #45a049;
}

form input[type=text]:focus,
form input[type=number]:focus {
    background-color: #ddd;
}
h2{
    text-align: center;
    margin: 10px;
    border: solid dashed
}

</style>
<body>
    <h2>Edit Product</h2>
    <form action="{{url('update/'.$data->id)}}" method="POST">
        @csrf
        <label for="">Product Name :</label>
        <input type="text" placeholder="Enter product name" name="name" value="{{$data->name}}"><br>

        <label for="">Product ID :</label>
        <input type="text" placeholder="Enter product ID" name="product_id" value="{{$data->product_id}}"><br>

        <label for="">Product Available Stocks :</label>
        <input type="number" placeholder="Enter product available_stocks" name="available_stocks" value="{{$data->available_stocks}}"><br>

        <label for="">Product price :</label>
        <input type="number" placeholder="Enter product name" name="price" value="{{$data->price}}"><br>

        <label for="">Product Tax Percentage :</label>
        <input type="number" placeholder="Enter product Tax Percentage" name="tax_percentage" value="{{$data->tax_percentage}}"><br>

        <input type="submit" value="Update Product">

    </form>
</body>
</html>