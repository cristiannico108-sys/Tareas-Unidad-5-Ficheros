<?php

    declare(strict_types=1);

    namespace Controllers;

    use Models\Contacto;
    use Lib\Pages;
    use Request\ContactoRequest;

    class ContactoController
    {
        private Pages $pagina;

        public function __construct()
        {
            $this->pagina = new Pages();
        }

        public function mostrarFormulario()
        {
            $this->pagina->render('Contacto/formulario');
        }

        public function procesar(): void
        {
            if($_SERVER['REQUEST_METHOD'] !== 'POST') 
                {
                    $this->mostrarFormulario();
                    return;
                }

            $contacto = Contacto::fromArray($_POST['contacto'] ?? []);

            $this->pagina->render('Contacto/resultado', [
                'nombre'    => $contacto->getNombre(),
                'apellidos' => $contacto->apellidos,
            ]);
        }
    }