<?php
include("./plantsDB.php");
if(isset($_POST['create'])){
    store();
    header("location:./");
    die;
}
if(isset($_GET['edit'])){
    $item = find($_GET['edit']);

}
if(isset($_POST['update'])){
    update();
    header("location:./");
    die;
}
if(isset($_POST['destroy'])){
    destroy();
    header("location:./");
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
        .larger {
            width: 50px;
            height: 50px;
        }
    </style>
</head>
<body>

<a class="btn btn-warning" href="./unique_plants.php">Visų augalų sąrašas</a>
<br><br>

    <form class="form" action="" method="post">
        <div class="form-group row mt-2">
            <label class="col-sm-1 col-form-label">Pavadinimas</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="name" value='<?= (isset($item))? $item['name']:"" ?>'>
            </div>
        </div>
        <div class="form-group row mt-2">
            <label class="col-sm-1 col-form-label">Vienmetis</label>
            <div class="col-sm-4">
                <input <?=(isset($item) && $item["is_yearling"])? "checked":""?> style="zoom:2" type="checkbox" name="is_yearling" value='<?= (isset($item))? $item['is_yearling']:"" ?>'>
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

    <table class="table">
        <th>id</th>
        <th>Pavadinimas</th>
        <th>Vienmetis</th>
        <th>Kiekis</th>

        <th></th>
        <th></th>
        <tr>
            <form action="" method="get">
                <td><input class="col-sm-6" type="text" name="id" value='<?= (isset($_GET['id']))? $_GET['id']:"" ?>'></td>
                <td><input class="col-sm-8" type="text" name="name" value='<?= (isset($_GET['name']))? $_GET['name']:"" ?>'></td>
                <td><input hidden class="col-sm-8" type="text" name="is_yearling" value='<?= (isset($_GET['is_yearling']))? $_GET['is_yearling']:"" ?>'></td>
                <td><input hidden class="col-sm-8" type="text" name="quantity" value='<?= (isset($_GET['quantity']))? $_GET['quantity']:"" ?>'></td>
                <td><button class="btn btn-primary" type="submit">Filter</button></td>
                <td> <a class="btn btn-primary" href="./">Clear</a> </td>
            </form>
        </tr>
        <?php 
        foreach (all() as $item) {      

            ?>
        <tr>
            <td><?=$item["id"]?></td>
            <td><?=$item["name"]?></td>
            <td><input <?=($item["is_yearling"])? "checked":""?> style="zoom:2" disabled type="checkbox" name="is_yearling"></td>
            <td><a class="btn btn-link" href="./unique_plants.php?plant_id=<?=$item["id"]?>"><?=$item["quantity"]?></a></td>
            <td><a class="btn btn-info" href="?edit=<?=$item["id"]?>">Edit</a></td>
            <td>
                <form action="" method="post">
                    <button class="btn btn-danger" type="submit" name="destroy" value="<?=$item["id"]?>">Delete</button>
                 </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>