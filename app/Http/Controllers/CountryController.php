<?php


namespace App\Http\Controllers;


use App\Http\Requests\CountryGetCitiesRequest;
use App\Imports\CountryImport;
use App\Models\Country;
use App\Traits\ApiResponser;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CountryController extends Controller
{
    use ApiResponser;

    public function import(Request $request)
    {
        Excel::import(new CountryImport(), '../public/countries.xlsx');
        return 'success';
    }

    public function index(Request $request)
    {
        $key = isset($request->key) ? $request->key : '';
        $countries = Country::where('name', 'like', '%' . $key . '%')->get();
        $data['datas'] = $countries;
        return $this->successResponseMessage($data, 200, 'Get countries success');
    }

    public function cities(CountryGetCitiesRequest $request)
    {
        $name = $request->get('name');
        if (!$name) {
            return $this->errorMessage('City Not Found!', 404);
        }

        $client = new Client();
        $key = env('GOOGLE_API_KEY');
        $uri = "https://maps.googleapis.com/maps/api/place/autocomplete/json?key=$key&input=$name&types=(cities)";
        $response = $client->get($uri);
        $json = json_decode($response->getBody(), true);
        if ($response->getStatusCode() != 200) {
            return $this->errorMessage(json_encode($json), $response->getStatusCode());
        }

        $items = $json['predictions'];
        $results = [];
        foreach ($items as $item) {
            $results[] = (object)['name' => $item['description'], 'short_name' => $item['terms'][0]['value']];
        }

        return $this->successResponse($results);
    }
}
