<?php

namespace view;

class AdCreateView
{
    private static $type = "AdCreateView::type";
    private static $category = "AdCreateView::category";
    private static $header = "AdCreateView::header";
    private static $description = "AdCreateView::description";
    private static $price = "AdCreateView::price";
    private static $location = "AdCreateView::location";
    private static $name = "AdCreateView::name";
    private static $mail = "AdCreateView::mail";
    private static $phone = "AdCreateView::phone";
    private static $image = "AdCreateView::image";
    
    private static $publish = "AdCreateView::publish";
    
    
    private $adCreateModel;
    
    
    public function __construct(\model\AdCreateModel $adCreateModel)
    {
        $this->adCreateModel = $adCreateModel;
    }
    
    public function userWantsToPublish()
    {
        return isset($_POST[self::$publish]);
    }
    
   
    
    public function getCreateAdInput()
    {
        return new \model\AdTemp($this->getType(),
            $this->getCategory(),
            $this->getHeader(),
            $this->getDescription(),
            $this->getPrice(),
            $this->getLocation(),
            $this->getName(),
            $this->getMail(),
            $this->getPhone(),
            $this->getImage());
    }

    public function generateCreateAdForm()
    {
        $types = $this->adCreateModel->getTypes();
        $categories = $this->adCreateModel->getCategories();
        $locations = $this->adCreateModel->getLocations();
        $message = $this->adCreateModel->getMessage();
        
        // FORM och UL
        $ret .= "
        <form class='createAdForm' method='post' enctype='multipart/form-data'>
        <ul>";
        
        // LI 1. Valbara annonstyper läses in och placeras i drop-down-menu
        $ret .= "
        <li>
        <label for='" .self::$type. "'>Typ av annons:</label> 
        <select name='" .self::$type. "'>";
        foreach ($types as $type)
        {
            $ret .= "<option value='" .$type->getId(). "'>" . $type->getName() . "</option>";
        }
        $ret .= "
        </select>
        <span class='message'>
        " . $message->getType() . "
        </span>
        </li>";
            
        // LI 2. Valbara kategorier läses in och placeras i drop-down-menu
        $ret .= "
        <li>
        <label for='" .self::$category. "'>Kategori:</label> 
        <select name='" .self::$category. "'>";
        foreach ($categories as $category)
        {
            $ret .= "<option value='" . $category->getId() . "'>" . $category->getName() . "</option>";
        }
        $ret .= "
        </select>
        <span class='message'>
        " . $message->getCategory() . "
        </span>
        </li>";

        // LI 3. Rubrik för annons
        $ret .= "
        <li>
        <label for='" .self::$header. "'>Rubrik:</label> 
        <input type='text' name='" .self::$header. "'>
        <span class='message'>
        " . $message->getHeader() . "
        </span>
        </li>";
        
        // LI 4. Beskrivning
        $ret .= "
        <li>
        <label for='" .self::$description. "'>Beskrivning:</label> 
        <textarea name='" .self::$description. "' cols=40 rows=6>
        </textarea>
        <span class='message'>
        " . $message->getDescription() . "
        </span>
        </li>";
        
        // LI 5. Pris
        $ret .= "
        <li>
        <label for='" .self::$price. "'>Pris:</label> 
        <input type='text' name='" .self::$price. "'>
        <span class=message>
        " . $message->getPrice() . "
        </span>
        </li>";
        
        // LI 6. Valbara orter läses in och placeras i drop-down-menu
        $ret .= "
        <li>
        <label for='" .self::$location. "'>Ort:</label> 
        <select name='" .self::$location. "'>";
        foreach ($locations as $location)
        {
            $ret .= "<option value='" . $location->getId() . "'>" . $location->getName() . "</option>";
        }
        $ret .= "
        </select>
        <span class='message'>
        " . $message->getLocation() . "
        </span>
        </li>";

        // LI 7. Annonsörens namn
        $ret .= "
        <li>
        <label for='" .self::$name. "'>Namn:</label> 
        <input type='text' name='" .self::$name. "'>
        <span class='message'>
        " . $message->getName() . "
        </span>
        </li>";
        
        // LI 7. Annonsörens mail
        $ret .= "
        <li>
        <label for='" .self::$mail. "'>Epost:</label> 
        <input type='text' name='" .self::$mail. "'>
        <span class='message'>
        " . $message->getMail() . "
        </span>
        </li>";
        
        // LI 8. Annonsörens telefon
        $ret .= "
        <li>
        <label for='" .self::$phone. "'>Telefon: (frivilligt)</label> 
        <input type='text' name='" .self::$phone. "'>
        <span class='message'>
        " . $message->getPhone() . "
        </span>
        </li>";
        
        // LI 9. Bild 1
        $ret .= "
        <li>
        <label for='" .self::$image. "'>Bild 1: (frivilligt)</label> 
        <input type='file' name='" .self::$image. "'>
        <span class='message'>
        " . $message->getImage() . "
        </span>
        </li>";
        
       
        
        // LI 10. Submit
        $ret .= "
        <li>
        <button class='submit' type='submit' name='" .self::$publish. "'>Publicera annons</button>
        </li>

        </ul>
        </form>";
            
        return $ret;
    }
    
    public function getType()
    {
        if (isset($_POST[self::$type]))
            return $_POST[self::$type];
        return "";
    }
    
    public function getCategory()
    {
        if (isset($_POST[self::$category]))
            return $_POST[self::$category];
        return "";
    }
    
    public function getHeader()
    {
        if (isset($_POST[self::$header]))
            return $_POST[self::$header];
        return "";
    }
    
    public function getDescription()
    {
        if (isset($_POST[self::$description]))
            return $_POST[self::$description];
        return "";
    }
    
    public function getPrice()
    {
        if (isset($_POST[self::$price]))
            return $_POST[self::$price];
        return "";
    }
    
    public function getLocation()
    {
        if (isset($_POST[self::$location]))
            return $_POST[self::$location];
        return "";
    }
    
    public function getName()
    {
        if (isset($_POST[self::$name]))
            return $_POST[self::$name];
        return "";
    }
    
    public function getMail()
    {
        if (isset($_POST[self::$mail]))
            return $_POST[self::$mail];
        return "";
    }
    
    public function getPhone()
    {
        if (isset($_POST[self::$phone]))
            return $_POST[self::$phone];
        return "";
    }
    
    public function getImage()
    {
        if (isset($_POST[self::$image]))
            return $_POST[self::$image];
        return "";
    }
    
   
    
}