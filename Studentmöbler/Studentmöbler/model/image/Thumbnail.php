<?php

namespace model;

class Thumbnail
{
    private $width = 80;
    private $height = 80;
    private $originalImageDirectory = "images/";
    private $directory = "thumbnails/";

    public function __construct($fileName)
    {
        // Källan till följande kommer från http://webcheatsheet.com/php/create_thumbnail_images.php
        
        if (exif_imagetype($this->originalImageDirectory . $fileName) == IMAGETYPE_GIF) 
        {
            $sourceImage = imagecreatefromgif($this->originalImageDirectory . $fileName);
        }
        
        else if (exif_imagetype($this->originalImageDirectory . $fileName) == IMAGETYPE_JPEG) 
        {
            $sourceImage = imagecreatefromjpeg($this->originalImageDirectory . $fileName); 
        }
        
        else if (exif_imagetype($this->originalImageDirectory . $fileName) == IMAGETYPE_PNG) 
        {
            $sourceImage = imagecreatefrompng($this->originalImageDirectory . $fileName);
        }
        
        $originalImageSize = getimagesize($this->originalImageDirectory . $fileName);
        $originalWidth = $originalImageSize[0];
        $originalHeight = $originalImageSize[1];
        $newWidth = $this->width;
        $newHeight = floor($originalHeight * ($this->width / $originalWidth));
        $tmp_img = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp_img, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
        imagejpeg( $tmp_img, "{$this->directory}{$fileName}", 100);
    }

}
    