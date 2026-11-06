<?php
    declare(strict_types=1);

    namespace Request;

    final class CandidatoRequest
    {
        public const array SITUACIONES = [
            'sin_empleo'      => 'Sin empleo',
            'media_jornada'   => 'Media jornada',
            'tiempo_completo' => 'Tiempo completo',
        ];

        public const array LENGUAJES = ['Python', 'PHP', 'JavaScript', 'Java', 'C++'];

        private array $datos = [];

        private array $errores = [];

        private bool $lenguajesNoEsArray = false;

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

        public function datosValidos(): array
        {
            return array_diff_key($this->datos, $this->errores);
        }

        // ---------------------------------------------------------------- SANEAR

        private function sanear(array $entrada): void
        {
            $texto = static fn(mixed $v): string => is_string($v)
                ? trim((string) preg_replace('/\s+/', ' ', strip_tags($v)))
                : '';

            $lenguajes = $entrada['lenguajes'] ?? [];
            if (!is_array($lenguajes)) {
                $this->lenguajesNoEsArray = true;
                $lenguajes = [];
            }

            $this->datos = [
                'nombre'    => $texto($entrada['nombre'] ?? ''),
                'apellidos' => $texto($entrada['apellidos'] ?? ''),
                'correo'    => filter_var($texto($entrada['correo'] ?? ''), FILTER_SANITIZE_EMAIL),
                'telefono'  => preg_replace('/[\s.\-]/', '', $texto($entrada['telefono'] ?? '')),
                'situacion' => $texto($entrada['situacion'] ?? ''),
                'lenguajes' => array_values(array_unique(array_map($texto, $lenguajes))),
                'url'       => filter_var($texto($entrada['url'] ?? ''), FILTER_SANITIZE_URL),
            ];
        }


        private function validar(): void
        {
            $this->validarNombre('nombre');
            $this->validarNombre('apellidos');
            $this->validarCorreo();
            $this->validarTelefono();
            $this->validarSituacion();
            $this->validarLenguajes();
            $this->validarUrl();
        }

        private function validarNombre(string $campo): void
        {
            $valor = $this->datos[$campo];

            $longitud = (int) preg_match_all('/./su', $valor);

            if ($valor === '') {
                $this->errores[$campo] = 'Este campo es obligatorio.';
            } elseif ($longitud < 2 || $longitud > 60) {
                $this->errores[$campo] = 'Debe tener entre 2 y 60 caracteres.';
            } elseif (!preg_match("/^[\p{L}][\p{L} '\-]*$/u", $valor)) {
                $this->errores[$campo] = 'Solo puede contener letras, espacios, apóstrofos y guiones.';
            }
        }

        private function validarCorreo(): void
        {
            $correo = $this->datos['correo'];

            if ($correo === '') {
                $this->errores['correo'] = 'Este campo es obligatorio.';
            } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $this->errores['correo'] = 'El correo electrónico no tiene un formato válido.';
            }
        }

        private function validarTelefono(): void
        {
            $telefono = $this->datos['telefono'];

            if ($telefono === '') {
                $this->errores['telefono'] = 'Este campo es obligatorio.';
            } elseif (!preg_match('/^\+?\d{9,15}$/', $telefono)) {
                $this->errores['telefono'] = 'El teléfono debe tener entre 9 y 15 dígitos (puede empezar por +).';
            }
        }

        private function validarSituacion(): void
        {
            $situacion = $this->datos['situacion'];

            if ($situacion === '') {
                $this->errores['situacion'] = 'Debes seleccionar tu situación laboral.';
            } elseif (!in_array($situacion, array_keys(self::SITUACIONES), true)) {
                $this->errores['situacion'] = 'La situación laboral seleccionada no es válida.';
            }
        }

        private function validarLenguajes(): void
        {
            if ($this->lenguajesNoEsArray) {
                $this->errores['lenguajes'] = 'El formato de los lenguajes no es válido.';
                return;
            }

            $lenguajes = $this->datos['lenguajes'];

            if ($lenguajes === []) {
                $this->errores['lenguajes'] = 'Debes seleccionar al menos un lenguaje.';
                return;
            }

            $noPermitidos = array_filter(
                $lenguajes,
                static fn(string $l): bool => !in_array($l, self::LENGUAJES, true)
            );

            if ($noPermitidos !== []) {
                $this->errores['lenguajes'] = 'Hay lenguajes no permitidos entre los seleccionados.';
            }
        }

        private function validarUrl(): void
        {
            $url = $this->datos['url'];

            if ($url === '') {
                $this->errores['url'] = 'Este campo es obligatorio.';
                return;
            }

            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $this->errores['url'] = 'La URL no es válida.';
                return;
            }

            $esquema = strtolower((string) parse_url($url, PHP_URL_SCHEME));
            if (!in_array($esquema, ['http', 'https'], true)) {
                $this->errores['url'] = 'La URL debe empezar por http:// o https://.';
            }
        }
    }
