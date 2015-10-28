<?php

namespace view;

class AdView
{
    
    // Namn för begäran om att annonsera och publicera samt redigering, borttagning och publicering av uppdaterad annons
    private static $advertise = "AdView::advertise";
    private static $publish = "AdView::publish";
    private static $update = "AdView::update";
    private static $delete = "AdView::delete";
    private static $udString = "AdView::updateString";
    private static $publishUpdated = "AdView::publishUpdated";
    
    // Namn för input-fälten vid skapande och uppdatering av annons
    private static $type = "AdView::type";
    private static $category = "AdView::category";
    private static $header = "AdView::header";
    private static $description = "AdView::description";
    private static $price = "AdView::price";
    private static $location = "AdView::location";
    private static $name = "AdView::name";
    private static $mail = "AdView::mail";
    private static $phone = "AdView::phone";
    private static $image = "AdView::image";
    
    // Namn för begäran om att visa annonser utifrån vald kategori
    private static $viewAds = "AdView::viewAds";
    private static $categoryId = "AdView::selectedCategoryId";
    
    // Namn för fälten i begäran om att se enskild annons
    private static $viewAd = "AdView::viewAd";
    private static $adId = "AdView::selectedAdId";
    
    // Namn för formulär för att kontakta annonsör
    private static $senderName = "AdView::senderName";
    private static $senderMail = "AdView::senderMail";
    private static $senderMessage = "AdView::senderMessage";
    private static $send = "AdView::senderSend";
    
    private $adModel;
    
    public function __construct(\model\AdModel $adModel)
    {
        $this->adModel = $adModel;
    }
    
    
    // Annonsera och publicera, uppdatera, ta bort och publicera uppdaterat
    public function userWantsToAdvertise()
    {
        return isset($_GET[self::$advertise]);
    }

    public function userWantsToPublish()
    {
        return isset($_POST[self::$publish]);
    }
    
    public function userWantsToUpdate()
    {
        return isset($_GET[self::$update]);
    }
    
    public function userWantsToPublishUpdated()
    {
        return isset($_POST[self::$publishUpdated]);
    }
    
    public function userWantsToDelete()
    {
        return isset($_GET[self::$delete]);
    }
    
    public function getUpdateDeleteString()
    {
        if (isset($_GET[self::$udString]))
            return $_GET[self::$udString];
    }
    
    
    // Se annonser utifrån vald kategori
    public function userWantsToViewAds()
    {
        return isset($_GET[self::$viewAds]);
    }
    
    public function getSelectedCategoryId()
    {
        if (isset($_GET[self::$categoryId]))
            return $_GET[self::$categoryId];   
    }
    
    
    
    // Se enskild vald annons
    public function userWantsToViewAd()
    {
        return isset($_GET[self::$viewAd]);
    }
    
    public function getSelectedAdId()
    {
        if (isset($_GET[self::$adId]))
            return $_GET[self::$adId];   
    }


    
    // Kontakta annonsör
    public function userWantsToContactAdvertiser()
    {
        return isset($_POST[self::$send]);
    }
    
    // Hämta indata från användare som kontaktar annonsör och packar ner i ett sändare-objekt
    public function getSenderInput()
    {
        $sender = new \model\Sender();
        $sender->setName($this->getSenderName());
        $sender->setMail($this->getSenderMail());
        $sender->setMessage($this->getSenderMessage());
        return $sender;
    }




    // Hämta indata från skapandet av en ny annons
    public function getCreateAdInput()
    {
        $ad = new \model\Ad();
        $ad->setType($this->getType());
        $ad->setCategory($this->getCategory());
        $ad->setHeader($this->getHeader());
        $ad->setDescription($this->getDescription());
        $ad->setPrice($this->getPrice());
        $ad->setLocation($this->getLocation());
        $ad->setName($this->getName());
        $ad->setMail($this->getMail());
        $ad->setPhone($this->getPhone());
        $ad->setImage($this->getImage());
        
        return $ad;
    }
    
    // Hämta indata från uppdatering av annons
    public function getUpdateAdInput()
    {
        $ad = new \model\Ad();
        $ad->setId($this->getSelectedAdId());
        $ad->setType($this->getType());
        $ad->setCategory($this->getCategory());
        $ad->setHeader($this->getHeader());
        $ad->setDescription($this->getDescription());
        $ad->setPrice($this->getPrice());
        $ad->setLocation($this->getLocation());
        $ad->setName($this->getName());
        $ad->setMail($this->getMail());
        $ad->setPhone($this->getPhone());
        return $ad;
    }
    
    // Lista över valbara kategorier
    public function generateSideBar()
    {
        $categories = $this->adModel->getCategories();
        $ret ="
            <div id='sidebar'>
            <nav>
                <h1>Annonsera</h1>
                    <ul>
                        <li><a href='?" .self::$advertise. "'>Lägg in annons här!</a></li>
                    </ul>
                <h1>Kategorier</h1>
                    <ul>";
                        foreach($categories as $category)
                        {
                            $ret .= "<li><a href='?" .self::$viewAds. "&" .self::$categoryId. "=";
                            $ret .= $category->getId();
                            $ret .="'>";
                            $ret .= $category->getName();
                            $ret .= "</a></li>";
                        }
            $ret .="</ul>
            </nav>
            </div>";
            return $ret;
        
    }
    
