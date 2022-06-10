<?php
session_start();
require_once "components/is_admin.php";
if (!$is_admin) header("location: index.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $path = $_FILES["csv"]["tmp_name"];
    $file = fopen($path, "r");
    $successes = 0;

    fgets($file); // ignore the headers
    set_time_limit(400); // stop timing out

    if (isset($_POST["wipe"])) $mysqli->query("DELETE FROM road_casualties");
    
    while ($line = fgets($file)) {
        $sql = "REPLACE INTO road_casualties (year, region, severity, age_group, gender, road_user_type, amount) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        // TODO: make different headers work
        $stmt->bind_param("isssssi", ...explode(",", $line));
        if ($stmt->execute()) {
            $successes++;
        } else {
            echo "<h3>failed to add row: $line</h3>";
        }
        $stmt->close();
    }
    fclose($file);
    $mysqli->close();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en-AU">
    <head>
        <title>Admin | Road Casualties</title>
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
                            <li><a href="admin.php">Admin</a></li>
                        </ol>
                    </div>
                    <div id="content">
                        <div class="article">
                            <div class="box-sizing">
                                <h1>Data Administration</h1>
                                <p>
                                    Here you can upload a CSV of road casualties. The first row must be the headers
                                    and the other rows must be in this order: year, region, severity, age group, gender, 
                                    road user type, amount. Check "Replace Table" to replace the whole table with your
                                    CSV instead of updating the table with the new data.
                                </p>
                                <?php 
                                    if (isset($successes)) {
                                        echo "<h2>Updated $successes rows succesfully</h2>";
                                    }
                                ?>
                                <form method="post" enctype="multipart/form-data" class="form"
                                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                >
                                    <div><input type="file" name="csv" id="csv" required accept=".csv"/></div>
                                    <div><div>
                                        <input type="checkbox" name="wipe" id="wipe" />
                                        <label for="wipe">Replace Table</label>
                                    </div></div>
                                    <div>
                                        <button>Upload CSV</button>
                                        <div>Note: this may take a few minutes to upload.</div>
                                    </div>
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
