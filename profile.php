<?php
include 'connection.php';

// Check if the user is logged in
if (!isset($_COOKIE['username'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Fetch customer information from the database using the username
$username = $_COOKIE['username'];
$query = "SELECT * FROM customers WHERE username = '$username'";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) == 1) {
    $customerData = mysqli_fetch_assoc($result);
} else {
    // Handle the case where customer data is not found (this should not happen if the login system is working correctly)
    echo "Error: Customer data not found.";
    exit();
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'])) {
    $newPassword = mysqli_real_escape_string($connection, $_POST['new_password']);
    // Additional security measures such as hashing should be implemented in a real-world scenario
    $updateQuery = "UPDATE customers SET pwd = '$newPassword' WHERE username = '$username'";
    if (mysqli_query($connection, $updateQuery)) {
        // Password updated successfully, set a JavaScript variable to indicate success
        echo '<script>var passwordUpdated = true;</script>';
    }
}

// Fetch menu items from the database
$menuQuery = "SELECT * FROM menu";
$menuResult = mysqli_query($connection, $menuQuery);

// Check if there are menu items
if (mysqli_num_rows($menuResult) > 0) {
    // Fetch the menu data into an associative array
    $menuData = mysqli_fetch_all($menuResult, MYSQLI_ASSOC);
} else {
    // Handle the case where no menu items are found
    echo "Error: No menu items found.";
    exit();
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Blend</title>
    <link rel="stylesheet" href="css/profileStyle.css" />
    <!-- Ajax link -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        header {
            background-color: #fac031;
            padding: 15px 0;
        }

        header img {
            display: block;
            margin: 0 auto;
        }

        section nav {
            display: flex;
            justify-content: space-around;
            align-items: center;
            position: fixed;
            right: 0;
            left: 0;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        section nav .logo img {
            width: 100px;
            cursor: pointer;
            margin: 7px 0;
        }

        section nav ul {
            list-style: none;
        }

        section nav ul li {
            display: inline-block;
            margin: 0 15px;
        }

        section nav ul li a {
            text-decoration: none;
            color: #000;
            font-weight: 500;
            font-size: 17px;
            transition: 0.1s;
        }

        section nav ul li a::after {
            content: '';
            width: 0;
            height: 1px;
            background: #fac031;
            display: block;
            transition: 0.2s linear;
        }

        section nav ul li a:hover::after {
            width: 100%;
        }

        section nav ul li a:hover {
            color: #fac031;
        }

        section nav .icon i {
            font-size: 18px;
            color: #000;
            margin: 0 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        section nav .icon i:hover {
            color: #fac031;
        }


        .profile-btn {
            background-color: #fac031;
            color: #333;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .profile-btn:hover {
            background-color: #333;
            color: #fff;
            transform: scale(1.05);
        }

        .content {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 200px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #fac031;
            color: #fff;
        }

        tbody tr:hover {
            background-color: #fac031;
        }

        select,
        button {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }

        button {
            background-color: #fac031;
            color: #333;
            cursor: pointer;
        }

        #Order {
            background-color: #f8f8f8;
            text-align: center;
            position: fixed;
            width: 100%;
        }

        .order-container {
            max-width: 500px;
            margin: auto;
        }

        .order-content {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .order-image {
            width: 140px;
            height: 120px;
            margin-top: 49px;
        }

        .order-text {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            font-family: mv boli;
        }

        .end {
            text-align: center;
            padding: 15px;
        }

        .end span {
            color: #fac031;
            margin-left: 10px;
        }

        .end {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        .end span {
            color: #fac031;
            margin-left: 10px;
        }

        ::-webkit-scrollbar {
            width: 13px;
        }

        ::-webkit-scrollbar-track {
            border-radius: 15px;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
        }

        ::-webkit-scrollbar-thumb {
            background: #fac031;
            border-radius: 15px;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            padding: 20px;
            max-width: 300px;
            width: 100%;
            text-align: center;
        }

        .popup ul {
            list-style: none;
            padding: 0;
        }

        .popup li {
            margin: 10px 0;
            font-size: 16px;
            font-family: mv boli;
        }

        .popup i {
            margin-right: 5px;
            color: #fac031;
        }

        .change-password {
            color: #fac031;
            text-decoration: underline;
            cursor: pointer;
            display: block;
            margin-top: 10px;
        }

        .password-form {
            display: none;
            margin-top: 10px;
        }

        .btn {
            background-color: #fac031;
            color: #333;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn:hover {
            color: #fff;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 18px;
            cursor: pointer;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .prof-image {
            width: 140px;
            height: 120px;


        }
    </style>

    </style>
</head>

<body>
    <section>
        <nav>
            <div class="logo">
                <img src="image/logo.png" />
            </div>

            <ul>
                <li><a href="index.html#Home">Home</a></li>
                <li><a href="index.html#About">About</a></li>
                <li><a href="index.html#Menu">Menu</a></li>
                <li><a href="index.html#Review">Review</a></li>
                <li><a href="index.html#team">Team</a></li>
                <li><button class="profile-btn" onclick="showPopup()"><?php echo strtoupper(substr($customerData['username'], 0, 1)); ?></button></li>
            </ul>
        </nav>
    </section>
    <div class="content">
        <div id="popup" class="popup">
            <span class="close-btn" onclick="hidePopup()">&times;</span>
            <ul>
                <img src="image/popup.png" alt="Order Image" class="prof-image">

                <li><i class="fas fa-user-circle"></i> <strong></strong> <?php echo $customerData['username']; ?></li>
                <li><i class="fas fa-phone"></i> <strong></strong> <?php echo $customerData['phone_number']; ?></li>
                <li><i class="fas fa-map-marker-alt"></i> <strong></strong> <?php echo $customerData['address']; ?></li>
            </ul>
            <!-- "Change Password" link -->
            <a href="#" class="change-password" onclick="togglePasswordForm()"><i class="fas fa-lock"></i> Change your password?</a>
            <form method="post" action="" class="password-form">
                <!-- Password input field with the class "change-password" -->
                <label for="new_password"><i class="fas fa-key"></i> New Password:</label>
                <input type="password" id="new_password" class="change-password" name="new_password" required>
                <button type="submit" class="btn">Change Password</button>
            </form>
        </div>
        <div id="overlay" class="overlay" onclick="hidePopup()"></div>
    </div>
    <section id="Order">
        <div class="order-container">
            <div class="order-content">
                <img src="image/profile.png" alt="Order Image" class="order-image">
                <p class="order-text">Welcome Back, Let's Place an Order!</p>
            </div>
        </div>
    </section> <!-- Display the menu in a table -->
    <section id="Menu">
        <form method="post" action="">
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through each menu item and display it in a table row with dropdowns
                    foreach ($menuData as $menuItem) {
                        echo "<tr>";
                        echo "<td>{$menuItem['item_name']}</td>";
                        echo "<td>{$menuItem['description']}</td>";
                        echo "<td>{$menuItem['price']}$</td>";
                        echo "<td>";
                        echo "<button type='button' onclick='showOrderPopup({$menuItem['ID']}, \"{$menuItem['item_name']}\", {$menuItem['price']})'>Order now</button>";


                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </section>

    <div id="order-popup" class="popup">
        <span class="close-btn" onclick="hideOrderPopup()">&times;</span>
        <div id="order-text" class="order-text"></div>
        <form method="post" id="order-form" action="save_order.php">
            <!-- Hidden input field to store the selected menu item ID -->
            <input type="hidden" id="menu_item_id" name="menu_item_id" value="menu_item_id">
            <!-- Size Dropdown -->
            <div class="form-group">
                <label for="size">Choose Size:</label>
                <select name="size[]" id="size" class="form-control">
                    <?php
                    $sizeQuery = "SELECT * FROM lookupitems WHERE lookup_id = 0";
                    $sizeResult = mysqli_query($connection, $sizeQuery);
                    while ($size = mysqli_fetch_assoc($sizeResult)) {
                        echo "<option value='{$size['name']}'>{$size['name']}- {$size['price']}\$</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Topping Dropdown -->
            <div class="form-group">
                <label for="topping">Choose Topping:</label>
                <select name="topping[]" id="topping" class="form-control">
                    <?php
                    $toppingQuery = "SELECT * FROM lookupitems WHERE lookup_id = 1";
                    $toppingResult = mysqli_query($connection, $toppingQuery);
                    while ($topping = mysqli_fetch_assoc($toppingResult)) {
                        echo "<option value='{$topping['name']}'>{$topping['name']} - {$topping['price']}\$</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Additional form elements for payment, confirmation, etc. -->
            <div id="displayed-price">Overall Price: $0.00</div>

            <!-- Confirm Order Button -->
            <button type="submit" class="btn" onclick="confirmOrder()">Confirm</button>
        </form>
    </div>
    </section>

    <script>
        function showPopup() {
            var popup = document.getElementById("popup");
            var overlay = document.getElementById("overlay");
            popup.style.display = "block";
            overlay.style.display = "block";
        }

        function hidePopup() {
            var popup = document.getElementById("popup");
            var overlay = document.getElementById("overlay");
            popup.style.display = "none";
            overlay.style.display = "none";
        }

        function togglePasswordForm() {
            var passwordForm = document.querySelector(".password-form");
            // Toggle the visibility of the password form
            passwordForm.style.display = (passwordForm.style.display === "block") ? "none" : "block";
        }

        // JavaScript code to display an alert when the password is updated successfully
        if (typeof passwordUpdated !== 'undefined' && passwordUpdated) {
            alert('Password updated successfully.');
        }

        // Highlight table rows on hover
        var tableRows = document.querySelectorAll("#Menu tbody tr");

        tableRows.forEach(function(row) {
            row.addEventListener("mouseover", function() {
                this.style.backgroundColor = "#e0e0e0";
            });

            row.addEventListener("mouseout", function() {
                this.style.backgroundColor = "";
            });
        });

        function showOrderPopup(itemID, itemName, itemPrice) {
            var orderPopup = document.getElementById("order-popup");
            var overlay = document.getElementById("overlay");
            var orderText = document.getElementById("order-text");

            // Set order details in the popup
            orderText.innerHTML = "Order Details: " + itemName + " - $" + itemPrice;
            orderPopup.style.display = "block";
            overlay.style.display = "block";

            // Add the itemID to a hidden input field in the form
            document.getElementById("menu_item_id").value = itemID;

            // Trigger the AJAX request to fetch the overall price
            updateOverallPrice();
        }

        function hideOrderPopup() {
            var orderPopup = document.getElementById("order-popup");
            var overlay = document.getElementById("overlay");

            orderPopup.style.display = "none";
            overlay.style.display = "none";
        }

        // Add this function to handle the change in size or topping selection
        function handleSelectionChange() {
            updateOverallPrice();
        }

        // Attach the handleSelectionChange function to the change event of size and topping dropdowns
        $('#size, #topping').change(handleSelectionChange);

        // Modify the existing function to update the overall price dynamically
        function updateOverallPrice() {
            var selectedSize = $('#size').val();
            var selectedTopping = $('#topping').val();
            var selectedItemId = $('#menu_item_id').val();
            $.ajax({
                type: 'GET',
                url: 'get_overall_price.php',
                data: {
                    size: selectedSize,
                    topping: selectedTopping,
                    item_id: selectedItemId
                },
                success: function(response) {
                    // Update the displayed price dynamically
                    $('#displayed-price').text('Overall Price: $' + response);
                },
                error: function() {
                    console.error('Error fetching overall price.');
                }
            });
        }
    </script>
</body>

</html>
