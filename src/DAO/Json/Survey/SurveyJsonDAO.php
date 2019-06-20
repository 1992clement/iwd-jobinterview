<?php

namespace IWD\JOBINTERVIEW\DAO\Json\Survey;

use IWD\JOBINTERVIEW\Interfaces\DAO\Survey\SurveyDAOInterface;
use IWD\JOBINTERVIEW\DAO\Json\BaseJsonDAO;
use IWD\JOBINTERVIEW\Entity\Survey;

class SurveyJsonDAO extends BaseJsonDAO implements SurveyDAOInterface {
    /**
    * Extracts surveys from Json data file, returns Array of Survey objects
    * @return Survey[]
    **/
    public function getSurveys() {
        $surveys = array();
        $jsonData = $this->getDataFromDataFolder();
        foreach($jsonData as $surveyData) {
            $surveys[] = $this->serializer->deserialize(
                json_encode($surveyData->survey), Survey::class, 'json'
            );
        }
        $surveys = array_unique($surveys, SORT_REGULAR);
        return $surveys;
    }

    /**
    * Returns surveys encoded in JSON
    * @return string
    **/
    public function getSurveysAsJson() {
        return $this->serializer->serialize($this->getSurveys(), 'json');
    }
}
