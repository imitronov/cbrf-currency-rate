<?php

declare(strict_types=1);

namespace Imitronov\CbrfCurrencyRate;

class CurrencyRate
{
    private $rate;

    private $value;

    private $name;

    private $nominal;

    private $charCode;

    private $numCode;

    private $id;

    public function __construct(
        string $id,
        int $numCode,
        string $charCode,
        int $nominal,
        string $name,
        float $value,
        string $rate
    ) {
        $this->id = $id;
        $this->numCode = $numCode;
        $this->charCode = $charCode;
        $this->nominal = $nominal;
        $this->name = $name;
        $this->value = $value;
        $this->rate = $rate;
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
