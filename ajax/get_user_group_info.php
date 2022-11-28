<?php 
include('../includes/include-bdd.php');
include('../includes/include-functions.php');

$id_user = $_GET['id_user'];
$id_group = $_GET['id_group'];

$get_user_info = $bdd->prepare('SELECT * FROM OMT_USER WHERE id_user = ?');
$get_user_info->execute(array($id_user));
$user_info = $get_user_info->fetch();

$get_group_detail = $bdd->prepare('SELECT id_user,group_status,group_admin FROM GROUP_RELATIONSHIP WHERE id_group = ? AND GROUP_RELATIONSHIP.id_user = ?');
$get_group_detail->execute(array($id_group,$id_user));
$data = $get_group_detail->fetchAll();

?>

<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <?= load_avatar($bdd,$id_user)?>
        </div>
        <div class="col-lg-9">
            <?= '<h1>'.$user_info['firstname'].' '.$user_info['surname'].' <small class="text-muted">#'.$user_info['id_user'].'</small></h1>'?>
            <?= '<p>'.$user_info['description'].'</p>'?>
            <?= '<p>'.get_admin_badge($data[0]['group_admin']).'</p>'?>
            <?= '<p>'.get_group_status($data[0]['group_status']).'</p>'?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">
                <label for="userspermissions">Permission Utilisateurs</label>
                <select class="form-control" id="userspermissions" onchange="change_permissions(this,<?=$id_group?>,<?=$id_user?>)">
                    <?php 
                    if($data[0]['group_admin'] == 1){
                        echo '<option value="1" selected>Administrateur</option>';
                        echo '<option value="0">Utilisateur</option>';
                    }
                    else{
                        echo '<option value="1">Administrateur</option>';
                        echo '<option value="0" selected>Utilisateur</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="actionuser">Action Utilisateurs</label>
                <br>
                <?php 
                if($data[0]['group_status'] == 3){
                    echo ' <button class="btn btn-link text-danger" onclick="ban_user_group(this,'.$id_group.','.$id_user.')"><i class="fa-solid fa-user-times"></i></button>';
                }
                else {
                    echo ' <button class="btn btn-link text-success" onclick="ban_user_group(this,'.$id_group.','.$id_user.')"><i class="fa-solid fa-user-check"></i></button>';
                }
                ?>
                <button class="btn btn-link text-danger" onclick="delete_user_group(<?=$id_group?>,<?=$id_user?>)"><i class="fa-solid fa-trash-can"></i></button>
            </div>
        </div>
    </div>
    <hr>
</div>