<?php

    declare(strict_types=1);

    namespace Models;


    class Articulo
    {
        private const array ARTICULOS = [
            1 => [
                'id'          => 1,
                'nombre'      => 'Teclado mecánico',
                'descripcion' => 'Teclado mecánico con interruptores rojos y retroiluminación RGB.',
                'precio'      => 79.90,
            ],
            2 => [
                'id'          => 2,
                'nombre'      => 'Ratón inalámbrico',
                'descripcion' => 'Ratón ergonómico inalámbrico con 6 botones y batería recargable.',
                'precio'      => 24.50,
            ],
            3 => [
                'id'          => 3,
                'nombre'      => 'Monitor 27 pulgadas',
                'descripcion' => 'Monitor IPS de 27 pulgadas con resolución QHD y 144 Hz.',
                'precio'      => 299.00,
            ],
            4 => [
                'id'          => 4,
                'nombre'      => 'Auriculares con micrófono',
                'descripcion' => 'Auriculares cerrados con micrófono desmontable y cancelación de ruido.',
                'precio'      => 59.99,
            ],
        ];

        public function buscarPorId(int $id): ?array
        {
            return self::ARTICULOS[$id] ?? null;
        }
    }
