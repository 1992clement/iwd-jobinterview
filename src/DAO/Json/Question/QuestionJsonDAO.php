<?php

namespace IWD\JOBINTERVIEW\DAO\Json\Question;

use IWD\JOBINTERVIEW\DAO\Interfaces\Question\QuestionDAOInterface;
use IWD\JOBINTERVIEW\DAO\Json\BaseJsonDAO;
use IWD\JOBINTERVIEW\Entity\Question;

class QuestionJsonDAO extends BaseJsonDAO implements QuestionDAOInterface {

    const QUESTION_TYPE_QCM = 'qcm';
    const QUESTION_TYPE_DATE = 'date';
    const QUESTION_TYPE_NUMERIC = 'numeric';

    /**
    * Returns the aggregated answers to the different questions found in a specific survey, encoded in JSON
    * @param string $code : code of the survey
    * @return string : JSON encoded list of the questions/answers. See /main.raml for structure example.
    **/
    public function getAggregatedAnswersBySurveyCodeAsJson($code) {
        return $this->serializer->serialize($this->getAggregatedAnswersBySurveyCode($code), 'json');
    }

    /**
    * Returns the aggregated answers to the different questions found in a specific survey
    * @param string $code : code of the survey
    * @return array()
    **/
    private function getAggregatedAnswersBySurveyCode($code) {
        $data = $this->getQuestionsBySurveyCode($code);
        $data = $this->sortQuestionsByType($data);
        //Assuming we might have several questions of same type, but different label in the future
        foreach($data as $type => $questions) {
            $data[$type] = $this->sortQuestionsByLabel($questions);
        }

        foreach ($data as $type => $questionsByLabel) {
            $questionsByTypeAndLabel = array();
            foreach ($questionsByLabel as $questions) {
                switch ($type) {
                    case self::QUESTION_TYPE_QCM :
                        $questionsByTypeAndLabel[] = $this->aggregateQcmAnswers($questions);
                        break;
                    case self::QUESTION_TYPE_NUMERIC :
                        $questionsByTypeAndLabel[] = $this->aggregateNumericAnswers($questions);
                        break;
                    case self::QUESTION_TYPE_DATE :
                        $questionsByTypeAndLabel[] = $this->aggregateDateAnswers($questions);
                        break;
                }
            }
            $data[$type] = $questionsByTypeAndLabel;
        }

        return $data;
    }

    /**
    * @param string $code : Code of the survey
    * @return Question[]
    **/
    private function getQuestionsBySurveyCode($code) {
        $result = array();
        $jsonData = $this->getDataFromDataFolder();
        foreach($jsonData as $surveyData) {
            if($surveyData->survey->code === $code) {
                foreach ($surveyData->questions as $question) {
                    $result[] = $this->serializer->deserialize(
                        json_encode($question), Question::class, 'json'
                    );
                }
            }
        }
        return $result;
    }

    /**
    * Sort an array of questions by question type
    * @param Question[]
    * @return array(Question[])
    **/
    private function sortQuestionsByType($questions) {
        $result = array();
        foreach ($questions as $question) {
            $result[$question->getType()][] = $question;
        }
        return $result;
    }

    /**
    * Sort an array of questions by label
    * @param Question[]
    * @return array(Question[])
    **/
    private function sortQuestionsByLabel($questions) {
        $result = array();
        foreach ($questions as $question) {
            $match = false;
            for ($i = 0; $i < count($result); $i++) {
                if($question->getLabel() === $result[$i][0]->getLabel()) {
                    $result[$i][] = $question;
                    $match = true;
                    break;
                }
            }
            if(!$match){
                $result[] = array($question);
            }
        }
        return $result;
    }


    /**
    * Aggregate QCM answers
    * @param Question[] Assumes questions have been sorted by label beforehand.
    * @return mixed[]
    **/
    private function aggregateQcmAnswers($questions) {
        $result = array(
            'type' => self::QUESTION_TYPE_QCM,
            'label' => $questions[0]->getLabel(),
            'answers' => array()
        );

        foreach ($questions as $question) {
            $options = $question->getOptions();
            $answers = $question->getAnswer();

            for($i = 0; $i < count($options); $i++) {
                if(!array_key_exists($options[$i], $result['answers'])) {
                    $result['answers'][$options[$i]] = 0;
                }
                if($answers[$i] === true) {
                    $result['answers'][$options[$i]]++;
                }
            }
        }
        return $result;
    }

    /**
    * aggregate Numeric answers
    * @param Question[] Assumes questions have been sorted by label beforehand.
    * @return mixed[]
    **/
    private function aggregateNumericAnswers($questions) {
        $result = array(
            'type' => self::QUESTION_TYPE_NUMERIC,
            'label' => $questions[0]->getLabel(),
            'answers' => 0
        );
        $count = 0;
        foreach ($questions as $question) {
            $count += $question->getAnswer();
        }
        $result['answers'] = intval($count / count($questions));
        return $result;
    }

    /**
    * Aggregate Date answers.
    * @param Question[] Assumes questions have been sorted by label beforehand.
    * @return mixed[]
    **/
    private function aggregateDateAnswers($questions) {
        $result = array(
            'type' => self::QUESTION_TYPE_DATE,
            'label' => $questions[0]->getLabel(),
            'answers' => array()
        );
        foreach ($questions as $question) {
            $result['answers'][] = new \DateTime($question->getAnswer());
        }
        return $result;
    }
}
