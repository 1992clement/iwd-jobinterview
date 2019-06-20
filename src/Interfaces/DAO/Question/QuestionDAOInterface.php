<?php
namespace IWD\JOBINTERVIEW\Interfaces\DAO\Question;

interface QuestionDAOInterface {
    public function getAggregatedAnswersBySurveyCodeAsJson($code);
}
