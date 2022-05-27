<?php
session_start();
require_once "database.php";

$total = $mysqli->query("SELECT SUM(amount) FROM road_casualties")->fetch_assoc()["SUM(amount)"];

function graphData(string $group) {
    global $mysqli;
    $sql = "SELECT $group, SUM(amount) FROM road_casualties GROUP BY $group";
    return $mysqli->query($sql);
}

// Convert a PHP sql result to JavaScript array
function jsArray($rows, string $column) {
    $rows->data_seek(0); // reset the pointer for repeat use
    echo "[";
    // JavaScript's type coercion means it is ok for numbers to be strings
    while($value = $rows->fetch_array()[$column]) echo "'$value', ";
    echo "]";
}

// Echo the JavaScript for a chart
function jsChart(string $group, bool $is_line = false) {
    $rows = graphData($group);
    echo "createChart('$group-chart', ";
    jsArray($rows, "SUM(amount)");
    echo ", ";
    jsArray($rows, $group);
    echo ", '" . ucfirst($group) . "'";
    if ($is_line) echo ", 'line'";
    echo ");\n";
}

// Echo the html for a chart
function htmlChart(string $group) { ?> 
    <div class="section">
        <h3>Road Casualties by <?php echo ucfirst($group); ?></h3>
        <canvas id="<?php echo $group; ?>-chart"></canvas>
    </div> 
<?php }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en-AU">
    <head>
        <title>Road Casualties</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
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
                        </ol>
                    </div>
                    <div id="content">
                        <div class="article">
                            <div class="box-sizing">
                                <h1>Road Casualties</h1>

                                <div class="section">
                                    <h2>Total Casualties: <?php echo $total; ?></h2>
                                </div>

                                <?php 
                                    htmlChart("year");
                                    htmlChart("severity");
                                    htmlChart("gender");
                                    htmlChart("road_user_type")
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php require_once "components/feedback.html"; ?>
                </div>
            </div>
        </div>

        <?php require_once "components/footer.html"; ?>

        <script><?php
            jsChart("year", true);
            jsChart("severity");
            jsChart("gender");
            jsChart("road_user_type");
        ?></script>
    </body>
</html>
