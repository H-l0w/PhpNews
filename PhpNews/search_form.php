<style>
    .form_div{
        display: flex;
        justify-content: right;
        margin-top: 25px;
        margin-bottom: 0;
    }

    .form_div input, .form_div button{
        border-radius: 5px;
    }

    .form_div button:hover{
        background-color: #b6c2d9;
    }

</style>
<div class="form_div">
    <form action="search.php" method="get">
        <input type="hidden" value="<?=$_SERVER['REQUEST_URI']?>" name="origin">
        <input type="search" placeholder="Vyhledat na stránce" name="search" value="<?=$_GET['search'] ?? ''?>">
        <button type="submit">Vyhledat</button>
    </form>
</div>