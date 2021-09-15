<?php
include("./unique_plantsDB.php");

if(isset($_GET['plant_id'])){
    $mainItem = getMainItem($_GET['plant_id']);
}

if(isset($_POST['create'])){
    store();
    header("location:./unique_plants.php?plant_id=".$_GET['plant_id']);
    die;
}
if(isset($_GET['edit'])){
    // $item = find();
    $item = find($_GET['edit']);
}

if(isset($_POST['update'])){
    update();
    header("location:./unique_plants.php?plant_id=".$_GET['plant_id']);
    die;
}
if(isset($_POST['destroy'])){
    destroy();
    header("location:./unique_plants.php?plant_id=".$_GET['plant_id']);
    die;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <title>Medelynas</title>
    <style>
        body {margin:15px;};
    </style>
</head>
<body>

<a class="btn btn-warning" href="./">Pagrindinis puslapis</a>
<a class="btn btn-warning" href="./unique_plants.php">Visų augalų sąrašas</a>
<br><br>

<?php
if(isset($_GET['plant_id']) && !$_GET['plant_id']==""){
?>
    <form class="form" action="" method="post">
        <div class="form-group row mt-2">
            <label class="col-sm-1 col-form-label">Augalas</label>
            <div class="col-sm-4">
                <input disabled class="form-control" type="text" name="health" value='<?= (isset($mainItem))? $mainItem["name"]:"" ?>'>
            </div>
        </div>
        <div class="form-group row mt-2">
            <label class="col-sm-1 col-form-label">Vienmetis</label>
            <div class="col-sm-4">
                <input <?=(isset($mainItem) && $mainItem["is_yearling"])? "checked":""?> style="zoom:2" disabled type="checkbox" name="is_yearling" value='<?= (isset($mainItem))? $mainItem['is_yearling']:"" ?>'>
            </div>
        </div>
        <div class="form-group row mt-2">
            <label class="col-sm-1 col-form-label">Amžius</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="age" value='<?= (isset($item))? $item['age']:"" ?>'>
            </div>
        </div>
        <div class="form-group row mt-2">
            <label class="col-sm-1 col-form-label">Aukštis</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="height" value='<?= (isset($item))? $item['height']:"" ?>'>
            </div>
        </div>
        
        <div class="form-group row mt-2">
            <label class="col-sm-1 col-form-label">Būklė</label>
            <div class="col-sm-4">
                <!-- <input class="form-control" type="text" name="health" value='<?= (isset($item))? $item['health']:"" ?>'> -->
                <select class="form-select" name="health">
                    <option></option>
                    <option <?=(isset($item) && $item["health"]=="Puiki")? "selected":""?>>Puiki</option>
                    <option <?=(isset($item) && $item["health"]=="Gera")? "selected":""?>>Gera</option>
                    <option <?=(isset($item) && $item["health"]=="Patenkinama")? "selected":""?>>Patenkinama</option>
                    <option <?=(isset($item) && $item["health"]=="Bloga")? "selected":""?>>Bloga</option>
                </select>
            </div>
        </div>


        <div class="form-group row mt-4">
            <label class="col-sm-1 col-form-label"></label>
            <div class="col-sm-4">
                <?php if(isset($item)) {
                    echo '<button class="btn btn-success col-sm-12" name="update" value="'.$item["id"].'" type="submit">Atnaujinti</button>';
                } else {
                    echo '<button class="btn btn-success col-sm-12" name="create" type="submit">Pridėti</button>';
                }?>
            </div>
        </div>
        <br>
    </form>

    <?php
        }
    ?>


    <table class="table">


        <th>id</th>
        <th>Pavadinimas</th>
        <th>Amžius</th>
        <th>Aukštis</th>
        <th>Būklė</th>

        <th></th>
        <th></th>
        <tr>
            <form action="" method="get">
                <td><input class="col-sm-6" type="text" name="uniqid" value='<?= (isset($_GET['uniqid']))? $_GET['uniqid']:"" ?>'></td>
                <td><input class="col-sm-6" type="text" name="name" value='<?= (isset($_GET['name']))? $_GET['name']:"" ?>'></td>
                <td><input class="col-sm-8" type="text" id="age" name="age" value='<?= (isset($_GET['age']))? $_GET['age']:"" ?>'></td>
                <td><input class="col-sm-8" type="text" name="height" value='<?= (isset($_GET['height']))? $_GET['height']:"" ?>'></td>
                <td><input class="col-sm-8" type="text" name="health" value='<?= (isset($_GET['health']))? $_GET['health']:"" ?>'></td>
                <td><button class="btn btn-primary" type="submit">Filter</button></td>
                <td> <a class="btn btn-primary" href="?plant_id=<?=(isset($_GET['plant_id']))? $_GET['plant_id']:""?>">Clear</a></td>
                <td><input hidden class="col-sm-8" type="text" name="plant_id" value='<?= (isset($_GET['plant_id']))? $_GET['plant_id']:"" ?>'></td>

            </form>
        </tr>
        <?php 
        foreach (all() as $item) { 
// print_r($item);die;
            ?>
        
        <tr>
            <td> <?=$item["uniqid"]?></td>
            <td> <?=$item["name"]?></td>
            <td> <?=$item["age"]?></td>
            <td> <?=$item["height"]?></td>
            <td> <?=$item["health"]?></td>
            <td> <a class="btn btn-info" href="?plant_id=<?=(isset($item['id']))? $item["id"]:""?>&edit=<?=$item["uniqid"]?>">Edit</a></td>
            <td>
                <form action="" method="post">
                    <button class="btn btn-danger" type="submit" name="destroy" value="<?=$item["uniqid"]?>">Delete</button>
                 </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>