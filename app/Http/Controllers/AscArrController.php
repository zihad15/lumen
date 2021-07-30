<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;

class AscArrController extends Controller
{
    public function asc()
    {
        $arr = [];
        // $response = Curl::to('https://gist.github.com/Loetfi/fe38a350deeebeb6a92526f6762bd719')->get();
        $json = json_decode(file_get_contents(storage_path('app\filter-data.json')), true);
        $dataTarget = $json['data']['response']['billdetails'];

        sort($dataTarget);
        for ($i=0; $i < count($dataTarget); $i++) { 
            $cutString = str_replace("DENOM           : ", "", $dataTarget[$i]['body'][0]);
            if ((int) $cutString >= 100000) {
                array_push($arr, (int) $cutString);
            }
        }


        return $arr;
    }
}
