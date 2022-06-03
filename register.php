<?php
// TODO: server side validation and error handling
session_start();
require_once "database.php";

function emptyToNull(string $str) {
    return empty($str) ? null : $str;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    // https://stackoverflow.com/questions/33993461/php-remove-all-non-numeric-characters-from-a-string
    $phone = emptyToNull(preg_replace("/[^0-9]/", "", $_POST["phone"])); // only keep numbers in the string
    $first_name = emptyToNull(trim($_POST["first_name"]));
    $last_name = emptyToNull(trim($_POST["last_name"]));
    $address = emptyToNull(trim($_POST["address"]));

    $sql = "INSERT INTO users (email, password, phone_number, first_name, last_name, address, is_admin) VALUES (?, ?, ?, ?, ?, ?, false)";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssssss", $email, password_hash($password, PASSWORD_BCRYPT), $phone, $first_name, $last_name, $address);

        if($stmt->execute()){
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $mysqli->insert_id; // should be the id from auto increment
            header("location: index.php"); // Redirect to login page
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        $stmt->close();
    }

    $mysqli->close();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en-AU">
    <head>
        <title>Register | Road Casualties</title>
        <?php require_once "components/head.html"; ?>
    </head>

    <body>
        <?php require_once "components/header.php"; ?>

        <div id="page-container">
            <div class="max-width">
                <div id="content-container">
                    <div id="breadcrumbs">
                        <h2>You are here:</h2>
                        <ol>
                            <li><a href=".">Home</a></li>
                            <li><a href="register.php">Register</a></li>
                        </ol>
                    </div>
                    <div id="content">
                        <div class="article">
                            <div class="box-sizing">
                                <h1>Register</h1>

                                <p>Create an account to receive alerts.</p>
                                <p>Already have an account? Login <a href="login.php">here</a></p>

                                <form class="form" method="post" 
                                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                >
                                    <?php require_once "components/credentials.html"; ?>

                                    <div>
                                        <label for="phone">Mobile Number</label>
                                        <!-- phone number can have spaces or - between the nums -->
                                        <input type="tel" name="phone" id="phone" 
                                            placeholder="0414 123 456"
                                            pattern="[0-9]{4}[- ]*[0-9]{3}[- ]*[0-9]{3}" 
                                        />
                                    </div>

                                    <div>
                                        <label for="first_name">First Name</label>
                                        <input type="text" name="first_name" id="first_name">
                                    </div>

                                    <div>
                                        <label for="last_name">Last Name</label>
                                        <input type="text" name="last_name" id="last_name">
                                    </div>

                                    <div>
                                        <label for="address">Address</label>
                                        <input type="text" name="address" id="address">
                                    </div>
                                    
                                    <button>Register</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <?php require_once "components/feedback.html"; ?>
                </div>
            </div>
        </div>

        <?php require_once "components/footer.html"; ?>
    </body>
</html>
