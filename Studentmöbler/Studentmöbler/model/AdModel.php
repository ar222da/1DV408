<?php

namespace model;

require_once("dbConnection.php");
require_once("ad/Ad.php");
require_once("ad/Filter.php");
require_once("ad/Validator.php");
require_once("ad/Message.php");
require_once("ad/AdService.php");
require_once("type/TypeService.php");
require_once("category/CategoryService.php");
require_once("location/LocationService.php");
require_once("image/Image.php");
require_once("image/ImageService.php");
require_once("image/Thumbnail.php");
require_once("sender/Sender.php");
require_once("sender/SenderMessage.php");



class AdModel
{
    private $db;
    private $typeService;
    private $categoryService;
    private $locationService;
    
    private $adService;
    private $ad;
    
    private $image;
    private $thumbnail;
    
    private $validator;
    private $filter;
    private $createdAdId;

    private $message;
    private $selectedAd;
    private $sender;
    private $senderMessage;

    
    public function __construct()
    {
        $this->db = new dbConnection();
        $this->typeService = new TypeService($this->db->getDb());
        $this->categoryService = new CategoryService($this->db->getDb());
        $this->locationService = new LocationService($this->db->getDb());
        $this->adService = new AdService($this->db->getDb());
        $this->imageService = new ImageService($this->db->getDb());
        $this->filter = new Filter();
        $this->validator = new Validator();
        $this->message = new Message();
        $this->ad = new Ad();
        
        
        $this->image = new Image();

        
        
        $this->sender = new Sender();
        $this->senderMessage = new SenderMessage();
    }
    
    
    // Hämtning av annonstyper, kategorier och orter
    public function getTypes()
    {
        return $this->typeService->getTypes();
    }
    
    public function getType($id)
    {
        return $this->typeService->getTypeById($id);
    }
    
    public function getCategories()
    {
        return $this->categoryService->getCategories();
    }
    
    public function getLocations()
    {
        return $this->locationService->getLocations();
    }
    
    public function getLocation($id)
    {
        return $this->locationService->getLocationById($id);
    }
    
    
    
    // Hämtning av annonser för visning
    public function getAds($categoryId)
    {
        return $this->adService->getAdsByCategory($categoryId);
    }
    
    
    // Hämtning av vald annons för visning
    public function getSelectedAd($adId)
    {
        $this->selectedAd = $this->adService->getAdById($adId);
        return $this->selectedAd;
    }
    
    
    // Validering och lagring av skapad eller uppdaterad annons
    public function doValidation($ad)
    {
        $this->ad = $ad;
        $errorsFound = false;

        // Validering av annonstyp    
        $type = $this->ad->getType();
            if (!$this->validator->isValid($type, "Annonstyp", true, 1, false, true))
            {
                $this->message->setType($this->validator->getMessage());
                $errorsFound = true;
            }

        // Validering av kategori
        $category = $this->ad->getCategory();
            if (!$this->validator->isValid($category, "Kategori", true, 1, false, true))
            {
                $this->message->setCategory($this->validator->getMessage());
                $errorsFound = true;
            }

        // Validering av rubrik
        $header = trim($this->ad->getHeader());
            if (strlen($header) > 100)
            {
                $header = substr($header, 0, 99);
            }
            if (!$this->validator->isValid($header, "Rubrik", true, 10, true, false))
            {
                $this->message->setHeader($this->validator->getMessage());
                $errorsFound = true;
            }
        $this->ad->setHeader($this->filter->sanitizeText($header));
        

        // Validering av beskrivning
        $description = trim($this->ad->getDescription());
            if (strlen($description) > 2000)
            {
                $description = substr($description, 0, 1999);
            }
            if (!$this->validator->isValid($description, "Beskrivning", true, 10, true, false))
            {
                $this->message->setDescription($this->validator->getMessage());
                $errorsFound = true;
            }
        $this->ad->setDescription($this->filter->sanitizeText($description));
        
            
        // Validering av pris
        $price = trim($this->ad->getPrice());
            if (strlen($price) > 6)
            {
                $price = substr($price, 0, 5);             
            }
            if (!$this->validator->isValid($price, "Pris", true, 2, false, true))
            {
                $this->message->setPrice($this->validator->getMessage());
                $errorsFound = true;
            }

        // Validering av ort
        $location = $this->ad->getLocation();
            if (!$this->validator->isValid($location, "Ort", true, 1, false, true))
            {
                $this->message->setLocation($this->validator->getMessage());
                //$this->message->setLocation($location);
                $errorsFound = true;
            }
            
        // Validering av namn
        $name = trim($this->ad->getName());
            if (strlen($name) > 20)
            {
                $name = substr($name, 0, 19);
            }
            if (!$this->validator->isValid($name, "Namn", true, 2, true, false))
            {
                $this->message->setName($this->validator->getMessage());
                $errorsFound = true;
            }
        $this->ad->setName($this->filter->sanitizeText($name));
        
            
        // Validering av mail
        $mail = trim($this->ad->getMail());
            
            if (!$this->validator->isValidMail($mail))
            {
                $this->message->setMail($this->validator->getMessage());
                $errorsFound = true;
            }
            
        // Validering av telefon
        $phone = trim($this->ad->getPhone());
            if (isset($phone) === true && $phone != '')
            {
                if (!$this->validator->isValidPhone($phone))
                {
                    $this->message->setPhone($this->validator->getMessage());
                    $errorsFound = true;
                }
            }
            else
            {
                $this->message->setPhone("");
            }
        
        // Validering av bild   
        $image = $this->ad->getImage();
            if (isset($image) === true && $image != '')
            {
                if (!$this->image->validateImageData($image))
                {
                    $this->message->setImage($this->image->getMessage());
                    $errorsFound = true;
                }
                
                else
                {
                    $fname = $this->generateString(30);
                    $extension = $this->image->getExtension();
                    $this->image->setName($fname);
                    $this->imageService->insertImage($this->image);
                    $imageId = $this->imageService->getLastInsertId();
                    $this->ad->setImage($imageId);
                    move_uploaded_file($image, 'images/'. $fname . $extension);
                }
            }
            else
            {
                $this->message->setImage("");
            }

        // Om all validering passerar
        if (!$errorsFound)
        {
            // Är id redan satt för annons-objektet som skickades med som argument, ska uppdatering ske av en redan befintlig annons
            $id = $this->ad->getId();
            if (isset($id))
            {
                $this->adService->updateAd($this->ad);
                return true;
            }
            // Är id inte satt är det en helt nyskapad annons som ska lagras persistent
            else
            {
                // En nyskapad annons får en slumpad sträng på 40 tecken som "nyckel" för att nå uppdateringsläge för annons
                $string = $this->generateString(40);
                $this->ad->setUpdateDeleteString($string); 
                // Annons lagras persistent
                $this->adService->insertAd($this->ad);
                // Hämta den nyskapade och lagrade annonsens id
                $this->createdAdId = $this->adService->getLastInsertId();
                return true;
            }
        }
        // Validering passerar ej
        else
        {
           return false;
        }
    }

