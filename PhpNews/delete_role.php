<?php
session_start();
if(isset($_GET['id'])){
    require_once 'Model/LoginService.php';
    if(!LoginService::IsAdministrator()){
        header('Location: index.php');
        die();
    }

    require_once 'Model/Database.php';
    require_once 'Model/RoleRepo.php';

    $db = new Database();
    $repo = new RoleRepo($db);
    if(!$repo->hasRoleMembers($_GET['id'])){
        $repo->deleteRole($_GET['id']);
        header('Location: administration_roles.php');
        die();
    }
    else{
        header('Location: administration_roles.php?error=role_has_members');
        die();
    }

}
header('Location: administration_roles.php');
die();
?>