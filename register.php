<?php
// TODO: server side validation and error handling
session_start();
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $phone = preg_replace("/[^0-9]/", "", $_POST["phone"]); // only keep numbers in the string
    // https://stackoverflow.com/questions/33993461/php-remove-all-non-numeric-characters-from-a-string

    if (empty($phone)) {
        $sql = "INSERT INTO users (email, password, is_admin) VALUES (?, ?, false)";
        $types = "ss";
        $params = [$email, password_hash($password, PASSWORD_BCRYPT)];
    } else {
        $sql = "INSERT INTO users (email, password, phone_number, is_admin) VALUES (?, ?, ?, false)";
        $types = "sss";
        $params = [$email, password_hash($password, PASSWORD_BCRYPT), $phone];
    }

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param($types, ...$params);

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
