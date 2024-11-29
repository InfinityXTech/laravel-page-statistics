<?php

namespace InfinityXTech\PageStatistics;

use DeviceDetector\DeviceDetector;
use GeoIp2\Database\Reader;
use Illuminate\Database\Eloquent\Model;

class PageStatistics {
    public function getDeviceData () {
        // Device Detection
        $userAgent = request()->userAgent();

        $deviceDetector = new DeviceDetector($userAgent);
        $deviceDetector->parse();
        $deviceType = $deviceDetector->getDeviceName(); // 'phone', 'tablet', 'desktop', or 'other'
        $deviceData = $deviceDetector->getDevice(); // All device data
        $clientInfo = $deviceDetector->getClient(); // holds information about browser, feed reader, media player, ...
        $osInfo = $deviceDetector->getOs();
        
        return [
            'device' => [
                'name' => $deviceType,
                'data' => $deviceData
            ],
            'os' => $osInfo,
            'client' => $clientInfo,
        ];
    }

    public function getLocationData () {
        $ipAddress = request()->ip();

        if (!in_array($ipAddress, ['127.0.0.1', '::1']) && $geoIpDB = config('laravel-page-statistics.geoip_db_path')) {

            $reader = new Reader($geoIpDB);
            $geoInfo = $reader->city($ipAddress);
            $countryName = $geoInfo->country->name;
            $cityName = $geoInfo->city->name;
            $countryCode = $geoInfo->country->isoCode;

            return [
                'country' => $countryName,
                'city' => $cityName,
                'short_code' => $countryCode,
                'ip_address' => $ipAddress,
            ];

        }
    }

    public function getDetails () {

        $data = $this->getDeviceData();

        $data['location'] = $this->getLocationData();

        return $data;
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
