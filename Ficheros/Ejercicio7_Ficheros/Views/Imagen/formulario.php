<?php
    $e = static fn(mixed $v): string => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
?>
<h1>Subida de archivos con PHP</h1>

<?php if ($mensaje !== null): ?>
    <p><strong><?= $e($mensaje) ?></strong></p>
<?php endif; ?>

<?php if ($error !== null): ?>
    <p><strong>Error:</strong> <?= $e($error) ?></p>
<?php endif; ?>

<form method="POST" action="index.php?controller=imagen&amp;action=subir" enctype="multipart/form-data">
    <input type="file" name="imagen" accept="image/jpeg,image/png,image/gif,image/webp"/>
    <input type="submit" value="Enviar" />
</form>

<h2>Listado de imágenes</h2>

<?php if ($imagenes === []): ?>
    <p>Todavía no hay imágenes subidas.</p>
<?php else: ?>
    <?php foreach ($imagenes as $nombre): ?>
        <p><img src="<?= $e(IMAGES_URL . '/' . $nombre) ?>" alt="Imagen subida" width="150"/></p>
    <?php endforeach; ?>
<?php endif; ?>
