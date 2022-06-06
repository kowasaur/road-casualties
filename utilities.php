<?php // This file has functions that are used in at least two files

// E.g. road_user_type -> Road User Type
function capitalise(string $str) {
    return ucwords(str_replace("_", " ", $str));
}

// Returns an array of the different unique values in a column of road_casualties
function uniqueColumnValues(mysqli $mysqli, string $column): array {
    $sql = "SELECT DISTINCT $column FROM road_casualties ORDER BY $column";
    return array_column($mysqli->query($sql)->fetch_all(), 0);
}

// Create an option element and make it selected if the user did previously
function htmlOption(string $value, string $selected_value) { ?>
    <option <?php if ($value == $selected_value) echo "selected='selected'"; ?> 
    value="<?php echo $value; ?>"><?php echo $value; ?></option>
<?php }
