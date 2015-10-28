<?php

namespace controller;

require_once ("model/AdModel.php");
require_once ("view/AdView.php");

class Controller
{
    private $adModel;
    private $adView;
   
    
    public function __construct($adModel, $adView)
    {
        $this->adModel = $adModel;
        $this->adView = $adView;
    }
    
    public function main()
    {

        $ret = $this->adView->generateSideBar();
        
        // UR1: Användaren ska kunna visa alla annonser utifrån vald kategori
        if ($this->adView->userWantsToViewAds())
        {
            $ads = $this->adModel->getAds($this->adView->getSelectedCategoryId());
            $ret = $this->adView->generateSideBar();
            $ret .= $this->adView->generateAdList($ads);
        }
        
        // UR2: Användaren ska kunna visa detaljer om vald annons
        if ($this->adView->userWantsToViewAd())
        {
            $ad = $this->adModel->getSelectedAd($this->adView->getSelectedAdId());
            $ret = $this->adView->generateSideBar();
            $ret .= $this->adView->generateAdView($ad);
            
        }
        
        // UR3: Användaren ska kunna skicka meddelande till annonsören för vald annons
        if ($this->adView->userWantsToContactAdvertiser())
        {
            if ($this->adModel->doSenderValidation($this->adView->getSenderInput()))
            {
                $ret = $this->adView->generateSideBar();
                $ret .= "Ditt meddelande har skickats till annonsören!";
            }
            else
            {
                $ret = $this->adView->generateSideBar();
                $ret .= $this->adView->generateAdView($ad);
            }
            
        }
        
        // UR4: Användaren ska kunna annonsera
        if ($this->adView->userWantsToAdvertise())
        {
            $ret = $this->adView->generateSideBar() . $this->adView->generateCreateAdForm();
        }
        
        // UR4
        if ($this->adView->userWantsToPublish())
        {
            if ($this->adModel->doValidation($this->adView->getCreateAdInput()))
            {
                $adId = $this->adModel->getCreatedAdId();
                $ad = $this->adModel->getStoredAd($adId);
                $content = $this->adView->getUpdateDeleteMailContent($ad);
                $this->adModel->sendUpdateDeleteMail($content);
                $ret = $this->adView->generateSideBar();
                $ret .= "Din annons har publicerats och ett mail har skickats till adressen du uppgav!";
            }
            else
            {
                $ret = $this->adView->generateSideBar();
                $ret .= $this->adView->generateCreateAdForm();
            }
        }
        
     
        // UR5: Användaren ska kunna redigera skapad annons
        if ($this->adView->userWantsToUpdate())
        {
            $adId = $this->adView->getSelectedAdId();
            $udString = $this->adView->getUpdateDeleteString();
            $ad = $this->adModel->getStoredAd($adId);
            
            if ($this->adModel->validateUdString($adId, $udString))
            {
                $ret = $this->adView->generateSideBar();
                $ret .= $this->adView->generateUpdateAdForm($ad);
            }
        }
        
        // UR5
        if ($this->adView->userWantsToPublishUpdated())
        {
            if ($this->adModel->doValidation($this->adView->getUpdateAdInput()))
            {
                $ret = $this->adView->generateSideBar();
                $ret .= "Din annons har uppdaterats!";
            }
            else
            {
                $ret = $this->adView->generateUpdateAdForm($ad);
            }
            
        }
        
        // UR6: Användaren ska kunna ta bort skapad annons
        if ($this->adView->userWantsToDelete())
        {
            $adId = $this->adView->getSelectedAdId();
            $udString = $this->adView->getUpdateDeleteString();
            
            if ($this->adModel->validateUdString($adId, $udString))
            {
                $ret = $this->adModel->deleteAd($adId);
                $ret = $this->adView->generateSideBar();
                $ret .= "Din annons har tagits bort!";
            }
            
        }
           
        return $ret;
    }
}