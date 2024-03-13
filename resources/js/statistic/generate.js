import axios from 'axios';
window.axios = axios;

document.querySelector('#generate_data').addEventListener('click', function () {
    let submit = this;
    let action = submit.dataset.action;

    axios.get(action)
        .then(function (response) {
            if (response.data.fetchDataStatus) alert(response.data.fetchDataStatus.original);
            if (response.data.statisticItems.length > 0) {
                createTable(response.data.statisticItems);
                document.querySelector('#generate_data').remove();
            } else {
                alert('Error while fetching data from resources');
            }
        })
        .catch(function (error) {
            console.log(error);
        });
});

function createTable(statisticItems) {
    let table = document.getElementById('statisticData').getElementsByTagName('tbody')[0];
    let i = 1;

    table.innerHTML = '';

    statisticItems.forEach(function(item) {
        let row = table.insertRow();

        row.insertCell(0).innerText = i++;
        row.insertCell(1).innerText = item.ad_id;
        row.insertCell(2).innerText = item.impressions;
        row.insertCell(3).innerText = item.clicks;
        row.insertCell(4).innerText = item.unique_clicks;
        row.insertCell(5).innerText = item.leads;
        row.insertCell(6).innerText = item.conversion;
        row.insertCell(7).innerText = item.roi;
    });

    search();
}

function search() {
    document.querySelector('#open_search').style.display = 'block';
    document.querySelector('#search').addEventListener('click', function () {
        let search_button = this;
        let search_form = search_button.closest('form');
        let search_action = search_form.action;
        let modal_body = search_form.closest('#searchModal').querySelector('.modal-body');
        let form_group = modal_body.querySelector('.form-group');
        let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const data = {
            __token: csrf,
            'ad_id': search_button.closest('form').querySelector('#ad_id').value
        };

        axios.post(search_action, data)
            .then(function (response) {
                createSearchTable(response.data);
                if (form_group) {
                    form_group.remove();
                    search_button.remove();
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    });
}

function createSearchTable(data) {
    let outputData = 'No elements';

    if (data.searchResult.length > 0) {
        let search_results = document.querySelector('.search-results');
        let searchResult = data.searchResult[0];
        let html = '<p>Ad ID: ' + searchResult.ad_id + '</p>' +
            '<p>Impressions: ' + searchResult.impressions + '</p>' +
            '<p>Clicks: ' + searchResult.clicks + '</p>' +
            '<p>Unique clicks: ' + searchResult.unique_clicks + '</p>' +
            '<p>Leads: ' + searchResult.leads + '</p>'+
            '<p>Conversion: ' + searchResult.conversion + '</p>' +
            '<p>ROI: ' + searchResult.roi + '</p>';
        search_results.innerHTML = html;
    }
}

