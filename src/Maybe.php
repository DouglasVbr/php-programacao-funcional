<?php

namespace src;

class Maybe
{
    private $valor;

    public function __construct($valor)
    {
        $this->valor = $valor;
    }

    public static function of($valor)
    {
        return new self($valor);
    }

    public function isNothing(): bool
    {
        return $this->valor === null;

    }

    public function getOrElse($default): bool
    {
        return $this->isNothing() ? $default : $this->valor;
    }

    public function map(callable $fn)
    {
        if ($this->isNothing()) {
            return Maybe::of($this->valor);
        }
        $valor = $fn($this->valor);
        return Maybe::of($valor);
    }
}

echo Maybe::of(10)
    ->map(fn ($numero) => $numero * 2)
    ->map(fn ($numero) => $numero + 10)
    ->getOrElse(0);