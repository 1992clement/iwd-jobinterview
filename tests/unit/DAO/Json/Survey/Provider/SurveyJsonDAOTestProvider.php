<?php
namespace Tests\unit\DAO\Json\Survey\Provider;

class SurveyJsonDAOTestProvider {
    public function provideMockJsonSurveys() {
        return json_encode(array(
            array(
                "code" => "XX1",
                "name" => "Paris"
            ),
            array(
                "code" => "256579XX",
                "name" => "Paris"
            )
        ));
    }
}
