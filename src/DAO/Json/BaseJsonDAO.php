<?php

namespace IWD\JOBINTERVIEW\DAO\Json;

use Symfony\Component\Serializer\Serializer;
use IWD\JOBINTERVIEW\Entity\Survey;

class BaseJsonDAO {

    /**
    * Path of the folder containing data files
    **/
    protected $dataFolderPath;

    /**
    * Serializer Service (Symfony Component)
    **/
    protected $serializer;

    /**
    * @param string $dataFolderPath
    * @param Serializer $serializer
    **/
    public function __construct(string $dataFolderPath, Serializer $serializer)
    {
        $this->dataFolderPath = $dataFolderPath;
        $this->serializer = $serializer;
    }

    /**
    * Loops over files in a folder and returns the datas as an array of JSON objects
    * @return $data : array of json formatted data from the files
    **/
    protected function getDataFromDataFolder() {
        $data = array();
        $folder = new \DirectoryIterator($this->dataFolderPath);
        foreach($folder as $fileInfo) {
            if(!$fileInfo->isDot())
            {
                $data[] = json_decode(file_get_contents($fileInfo->getPathName()));
            }
        }
        return $data;
    }

}
