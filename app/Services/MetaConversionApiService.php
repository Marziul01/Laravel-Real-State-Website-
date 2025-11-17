<?php

namespace App\Services;

use App\Models\Seo;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;

class MetaConversionApiService
{
    public static function sendEvent($eventName, $eventData = [])
    {
        $setting = Seo::first();

        if (!$setting->meta_pixel_id || !$setting->meta_access_token) {
            return;
        }

        $url = "https://graph.facebook.com/v17.0/{$setting->meta_pixel_id}/events";

        $payload = [
            "data" => [
                [
                    "event_name" => $eventName,
                    "event_time" => time(),
                    "event_source_url" => url()->current(),
                    "user_data" => [
                        "client_ip_address" => request()->ip(),
                        "client_user_agent" => request()->userAgent(),
                    ],
                    "custom_data" => $eventData,
                    "action_source" => "website"
                ]
            ],
            "access_token" => $setting->meta_access_token
        ];

        if ($setting->meta_test_event_code) {
            $payload["test_event_code"] = $setting->meta_test_event_code;
        }

        return Http::post($url, $payload)->json();
    }
}
