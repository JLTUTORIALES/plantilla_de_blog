<?php
    //Importar ajustes
    require_once("settings.php");

    //Conectar a base de datos
    $conexion = db_connect();

    if (!isset($_GET['keys']) || $_GET['keys'] == ''){ header("LOCATION: index"); }

    $query = "SELECT * FROM post WHERE status=1 AND (title LIKE '%".$_GET['keys']."%' OR content LIKE '%".$_GET['keys']."%')";
    $query = mysqli_query($conexion, $query);

?>

<!DOCTYPE html>
<html lang="<?php echo $info["language"]; ?>">
<?php blog_struct::get_head(); ?>
<body>
    <?php blog_struct::get_nav(); ?>
    <header>
        <h1>Buscar contenido</h1>
        <img src="<?php echo $info["icon"]; ?>" alt="ícono del blog"/>
    </header>
    <article>
        <?php
            while($row = mysqli_fetch_array($query)){
                blog_struct::get_post($row);
            }
        ?>
    </article>
    <?php blog_struct::get_footer(); ?>
</body>