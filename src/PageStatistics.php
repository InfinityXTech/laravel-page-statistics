<?php

namespace InfinityXTech\PageStatistics;

use DeviceDetector\DeviceDetector;
use GeoIp2\Database\Reader;
use Illuminate\Database\Eloquent\Model;

class PageStatistics {
    public function getDetails () {
        // Get the user agent and IP address
        $userAgent = request()->userAgent();
        $ipAddress = request()->ip();

        // Device Detection
        $deviceDetector = new DeviceDetector($userAgent);
        $deviceDetector->parse();
        $deviceType = $deviceDetector->getDeviceName(); // 'phone', 'tablet', 'desktop', or 'other'
        $deviceData = $deviceDetector->getDevice(); // All device data
        $clientInfo = $deviceDetector->getClient(); // holds information about browser, feed reader, media player, ...
        $osInfo = $deviceDetector->getOs();

        if (!in_array($ipAddress, ['127.0.0.1', '::1'])) {
            // IP Geolocation
            $reader = new Reader(config('laravel-page-statistics.geoip_db_path', resource_path('data/geo.mmdb')));
            $geoInfo = $reader->city($ipAddress);
            $countryName = $geoInfo->country->name;
            $cityName = $geoInfo->city->name;
            $countryCode = $geoInfo->country->isoCode; // 'CA' for Canada, etc.

            // Prepare location and meta information

            $locationMeta = [
                'country' => $countryName,
                'city' => $cityName,
                'short_code' => $countryCode,
                'ip_address' => $ipAddress,
            ];

            $deviceMeta = [
                'name' => $deviceType,
                'data' => $deviceData
            ];

            return [
                'location' => $locationMeta,
                'device' => $deviceMeta,
                'os' => $osInfo,
                'client' => $clientInfo,
            ];
        }
    }

    public function record (Model $model, $data = []) {
        if (empty($data)) {
            $data = $this->getDetails($model, );
        }

        // Record the view with additional data
        $view = views($model)
            ->location($data['location']['short_code'])
            ->device($data['device']['name'])
            ->os($data['os']['name'])
            ->browser($data['client']['name'])
            ->meta($data);

        $view->record();

        return $view;
    }
}
