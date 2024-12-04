<div id="sesion">
    <form name='login' method='POST' action="php/sesion/login.php">
        <?php if (isset($_SESSION['sms'])) { echo "<p  id='sms'>" . htmlspecialchars($_SESSION['sms']) . "</p>"; unset($_SESSION['sms']); }?>
        <h2>INICIAR SESIÓN</h2>
        <?php if (isset($_SESSION['error'])) { echo "<p class='error'>" . htmlspecialchars($_SESSION['error']) . "</p>"; unset($_SESSION['error']); }?>
        <input type='text' name='usuario' placeholder='Ingresar su usuario' autocomplete='off' maxlength='50'>
        <input type='password' name='password' placeholder='Ingresar su contraseña' autocomplete='off' maxlength='20'>
        <input type='submit' name='login' value='INICIAR SESIÓN'>
        <a href='index.php?seccion=crearcuenta'>Crear cuenta</a>
        <a href='#'>Olvide mi contraseña</a>
    </form>
</div>