<?php
// Incluir la página header
include "lib/header.php";
?>

<style>
  body {
    background-image: linear-gradient(to right, #9CCC65 0%, #8BC34A 20%, #7CB342 40%, #689F38 60%, #558B2F 80%, #33691E 100%); /* Gradient ajustado al estilo Frutiger Aero */
    background-size: 800px; /* Adjust for larger patterns */
    animation: animateBackground 10s ease-in-out infinite; /* Animation for movement */
  }

  @keyframes animateBackground {
    from { background-position: 0 0; }
    to { background-position: -800px 0; }
  }
</style>

<div style="text-align: center;">
  <div style="font-size: 24px; margin-bottom: 20px;">Formulario para la introducción de noticias</div>
  <div>
    <form action="recibe.php" method="post" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
      <label for="id" style="display: block; margin-bottom: 5px;">Id:</label>
      <input type="text" name="id" style="width: 100%; padding: 5px; margin-bottom: 10px;"><br>

      <label for="titulo" style="display: block; margin-bottom: 5px;">Título:</label>
      <input type="text" id="titulo" name="titulo" style="width: 100%; padding: 5px; margin-bottom: 10px;"><br>

      <label for="fecha" style="display: block; margin-bottom: 5px;">Fecha:</label>
      <input type="date" name="fecha" style="width: 100%; padding: 5px; margin-bottom: 10px;"><br>

      <label for="autor" style="display: block; margin-bottom: 5px;">Autor:</label>
      <input type="text" name="autor" style="width: 100%; padding: 5px; margin-bottom: 10px;"><br>

      <label for="noticia" style="display: block; margin-bottom: 5px;">Noticia:</label>
      <textarea name="noticia" cols="30" rows="5" style="width: 100%; padding: 5px; margin-bottom: 10px;"></textarea><br>

      <input type="submit" value="Enviar" name="enviar" style="padding: 10px 20px; background-color: #252F33; color: #fff; border: 2px solid #252F33;
      font-family: sans-serif; font-size: 16px; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; border-radius: 5px; display: block; margin: 0 auto;">
    </form>
  </div>
</div>

<?php
// Incluir la página footer
include "lib/footer.php";
?>