    // Hämta meddelanden som eventuellt sätts under valideringen
    public function getMessage()
    {
        return $this->message;
    }
    
    // Hämta id för nyskapad och lagrad annons
    public function getCreatedAdId()
    {
        return $this->createdAdId;
    }
    
    // Hämta en enskild annons utifrån annons-id
    public function getStoredAd($adId)
    {
        return $this->adService->getAdById($adId);
    }
    
    public function getImage($id)
    {
        return $this->imageService->getImageById($id);
    }
    
    // Kontroll för matchning av annons-id och nyckel
    public function validateUdString($adId, $udString)
    {
        $ad = $this->adService->getAdById($adId);
        if ($ad->getUpdateDeleteString() === $udString)
            return true;
        return false;
    }

    // Skickar mail med länkar för ändring och borttagning av annons till annonsör efter skapad annons som passerat validering
    public function sendUpdateDeleteMail($content)
    {
        $to = $this->ad->getMail();
        $subject = "Studentmöbler: Din annons har publicerats.";
        $txt = $content;
        $headers = 'From: kundtjanst@nalaka.se' . "\r\n" . 'Reply-To: kundtjanst@nalaka.se' . "\r\n";
        mail($to,$subject,$txt,$headers);
    }
    
    public function deleteAd($adId)
    {
        $this->adService->deleteAd($adId);
    }
    
    // För slumpvis skapade namn på bilder och nycklar
    public function generateString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';

        for ($i = 0; $i < $length; $i++) 
        {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }
    
    
    
   
    
    // Validering av användaruppgifter och skickande av meddelande till annonsör om validering passeras
    public function doSenderValidation($sender)
    {
        $this->sender = $sender;
        $errorsFound = false;
        
        // Validering av sändarens namn
        $name = trim($this->sender->getName());
            if (strlen($header) > 20)
            {
                $name = substr($name, 0, 19);
            }
            if (!$this->validator->isValid($name, "Namn", true, 5, true, false))
            {
                $this->senderMessage->setName($this->validator->getMessage());
                $errorsFound = true;
            }
        
        // Validering av sändarens mail
        $mail = trim($this->sender->getMail());
            if (!$this->validator->isValidMail($mail))
            {
                $this->senderMessage->setMail($this->validator->getMessage());
                $errorsFound = true;
            } 
        
        // Validering av sändarens meddelande    
        $message = trim($this->sender->getMessage());
            if (strlen($message) > 200)
            {
                $message = substr($description, 0, 199);
            }
            if (!$this->validator->isValid($message, "Meddelande", true, 10, true, false))
            {
                $this->senderMessage->setMessage($this->validator->getMessage());
                $errorsFound = true;
            }
            
        if (!$errorsFound)
        {
            $to = $this->selectedAd->getMail();
            $subject = "Studentmöbler: " . $this->sender->getName() . " har svarat på din annons.";
            $txt = "Meddelande: " .$this->sender->getMessage() . "\n\n" . $this->sender->getName() . " har följande e-post: " . $this->sender->getMail();
            $headers = 'From: kundtjanst@nalaka.se' . "\r\n" . 'Reply-To: kundtjanst@nalaka.se' . "\r\n";
            mail($to,$subject,$txt,$headers);
            return true;
        }
        else
        {
            return false;
        }
            

    }
    
    // Hämta meddelanden som sätts vid validering av användaruppgifter och meddelande till annonsör
    public function getSenderMessage()
    {
        return $this->senderMessage;
    }
    
    
    
    
}