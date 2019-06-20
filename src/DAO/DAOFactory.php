<?php

namespace IWD\JOBINTERVIEW\DAO;

use Symfony\Component\Serializer\Serializer;
use IWD\JOBINTERVIEW\DAO\Json\Survey\SurveyJsonDAO;
use IWD\JOBINTERVIEW\DAO\Json\Question\QuestionJsonDAO;

class DAOFactory {

    //Available DAO Objects.
    public const SURVEY_JSON_DAO = 'SURVEY_JSON_DAO';
    public const QUESTION_JSON_DAO = 'QUESTION_JSON_DAO';

    /**
    * Create the adequate DAO, depending on the need. (We could fetch also data from db, or whatever)
    * @param string $daoType : type of dao needed. Refer to list of constants to know available options.
    * @param SerializerInterface $serializer : allows the dao to format objects based on entities
    * @param Array $options : additionnal params that might be needed by the dao constructor
    **/
    public function createDao(string $daoType, Serializer $serializer, $options = array()) {
        switch ($daoType) {
            case self::SURVEY_JSON_DAO:
                return new SurveyJsonDAO($options['dataPath'], $serializer);
                break;
            case self::QUESTION_JSON_DAO:
                return new QuestionJsonDAO($options['dataPath'], $serializer);
                break;
            default:
                throw \Exception('Unknown DAO type');
        }
    }
}
