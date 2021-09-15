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

    $idFilt = "%";
    if (isset($_GET['id']) && $_GET['id']!=="") {
        $idFilt = $_GET['id'];
    }
    
    $nameFilt = "";
    if (isset($_GET['name'])) {
        $nameFilt = $_GET['name'];
    }

    $isyearlingFilt = "%";
    if (isset($_GET['is_yearling'])) {
        $isyearlingFilt = $_GET['is_yearling'];
    }

    $quantityFilt = "%";
    if (isset($_GET['quantity'])) {
        $quantityFilt = $_GET['quantity'];
    }


    // $sql = "SELECT * FROM `plants` WHERE 
    //         `id` LIKE '".$idFilt."' AND
    //         `name` LIKE '%".$nameFilt."%' AND
    //         `is_yearling` LIKE '%".$isyearlingFilt."%' AND
    //         `quantity` LIKE '%".$quantityFilt."%'";

    // $sql = "SELECT `plants`.`id`, `name`, `is_yearling`, `age`, count(`plants`.`id`) as 'quantity'
    //         FROM `unique_plants` right join `plants`
    //         ON `plants`.`id` = `unique_plants`.`plant_id`
    //         WHERE `plants`.`id` LIKE '".$idFilt."' AND
    //         `name` LIKE '%".$nameFilt."%' AND
    //         `is_yearling` LIKE '%".$isyearlingFilt."%' AND
    //         `quantity` LIKE '".$quantityFilt."'
    //         GROUP by `plants`.`id`;";

    $sql = "SELECT `plants`.`id`, `name`, `is_yearling`, (SELECT COUNT(*) 
                FROM `unique_plants` 
                WHERE `unique_plants`.`plant_id`  = `plants`.`id`) as 'quantity'
            FROM `unique_plants` right join `plants`
            ON `plants`.`id` = `unique_plants`.`plant_id`
            WHERE `plants`.`id` LIKE '".$idFilt."' AND
            `name` LIKE '%".$nameFilt."%' AND
            `is_yearling` LIKE '%".$isyearlingFilt."%' AND
            `quantity` LIKE '%".$quantityFilt."%'
            GROUP by `plants`.`id`;";

    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function find($id) {
    $sql = "SELECT * FROM `plants` WHERE `id` = '".$id."'";
    $conn = connection();
    $item = $conn->query($sql);
    $conn->close();
    return (array) $item->fetch_assoc();
}

function store(){
    $sql = "INSERT INTO `plants`(`id`, `name`, `is_yearling`, `quantity`) 
            VALUES (Null,'".$_POST['name']."','".$_POST['is_yearling']."','".$_POST['quantity']."')";
    $conn = connection ();
    $conn->query($sql);
    $conn->close();
}

function update() {
    $sql = "UPDATE `plants` SET `name` = '".$_POST['name']."', `is_yearling` = '".$_POST['is_yearling']."', 
            `quantity` = '".$_POST['quantity']."'
            WHERE `plants`.`id` = ".$_POST['update'].";";
    $conn = connection ();
    $conn->query($sql);
    $conn->close();
}

function destroy() {
    $sql = "DELETE FROM `plants` WHERE `id` = '".$_POST['destroy']."'";
    $conn = connection ();
    $conn->query($sql);
    $conn->close();
}


// nebenaudojama
function countItems($id) {
    $sql = "SELECT * FROM `unique_plants` WHERE `plant_id` = '".$id."'";
    $conn = connection();
    $it = $conn->query($sql);
    $conn->close();
    $result = $it->fetch_assoc();
    return mysqli_num_rows($it);
}

?>