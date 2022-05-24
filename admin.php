<?php
session_start();
require_once "components/is_admin.php";
if (!$is_admin) header("location: index.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $path = $_FILES["csv"]["tmp_name"];
    $file = fopen($path, "r");
    fgets($file); // ignore the headers for now

    while ($line = fgets($file)) {
        $sql = "INSERT INTO road_casualties (year, region, severity, age_group, gender, road_user_type, amount) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        // TODO: make different headers work
        $stmt->bind_param("isssssi", ...explode(",", $line));
        if (!$stmt->execute()) {
            echo "<h3>failed to add row</h3>";
        }
        $stmt->close();
    }
    fclose($file);
    $mysqli->close();
    ?> <div>uploaded successfully</div> <?php
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
                                <form method="post" enctype="multipart/form-data" class="form"
                                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                >
                                    <div><input type="file" name="csv" id="csv" required /></div>
                                    <div><button>Upload CSV</button></div>
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
