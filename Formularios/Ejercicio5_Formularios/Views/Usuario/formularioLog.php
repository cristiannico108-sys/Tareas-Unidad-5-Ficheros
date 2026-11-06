<h2>Inicio de sesión</h2>

<form method="POST" action="index.php?controller=Auth&amp;action=procesarUser">
    <p>
        <label for="nombre">Usuario</label>
        <input type="text" id="nombre" name="Usuario[nombre]" required/>
    </p>

    <p>
        <label for="pass">Clave</label>
        <input type="password" id="pass" name="Usuario[password]" required/>
    </p>

    <input type="submit" value="Entrar" />
</form>
