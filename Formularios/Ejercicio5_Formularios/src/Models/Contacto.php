<?php

    declare(strict_types=1);

    namespace Models;

    class Contacto
    {
        public function __construct(
            public string $nombre = '',
            public string $apellidos = '',
            public string $correo = '',
            public array $metodosPago = [],
            public bool $marcar = false,
        )
        {}

        public static function fromArray(array $datos): self
        {
            return new self(
                nombre: trim($datos['nombre'] ?? ''),
                apellidos: trim($datos['apellidos'] ?? ''),
                correo: trim($datos['correo'] ?? ''),
                metodosPago: $datos['MetodosPago'] ?? [],
                marcar: isset($datos['marcar']),
            );
        }

        function getNombre(): string
        {
            return $this->nombre;
        }
    }