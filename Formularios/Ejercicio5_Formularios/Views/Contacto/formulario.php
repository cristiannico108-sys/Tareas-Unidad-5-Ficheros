<h1>Nuevo Contacto</h1>

<form method="POST" action="index.php?controller=contacto&amp;action=procesar">
    <p>
        <label for=nombre>Nombre</label>
        <input type="text" id="nombre" name="contacto[nombre]"/>
    </p>

    <p>
        <label for="apellidos">Apellidos</label>
        <input type="text" id="apellidos" name="contacto[apellidos]"/>
    </p>

    <p>
        <label for=correo>Correo Electronico</label>
        <input type="text" id="correo" name="contacto[correo]"/>
    </p>

    <p>
        <label for="metodoPago">Selecciona método de pago</label>
        <select id="metodoPago" name="contacto[metodosPago][]" multiple size = "3">
            <option value="VISA" selected>VISA</option>
            <option value="PAYPAL" selected>PAYPAL</option>
            <option value="MASTERCARD" selected>MASTERCARD</option>
        </select>
    </p>

    <p>
        <input type="checkbox" id="marcar" name="contacto[marcar]" value="1" required/>
        <label for="marcar">Aceptar los términos y condiciones</label>
    </p>

    <label for="pass">Password</label>
    <input type="password" id="pass" name="contacto[password]" required/>

    <br>

    <input type="submit" value="Enviar" />

</form>