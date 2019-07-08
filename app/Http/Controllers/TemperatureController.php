<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class TemperatureController extends Controller
{
    //

    public function show()
    {
        $client = new Client(['base_uri' => 'https://testslate.atlassian.net/rest/api/3/']);

        $response = $client->request(
            'GET',
            'filter/search', [
            'headers' => [
                'Authorization' => "Basic " . base64_encode("korets.dmytro@pdffiller.team:KbMHUmjBxH39KmytnYh350A6")
            ]]);

        $filters = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        $filters = $filters['values'];

        return view('filters', compact('filters'));
    }

    function print_arr($arr)
    {

    }
}

//curl -v https://testslate.atlassian.net/rest/api/3/filter/search --user "korets.dmytro@pdffiller.team:KbMHUmjBxH39KmytnYh350A6"