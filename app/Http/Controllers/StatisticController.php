<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class StatisticController extends Controller
{
    public function generate()
    {
        $endpoint1Items = $endpoint2Items = $mergeItems = null;

        try {
            $responseEndpoint1 = Http::get('https://submitter.tech/test-task/endpoint1.json');
            $endpoint1Items = $responseEndpoint1->json();

            $responseEndpoint2 = Http::get('https://submitter.tech/test-task/endpoint2.json');
            $endpoint2Items = $responseEndpoint2->json()['data']['list'];
        } catch (Exception $e) {
            return response()->json('Error while fetching data from resources: ' . $e->getMessage());
        }

        try {
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
        } catch (Exception $e) {
            return response()->json('Error while processing data from resources: ' . $e->getMessage());
        }

        if (DB::table(Statistic::TABLE)->count() == 0) Statistic::query()->insert($mergeItems);

        $statisticItems = DB::table(Statistic::TABLE)
            ->select('ad_id', 'impressions', 'clicks', 'unique_clicks', 'leads', 'conversion', 'roi')
            ->get();

        dd($statisticItems);

        return response()->json(['statisticItems' => $statisticItems]);
    }
}
