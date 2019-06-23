<?php
class  ModelLocalisationNovaposhta extends Model {

    public function getDepart($cityId) {

        $request = <<<STR
        {
            "modelName": "AddressGeneral",
            "calledMethod": "getWarehouses",
            "methodProperties": {
            "CityRef": "$cityId"
            },
            "apiKey": "2122e3829f90f8b42e1213abfc310c6b"
        }
STR;
        $response = $this->getData($request);

        return $response;
    }

    public function getCities()
    {
        $cities = [];
        $request = <<<STR
        {
            "modelName": "Address",
            "calledMethod": "getCities",
            "apiKey": "2122e3829f90f8b42e1213abfc310c6b"
        }
STR;
        $response = $this->getData($request);
        $result = json_decode($response);
        foreach ($result->data as $item) {
            $cities[] = ['name' => $item->Description, 'city_id' => $item->Ref];
        }

        return $cities;
    }

    private function getData($request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.novaposhta.ua/v2.0/json/",
            CURLOPT_RETURNTRANSFER => True,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $request,
            CURLOPT_HTTPHEADER => array("content-type: application/json",),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}


