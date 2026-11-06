<?php

    declare(strict_types=1);

    namespace Controllers;

    use Lib\Pages;
    use Models\Usuario;
    use Request\UsuarioRequest;

    class AuthController
    {
        private Pages $pagina;

        public function __construct()
        {
            $this->pagina = new Pages();
        }

        public function mostrarFormularioUser(): void
        {
            $this->pagina->render('Usuario/formularioLog');
        }

        public function paginaBienvenida(): void
        {
            $this->pagina->render('Usuario/bienvenida');
        }

        public function paginaError(): void
        {
            $this->pagina->render('Usuario/errorLogin');
        }

        public function procesarUser(): void
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->mostrarFormularioUser();
                return;
            }

            $request = new UsuarioRequest($_POST['Usuario'] ?? []);

            if (!$request->esValido()) {
                $this->redirigir('paginaError');
            }

            $usuario = Usuario::fromArray($request->datos());

            $nombreCorrecto = hash_equals(USUARIO_SIMULADO, $usuario->getNombre());
            $claveCorrecta  = password_verify($usuario->getPassword(), CLAVE_SIMULADA_HASH);

            if ($nombreCorrecto && $claveCorrecta) {
                $this->redirigir('paginaBienvenida');
            }

            $this->redirigir('paginaError');
        }

        private function redirigir(string $accion): never
        {
            header('Location: index.php?controller=Auth&action=' . $accion);
            exit;
        }
    }
