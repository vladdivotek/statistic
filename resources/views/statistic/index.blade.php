@extends('layouts.app')

@section('content')
    <div class="table-responsive">
        <table id="statisticData" class="table table-striped table-bordered">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ad ID</th>
                <th scope="col">Impressions</th>
                <th scope="col">Clicks</th>
                <th scope="col">Unique clicks</th>
                <th scope="col">Leads</th>
                <th scope="col">Conversion</th>
                <th scope="col">ROI</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="d-flex align-items-center justify-content-center mt-3">
        <button type="button" id="generate_data" class="btn btn-warning" data-action="{{ route('statistic.generate') }}">Generate data</button>
    </div>
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="searchModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="get" action="{{ route('statistic.search') }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="number" id="ad_id" name="ad_id" class="form-control" placeholder="Ad ID" required>
                        </div>
                        <div class="search-results"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="search" class="btn btn-warning">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/statistic/generate.js')
@endsection
