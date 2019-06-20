<?php
declare(strict_types=1);

if (file_exists(ROOT_PATH.'/vendor/autoload.php') === false) {
    echo "run this command first: composer install";
    exit();
}
require_once ROOT_PATH.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;

use Silex\Application;

use IWD\JOBINTERVIEW\DAO\DAOFactory;

$app = new Application();

/****** Services ******/

//register the serializer
$app->register(new Silex\Provider\SerializerServiceProvider());
$app['serializer.normalizers'] = function () use ($app) {
    $propertyInfo = new ReflectionExtractor();

    return array(
        new ArrayDenormalizer(),
        new ObjectNormalizer(null, null, null, $propertyInfo)
    );
};

//Define Data Access Object (DAO) Factory as a Service
$app['DAO.Factory'] = function () use ($app) {
    return new DAOFactory();
};

//Define a DAO Service to get surveys from JSON files
$app['DAO.JSON.Survey'] = function () use ($app) {
    return $app['DAO.Factory']->createDao(
    	DAOFactory::SURVEY_JSON_DAO, $app['serializer'], array('dataPath' => ROOT_PATH . '/data')
    );
};

$app['DAO.JSON.Question'] = function () use ($app) {
    return $app['DAO.Factory']->createDao(
    	DAOFactory::QUESTION_JSON_DAO, $app['serializer'], array('dataPath' => ROOT_PATH . '/data')
    );
};

/****** Routing ******/

$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
	$response->headers->set('Content-Type', 'application/json');
});

$app->get('/', function () use ($app) {
    return 'Status OK';
});

$app->get('/surveys', function () use ($app) {
	return new Response($app['DAO.JSON.Survey']->getSurveysAsJson(), 200);
});

$app->get('/surveys/{surveyCode}/answers', function ($surveyCode) use ($app) {
	return new Response($app['DAO.JSON.Question']->getAggregatedAnswersBySurveyCodeAsJson($surveyCode), 200);
});
$app->run();

return $app;
