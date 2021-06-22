<?php
    //Importar ajustes
    require_once("settings.php");
    if (!is_admin()){ header('LOCATION: admin.php'); }

    $id = 0; $title = ''; $url = ''; $thumb = ''; $descr = ''; $content = '';
    $edit = false;

    if (isset($_GET['id'])){
        $conexion = db_connect();
        $query = "SELECT * FROM post WHERE id=".$_GET['id'];        
        $query = mysqli_fetch_array(mysqli_query($conexion, $query));
        
        //Modo edición de entradas
        if (isset($query['id'])){
            $id = $query['id'];
            $title = $query['title'];
            $url = $query['url'];
            $thumb = $query['thumb'];
            $descr = $query['descr'];
            $content = $query['content'];
            $edit = true;
        }

    }


?>

<!DOCTYPE html>
<html lang="<?php echo $info["language"]; ?>">
<?php blog_struct::get_head(
    'Escribir entrada',
    '<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>'
    );
?>
<body style="background: #eee;">
    <?php blog_struct::get_nav(); ?>
    <form method="post" class="write-form" autocomplete="off">
        <header style="margin-bottom: 0px;">
            <input type="text" name="entry-title" placeholder="Título de la Entrada" maxlength="50" value="<?php echo $title; ?>"/>
        </header>
        <div class="main-image">
            <img id="post_image" />
        </div>
        <div class="write-main">
            <textarea name="content" id="content-area" placeholder="Escribe algo..."><?php echo $content; ?></textarea>
        </div>
        <div class="info">
            <button type="submit" onclick="this.form.target='_blank'; this.form.action='post.php?mode=preview'">Vista Previa</button><br>
            <label for="url">URL&nbsp;</label><br>
            <input type="text" name="url" readonly id="url" value="<?php echo $url;?>" maxlength="255"/><br>

            <label for="thumb">URL Imágen Principal</label>
            <input type="text" name="thumb" id="thumb" maxlength="255" value="<?php echo $thumb; ?>"/><br>

            <label for="descr">Descripción&nbsp;</label><br>
            <textarea name="descr" placeholder="Escribe una breve descripción..."><?php echo $descr; ?></textarea><br>

            <?php 

            if ($edit){
                echo '<button type="submit" onclick="this.form.target=\'_self\'; this.form.action=\'post?mode=post&alter=edit&id='.$id.'\'">Publicar Entrada</button><br>
                <button type="submit" onclick="this.form.target=\'_blank\'; this.form.action=\'post?mode=save&alter=edit&id='.$id.'\'">Guardar Como Borrador</button>';                
            }else{
                echo '<button type="submit" onclick="this.form.target=\'_self\'; this.form.action=\'post?mode=post\'">Publicar Entrada</button><br>
                <button type="submit" onclick="this.form.target=\'_blank\'; this.form.action=\'post?mode=save\'">Guardar Como Borrador</button>';
            }

            

            ?>
        </div>

    </form>
    <?php blog_struct::get_footer(); ?>
    <script>
        //Evitar el enío del formulario pulsando intro
        $(".write-form input").keydown(function(e){ if (e.which == 13){ event.preventDefault(); } });

        //Resize textarea
        var textarea = $(".write-form .write-main textarea");

        textarea.bind('keyup', function(e){
            var h = textarea.get(0).scrollHeight;
            textarea.height(h + 'px');
        });

        //Enlazar la URL con el título del artículo
        $(".write-form header input").keyup(function (e){
            var _value1 = $(".write-form header input").get(0).value.replaceAll(" ", '-').toLowerCase();
            var _value = $(".write-form .info #url");

            if ((_value.get(0).value == "") || (_value.get(0).value != _value1)){ _value.get(0).value = _value1; }
        });

        //Establecer imagen del artículo
        var img_box = $("#post_image");
        var img_url = $("#thumb");

        img_url.focusout(function (e){
            if (img_url.get(0).value != ""){
                img_box.attr('src', img_url.get(0).value);
            }else{
                img_box.attr('src', '');
            }
        });

    </script>
</body>
</html>