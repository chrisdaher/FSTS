<?php
include_once("html.php");
include_once("Bar.php");
include_once("GeneralBar.php");
include_once("OptionBar_AbstractFactory.php");


class OptionBar_Admin extends OptionBar_AbstractFactory{
    
    
    public function __construct(){
        parent::__construct();
        /*$this->divID="div_optionBar";
        $this->divID="OptionBarContainer";*/

        
        $this->buildBar();
    }

    protected function buildLeft(){
               
    }
    protected function buildCenter(){
		$toBeAdded = new html("center");
        $tempContainer = new html("div", "div_adminLinks");	
		
	
        $tempLink = new html("a", "link_adminLink");
        $tempLink->setText("Language");
        $tempLink->addAttribute("href", "#Language");
        $tempContainer->addChild($tempLink);
        
        $tempSeparator = new html("label", "link_separator");
        $tempSeparator->setText(" / ");
        $tempContainer->addChild($tempSeparator);
        
        $tempLink = new html("a", "link_adminLink");
        $tempLink->setText("Postal Code");
        $tempLink->addAttribute("href", "#PostalCode");
        $tempContainer->addChild($tempLink);
        
        $tempSeparator = new html("label", "link_separator");
        $tempSeparator->setText(" / ");
        $tempContainer->addChild($tempSeparator);
        
        $tempLink = new html("a", "link_adminLink");
        $tempLink->setText("Marital Status");
        $tempLink->addAttribute("href", "#MaritalStatus");
        $tempContainer->addChild($tempLink);
        
        $tempSeparator = new html("label", "link_separator");
        $tempSeparator->setText(" / ");
        $tempContainer->addChild($tempSeparator);
        
        $tempLink = new html("a", "link_adminLink");
        $tempLink->setText("Relationship");
        $tempLink->addAttribute("href", "#Relationship");
        $tempContainer->addChild($tempLink);
        
        $tempSeparator = new html("label", "link_separator");
        $tempSeparator->setText(" / ");
        $tempContainer->addChild($tempSeparator);
        
        $tempLink = new html("a", "link_adminLink");
        $tempLink->setText("Work Status");
        $tempLink->addAttribute("href", "#WorkStatus");
        $tempContainer->addChild($tempLink);
        
        $tempSeparator = new html("label", "link_separator");
        $tempSeparator->setText(" / ");
        $tempContainer->addChild($tempSeparator);
        
        $tempLink = new html("a", "link_adminLink");
        $tempLink->setText("Event Type");
        $tempLink->addAttribute("href", "#EventType");
        $tempContainer->addChild($tempLink);
        
        $tempSeparator = new html("label", "link_separator");
        $tempSeparator->setText(" / ");
        $tempContainer->addChild($tempSeparator);
        
        $tempLink = new html("a", "link_adminLink");
        $tempLink->setText("Income Type");
        $tempLink->addAttribute("href", "#IncomeType");
        $tempContainer->addChild($tempLink);
        
        $tempSeparator = new html("label", "link_separator");
        $tempSeparator->setText(" / ");
        $tempContainer->addChild($tempSeparator);
        
        $tempLink = new html("a", "link_adminLink");
        $tempLink->setText("Income Mode");
        $tempLink->addAttribute("href", "#IncomeLength");
        $tempContainer->addChild($tempLink);
        
        $toBeAdded->addChild($tempContainer);
        $this->bar->addCenter($toBeAdded);
		
		$tempLink = new html("div", "logoImg");
		$this->bar->addLeft($tempLink);
    }
    protected function buildRight(){

    }
    

}
?>