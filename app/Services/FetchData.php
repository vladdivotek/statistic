<?php

namespace App\Services;

use App\Models\Statistic;
use Exception;
use Illuminate\Support\Facades\Http;

class FetchData
{
    public static function getData()
    {
        $endpoint1Items = $endpoint2Items = $mergeItems = null;
        $endpoint1Url = config('statistic.endpoint_1');
        $endpoint2Url = config('statistic.endpoint_2');

        if (!$endpoint1Url || !$endpoint2Url) return response()->json('Endpoints urls doesnt exist');

        try {
            $responseEndpoint1 = Http::get($endpoint1Url);
            $endpoint1Items = $responseEndpoint1->json();

            $responseEndpoint2 = Http::get($endpoint2Url);
            $endpoint2Items = $responseEndpoint2->json()['data']['list'];
        } catch (Exception $e) {
            return response()->json('Error while fetching data from resources: ' . $e->getMessage());
        }

        if (count($endpoint1Items) > 0 && count($endpoint2Items) > 0) {
            foreach ($endpoint1Items as $endpoint1Item) {
                foreach ($endpoint2Items as $endpoint2Item) {
                    if ($endpoint1Item['name'] == $endpoint2Item['dimensions']['ad_id']) {
                        $mergeItems[] = [
                            'ad_id' => $endpoint2Item['dimensions']['ad_id'],
                            'impressions' => $endpoint2Item['metrics']['impressions'],
                            'clicks' => $endpoint1Item['clicks'],
                            'unique_clicks' => $endpoint1Item['unique_clicks'],
                            'leads' => $endpoint1Item['leads'],
                            'conversion' => $endpoint2Item['metrics']['conversion'],
                            'roi' => $endpoint1Item['roi']
                        ];
                    }
                }
            }

            usort($mergeItems, function($a, $b) {
                return $b['impressions'] - $a['impressions'];
            });

            Statistic::query()->insert($mergeItems);
        } else {
            return response()->json('Error while processing data from resources.');
        }

        return response()->json('Success');
    }
}
