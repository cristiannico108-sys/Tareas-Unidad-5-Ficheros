<?php

    declare(strict_types=1);

    namespace Controllers;

    use Lib\Pages;
    use Models\Imagen;
    use Request\ImagenRequest;

    class ImagenController
    {
        private Pages $pagina;

        private Imagen $imagen;

        public function __construct()
        {
            $this->pagina = new Pages();
            $this->imagen = new Imagen();
        }

        public function mostrarFormulario(): void
        {
            $mensaje = ($_GET['subida'] ?? '') === 'ok' ? 'Imagen subida correctamente.' : null;

            $this->mostrar($mensaje, null);
        }

        public function subir(): void
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->mostrarFormulario();
                return;
            }

            $request = new ImagenRequest($_FILES['imagen'] ?? null);

            if (!$request->esValido()) {
                http_response_code(400);
                $this->mostrar(null, $request->error());
                return;
            }

            $nombre = $this->imagen->guardar($request->tmpName(), $request->extension());

            if ($nombre === null) {
                http_response_code(500);
                $this->mostrar(null, 'No se pudo guardar la imagen en el servidor.');
                return;
            }

            header('Location: index.php?controller=imagen&action=mostrarFormulario&subida=ok');
            exit;
        }

        private function mostrar(?string $mensaje, ?string $error): void
        {
            $this->pagina->render('Imagen/formulario', [
                'mensaje'  => $mensaje,
                'error'    => $error,
                'imagenes' => $this->imagen->listar(),
            ]);
        }
    }
