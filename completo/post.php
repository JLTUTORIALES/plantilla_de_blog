<?php

    require_once("settings.php");

    if (!is_admin()){ header('LOCATION: admin.php'); }

    $conexion = db_connect();

    if (isset($_GET['mode'])){

        switch ($_GET['mode']){
            case 'preview':
                if (isset(
                    $_POST['entry-title'],
                    $_POST['descr'],
                    $_POST['thumb'],
                    $_POST['content']
                )){
                    echo "<!DOCTYPE html> <html lang=".$info["language"].">";
                    blog_struct::get_head($_POST['entry-title']." - Vista previa", "<meta name='description' content='".$_POST['descr']."' />");
                    echo "<body style='background: #eee;'>"; blog_struct::get_nav();
                    echo "<header class='entry-post'><h1>".$_POST['entry-title']."</h1></header><div class='main-image'>
                    <img id='post_image' src='".$_POST['thumb']."' /></div><center><article class='entry-content'>".$_POST['content']."
                    </article></center>"; blog_struct::get_footer(); echo "</body>";
                } else {
                    echo 'Faltan datos para la vista previa';
                }

                break;
            case 'delete':
                
                if (isset($_GET['id'])){
                    $query = "DELETE FROM post WHERE id=".$_GET['id'];
                    mysqli_query($conexion, $query);
                    echo '<script>alert("Se eliminó la entrada"); location.href="index";</script>';
                }else{
                    echo '<script>alert("No se pudo eliminar la entrada indicada"); location.href="index";</script>';
                }
                break;

            case 'post':
            case 'save':

                $title = ''; $url = ''; $description = ''; $thumb = ''; $content = '';
                if (isset($_POST['entry-title'])) { $title = $_POST['entry-title'];  }
                if (isset($_POST['url'])) { $url = $_POST['url']; }
                if (isset($_POST['descr'])) { $description = $_POST['descr'];  }
                if (isset($_POST['thumb'])) { $thumb = $_POST['thumb'];  }
                if (isset($_POST['content'])) { $content = $_POST['content'];  }

               
                if (isset($_GET['alter']) && $_GET['alter'] == 'edit'){
                    //Actualizar la entrada si existe

                    $query = "UPDATE post SET title='$title', url='$url', thumb='$thumb', descr='$description', content='$content', status=";
                    if ($_GET['mode'] == 'post') { $query.="true "; } else { $query.="false ";}
                    $query .= "WHERE id=".$_GET['id']."";

                } else {
                    //Se creará una nueva entrada

                    $query = "INSERT INTO post(title, url, thumb, descr, content, status) VALUES (
                        '$title', '$url', '$thumb', '$description', '$content', ";
                    if ($_GET['mode'] == 'post') { $query.="true )"; } else { $query.="false )";}

                }

                mysqli_query($conexion, $query) or die('No se pudo subir el contenido :(');

                if ($_GET['mode'] == 'save'){
                    echo "<br/><script>alert('Se guardó como borrador');close();</script>";
                }else{
                    echo "<script>alert('Se publicó la entrada'); location.href='index';</script>";
                }
                
                break;
        }
    }

?>
