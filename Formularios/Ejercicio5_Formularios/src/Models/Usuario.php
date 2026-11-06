<?php

    declare(strict_types=1);

    namespace Models;

    class Usuario
    {
        public function __construct(
            public string $nombre = '',
            public string $password = ''
        )
        {}

        public static function fromArray(array $datos): self
        {
            return new self(
                nombre: trim((string) ($datos['nombre'] ?? '')),
                password: (string) ($datos['password'] ?? ''),
            );
        }

        public function getNombre(): string
        {
            return $this->nombre;
        }

        public function getPassword(): string
        {
            return $this->password;
        }
    }
