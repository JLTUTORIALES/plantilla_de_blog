<?php require_once("settings.php");if(!is_admin()){header('LOCATION: admin.php');}$id=0;$title='';$url='';$thumb='';$descr='';$content='';$edit=false;if(isset($_GET['id'])){$conexion=db_connect();$query="SELECT * FROM post WHERE id=".$_GET['id'];$query=mysqli_fetch_array(mysqli_query($conexion,$query));if(isset($query['id'])){$id=$query['id'];$title=$query['title'];$url=$query['url'];$thumb=$query['thumb'];$descr=$query['descr'];$content=$query['content'];$edit=true;}} ?><!doctypehtml><html lang="<?php echo $info["language"]; ?>"><?php blog_struct::get_head('Escribir entrada','<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>'); ?><body style="background:#eee"><?php blog_struct::get_nav(); ?><form autocomplete="off"class="write-form"method="post"><header style="margin-bottom:0"><input maxlength="50"name="entry-title"value="<?php echo $title; ?>"placeholder="Título de la Entrada"></header><div class="main-image"><img id="post_image"></div><div class="write-main"><textarea name="content"placeholder="Escribe algo..."id="content-area"><?php echo $content; ?></textarea></div><div class="info"><button onclick='this.form.target="_blank",this.form.action="post.php?mode=preview"'type="submit">Vista Previa</button><br><label for="url">URL</label><br><input maxlength="255"name="url"value="<?php echo $url; ?>"id="url"readonly><br><label for="thumb">URL Imágen Principal</label> <input maxlength="255"name="thumb"value="<?php echo $thumb; ?>"id="thumb"><br><label for="descr">Descripción</label><br><textarea name="descr"placeholder="Escribe una breve descripción..."><?php echo $descr; ?></textarea><br><?php if($edit){echo '<button type="submit" onclick="this.form.target=\'_self\'; this.form.action=\'post?mode=post&alter=edit&id='.$id.'\'">Publicar Entrada</button><br>
                <button type="submit" onclick="this.form.target=\'_blank\'; this.form.action=\'post?mode=save&alter=edit&id='.$id.'\'">Guardar Como Borrador</button>';}else{echo '<button type="submit" onclick="this.form.target=\'_self\'; this.form.action=\'post?mode=post\'">Publicar Entrada</button><br>
                <button type="submit" onclick="this.form.target=\'_blank\'; this.form.action=\'post?mode=save\'">Guardar Como Borrador</button>';} ?></div></form><?php blog_struct::get_footer(); ?><script>$(".write-form input").keydown(function(e){13==e.which&&event.preventDefault()});var textarea=$(".write-form .write-main textarea");textarea.bind("keyup",function(e){var t=textarea.get(0).scrollHeight;textarea.height(t+"px")}),$(".write-form header input").keyup(function(e){var t=$(".write-form header input").get(0).value.replaceAll(" ","-").toLowerCase(),r=$(".write-form .info #url");""!=r.get(0).value&&r.get(0).value==t||(r.get(0).value=t)});var img_box=$("#post_image"),img_url=$("#thumb");img_url.focusout(function(e){""!=img_url.get(0).value?img_box.attr("src",img_url.get(0).value):img_box.attr("src","")})</script></body></html>