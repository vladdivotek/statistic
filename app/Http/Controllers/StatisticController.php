<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Services\FetchData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class StatisticController extends Controller
{
    public function index()
    {
        return view('statistic.index');
    }

    public function generate()
    {
        if (DB::table((new Statistic())->getTable())->count() == 0) $mergeItems = FetchData::getData();

        $statisticItems = DB::table((new Statistic())->getTable())
            ->select('ad_id', 'impressions', 'clicks', 'unique_clicks', 'leads', 'conversion', 'roi')
            ->get();

        return response()->json(['statisticItems' => $statisticItems]);
    }

    public function search(Request $request)
    {
        $request->validate(['ad_id' => 'required']);

        $searchResult = DB::table((new Statistic())->getTable())
            ->where('ad_id', $request->ad_id)
            ->select('ad_id', 'impressions', 'clicks', 'unique_clicks', 'leads', 'conversion', 'roi')
            ->get();

        return response()->json(['searchResult' => $searchResult]);
    }
}
