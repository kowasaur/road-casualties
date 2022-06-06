<?php
session_start();
require_once "database.php";
require_once "utilities.php";

function htmlSelectDiv(string $label, array $options, string $selected) { ?>
    <div>
        <label for="<?php echo $label; ?>"><?php echo capitalise($label); ?></label>
        <select name="<?php echo $label; ?>">
            <?php foreach ($options as $opt) htmlOption($opt, $selected); ?>
        </select>
    </div>
<?php }

function htmlAlertForm() { 
    global $mysqli; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form alert">
        <?php
            // TODO: change to local government areas instead
            $regions = uniqueColumnValues($mysqli, "region");
            array_unshift($regions, "None");
            htmlSelectDiv("location", $regions, "Brisbane");
            htmlSelectDiv("severity", uniqueColumnValues($mysqli, "severity"), "Fatality");
            htmlSelectDiv("send_via", ["Email", "SMS"], "Email");
        ?>
        <input type="hidden" name="alert_id" value="id from database">
        <button>Update Alert</button>
    </form>
<?php }

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

                                <?php
                                    htmlAlertForm();
                                    htmlAlertForm();
                                    htmlAlertForm();
                                ?>
                                
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
