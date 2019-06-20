<?php
namespace Tests\unit\DAO\Json\Question\Provider;

class QuestionJsonDAOTestProvider {
    public function provideMockJsonAggregatedAnswers() {
        $data = array(
            "qcm" => array(
                array(
                    "type" => "qcm",
                    "label" => "What best sellers are available in your store?",
                    "answers" => array(
                        "Product 1" => 1,
                        "Product 2" => 2,
                        "Product 3" => 1,
                        "Product 4" => 2,
                        "Product 5" => 0,
                        "Product 6" => 0,
                    )
                ),
                array(
                    "type" => "qcm",
                    "label" => "Another QCM",
                    "answers" => array(
                        "Choice 1" => 0,
                        "Choice 2" => 1
                    )
                )
            ),
            "numeric" => array(
                array(
                    "type" => "numeric",
                    "label" => "Number of products?",
                    "answers" => 520
                ),
                array(
                    "type" => "numeric",
                    "label" => "Need number ?",
                    "answers" => 42
                )
            ),
            "date" => array(
                array(
                    "type" => "date",
                    "label" => "What is the visit date?",
                    "answers" => array(
                        array(
                            "timezone" => array(
                                "name" => "Z",
                                "transitions" => false,
                                "location" => false
                            ),
                            "offset" => 0,
                            "timestamp" => 1459249490
                        ),
                        array(
                            "timezone" => array(
                                "name" => "Z",
                                "transitions" => false,
                                "location" => false
                            ),
                            "offset" => 0,
                            "timestamp" => 1459249490
                        )
                    )
                ),
                array(
                    "type" => "date",
                    "label" => "Random date",
                    "answers" => array(
                        array(
                            "timezone" => array(
                                "name" => "Z",
                                "transitions" => false,
                                "location" => false
                            ),
                            "offset" => 0,
                            "timestamp" => 2784625490
                        )
                    )
                )
            )
        );

        return json_encode($data);
    }
}
