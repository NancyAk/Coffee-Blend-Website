<?php
include 'connection.php';

// Fetch customer information from the database using the username
if (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
    $query = "SELECT * FROM customers WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 1) {
        $customerData = mysqli_fetch_assoc($result);
    } else {
        // Handle the case where customer data is not found
        echo "Error: Customer data not found.";
        exit();
    }
} else {
    // Handle the case where the user is not logged in
    echo "Error: User not logged in.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $customerID = $customerData['ID'];
    $menuID = isset($_POST['menu_item_id'][0]) ? mysqli_real_escape_string($connection, $_POST['menu_item_id']) : null;
    $toppings = isset($_POST['topping']) ? mysqli_real_escape_string($connection, implode(', ', $_POST['topping'])) : '';
    $size = isset($_POST['size'][0]) ? mysqli_real_escape_string($connection, $_POST['size'][0]) : '';

    // Insert the order into the 'order' table
    $insertQuery = "INSERT INTO `orders` (customer_id, menu_id, toppings, size) VALUES ('$customerID', '$menuID', '$toppings', '$size')";

    if (mysqli_query($connection, $insertQuery)) {
        // Order saved successfully
        header("Location:thankyou.php");
    }
}
