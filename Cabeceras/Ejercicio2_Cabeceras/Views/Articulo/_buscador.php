
<form method="GET" action="index.php">
    <input type="hidden" name="controller" value="articulo"/>
    <input type="hidden" name="action" value="buscar"/>

    <p>
        <label for="id">Identificador del artículo</label>
        <input type="text" id="id" name="id" inputmode="numeric"
               value="<?= htmlspecialchars((string) ($idBuscado ?? ''), ENT_QUOTES, 'UTF-8') ?>"/>
    </p>

    <input type="submit" value="Buscar" />
</form>