    // Lista över annonser
    public function generateAdList($ads)
    {
        $ret .= "<div id='contentAdListView'>";
            $ret .= "<ul>";
            foreach ($ads as $ad)
            {
                $ret .= "<li class='adListViewElement'>";
                $ret .= "<h1>";
                $ret .= "<a href='?" .self::$viewAd. "&" .self::$adId. "=";
                $ret .= $ad->getId();
                $ret .= "'>";
                $ret .= $ad->getHeader();
                $ret .= "</a>";
                $ret .= "</h1>";
                $ret .= "<p>";
                $ret .= $ad->getDescription();
                $ret .= "</p>";
                //$ret .= "<img src='thumbnails/";
                //$ret .= $ad->getImageFileName();
                //$ret .= "'>";
                $ret .= "</li>";
            }
            $ret .= "</ul>";
            $ret .= "</div>";
            return $ret;
    }
    
    // Detaljvy över enskild vald annons samt formulär för att kontakta annonsör
    public function generateAdView($ad)
    {
        $image = $this->adModel->getImage($ad->getImage());
        $imageFileName = $image->getName() . $image->getExtension();
        $message = $this->adModel->getSenderMessage();
        
        $ret .= "<div id='contentAdView'>";
        $ret .= "<h1>";
        $ret .= " ";
        $ret .= $this->adModel->getType($ad->getType())->getName();
        $ret .= "</h1>";
        $ret .= "<h2>";
        $ret .= $ad->getHeader();
        $ret .= "</h2>";
        $ret .= "<p>";
        $ret .= $ad->getDescription();
        $ret .= "</p>";
        $ret .= "<p>";
        $ret .= "Pris ";
        $ret .= $ad->getPrice();
        $ret .= " kr</p>";
        $ret .= "<p>Inlagd ";
        $ret .= $ad->getDate();
        $ret .= " av ";
        $ret .= $ad->getName();
        $ret .= "</p>";
        
        $ret .= $this->adModel->getLocation($ad->getLocation())->getName();
        
        if ($imageFileName != "")
        {
            $ret .= "<img src='images/";
            $ret .= $imageFileName;
            $ret .= "' width='250' height='200'>";
        }
        
        $ret .= "<p>Kontakta annonsör</p>";
        $ret .= "</div>";

        $ret .= "<form class='createAdForm' method='post'>
        <ul>
        <li>
        <label for='" .self::$senderName. "'>Ditt namn:</label> 
        <input type='text' name='" .self::$senderName. "' value='" . $this->getSenderName() . "'>
        <span class='message'>
        " . $message->getName() . "
        </span>
        </li>
        
        <li>
        <label for='" .self::$senderMail. "'>Din epost:</label> 
        <input type='text' name='" .self::$senderMail. "' value='" . $this->getSenderMail() . "'>
        <span class='message'>
        " . $message->getMail() . "
        </span>
        </li>
        
        <li>
        <label for='" .self::$senderMessage. "'>Meddelande:</label> 
        <textarea name='" .self::$senderMessage. "' value='" . $this->getSenderMessage() . "' cols=40 rows=6>
        </textarea>
        <span class='message'>
        " . $message->getMessage() . "
        </span>
        </li>
        <li>
        <button class='submit' type='submit' name='" .self::$send. "'>Skicka meddelande</button>
        </li>
        
        </ul>
        </form>";

        return $ret;
    }
    
    
    // Formulär för skapande av ny annons
    public function generateCreateAdForm()
    {
        $types = $this->adModel->getTypes();
        $categories = $this->adModel->getCategories();
        $locations = $this->adModel->getLocations();
        $message = $this->adModel->getMessage();
        
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
        <input type='text' name='" .self::$header. "' value='" . $this->getHeader() . "'>
        <span class='message'>
        " . $message->getHeader() . "
        </span>
        </li>";
        
        // LI 4. Beskrivning
        $ret .= "
        <li>
        <label for='" .self::$description. "'>Beskrivning:</label> 
        <textarea name='" .self::$description. "' value='" . $this->getDescription() . "' cols=40 rows=6>"
         .$this->getDescription() .
        "</textarea>
        <span class='message'>
        " . $message->getDescription() . "
        </span>
        </li>";
        
        // LI 5. Pris
        $ret .= "
        <li>
        <label for='" .self::$price. "'>Pris:</label> 
        <input type='text' name='" .self::$price. "' value='" . $this->getPrice() . "'>
        <span class='message'>
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
        <input type='text' name='" .self::$name. "' value='" . $this->getName() . "'>
        <span class='message'>
        " . $message->getName() . "
        </span>
        </li>";
        
        // LI 7. Annonsörens mail
        $ret .= "
        <li>
        <label for='" .self::$mail. "'>Epost:</label> 
        <input type='text' name='" .self::$mail. "' value='" . $this->getMail() . "'>
        <span class='message'>
        " . $message->getMail() . "
        </span>
        </li>";
        
        // LI 8. Annonsörens telefon
        $ret .= "
        <li>
        <label for='" .self::$phone. "'>Telefon: (frivilligt)</label> 
        <input type='text' name='" .self::$phone. "' value='" . $this->getPhone() . "'>
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
        
       
        
        // LI 10. Publicera och förhandsgranska annons
        $ret .= "
        <li>
        <button class='submit' type='submit' name='" .self::$publish. "'>Publicera annons</button>
        </li>
        
        </ul>
        </form>";
        return $ret;
    }
    
