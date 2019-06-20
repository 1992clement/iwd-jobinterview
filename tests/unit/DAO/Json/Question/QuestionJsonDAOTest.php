<?php
namespace TESTS\unit\DAO\Json\Question;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use IWD\JOBINTERVIEW\DAO\Json\Question\QuestionJsonDAO;
use Tests\unit\DAO\Json\Question\Provider\QuestionJsonDAOTestProvider;

class QuestionJsonDAOTest extends TestCase {
    private $questionJsonDAO;

    public function setUp() {
        //Instanciate Serializer
        $propertyInfo = new ReflectionExtractor();
        $normalizers = array(
            new ArrayDenormalizer(),
            new ObjectNormalizer(null, null, null, $propertyInfo),
        );
        $encoders = array(new JsonEncoder());
        $serializer = new Serializer($normalizers, $encoders);

        $pathToDataFolder = __DIR__ . '/../MockData';
        $this->questionJsonDAO = new QuestionJsonDAO($pathToDataFolder, $serializer);
    }

    /**
    * @dataProvider aggregatedAnswerProvider
    **/
    public function testGetAggregatedAnswersBySurveyCodeAsJson($expectedResult) {
        $this->assertEquals(
            $this->questionJsonDAO->getAggregatedAnswersBySurveyCodeAsJson('XX1'), $expectedResult
        );
    }

    public function aggregatedAnswerProvider() {
        $this->dataProvider = new QuestionJsonDAOTestProvider();
        return array(
            array($this->dataProvider->provideMockJsonAggregatedAnswers())
        );
    }


}
