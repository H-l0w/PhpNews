<?php 
class PageRepo{
    public static function getActualPage($pagesNumber){
        if (isset($_GET['page']) && !empty($_GET['page'])){
            if (!is_numeric($_GET['page']))
                return 1;
            else if ($_GET['page'] > $pagesNumber)
                return $pagesNumber;
            else if ($_GET['page'] < 1)
                return 1;
            else
                return $_GET['page'];
        }
        return 1;
    }
}
?>