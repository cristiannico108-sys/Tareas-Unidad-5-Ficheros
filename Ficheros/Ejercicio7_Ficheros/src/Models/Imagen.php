<?php

    declare(strict_types=1);

    namespace Models;

    class Imagen
    {
        private const array EXTENSIONES = ['jpg', 'png', 'gif', 'webp'];

        public function guardar(string $tmpName, string $extension): ?string
        {
            if (!is_dir(IMAGES_DIR) && !mkdir(IMAGES_DIR, 0755, true) && !is_dir(IMAGES_DIR)) {
                return null;
            }

            $nombre = bin2hex(random_bytes(8)) . '.' . $extension;

            if (!move_uploaded_file($tmpName, IMAGES_DIR . '/' . $nombre)) {
                return null;
            }

            return $nombre;
        }

        public function listar(): array
        {
            if (!is_dir(IMAGES_DIR)) {
                return [];
            }

            $imagenes = [];

            foreach (scandir(IMAGES_DIR) ?: [] as $archivo) {
                $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));

                if (in_array($extension, self::EXTENSIONES, true)) {
                    $imagenes[$archivo] = (int) filemtime(IMAGES_DIR . '/' . $archivo);
                }
            }

            asort($imagenes);   // por fecha de subida

            return array_keys($imagenes);
        }
    }
