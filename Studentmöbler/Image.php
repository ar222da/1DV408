<?php

    class Image
    {
        private $id;
        private $fileName;
        
        public function __construct()
        {
            
        }
        
        public function setId($id)
        {
            $this->id = $id;
        }
        
        public function getId()
        {
            return $this->id;
        }
        
        public function setFileName($fileName)
        {
            $this->fileName = $fileName;
        }
        
        public function getFileName()
        {
            return $this->fileName;
        }
        
        public function validate()
        {
            
        }
    }