<?php
session_start();
require_once "database.php";
require_once "utilities.php";

function locationOptions(array $regions, string $selected_location) {
    htmlOption("Queensland", $selected_location);
    foreach ($regions as $location) htmlOption($location, $selected_location);
}

function graphData(string $group, string $location) {
    global $mysqli;
    /* Adding the group and location in like this should be fine since the group is
       never user supplied and the location is checked earlier to be valid*/
    if ($location == "Queensland") {
        $sql = "SELECT $group, SUM(amount) FROM road_casualties GROUP BY $group";
    } else {
        $sql = "SELECT $group, SUM(amount) FROM road_casualties WHERE region = '$location' GROUP BY $group";
    }
    return $mysqli->query($sql);
}

// Convert a PHP sql result to JavaScript array
function jsArray($rows, string $column) {
    $rows->data_seek(0); // reset the pointer for repeat use
    echo "[";
    // JavaScript's type coercion means it is ok for numbers to be strings
    while($value = $rows->fetch_assoc()[$column]) echo "'$value', ";
    echo "]";
}

// Echo the JavaScript for a chart
function jsChart(string $group, bool $is_line = false) {
    global $location1, $location2;
    $rows1 = graphData($group, $location1);
    echo "createChart('$group-chart', ";
    jsArray($rows1, "SUM(amount)");
    echo ", '$location1', ";
    jsArray($rows1, $group);
    $type = $is_line ? "line" : "bar";
    echo ", '" . capitalise($group) . "', '$type'";
    if ($location2 != "None") {
        $rows2 = graphData($group, $location2);
        echo ", ";
        jsArray($rows2, "SUM(amount)");
        echo ", '$location2'";
    }
    echo ");\n";
}

// Echo the html for a chart
function htmlChart(string $group) { ?> 
    <div class="section">
        <h3>Road Casualties by <?php echo capitalise($group); ?></h3>
        <canvas id="<?php echo $group; ?>-chart"></canvas>
    </div> 
<?php }

// Echo the html for the total casualties
function htmlTotal(string $location) {
    global $mysqli;
    if ($location == "None") return; // do nothing
    $sql = "SELECT SUM(amount) FROM road_casualties";
    if ($location != "Queensland") $sql .= " WHERE region = '$location'";
    $total = $mysqli->query($sql)->fetch_assoc()["SUM(amount)"]; ?>
    <h2>Total <?php echo $location; ?> Casualties: <?php echo $total; ?></h2> <?php
}

$regions = uniqueColumnValues($mysqli, "region");
$valid_regions = array_merge($regions, ["Queensland", "None"]);

// The locations should only be invalid from trying to attack this system
if ($_SERVER["REQUEST_METHOD"] == "POST" && in_array($_POST["location1"], $valid_regions) && in_array($_POST["location2"], $valid_regions)) {
    $location1 = $_POST["location1"];
    $location2 = $_POST["location2"];
} else {
    $location1 = "Queensland";
    $location2 = "None";
}

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
                        <ol><li><a href=".">Home</a></li></ol>
                    </div>
                    <div id="content">
                        <div class="article">
                            <div class="box-sizing">
                                <h1>Queensland Road Casualties</h1>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">                                
                                    <select name="location1" id="location1">
                                        <?php locationOptions($regions, $location1); ?>
                                    </select>
                                    <select name="location2" id="location2"><?php 
                                        htmlOption("None", $location2);
                                        locationOptions($regions, $location2); 
                                    ?></select>
                                    <button>Select Locations</button>
                                </form>

                                <div class="section"><?php 
                                    htmlTotal($location1);
                                    htmlTotal($location2);
                                ?></div>

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
