<?php

declare(strict_types=1);

namespace Imitronov\CbrfCurrencyRate;

class CurrencyRate
{
    public function __construct(
        private string $id,
        private int $numCode,
        private string $charCode,
        private int $nominal,
        private string $name,
        private float $value,
        private string $rate,
    ) {
    }

    /**
     * Внутренний уникальный код валюты
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * ISO Цифровой код валюты
     */
    public function getNumCode(): int
    {
        return $this->numCode;
    }

    /**
     * ISO Буквенный код валюты
     */
    public function getCharCode(): string
    {
        return $this->charCode;
    }

    /**
     * Номинал
     */
    public function getNominal(): int
    {
        return $this->nominal;
    }

    /**
     * Название валюты
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Стоимость в рублях за указанный номинал
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * Стоимость в рублях за 1 единицу валюты
     */
    public function getRate(): string
    {
        return $this->rate;
    }
}
