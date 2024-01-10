<?php
include 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if it's a login form submission
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];


        // SQL query to check if the username and password match
        $query = "SELECT * FROM customers WHERE username = '$username' AND pwd = '$password'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) == 1) {
            // Valid login
            setcookie("username", $username, time() + 3600, "/");
            // Redirect to the profile page
            header("Location: profile.php");
            exit();
        } else {
            // Invalid login
            echo '<script>var loginFail = true;</script>';
        }
        // Get the maximum ID from the 'customers' table
        $maxIDQuery = "SELECT MAX(ID) as maxID FROM customers";
        $maxIDResult = mysqli_query($connection, $maxIDQuery);
        $maxIDRow = mysqli_fetch_assoc($maxIDResult);
    } elseif (isset($_POST['new-username']) && isset($_POST['newpwd']) && isset($_POST['confirmpwd'])) {


        $newUsername = $_POST['new-username'];
        $newPassword = $_POST['newpwd'];
        $confirmPassword = $_POST['confirmpwd'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        // Check if the passwords match
        if ($newPassword === $confirmPassword) {
            // Passwords match, proceed to insert into the database
            $insertQuery = "INSERT INTO customers (username, pwd,phone_number,address) VALUES ('$newUsername', '$newPassword','$phone','$address')";
            $insertResult = mysqli_query($connection, $insertQuery);

            // Signup successful
            if ($insertResult) {
                echo '<script>var signupSuccess = true;</script>';
            } else {
                // Signup failed
                echo '<script>var signupFail = true;</script>';
            }
        } else {
            // Passwords do not match
            echo '<script>var signupFail = true;</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" />
    <title>Login</title>
</head>

<body>
    <section id="Home">
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
            </ul>
        </nav>
        <div class="popup" id="loginPopup">
            <div class="wrapper">
                <div class="title-text">
                    <div class="title login">Login Form</div>
                    <div class="title signup">Signup Form</div>
                </div>
                <div class="form-container">
                    <div class="slide-controls">
                        <input type="radio" name="slide" id="login" checked />
                        <input type="radio" name="slide" id="signup" />
                        <label for="login" class="slide login">Login</label>
                        <label for="signup" class="slide signup">Signup</label>
                        <div class="slider-tab"></div>
                    </div>
                    <div class="form-inner">
                        <form method="post" class="login">
                            <div class="field">
                                <input type="text" name="username" placeholder="Username" required />
                            </div>
                            <div class="field">
                                <input type="password" name="password" placeholder="Password" required />
                            </div>
                            </br>
                            <div class="field btn">
                                <div class="btn-layer"></div>
                                <input type="submit" value="Login" />
                            </div>
                            <div class="signup-link">
                                Not a member? <a href="">Signup now</a>
                            </div>
                            <?php if (isset($loginerror)) : ?>
                                <div class="error-message">
                                    <?php echo $loginerror; ?>
                                </div>
                            <?php endif; ?>
                        </form>
                        <form action="" method="post" class="signup">
                            <div class="field">
                                <input type="text" name="new-username" placeholder="Username" required />
                            </div>
                            <div class="field">
                                <input type="password" name="newpwd" placeholder="Password" required />
                            </div>
                            <div class="field">
                                <input type="password" name="confirmpwd" placeholder="Confirm password" required />
                            </div>
                            <div class="field">
                                <input type="text" name="phone" placeholder="phone number" required />
                            </div>
                            <div class="field">
                                <input type="text" name="address" placeholder="Address" required />
                            </div>
                            <div class="field btn">
                                <div class="btn-layer"></div>
                                <input type="submit" value="Signup" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Display JavaScript alerts based on login and signup outcomes
            if (typeof loginFail !== 'undefined' && loginFail) {
                alert('Invalid username or password.');
            }

            if (typeof signupSuccess !== 'undefined' && signupSuccess) {
                alert('Registration successful. Redirecting to the profile page.');
                window.location.href = 'profile.php'; // Redirect to the profile page
            }

            if (typeof signupFail !== 'undefined' && signupFail) {
                alert('Password and Confirm password does not Match');
            }
            const loginText = document.querySelector(".title-text .login");
            const loginForm = document.querySelector("form.login");
            const loginBtn = document.querySelector("label.login");
            const signupBtn = document.querySelector("label.signup");
            const signupLink = document.querySelector("form .signup-link a");
            signupBtn.onclick = (() => {
                loginForm.style.marginLeft = "-50%";
                loginText.style.marginLeft = "-50%";
            });
            loginBtn.onclick = (() => {
                loginForm.style.marginLeft = "0%";
                loginText.style.marginLeft = "0%";
            });
            signupLink.onclick = (() => {
                signupBtn.click();
                return false;
            });
        </script>
    </section>
</body>

</html>
