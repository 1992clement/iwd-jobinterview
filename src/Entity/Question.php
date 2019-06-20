<?php
namespace IWD\JOBINTERVIEW\Entity;

class Question {
    /**
    * Type of the question (qcm, numeric, date, ...)
    * @var string
    **/
    private $type;

    /**
    * Question label
    * @var string
    **/
    private $label;

    /**
    * Available options if qcm
    * @var mixed[]
    **/
    private $options;

    /**
    * Answer provided
    * @var mixed
    **/
    private $answer;

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setlabel($label) {
        $this->label = $label;
    }

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        $this->options = $options;
    }

    public function getAnswer() {
        return $this->answer;
    }

    public function setAnswer($answer) {
        $this->answer = $answer;
    }
}
