<?php
    $localurl = urldecode(str_replace("/", "", $_SERVER['REQUEST_URI']));
    require_once('settings.php');

    function _404(){
        //Página de error 404
        header('HTTP/2.0: 404 Not Found');
        blog_struct::get_head("404 Página no Encontrada");
        blog_struct::get_nav();
        echo '<header><h1>Error 404</h1><center><p>Lo sentimos la página que buscas no fue encontrada :(</p><center></header>';
        blog_struct::get_footer();
    }

    if ($localurl == 'inicio'){
        header('LOCATION: index');
    }else if ($localurl == 'posts'){
        blog_struct::get_head("Todas las entradas");
        blog_struct::get_nav();
        echo '<header><h1>Todas las entradas</h1></header>';
        echo '<article>';
        blog_struct::get_all_post(2);
        echo '</article>';
        blog_struct::get_footer();
    }else{

        //Buscar entradas con esa url
        $conexion = db_connect();

        $query = "SELECT * FROM post WHERE url='$localurl'";
        $result = mysqli_query($conexion, $query);
        $result = mysqli_fetch_array($result);

        //Si existe la entrada se muestra
        if (isset($result['id'])){
            if ($result['status'] == 1 || is_admin()){
                header('HTTP/2.0: 200 Ok');
                blog_struct::map_post($result);

                //Aumentar las vistas menos las de los admins
                if (!is_admin()){
                    $query = "UPDATE post SET views=".($result['views']+ 1)." WHERE id=".$result['id']."";
                    mysqli_query($conexion, $query);
                }
            }else{
                _404();
            }

        }else{
            _404();
        }
    }
?>