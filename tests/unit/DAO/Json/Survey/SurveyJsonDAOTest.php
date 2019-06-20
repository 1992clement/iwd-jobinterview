<?php
namespace TESTS\unit\DAO\Json\Survey;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use IWD\JOBINTERVIEW\DAO\Json\Survey\SurveyJsonDAO;
use Tests\unit\DAO\Json\Survey\Provider\SurveyJsonDAOTestProvider;

class SurveyJsonDAOTest extends TestCase {
    private $surveyJsonDAO;

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
        $this->surveyJsonDAO = new SurveyJsonDAO($pathToDataFolder, $serializer);
    }

    /**
    * @dataProvider surveyProvider
    **/
    public function testGetSurveysAsJson($expectedResult) {
        $this->assertEquals(
            $this->surveyJsonDAO->getSurveysAsJson(), $expectedResult
        );
    }

    public function surveyProvider() {
        $this->dataProvider = new SurveyJsonDAOTestProvider();
        return array(
            array($this->dataProvider->provideMockJsonSurveys())
        );
    }


}
