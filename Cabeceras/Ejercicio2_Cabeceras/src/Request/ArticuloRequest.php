<?php
    declare(strict_types=1);

    namespace Request;

    final class ArticuloRequest
    {
        private string $id = '';

        private ?string $error = null;

        public function __construct(array $entrada)
        {
            $this->sanear($entrada);
            $this->validar($entrada);
        }

        public function esValido(): bool
        {
            return $this->error === null;
        }

        public function error(): ?string
        {
            return $this->error;
        }

        public function codigoHttp(): int
        {
            return $this->esValido() ? 200 : 400;
        }

        public function id(): int
        {
            return (int) $this->id;
        }

        private function sanear(array $entrada): void
        {

            $this->id = is_string($entrada['id'] ?? null) ? trim($entrada['id']) : '';
        }

        private function validar(array $entrada): void
        {
            if (isset($entrada['id']) && !is_string($entrada['id'])) {
                $this->error = 'El identificador no tiene un formato válido.';
                $this->id = '';
                return;
            }

            if ($this->id === '') {
                $this->error = 'No has introducido ningún identificador.';
                return;
            }


            if (!preg_match('/^[1-9][0-9]{0,8}$/', $this->id)) {
                $this->error = 'El identificador no tiene un formato válido: debe ser un número entero positivo.';
            }
        }
    }
