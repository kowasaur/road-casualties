<?php
session_start();
require_once "database.php";
require_once "utilities.php";
if (!isset($_SESSION["id"])) header("location: login.php");

function htmlSelectDiv(string $label, array $options, string $selected, string $props = null) { ?>
    <div>
        <label for="<?php echo $label; ?>"><?php echo capitalise($label); ?></label>
        <select name="<?php echo $label; ?>" <?php echo $props;?>>
            <?php foreach ($options as $opt) htmlOption($opt, $selected); ?>
        </select>
    </div>
<?php }

function htmlAlertForm(array $alert) { 
    global $mysqli; 
    $html_id = uniqid("alert"); ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
        class="form alert" id="<?php echo $html_id; ?>"
    >
        <?php
            // TODO: change to local government areas instead
            $regions = uniqueColumnValues($mysqli, "region");
            array_unshift($regions, "None");
            htmlSelectDiv("location", $regions, $alert["location"], "onchange=\"alertLocationChange('$html_id')\"");
            htmlSelectDiv("severity", uniqueColumnValues($mysqli, "severity"), $alert["severity"]);
            htmlSelectDiv("send_via", ["Email", "SMS"], $alert["via_email"] == 1 ? "Email" : "SMS");
        ?>
        <input type="hidden" name="alert_id" value="<?php echo $alert["id"]; ?>">
        <button id="<?php echo $html_id; ?>-button">Update Alert</button>
    </form>
    <script>
        {
            const id = "<?php echo $html_id;?>";
            alertLocationChange(id);
            document.getElementById(id + "-button").addEventListener("click", e => {
                e.preventDefault();
                if (confirm("Are you sure you want to update this alert?")) document.getElementById(id).submit();
            });
        }
    </script>
<?php }

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["location"] == "None") {
        $mysqli->query("DELETE FROM alerts WHERE id = " . $_POST["alert_id"]);
    } else {
        if ($_POST["alert_id"] == "None") {
            $sql = "INSERT INTO alerts (user_id, location, severity, via_email) VALUES ({$_SESSION["id"]}, ?, ?, ?)";
        } else {
            $sql = "SELECT id FROM alerts WHERE user_id = {$_SESSION["id"]}";
            $alert_ids = array_column($mysqli->query($sql)->fetch_all(), 0);
            if (!in_array($_POST["alert_id"], $alert_ids)) die("You do not have permission to alter this alert");
            $sql = "UPDATE alerts SET location=?, severity=?, via_email=? WHERE id=" . $_POST["alert_id"];
        }
    
        if ($stmt = $mysqli->prepare($sql)) {
            $via_email = $_POST["send_via"] == "Email";
    
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssi", $_POST["location"], $_POST["severity"], $via_email);
            if(!($stmt->execute())) echo "Oops! Something went wrong. Please try again later.";
            $stmt->close();
        }
    }
}

$alerts = $mysqli->query("SELECT * FROM alerts WHERE user_id = {$_SESSION["id"]}");

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
                                    $alerts_count = 0;
                                    while ($alert = $alerts->fetch_assoc()) {
                                        htmlAlertForm($alert);
                                        $alerts_count++;
                                    }
                                    for ($i = $alerts_count; $i < 3; $i++) { 
                                        htmlAlertForm([
                                            "location"=>"None", "severity"=>"Fatality", 
                                            "via_email"=>1, "id"=>"None"
                                        ]);
                                    }
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
