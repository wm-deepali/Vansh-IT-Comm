<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GeoIpService
{
    /**
     * Best-effort IP lookup. Never throws, so a failed lookup
     * can't break login.
     */
    public static function lookup(?string $ip): array
    {
        $empty = ['city' => null, 'country' => null, 'isp' => null];

        if (!$ip) {
            return $empty;
        }

        // Private / local IPs can't be geolocated
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return ['city' => 'Local', 'country' => 'Local', 'isp' => 'Local Network'];
        }

        return Cache::remember('geoip:' . $ip, now()->addDay(), function () use ($ip, $empty) {
            try {
                $response = Http::timeout(3)
                    ->get("http://ip-api.com/json/{$ip}", [
                        'fields' => 'status,country,city,isp',
                    ]);

                if ($response->successful() && $response->json('status') === 'success') {
                    return [
                        'city'    => $response->json('city'),
                        'country' => $response->json('country'),
                        'isp'     => $response->json('isp'),
                    ];
                }
            } catch (\Throwable $e) {
                // ignore, fall through to empty result
            }

            return $empty;
        });
    }
}