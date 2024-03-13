<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Services\FetchData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index()
    {
        return view('statistic.index');
    }

    public function generate()
    {
        $fetchDataStatus = DB::table((new Statistic())->getTable())->count() == 0 ? FetchData::getData() : null;

        $statisticItems = DB::table((new Statistic())->getTable())
            ->select('ad_id', 'impressions', 'clicks', 'unique_clicks', 'leads', 'conversion', 'roi')
            ->get();

        return response()->json(['statisticItems' => $statisticItems, 'fetchDataStatus' => $fetchDataStatus]);
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
