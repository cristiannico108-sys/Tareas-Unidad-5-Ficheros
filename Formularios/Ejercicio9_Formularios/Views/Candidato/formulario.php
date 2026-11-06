<h2>Solicitud de empleo</h2>

<form method="POST" action="index.php?controller=Candidato&amp;action=procesar" novalidate>
    <p>
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="candidato[nombre]"/>
    </p>

    <p>
        <label for="apellidos">Apellidos</label>
        <input type="text" id="apellidos" name="candidato[apellidos]"/>
    </p>

    <p>
        <label for="correo">Correo electrónico</label>
        <input type="email" id="correo" name="candidato[correo]"/>
    </p>

    <p>
        <label for="telefono">Teléfono</label>
        <input type="tel" id="telefono" name="candidato[telefono]"/>
    </p>

    <fieldset>
        <legend>Situación laboral actual</legend>
        <?php foreach ($situaciones as $valor => $etiqueta): ?>
            <label>
                <input type="radio" name="candidato[situacion]" value="<?= htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') ?>"/>
                <?= htmlspecialchars($etiqueta, ENT_QUOTES, 'UTF-8') ?>
            </label>
        <?php endforeach; ?>
    </fieldset>

    <fieldset>
        <legend>Lenguajes de programación que domina</legend>
        <?php foreach ($lenguajes as $lenguaje): ?>
            <label>
                <input type="checkbox" name="candidato[lenguajes][]" value="<?= htmlspecialchars($lenguaje, ENT_QUOTES, 'UTF-8') ?>"/>
                <?= htmlspecialchars($lenguaje, ENT_QUOTES, 'UTF-8') ?>
            </label>
        <?php endforeach; ?>
    </fieldset>

    <p>
        <label for="url">URL de un trabajo anterior</label>
        <input type="url" id="url" name="candidato[url]" placeholder="https://..."/>
    </p>

    <input type="submit" value="Enviar candidatura" />
</form>
