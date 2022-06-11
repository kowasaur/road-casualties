<?php
// TODO: server side validation and error handling
session_start();
require_once "database.php";
require_once "utilities.php";

function htmlTextInput(string $label, string $placeholder, ?string $value) { ?>
    <div>
        <label for="<?php echo $label; ?>"><?php echo capitalise($label); ?></label>
        <input type="text" name="<?php echo $label; ?>" id="<?php echo $label; ?>"
            placeholder="<?php echo $placeholder; ?>" 
            value="<?php if (isset($value)) echo $value; ?>"
        >
    </div>
<?php }

function emptyToNull(string $str) {
    return empty($str) ? null : $str;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $phone = emptyToNull(preg_replace("/[^0-9]/", "", $_POST["phone"])); // only keep numbers in the string
    $first_name = emptyToNull(trim($_POST["first_name"]));
    $last_name = emptyToNull(trim($_POST["last_name"]));
    $address = emptyToNull(trim($_POST["address"]));

    $sql = "INSERT INTO users (email, password, phone_number, first_name, last_name, address, is_admin) VALUES (?, ?, ?, ?, ?, ?, false)";

    if ($stmt = $mysqli->prepare($sql)) {
        $pass_hash = password_hash($password, PASSWORD_BCRYPT);
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssssss", $email, $pass_hash, $phone, $first_name, $last_name, $address);

        if($stmt->execute()){
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $mysqli->insert_id; // should be the id from auto increment
            header("location: alerts.php"); // Redirect to alerts page
        } else {
            $error = "An account with this email already exists.";
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

                                <p>
                                    Create an account by entering your details below and 
                                    clicking register to receive alerts about new crashes.
                                </p>
                                <p>Already have an account? Login <a href="login.php">here</a>.</p>

                                <form class="form" method="post" 
                                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                >
                                    <?php 
                                        if (isset($error)) echo "<h3 class=\"error\">$error</h3>";
                                        require_once "components/credentials.php"; 
                                    ?>

                                    <div>
                                        <label for="phone">Mobile Number</label>
                                        <!-- phone number can have spaces or hyphens between the nums -->
                                        <input type="tel" name="phone" id="phone" 
                                            placeholder="0414 123 456"
                                            pattern="[0-9]{4}[- ]*[0-9]{3}[- ]*[0-9]{3}" 
                                            value="<?php if (isset($phone)) echo $phone; ?>" 
                                        />
                                    </div>

                                    <?php
                                        htmlTextInput("first_name", "John", $first_name);
                                        htmlTextInput("last_name", "Smith", $last_name);
                                        htmlTextInput("address", "21 Place Street, Cool Suburb", $address);
                                    ?>
                                    
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
