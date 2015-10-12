<?php

class AdCreate_View
{
    private $keys;
    private $input = array();
    
    public function __construct($keys)
    {
        $this->keys = $keys;
        $this->input = array_fill_keys($keys, '');    
    }
    
    public function publishAdRequest()
    {
        if (isset($_POST["publishAd"]))
            return true;
        return false;
    }
    
    public function imageUploaded()
    {
        if ($_FILES['Image1']['name'])
            return true;
        return false;
    }
    
    public function getInput()
    {
        foreach ($this->keys as $key)
        {
            $this->input[$key] = $_POST[$key];
        }
        
        return $this->input;
           
    }

    public function createAdForm($types, $categories, $locations, $messages)
    {
        // Klasser för CSS
        // Element: Formulär. Klassnamn: createAdForm
        // Element: span. Klassnamn: message
        
        // FORM och UL
        $ret .= "
        <form class=createAdForm action=?submitAdRequest method=post enctype=multipart/form-data name=createAdForm>
        <ul>";
        
        // LI 1. Valbara annonstyper läses in och placeras i drop-down-menu
        $ret .= "
        <li>
        <label for=type>Typ av annons:</label> 
        <select name=Type>";
        foreach ($types as $type)
        {
            $ret .= "<option value=" . $type->getId() . ">" . $type->getName() . "</option>";
        }
        $ret .= "
        </select>
        <span class=message>
        " . $messages[Type] . "
        </span>
        </li>";
            
        // LI 2. Valbara kategorier läses in och placeras i drop-down-menu
        $ret .= "
        <li>
        <label for=category>Kategori:</label> 
        <select name=Category>";
        foreach ($categories as $category)
        {
            $ret .= "<option value=" . $category->getId() . ">" . $category->getName() . "</option>";
        }
        $ret .= "
        </select>
        <span class=message>
        " . $messages[Category] . "
        </span>
        </li>";

        // LI 3. Rubrik för annons
        $ret .= "
        <li>
        <label for=header>Rubrik:</label> 
        <input type=text name=Header>
        <span class=message>
        " . $messages[Header] . "
        </span>
        </li>";
        
        // LI 4. Beskrivning
        $ret .= "
        <li>
        <label for=description>Beskrivning:</label> 
        <textarea name=Description cols=40 rows=6>
        </textarea>
        <span class=message>
        " . $messages[Description] . "
        </span>
        </li>";
        
        // LI 5. Pris
        $ret .= "
        <li>
        <label for=price>Pris:</label> 
        <input type=text name=Price>
        <span class=message>
        " . $messages[Price] . "
        </span>
        </li>";
        
        // LI 6. Valbara orter läses in och placeras i drop-down-menu
        $ret .= "
        <li>
        <label for=location>Ort:</label> 
        <select name=Location>";
        foreach ($locations as $location)
        {
            $ret .= "<option value=" . $location->getId() . ">" . $location->getName() . "</option>";
        }
        $ret .= "
        </select>
        <span class=message>
        " . $messages[Location] . "
        </span>
        </li>";

        // LI 7. Annonsörens namn
        $ret .= "
        <li>
        <label for=name>Namn:</label> 
        <input type=text name=Name>
        <span class=message>
        " . $messages[Name] . "
        </span>
        </li>";
        
        // LI 7. Annonsörens mail
        $ret .= "
        <li>
        <label for=mail>Epost:</label> 
        <input type=text name=Mail>
        <span class=message>
        " . $messages[Mail] . "
        </span>
        </li>";
        
        // LI 8. Annonsörens telefon
        $ret .= "
        <li>
        <label for=mail>Telefon: (frivilligt)</label> 
        <input type=text name=Phone>
        <span class=message>
        " . $messages[Phone] . "
        </span>
        </li>";
        
        // LI 9. Bild 1
        $ret .= "
        <li>
        <label for=mail>Bild 1: (frivilligt)</label> 
        <input type=file name=Image1>
        <span class=message>
        " . $messages[Image1] . "
        </span>
        </li>";
        
        // LI 10. Bild 2
        $ret .= "
        <li>
        <label for=mail>Bild 2: (frivilligt)</label> 
        <input type=file name=Image2>
        <span class=message>
        " . $messages[Image2] . "
        </span>
        </li>";
        
        // LI 11. Bild 3
        $ret .= "
        <li>
        <label for=mail>Bild 3: (frivilligt)</label> 
        <input type=file name=Image3>
        <span class=message>
        " . $messages[Image3] . "
        </span>
        </li>";
        
        // LI 10. Submit
        $ret .= "
        <li>
        <button class=submit type=submit name=publishAd>Publicera annons</button>
        </li>

        </ul>
        </form>";
            
        return $ret;
    }
    
   
    
}