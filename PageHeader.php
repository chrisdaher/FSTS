<?php
require_once('php/services/BrowserDetection/Browser.php');
include_once("php/services/Theme/ThemeServices.php");
class PageHeader{
    private $header;
    private $title;
    private $meta;
    public function __construct($PageName=null){
        $this->header="<head>";
        $this->setTitle($PageName);
    }
    
    public function setTitle($PageName){
        $this->title = "<title>".$PageName."</title>";
    }
    public function addComment($Section){
        $this->header.="<!--".$Section."-->";
    }
    public function addCSS($location){
        $this->header.= '<link type="text/css" href="'.$location.'" rel="stylesheet" />';
    }
    public function addJS($location){
        $this->header.= '<script type="text/javascript" src="'.$location.'"></script>';
    }
    public function addManualJS($command){
        $this->header.="<script>".$command."</script>";
    }
    public function addMeta($http_equiv="Content-Language", $content="en-us"){
        $this->header.= '<meta http-equiv="'.$http_equiv.'" content="'.$content.'" />';
    }
    public function getHeader(){
        $this->header.=$this->title."</head>";
        return $this->header;
    }
    public function getBrowserPath(){
        $browser = new Browser();

        //if( $browser->getBrowser() == Browser::BROWSER_IE){
        //    print("css/IE".ceil($browser->getVersion()));
        //}
        //else{
            return("css/IE9");
        //}
    }
    public function getThemePath(){
		$id = $_COOKIE['LoginID'];
		$theTheme = getThemeString($id);
		return "theme/$theTheme";
    }
}
?>