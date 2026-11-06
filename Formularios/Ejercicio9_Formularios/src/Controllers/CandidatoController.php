<?php

    declare(strict_types=1);

    namespace Controllers;

    use Lib\Pages;
    use Request\CandidatoRequest;

    class CandidatoController
    {
        private Pages $pagina;

        public function __construct()
        {
            $this->pagina = new Pages();
        }

        public function mostrarFormulario(): void
        {
            $this->pagina->render('Candidato/formulario', [
                'situaciones' => CandidatoRequest::SITUACIONES,
                'lenguajes'   => CandidatoRequest::LENGUAJES,
            ]);
        }

        public function procesar(): void
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->mostrarFormulario();
                return;
            }


            $entrada = $_POST['candidato'] ?? [];
            if (!is_array($entrada)) {
                $entrada = [];
            }

            $request = new CandidatoRequest($entrada);

            $this->pagina->render('Candidato/resultado', [
                'valido'      => $request->esValido(),
                'datos'       => $request->datosValidos(),
                'errores'     => $request->errores(),
                'situaciones' => CandidatoRequest::SITUACIONES,
            ]);
        }
    }
