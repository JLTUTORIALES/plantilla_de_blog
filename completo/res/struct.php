<?php
    class blog_struct
    {
        public static function get_nav()
        {
            $target = '<nav><form action="/find" autocomplete="off" method="get"><input type="text" name="keys"/>
                <button type="submit"><span class="fa fa-search"></span></button></form>
                <a href="inicio"><button><span class="fas fa-home" title="Inicio"></button></a>';
            
            if (is_admin())
            {
                $target .= '<a href="admin"><button><span class="fas fa-sign-out-alt" title="Cerrar sesión"></button></a></nav>';
            }

            $target.= '</nav>';

            echo $target;
        }

        public static function get_footer()
        {
            global $info;

            $target = "<footer><p>".$info['title']."&copy; ";
            if ($info["year"] < date("Y")){
                $target .= $info["year"]."- ".date("Y");
            }else{
                $target .= date("Y");
            }
            $target .= '</p>
            <br><span title="HTML5" class="fab fa-html5 tecnologies"></span><span title="CSS3" class="fab fa-css3 tecnologies"></span>
            <span title="PHP" class="fab fa-php tecnologies"></span><span title="MYSQL" class="fa fa-database tecnologies"></span><br>
            <a href="#"><button> <span class="fa fa-github"></span> Ver repositorio</button></a></footer>';

            echo $target;
        }

        public static function get_head($title = "", $extras = ""){
            global $info;

            $target = "<head>
                <meta charset='UTF-8'/>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <title>";

            if ($title != ""){ $target.= $title; }else{ $target.= $info['title']; }
                
            $target .= "</title>
                <link rel='stylesheet' href='res/styles.css'/>
                <link rel='icon' href='".$info['icon']."'/>
                <script src='https://kit.fontawesome.com/9bea2f1c05.js' crossorigin='anonymous' load='async'></script>
                $extras
            </head>";

            echo $target;
        }

        public static function get_all_post($type = 0){
            $conexion = db_connect();

            switch($type){

                case 0:
                    //Obtener las tres entradas publicadas más recientes
                    $query = "SELECT * FROM post WHERE status=1 ORDER BY fecha DESC LIMIT 3";
                    $result = mysqli_query($conexion, $query);

                break;

                case 1:
                    //Obtener las tres entradas publicadas más populares
                    $query = "SELECT * FROM post WHERE status=1 ORDER BY views DESC LIMIT 3";
                    $result = mysqli_query($conexion, $query);

                    break;
                
                
                case 2:
                    //Obtener todas las entradas (incluyendo borradores)
                    $query = "SELECT * FROM post ORDER BY fecha";
                    $result = mysqli_query($conexion, $query);

                    break;

            }

            while ($query = mysqli_fetch_array($result)){

                //Mostrar todas las entradas y los borradores a los adminstradores
                if ($query['status'] == 0){
                    if (is_admin()){ blog_struct::get_post($query, 1); }
                } else { blog_struct::get_post($query); }

            }

        }

        //Función para mapear el post
        public static function map_post($data){
            global $info;
            echo "<!DOCTYPE html> <html lang=".$info["language"].">";
                    blog_struct::get_head($data['title'], "<meta name='description' content='".$data['descr']."' />");
                    echo "<body style='background: #eee;'>"; blog_struct::get_nav();
                    echo "<header class='entry-post'><h1>".$data['title']."</h1></header><div class='main-image'>";
                    echo "<img id='post_image' src='".$data['thumb']."' /></div><center>";
                    if (is_admin()){ echo "<a href='write?id=".$data['id']."'><button>Editar entrada</button></a><br/>"; }
                    echo "<article class='entry-content'>".$data['content']."</article><br>";
                    if (is_admin()) { echo "<button onclick='eliminar()'>Eliminar Post</button>"; }
                    echo '</center><script>
                        function eliminar (){ if (confirm("¿Estás seguro de eliminar la entrada?")) {
                            location.href="post?mode=delete&id='.$data['id'].'"
                        } }
                    </script>';
                    blog_struct::get_footer(); echo "</body>";
        }

        public static function get_post($data, $type = 0){
            
            echo '<a href="'.$data['url'].'"><section style=\'background-image: url("'.$data['thumb'].'")\'>';
            echo '<div class="content"><h3>';
            if ($type == 1){ echo $data['title']." - Borrador"; } else { echo $data['title']; }
            echo'</h3><p>'.substr($data['descr'], 0, 66).'...</p>';
            echo '<div class="stats">'.$data['fecha'].'<span class="fa fa-user" title="Visto por '.$data['views'].' usuarios"> '.$data['views'].'</span>';
            if (is_admin()){ echo '<a href="write?id='.$data['id'].'"><span class="fa fa-pen" title="Editar entrada"></span></a>'; }
            echo '</div></section></a>';
        }

    }
?>