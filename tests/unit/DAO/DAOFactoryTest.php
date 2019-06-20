<?php
namespace TESTS\unit\DAO\Json\Survey;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use IWD\JOBINTERVIEW\DAO\DAOFactory;
use IWD\JOBINTERVIEW\DAO\Json\Survey\SurveyJsonDAO;
use IWD\JOBINTERVIEW\DAO\Json\Question\QuestionJsonDAO;

class DAOFactoryTest extends TestCase {
    private $serializer;
    private $daoFactory;

    public function setUp() {
        //Instanciate Serializer
        $propertyInfo = new ReflectionExtractor();
        $normalizers = array(
            new ArrayDenormalizer(),
            new ObjectNormalizer(null, null, null, $propertyInfo),
        );
        $encoders = array(new JsonEncoder());
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->daoFactory = new DAOFactory();
    }

    /**
    * @dataProvider daoProvider
    **/
    public function testCreateDao($daoType, $expectedResult) {
        $this->assertEquals(
            $this->daoFactory->createDao($daoType, $this->serializer, array('dataPath' => '')), $expectedResult
        );
    }

    public function daoProvider() {
        //Data provider are called BEFORE setup()....
        $serializer = new Serializer(
            array(
                new ArrayDenormalizer(),
                new ObjectNormalizer(null, null, null, new ReflectionExtractor()),
            ),
            array(new JsonEncoder())
        );

        return array(
            array(DAOFactory::SURVEY_JSON_DAO, new SurveyJsonDAO('', $serializer)),
            array(DAOFactory::QUESTION_JSON_DAO, new QuestionJsonDAO('', $serializer))
        );
    }


}
