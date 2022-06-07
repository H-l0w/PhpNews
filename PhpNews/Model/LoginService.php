<?php

class LoginService
{
    public static function IsLogged():bool{
        if(isset($_SESSION['is_logged']) && ['is_logged'] == true){
            return true;
        }
        return  false;
    }

    public static function IsAdministrator():bool{
        if (self::IsLogged() == false)
            return  false;
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
            return true;
        }
        return  false;
    }

    public static function IsCreator():bool{
        if (self::IsLogged() == false)
            return  false;
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Editor'){
            return true;
        }
        return  false;
    }
}