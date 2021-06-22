<?php
    //Importar ajustes
    require_once("settings.php");

    //Conectar a base de datos
    $conexion = db_connect();

?>

<!DOCTYPE html>
<html lang="<?php echo $info["language"]; ?>">
<?php blog_struct::get_head(); ?>
<body>
    <?php blog_struct::get_nav(); ?>
    <header>
        <h1><?php echo $info["title"]; ?></h1>
        <img src="<?php echo $info["icon"]; ?>" alt="ícono del blog"/>
        <center><p><?php echo $info["brief_description"]; ?></p></center>
    </header>
    <article>
        <?php
            if (is_admin()){
                echo "<a href='write.php'><button>Escribir entrada</button></a>";
            }
        ?>
        <h2>Entradas Recientes</h2>
        <?php blog_struct::get_all_post(0); ?>
        <h2>Entradas más visitadas</h2>
        <?php blog_struct::get_all_post(1); ?><br>
        <a href="posts"><button>Ver más entradas</button></a>
    </article>
    <?php blog_struct::get_footer(); ?>
</body>
</html>