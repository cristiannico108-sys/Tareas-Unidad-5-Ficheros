<?php
    declare(strict_types=1);

    namespace Request;


    final class ImagenRequest
    {
        public const array TIPOS_PERMITIDOS = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
        ];

        private const array ERRORES_PHP = [
            UPLOAD_ERR_INI_SIZE   => 'El archivo supera el tamaño máximo permitido por el servidor.',
            UPLOAD_ERR_FORM_SIZE  => 'El archivo supera el tamaño máximo permitido.',
            UPLOAD_ERR_PARTIAL    => 'El archivo se subió solo parcialmente. Inténtalo de nuevo.',
            UPLOAD_ERR_NO_TMP_DIR => 'Error del servidor: falta la carpeta temporal.',
            UPLOAD_ERR_CANT_WRITE => 'Error del servidor: no se pudo escribir el archivo.',
            UPLOAD_ERR_EXTENSION  => 'Una extensión de PHP detuvo la subida.',
        ];

        private ?string $error = null;

        private string $tmpName = '';

        private string $extension = '';

        public function __construct(mixed $archivo)
        {
            $this->validar($archivo);
        }

        public function esValido(): bool
        {
            return $this->error === null;
        }

        public function error(): ?string
        {
            return $this->error;
        }

        public function tmpName(): string
        {
            return $this->tmpName;
        }


        public function extension(): string
        {
            return $this->extension;
        }

        private function validar(mixed $archivo): void
        {
            if (!is_array($archivo) || !isset($archivo['error'], $archivo['tmp_name'], $archivo['size'])) {
                $this->error = 'No se ha recibido ningún archivo (puede superar el tamaño máximo del servidor).';
                return;
            }

            if (!is_int($archivo['error']) || !is_string($archivo['tmp_name']) || !is_int($archivo['size'])) {
                $this->error = 'La petición no tiene un formato válido.';
                return;
            }

            if ($archivo['error'] === UPLOAD_ERR_NO_FILE) {
                $this->error = 'No has seleccionado ningún archivo.';
                return;
            }

            if ($archivo['error'] !== UPLOAD_ERR_OK) {
                $this->error = self::ERRORES_PHP[$archivo['error']] ?? 'Error desconocido al subir el archivo.';
                return;
            }

            if (!is_uploaded_file($archivo['tmp_name'])) {
                $this->error = 'El archivo no procede de una subida válida.';
                return;
            }

            if ($archivo['size'] <= 0) {
                $this->error = 'El archivo está vacío.';
                return;
            }

            if ($archivo['size'] > MAX_IMAGE_BYTES) {
                $this->error = 'La imagen supera el tamaño máximo de ' . (MAX_IMAGE_BYTES / 1024 / 1024) . ' MB.';
                return;
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = $finfo === false ? false : finfo_file($finfo, $archivo['tmp_name']);

            if ($mime === false || !array_key_exists($mime, self::TIPOS_PERMITIDOS)) {
                $this->error = 'El archivo no es una imagen permitida (solo JPEG, PNG, GIF o WebP).';
                return;
            }

            if (@getimagesize($archivo['tmp_name']) === false) {
                $this->error = 'El archivo está dañado o no es una imagen válida.';
                return;
            }

            $this->tmpName   = $archivo['tmp_name'];
            $this->extension = self::TIPOS_PERMITIDOS[$mime];
        }
    }
