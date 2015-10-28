<?php

namespace model;

class Filter 
{
    public function __construct()
    {
    }
        
    public function sanitizeText($text)
    {
        // Potentiellt farliga tecken tas bort direkt
        $text = strip_tags($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);

        // Av det som återstår av inmatad sträng valideras tecken för tecken och om aktuellt tecken passerar validering används aktuellt tecken
        // för en ny uppbyggd sträng som är den som slutligen returneras
        
        // Längd på originalsträngen
        $length = strlen($text);
        // Den nya strängen skapas och är tom
        $string = "";
        
        // Tecken för tecken i originalsträng gås igenom
        for ($i = 0; $i < $length; $i++)
        {
            // Det akutella tecknet
            $char = substr($text, $i, 1);
            // Förgående tecken i den nya strängen
            $lastCharOfNewString = substr($string, -1);
            
            // Bokstäver inklusive åäö, siffror samt mellanslag, radbrytning med retur, punkt, komma och (-)-tecken släpps igenom
            if (ctype_alpha($char) || preg_match("/[åäöÅÄÖ0123456789 !\r.,-]/", $char))
            {
                
                // Punkt, komma, !-tecken och (-)-tecken måste kontrolleras vidare 
                if (preg_match("/[.]/", $char) || preg_match("/[,]/", $char) || preg_match("/[-]/", $char) || preg_match("/[!]/", $char)   ) 
                {
                    // Punkt, komma eller (-)-tecknet släppas enbart igenom om förgående tecken är bokstav eller siffra.
                    // Kontrollera alltså förgeånde tecken som släpptes igenom.
                    if (!ctype_alpha($lastCharOfNewString) && !ctype_digit($lastCharOfNewString) 
                    && !preg_match("/[åäöÅÄÖ]/", $lastCharOfNewString))
                    {
                        // Aktuellt tecken ignoreras och ny loopomgång ska startas och nästa tecken i originalsträng kontrolleras.
                        continue;
                    }
                    else
                    {
                        // Aktuellt tecken går igenom och läggs till den nya strängen.
                        $string .= $char;
                    }
                }
                
                // Mellanslag måste kontrolleras vidare
                else if (preg_match("/[ ]/", $char))
                {
                    // Förgående tecken i den nya strängen kontrolleras och är det ett mellanslag ignoreras detta nya mellanslag
                    // Mellanslag efter radbrytning godtas inte heller
                    if (preg_match("/[ ]/", $lastCharOfNewString) || preg_match("/[\r]/", $lastCharOfNewString) )
                    {
                        // Aktuellt mellanslag ignoreras
                        continue;
                    }
                    else
                    {
                        // Mellanslag går igenom och läggs till den nya strängen.
                        $string .= $char;
                    }
                }
                
                // Radbrytning med return måste kontrolleras, de får inte vara flera stycken i följd
                else if (preg_match("/[\r]/", $char))
                {
                    // Förgående tecken i den nya strängen kontrolleras och är det ett mellanslag ignoreras detta nya mellanslag
                    if (preg_match("/[\r]/", $lastCharOfNewString))
                    {
                        // Aktuell radbrytning ignoreras
                        continue;
                    }
                    else
                    {
                        // Radbrytning går igenom och läggs till den nya strängen.
                        $string .= $char;
                    }
                }
                
                
                // Om aktuellt tecken varken är mellanslag, punkt, komma eller (-)-tecken är aktuellt tecken en bokstav eller siffra
                // och kan därmed läggas till direkt till den nya strängen utan vidare kontroll.
                else
                {
                    $string .= $char;
                }
            }
            
            
            // Tecken är varken bokstav, siffra eller ovan tillåtna tecken och ignoreras därmed
            else
            {
                continue;
            }
        }
        
        // Genomgång klar. Den nya strängen returneras.
        
        return $string;
    }
    

        public function sanitizeName($name)
        {
            // Ersätter följder av mellanslag med ett mellanslag
            $name = preg_replace('/\s+/', ' ', $name);
            
            // Tar bort alla tecken som inte är stora och små bokstäver förutom mellanslag
            $name = preg_replace("/[^A-Öa-ö ]/", "", $name);
            
            // Ersätter _-tecken med mellanslag
            $name = preg_replace('/\_+/', ' ', $name);
            
            return $name;
        }
        
        public function sanitizePrice($price)
        {
            // Tar bort följder av mellanslag
            $price = preg_replace('/\s+/', '', $price);
            
            // Tar bort alla tecken som inte är numeriska
            $price = preg_replace("/[^0-9]/", "", $price);
            
            return $price;
        }
        
    }
