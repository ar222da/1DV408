<?php

namespace model;
 
class Image
{
    private $id;
    private $name;
    private $extension;
    private $message;
    private $directory = "images/";
    private $thumbnailDirectory = "thumbnails/";

    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function getExtension()
    {
        return $this->extension;
    }
    
    public function getDirectory()
    {
        return $this->directory;    
    }
    
    public function getThumbnailDirectory()
    {
        return $this->thumbnailDirectory;
    }
    
    public function getMessage()
    {
        return $this->message;
    }

    public function __construct()
    {
    }
    
    public function validateImageData($image)
    {
        $imageFileCheck = getimagesize($image);
        
        if($imageFileCheck == false) 
        {
            $this->message = "Vald fil är inte en bild.";
            return false;
        }
        
        if(filesize($image) > 500000)
        {
            $this->message = "Storlek på bild överskrider gränsen";
            return false;
        }
        
        if (exif_imagetype($image) != IMAGETYPE_GIF 
        && exif_imagetype($image) != IMAGETYPE_JPEG
        && exif_imagetype($image) != IMAGETYPE_PNG) 
        {
            $this->message = "Ogiltigt bildformat. Giltiga format är JPG, JPEG, PNG och GIF.";
            return false;
        }
        
        if (exif_imagetype($image) == IMAGETYPE_GIF)
        {
            $this->extension = ".GIF";
        }
        
        if (exif_imagetype($image) == IMAGETYPE_JPEG)
        {
            $this->extension = ".JPG";
        }
        
        if (exif_imagetype($image) == IMAGETYPE_PNG)
        {
            $this->extension = ".PNG";
        }

        return true;
    }
    
    
}