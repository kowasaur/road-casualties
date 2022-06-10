<?php
// TODO: server side validation and error handling
session_start();
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT id, email, password FROM users WHERE email = ?";

    if ($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("s", $email);

        if($stmt->execute()){
            $stmt->store_result();

            if($stmt->num_rows == 1){
                $stmt->bind_result($id, $email, $hashed_password);

                if($stmt->fetch()) {
                    if(password_verify($password, $hashed_password)){                        
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;    
                        header("location: index.php");
                    } else {
                        $error = "Password Incorrect.";
                    }
                }
            } else {
                $error = "A user with the email $email does not exist.";
            }
            $stmt->close();
        }
    }
    $mysqli->close();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en-AU">
    <head>
        <title>Login | Road Casualties</title>
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
                            <li><a href="login.php">Login</a></li>
                        </ol>
                    </div>
                    <div id="content">
                        <div class="article">
                            <div class="box-sizing">
                                <h1>Login</h1>

                                <p>Enter your details to login to your account.</p>
                                <p>Don't have an account? Register <a href="register.php">here.</a></p>

                                <form class="form" method="post" 
                                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                >
                                    <?php
                                        if (isset($error)) echo "<h3 class=\"error\">$error</h3>";
                                        require_once "components/credentials.php"; 
                                    ?>
                                    <button>Login</button>
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
