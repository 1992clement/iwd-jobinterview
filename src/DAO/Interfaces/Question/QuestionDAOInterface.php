<?php
namespace IWD\JOBINTERVIEW\DAO\Interfaces\Question;

interface QuestionDAOInterface {
    public function getAggregatedAnswersBySurveyCodeAsJson($code);
}
