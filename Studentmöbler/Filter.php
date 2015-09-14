<?php
    
class Filter 
{
    public function __construct()
    {
    }
        
    // Inmatad sträng valideras tecken för tecken och används för att bygga upp en ny sträng som returneras
    public function sanitizeText($text, $maxLength)
    {
        $length = strlen($text);
        $string = "";

        for ($i = 0; $i < $length; $i++)
        {
            $char = substr($text, $i, 1);
            $lastCharOfNewString = substr($string, -1);
            
            // Överstiger inmatad sträng angiven maxlängd bryts valideringen och den nya strängen returneras
            if ($i >= $maxLength)
            {
                break;
            }
            
            if (ctype_alpha($char) || preg_match("/[åäöÅÄÖ0123456789 .,-]/", $char))
            {
                // Punkt, komma och (-)-tecken släpps bara igenom som följd till bokstäver och siffror
                if (preg_match("/[.]/", $char) || preg_match("/[,]/", $char) || preg_match("/[-]/", $char)  ) 
                {
                    if (!ctype_alpha($lastCharOfNewString) && !ctype_digit($lastCharOfNewString) 
                    && !preg_match("/[åäöÅÄÖ]/", $lastCharOfNewString))
                    {
                        continue;
                    }
                    else
                    {
                        $string .= $char;
                    }
                }
                // Mellanslag i följd släpps inte igenom
                else if (preg_match("/[ ]/", $char))
                {
                    if (preg_match("/[ ]/", $lastCharOfNewString))
                    {
                        continue;
                    }
                    else
                    {
                        $string .= $char;
                    }
                }
                else
                {
                    $string .= $char;
                }
            }
            else
            {
                continue;
            }
        }
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
