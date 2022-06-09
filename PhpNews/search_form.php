<style>
    .form_div_search{
        form_div_search: flex;
        justify-content: right;
        margin-top: 25px;
        margin-bottom: 0;
    }

    .form_div_search input, .form_div button{
        border-radius: 5px;
    }

    .form_div_search button:hover{
        background-color: #b6c2d9;
    }

</style>
<div class="form_div_search">
    <form action="search.php" method="get">
        <input type="search" placeholder="Vyhledat na stránce" name="search" value="<?=$_GET['search'] ?? ''?>">
        <button type="submit">Vyhledat</button>
    </form>
</div>