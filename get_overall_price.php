<?php
include 'connection.php';

if (isset($_GET['size']) && isset($_GET['topping']) && isset($_GET['item_id'])) {
    $size = mysqli_real_escape_string($connection, $_GET['size']);
    $topping = mysqli_real_escape_string($connection, $_GET['topping']);
    $itemID = mysqli_real_escape_string($connection, $_GET['item_id']);
    // Query the database to get the price of the item
    $itemPriceQuery = "SELECT price FROM menu WHERE ID = $itemID";
    $itemPriceResult = mysqli_query($connection, $itemPriceQuery);

    if ($itemPriceResult && mysqli_num_rows($itemPriceResult) == 1) {
        $itemPriceData = mysqli_fetch_assoc($itemPriceResult);

        // Query the database to get the prices of the selected size and topping
        $sizeQuery = "SELECT price FROM lookupitems WHERE name = '$size' AND lookup_id = 0";
        $toppingQuery = "SELECT price FROM lookupitems WHERE name = '$topping' AND lookup_id = 1";

        $sizeResult = mysqli_query($connection, $sizeQuery);
        $toppingResult = mysqli_query($connection, $toppingQuery);

        if ($sizeResult && $toppingResult && mysqli_num_rows($sizeResult) == 1 && mysqli_num_rows($toppingResult) == 1) {
            $sizeData = mysqli_fetch_assoc($sizeResult);
            $toppingData = mysqli_fetch_assoc($toppingResult);

            // Calculate the overall price
            $overallPrice = $itemPriceData['price'] + $sizeData['price'] + $toppingData['price'];

            // Return the overall price
            echo number_format($overallPrice, 2);
        } else {
            echo 'Error calculating overall price.';
        }
    } else {
        echo 'Error fetching item price.';
    }
} else {
    echo 'Invalid parameters.';
}
