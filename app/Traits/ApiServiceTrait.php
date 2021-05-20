<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ApiServiceTrait {

    public function getAvailabilitiesFromDoctolib($EXTERNAL_ID) {
        $url = "https://tech-test.joovence.dev/api/doctolib/{$EXTERNAL_ID}/availabilities";

        $response = Http::get($url)->throw()->json();

        return $response;
    }

    public function getAvailabilitiesFromClicrdv($EXTERNAL_ID) {
        $url = "https://tech-test.joovence.dev/api/clic-rdv/availabilities?proId={$EXTERNAL_ID}";

        $response = Http::get($url)->throw()->json();

        return $response;
    }

}
