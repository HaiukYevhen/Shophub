<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class ExchangeRateService
{
    public function getUsdToUahRate(): float
    {
        return Cache::remember('exchange_rate.usd_uah', now()->addHour(), function () {
            try {
                $response = Http::timeout(10)
                    ->get('https://api.frankfurter.dev/v2/rate/usd/uah');

                $response->throw();

                $rate = $response->json('rate');

                if (!is_numeric($rate) || $rate <= 0) {
                    throw new RuntimeException('Invalid exchange rate received.');
                }

                return (float) $rate;
            } catch (\Throwable $exception) {
                Log::error('Failed to retrieve USD to UAH exchange rate.', [
                    'message' => $exception->getMessage(),
                ]);

                throw new RuntimeException(
                    'Unable to retrieve the exchange rate.',
                    0,
                    $exception
                );
            }
        });
    }

    public function convertUsdToUah(float $amount): float
    {
        return round($amount * $this->getUsdToUahRate(), 2);
    }
}
