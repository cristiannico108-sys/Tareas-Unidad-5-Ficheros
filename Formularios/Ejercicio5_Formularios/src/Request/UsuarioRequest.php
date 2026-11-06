<?php
    declare(strict_types=1);

    namespace Request;


    final class UsuarioRequest
    {
        private array $datos = [];

        private array $errores = [];

        public function __construct(array $entrada)
        {
            $this->sanear($entrada);
            $this->validar();
        }

        public function esValido(): bool
        {
            return $this->errores === [];
        }

        public function errores(): array
        {
            return $this->errores;
        }

        public function datos(): array
        {
            return $this->datos;
        }

        private function sanear(array $entrada): void
        {
            $texto = static fn(mixed $v): string => is_string($v) ? trim(strip_tags($v)) : '';

            $this->datos = [
                'nombre'   => $texto($entrada['nombre'] ?? ''),
                'password' => is_string($entrada['password'] ?? null) ? $entrada['password'] : '',
            ];
        }

        private function validar(): void
        {
            if ($this->datos['nombre'] === '') {
                $this->errores['nombre'] = 'El nombre de usuario es obligatorio.';
            }

            if ($this->datos['password'] === '') {
                $this->errores['password'] = 'La clave es obligatoria.';
            }
        }
    }
