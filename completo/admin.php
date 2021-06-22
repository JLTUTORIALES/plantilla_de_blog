<?php
    //Importar ajustes
    require_once("settings.php");

    if (!isset($_SESSION['admin'])){

        if (isset($_POST['username'], $_POST['password'])){
            if (!(
                $_POST['username'] == $admin['username'] && 
                $_POST['password'] == $admin['password']
            )){
                echo '<script>alert("Los datos no coinciden");</script>';
            }else{
                echo '<script>alert("Bienvenido Administrador :)"); location.href = "inicio"</script>';
                $_SESSION['admin'] = true;
            }
        }
    }else{
        $_SESSION['admin'] = false;
        session_destroy();
        header("LOCATION: index.php");
    }

?>

<!DOCTYPE html>
<html lang="<?php echo $info["language"]; ?>">
<?php blog_struct::get_head('Ingresar como Administrador - '.$info['title']) ?>

<body style="background: #7cc;">

    <?php blog_struct::get_nav(); ?>
    
    <header class="login-form">
        <h1>Panel de Administrador</h1>
        <form method="post" autocomplete="off">
            <div class="login-input">
                <label for="username">Nombre de Usuario </label> <input type="text" name="username"/>
            </div>
            <div class="login-input">
                <label for="password">Contraseña </label> <input type="password" name="password"/>
            </div>
            <button type="submit">Ingresar</button>
        </form>
    </header>
    <footer style="margin-top: 25 !important;">
        <p><?php echo $info["title"]." &copy; "; if ($info["year"] < date("Y")){echo $info["year"]."- ".date("Y");}else{echo date("Y");} ?></p>
        <br><span title="HTML5" class="fab fa-html5 tecnologies"></span>
        <span title="CSS3" class="fab fa-css3 tecnologies"></span>
        <span title="PHP" class="fab fa-php tecnologies"></span>
        <span title="MYSQL" class="fa fa-database tecnologies"></span><br>
        <a href="#"><button> <span class="fa fa-github"></span> Ver repositorio</button></a>
    </footer>
</body>
</html>