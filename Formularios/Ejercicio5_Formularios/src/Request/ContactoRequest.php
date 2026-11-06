<?php
    declare(strict_types=1);

    namespace Request;

    final class ContactoRequest
    {
        public const array METODOS_PAGO = ['VISA', 'MASTERCARD', 'PAYPAL'];

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
                'nombre'      => $texto($entrada['nombre'] ?? ''),
                'apellidos'   => $texto($entrada['apellidos'] ?? ''),
                'correo'      => $texto($entrada['correo'] ?? ''),
                'metodosPago' => is_array($entrada['metodosPago'] ?? null)
                    ? array_map($texto, $entrada['metodosPago'])
                    : [],
                'marcar'      => isset($entrada['marcar']),
                'password'    => is_string($entrada['password'] ?? null) ? $entrada['password'] : '',
            ];
        }

        private function validar(): void
        {
            if ($this->datos['nombre'] === '') {
                $this->errores['nombre'] = 'El nombre es obligatorio.';
            }

            if ($this->datos['apellidos'] === '') {
                $this->errores['apellidos'] = 'Los apellidos son obligatorios.';
            }

            if (!filter_var($this->datos['correo'], FILTER_VALIDATE_EMAIL)) {
                $this->errores['correo'] = 'El correo no es válido.';
            }

            foreach ($this->datos['metodosPago'] as $metodo) {
                if (!in_array($metodo, self::METODOS_PAGO, true)) {
                    $this->errores['metodosPago'] = 'Método de pago no válido.';
                    break;
                }
            }

            if (!$this->datos['marcar']) {
                $this->errores['marcar'] = 'Debes aceptar los términos y condiciones.';
            }
        }
    }