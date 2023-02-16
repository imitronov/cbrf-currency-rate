<?php

declare(strict_types=1);

namespace Imitronov\CbrfCurrencyRate;

use SimpleXMLElement;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new CurlHttpClient();
    }

    /**
     * @throws CbrfException
     */
    private function fetchXml(): string
    {
        try {
            $request = $this->httpClient->request(
                'GET',
                'https://cbr.ru/scripts/XML_daily.asp'
            );
        } catch (TransportExceptionInterface $exception) {
            throw new CbrfException(
                'Failed to connect to the CB RF.',
                100,
                $exception
            );
        }

        try {
            $xmlContent = $request->getContent();
        } catch (
            ClientExceptionInterface
            | RedirectionExceptionInterface
            | ServerExceptionInterface
            | TransportExceptionInterface $exception
        ) {
            throw new CbrfException(
                'Failed to receive a response from the CB RF.',
                110,
                $exception
            );
        }

        return $xmlContent;
    }

    /**
     * @throws CbrfException
     */
    public function getCurrencyRates(): iterable
    {
        $xml = $this->fetchXml();

        try {
            $xmlRoot = new SimpleXMLElement($xml);
        } catch (\Exception $exception) {
            throw new CbrfException(
                'Failed to parse response from CB RF.',
                200,
                $exception
            );
        }

        $xmlCurrencyRates = $xmlRoot->children();

        foreach ($xmlCurrencyRates as $xmlCurrencyRate) {
            $nominal = intval($xmlCurrencyRate->Nominal);
            $value = sprintf('%s', $xmlCurrencyRate->Value);
            $rate = bcdiv(
                str_replace(',', '.', $value),
                sprintf('%s', $nominal),
                intval(log($nominal * 10000, 10))
            );

            yield new CurrencyRate(
                sprintf('%s', $xmlCurrencyRate->attributes('ID')),
                intval($xmlCurrencyRate->NumCode),
                sprintf('%s', $xmlCurrencyRate->CharCode),
                $nominal,
                sprintf('%s', $xmlCurrencyRate->Name),
                floatval($value),
                $rate
            );
        }
    }

    /**
     * @throws CbrfException
     */
    public function getCurrencyRateByCharCode(string $charCode): ?CurrencyRate
    {
        foreach ($this->getCurrencyRates() as $currencyRate) {
            if ($charCode === $currencyRate->getCharCode()) {
                return $currencyRate;
            }
        }

        return null;
    }
}
