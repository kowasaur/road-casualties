<?php
session_start();
require_once "database.php";

// TODO: ensure the alert id passed in is allowed to be modified by the user

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo $_POST["location"];
    echo $_POST["severity"];
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en-AU">
    <head>
        <title>Alert Configuration | Road Casualties</title>
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
                            <li><a href="alerts.php">Alert Configuration</a></li>
                        </ol>
                    </div>
                    <div id="content">
                        <div class="article">
                            <div class="box-sizing">
                                <h1>Alert Configuration</h1>

                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form">
                                    <div>
                                        <label for="location">Location</label>
                                        <select name="location">
                                            <option value="bruh">home</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="severity">Severity</label>
                                        <select name="severity">
                                            <option value=":)">will literally kill you</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="via_email">Send Via</label>
                                        <select name="via_email">
                                            <option value="true">Email</option>
                                            <option value="false">SMS</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="alert_id" value="id from database">
                                    <button>Update Alert</button>
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
