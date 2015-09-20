<?php

class AdCreate_View
{
    public function __construct()
    {
        
    }
    
    public function createAdForm($types, $categories, $locations, $messages)
    {
        // Klasser för CSS
        // Element: Formulär. Klassnamn: createAdForm
        // Element: span. Klassnamn: message
        
        // FORM och UL
        $ret .= "
        <form class=createAdForm action=?submitAdRequest method=post name=createAdForm>
        <ul>";
        
        // LI 1. Valbara annonstyper läses in och placeras i drop-down-menu
        $ret .= "
        <li>
        <label for=type>Typ av annons:</label> 
        <select name=type>";
        foreach ($types as $type)
        {
            $ret .= "<option value=" . $type->getId() . ">" . $type->getName() . "</option>";
        }
        $ret .= "
        </select>
        <span class=message>
        " . $messages[type] . "
        </span>
        </li>";
            
        // LI 2. Valbara kategorier läses in och placeras i drop-down-menu
        $ret .= "
        <li>
        <label for=category>Kategori:</label> 
        <select name=category>";
        foreach ($categories as $category)
        {
            $ret .= "<option value=" . $category->getId() . ">" . $category->getName() . "</option>";
        }
        $ret .= "
        </select>
        <span class=message>
        " . $messages[category] . "
        </span>
        </li>";

        // LI 3. Rubrik för annons
        $ret .= "
        <li>
        <label for=header>Rubrik:</label> 
        <input type=text name=header>
        <span class=message>
        " . $messages[header] . "
        </span>
        </li>";
        
        // LI 4. Beskrivning
        $ret .= "
        <li>
        <label for=description>Beskrivning:</label> 
        <textarea name=description cols=40 rows=6>
        </textarea>
        <span class=message>
        " . $messages[description] . "
        </span>
        </li>";
        
        // LI 5. Pris
        $ret .= "
        <li>
        <label for=price>Pris:</label> 
        <input type=text name=price>
        <span class=message>
        " . $messages[price] . "
        </span>
        </li>";
        
        // LI 6. Valbara orter läses in och placeras i drop-down-menu
        $ret .= "
        <li>
        <label for=location>Ort:</label> 
        <select name=location>";
        foreach ($locations as $location)
        {
            $ret .= "<option value=" . $location->getId() . ">" . $location->getName() . "</option>";
        }
        $ret .= "
        </select>
        <span class=message>
        " . $messages[location] . "
        </span>
        </li>";

        // LI 7. Annonsörens namn
        $ret .= "
        <li>
        <label for=name>Namn:</label> 
        <input type=text name=name>
        <span class=message>
        " . $messages[name] . "
        </span>
        </li>";
        
        // LI 7. Annonsörens mail
        $ret .= "
        <li>
        <label for=mail>Epost:</label> 
        <input type=text name=mail>
        <span class=message>
        " . $messages[mail] . "
        </span>
        </li>";
        
        // LI 8. Submit
        $ret .= "
        <li>
        <button class=submit type=submit>Publicera annons</button>
        </li>

        </ul>
        </form>";
            
        return $ret;
    }
    
   
    
}