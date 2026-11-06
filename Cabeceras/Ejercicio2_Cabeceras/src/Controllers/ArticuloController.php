<?php

    declare(strict_types=1);

    namespace Controllers;

    use Lib\Pages;
    use Models\Articulo;
    use Request\ArticuloRequest;

    class ArticuloController
    {
        private Pages $pagina;

        public function __construct()
        {
            $this->pagina = new Pages();
        }

        public function mostrarFormulario(): void
        {
            $this->pagina->render('Articulo/formulario');
        }

        public function buscar(): void
        {
            $request = new ArticuloRequest($_GET);

            if (!$request->esValido()) {
                http_response_code($request->codigoHttp());
                $this->pagina->render('Articulo/error', [
                    'titulo'  => 'Petición no válida',
                    'mensaje' => $request->error(),
                ]);
                return;
            }

            $id       = $request->id();
            $articulo = (new Articulo())->buscarPorId($id);

            if ($articulo === null) {
                http_response_code(404);
                $this->pagina->render('Articulo/error', [
                    'titulo'   => 'Artículo no encontrado',
                    'mensaje'  => 'Lo sentimos, el artículo que estás buscando no existe.',
                    'idBuscado' => $id,
                ]);
                return;
            }

            http_response_code(200);
            $this->pagina->render('Articulo/resultado', [
                'articulo'  => $articulo,
                'idBuscado' => $id,
            ]);
        }
    }
