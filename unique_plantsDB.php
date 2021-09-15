<?php

function connection () {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "medelynas";
    
    return new mysqli($servername, $username, $password, $dbname);
}

function all() {
    $conn = connection ();

    $nameFilt = "";
    if (isset($_GET['name']) && $_GET['name']!=="") {
        $nameFilt = $_GET['name'];
    }

    $ageFilt = "";
    if (isset($_GET['age'])) {
        $ageFilt = $_GET['age'];
    }

    $heightFilt = "";
    if (isset($_GET['height'])) {
        $heightFilt = $_GET['height'];
    }

    $healthFilt = "";
    if (isset($_GET['health'])) {
        $healthFilt = $_GET['health'];
    }

    $plant_idFilt = "%";
    if (isset($_GET['plant_id']) && $_GET['plant_id']!=="") {
        $plant_idFilt = $_GET['plant_id'];
    }

    $idFilt = "%";
    if (isset($_GET['uniqid']) && $_GET['uniqid']!=="") {
        $idFilt = $_GET['uniqid'];
    }

    // $sql = "SELECT * from medelynas";
    // $sql = "SELECT * FROM `unique_plants` WHERE 
    //         `id` LIKE '".$idFilt."' AND
    //         `age` LIKE '%".$ageFilt."%' AND
    //         `height` LIKE '%".$heightFilt."%' AND
    //         `health` LIKE '%".$healthFilt."%' AND
    //         `plant_id` LIKE '".$plant_idFilt."'";

    $sql = "SELECT `plants`.`id`,`unique_plants`.`id` as `uniqid`, `name`, `is_yearling` , `age`, `height` , `health` 
            FROM `unique_plants` inner join `plants` 
            ON `plants`.`id` = `unique_plants`.`plant_id`
            WHERE 
            `unique_plants`.`id` LIKE '".$idFilt."' AND
            `name` LIKE '%".$nameFilt."%' AND
            `age` LIKE '%".$ageFilt."%' AND
            `height` LIKE '%".$heightFilt."%' AND
            `health` LIKE '%".$healthFilt."%' AND
            `plant_id` LIKE '".$plant_idFilt."'
            ORDER BY `uniqid`";

    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function find($id) {
    $sql = "SELECT * FROM `unique_plants` WHERE `id` = '".$id."'";
    $conn = connection();
    $item = $conn->query($sql);
    $conn->close();
    return (array) $item->fetch_assoc();
}

function store(){
    $sql = "INSERT INTO `unique_plants`(`id`, `age`, `height`, `health`, `plant_id`) 
            VALUES (Null,'".$_POST['age']."','".$_POST['height']."','".$_POST['health']."','".$_GET['plant_id']."')";
    $conn = connection ();
    $conn->query($sql);
    $conn->close();
}

function update() {
    $sql = "UPDATE `unique_plants` SET `age` = '".$_POST['age']."', `height` = '".$_POST['height']."', 
            `health` = '".$_POST['health']."'
            WHERE `unique_plants`.`id` = ".$_POST['update'].";";
    $conn = connection ();
    $conn->query($sql);
    $conn->close();
}

function destroy() {

    $sql = "DELETE FROM `unique_plants` WHERE `id` = '".$_POST['destroy']."'";

    $conn = connection ();
    $conn->query($sql);
    $conn->close();
}


function getMainItem($id) {
    $sql = "SELECT * FROM `plants` WHERE `id` = '".$id."'";
    $conn = connection();
    $item = $conn->query($sql);
    $conn->close();
    return (array) $item->fetch_assoc();
}



?>