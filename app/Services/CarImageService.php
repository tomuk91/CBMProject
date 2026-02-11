<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CarImageService
{
    /**
     * Get car image URL from Unsplash
     */
    public function getCarImage($make, $model, $year = null)
    {
        $cacheKey = 'car_image_' . strtolower($make) . '_' . strtolower($model) . '_' . $year;
        
        // Cache for 30 days
        return Cache::remember($cacheKey, 60 * 60 * 24 * 30, function () use ($make, $model, $year) {
            try {
                $query = $year ? "$year $make $model car" : "$make $model car";
                
                $response = Http::get('https://api.unsplash.com/search/photos', [
                    'query' => $query,
                    'per_page' => 1,
                    'orientation' => 'landscape',
                    'client_id' => config('services.unsplash.access_key')
                ]);

                if ($response->successful() && isset($response->json()['results'][0])) {
                    return $response->json()['results'][0]['urls']['regular'];
                }
            } catch (\Exception $e) {
                \Log::error('Car image fetch error: ' . $e->getMessage());
            }

            // Fallback to placeholder
            return $this->getPlaceholderImage($make);
        });
    }

    /**
     * Get placeholder image based on make
     */
    private function getPlaceholderImage($make)
    {
        // You can customize these or use a default car image
        $defaultImages = [
            'toyota' => 'https://images.unsplash.com/photo-1629897048514-3dd7414fe72a?w=800',
            'bmw' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=800',
            'mercedes' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=800',
            'audi' => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=800',
            'ford' => 'https://images.unsplash.com/photo-1612825173281-9a193378527e?w=800',
            'default' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800'
        ];

        $makeLower = strtolower($make);
        return $defaultImages[$makeLower] ?? $defaultImages['default'];
    }

    /**
     * Get manufacturer logo
     */
    public function getManufacturerLogo($make)
    {
        // Using Simple Icons CDN for car logos
        $makeLower = strtolower(str_replace(' ', '', $make));
        
        // Map common makes to their logo identifiers
        $logoMap = [
            'toyota' => 'toyota',
            'bmw' => 'bmw',
            'mercedes' => 'mercedesbenz',
            'audi' => 'audi',
            'ford' => 'ford',
            'honda' => 'honda',
            'nissan' => 'nissan',
            'volkswagen' => 'volkswagen',
            'vw' => 'volkswagen',
            'chevrolet' => 'chevrolet',
            'hyundai' => 'hyundai',
            'kia' => 'kia',
            'mazda' => 'mazda',
            'subaru' => 'subaru',
            'lexus' => 'lexus',
            'porsche' => 'porsche',
            'tesla' => 'tesla',
        ];

        if (isset($logoMap[$makeLower])) {
            return "https://cdn.simpleicons.org/{$logoMap[$makeLower]}/dc2626";
        }

        return null;
    }
}
