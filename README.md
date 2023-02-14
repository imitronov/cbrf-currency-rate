# Получение курса валют ЦБ РФ

Данная библиотека забирает данные о курсе валют от Центрального Банка РФ.

Доки ЦБ РФ по используемой XML: https://cbr.ru/development/SXML/

## Установка
```shell
composer require imitronov/cbrf-currency-rate
```

## Использование
```php
<?php

// ...

use Imitronov\CbrfCurrencyRate\Client;

$cbrf = new Client();
$currencyRates = $cbrf->getCurrencyRates();

/**
 * Перебор всех доступных валют
 */
foreach ($currencyRates as $currencyRate) {
    echo sprintf(
        '1 %s = %s RUB' . PHP_EOL,
        $currencyRate->getCharCode(),
        $currencyRate->getRate()
    );
}

/**
 * Получение курса по нужной валюте
 */
$usdCurrencyRate = $cbrf->getCurrencyRateByCharCode('USD');

echo sprintf(
    '1 %s = %s RUB',
    $usdCurrencyRate->getCharCode(),
    $usdCurrencyRate->getRate(),
);

```