    // Formulär för uppdatering av annons
    public function generateUpdateAdForm($ad)
    {
        $types = $this->adModel->getTypes();
        $categories = $this->adModel->getCategories();
        $locations = $this->adModel->getLocations();
        $message = $this->adModel->getMessage();
        
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
        <input type='text' name='" .self::$header. "' value='" . $ad->getHeader() . "'>
        <span class='message'>
        " . $message->getHeader() . "
        </span>
        </li>";
        
        // LI 4. Beskrivning
        $ret .= "
        <li>
        <label for='" .self::$description. "'>Beskrivning:</label> 
        <textarea name='" .self::$description. "' value='" . $ad->getDescription() . "' cols=40 rows=6>"
        . $ad->getDescription() . 
        "</textarea>
        <span class='message'>
        " . $message->getDescription() . "
        </span>
        </li>";
        
        // LI 5. Pris
        $ret .= "
        <li>
        <label for='" .self::$price. "'>Pris:</label> 
        <input type='text' name='" .self::$price. "' value='" . $ad->getPrice() . "'>
        <span class='message'>
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
        <input type='text' name='" .self::$name. "' value='" . $ad->getName() . "'>
        <span class='message'>
        " . $message->getName() . "
        </span>
        </li>";
        
        // LI 7. Annonsörens mail
        $ret .= "
        <li>
        <label for='" .self::$mail. "'>Epost:</label> 
        <input type='text' name='" .self::$mail. "' value='" . $ad->getMail() . "'>
        <span class='message'>
        " . $message->getMail() . "
        </span>
        </li>";
        
        // LI 8. Annonsörens telefon
        $ret .= "
        <li>
        <label for='" .self::$phone. "'>Telefon: (frivilligt)</label> 
        <input type='text' name='" .self::$phone. "' value='" . $ad->getPhone() . "'>
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
        
       
        
        // LI 10. Publicera och förhandsgranska annons
        $ret .= "
        <li>
        <button class='submit' type='submit' name='" .self::$publishUpdated. "'>Publicera förändrad annons</button>
        </li>
        
        </ul>
        </form>";
            
        return $ret;
        
    }
    
    
    // Hämta innehåll för mail som skickas till annonsören efter att denna skapat annons
    public function getUpdateDeleteMailContent($ad)
    {
        $ret .= "Detta mail är en bekräftelse på att din annons ";
            $ret .= $ad->getHeader();
            $ret .= " ";
            //$ret .= $ad->getType()->getName();
            $ret .= " har publicerats på Studentmöbler.\n\n";
            $ret .= "Använd följande länk för att visa annons: ";
            $ret .= "http://nalaka.se/Studentmöbler/index.php?" .self::$viewAd. "&" .self::$adId. "=" .$ad->getId(). "\n\n" .

            "Använd följande länk om du vill redigera din annons: ";
            $ret .= "http://nalaka.se/Studentmöbler/index.php?" .self::$update. "&" .self::$adId. "=" .$ad->getId(). "&" 
            .self::$udString. "=" .$ad->getUpdateDeleteString(). "\n\n" .
            
            "Använd följande länk om du vill ta bort din annons: ";
            $ret .= "http://nalaka.se/Studentmöbler/index.php?" .self::$delete. "&" .self::$adId. "=" .$ad->getId(). "&" 
            .self::$udString. "=" .$ad->getUpdateDeleteString(). " ";
            
            return $ret;
    }

    
    // Input vid skapande och uppdatering av annons
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
        if (isset($_FILES[self::$image]['tmp_name']))
            return $_FILES[self::$image]['tmp_name'];
        return "";
    }
    
    
    // Input vid skapande av meddelande till Annonsörens
    public function getSenderName()
    {
        if (isset($_POST[self::$senderName]))
            return $_POST[self::$senderName];
        return "";
    }
    
    public function getSenderMail()
    {
        if (isset($_POST[self::$senderMail]))
            return $_POST[self::$senderMail];
        return "";
    }
    
    public function getSenderMessage()
    {
        if (isset($_POST[self::$senderMessage]))
            return $_POST[self::$senderMessage];
        return "";
    }
    
    
    
   
    
}