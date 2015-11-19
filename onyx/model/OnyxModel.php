<?php
class OnyxModel {
    
    public $connection;
    
    public $styles;
    
    public $headerScripts;
    
    public $footerScripts;
    
    //static $instance = null;
    public $Onyx;
    
    final public function __construct(){
        $this->Onyx = OnyxService::GetInstance();
        
        $this->main();
    }
    /*
    final static function GetInstance(){
        if(OnyxModel::$instance == null){
            OnyxModel::$instance = new OnyxModel();
        }
        return OnyxModel::$instance;
    }
    */

    public function styles($file, $path = null, $plugin = null){
        if(is_array($file) && (isset($file['type']) && $file['type'] == 'inline')){
            $this->buildInlineStyle($file);
        }else if(is_array($file)){
            $path = BASE_URL.($path != null ? $path.'/' : '').($plugin != null ? $plugin.'/' :'');
            $title = isset($file['title']) && $file['title'] != '' ? 'title="'.$file['title'].'"' : '';
            $styleString = sprintf('<link href="%s" rel="stylesheet" %s type="text/css" />%s', $path.'assets/css/'.$file['file'], $title, "\r\n");
            $this->styles[] = $styleString;
        }
        //throw some kind of error that $file was not passed as an array 
    }
    
    public function headerScripts($file, $path = null, $plugin = null){
        $this->scriptSwitch($file, $path, $plugin, 'headerScripts');
    }
    public function footerScripts($file, $path = null, $plugin = null){
        $this->scriptSwitch($file, $path,$plugin, 'footerScripts');
    }
    private function scriptSwitch($file, $type, $path = null,$plugin = null){
        $path = BASE_URL.($path != null ? $path.'/' : '').($plugin != null ? $plugin.'/' :'');
        if(is_array($file) && (isset($file['type']) && $file['type'] == 'inline')){
            $scriptString = $this->buildInlineSript($file);
        }else if(is_array($file)){
            $scriptString = sprintf('<script src="%s"></script>%s', $path.'assets/js/'.$file['file'], "\r\n");
        }
        $this->$type = array($scriptString);
    }
    public function renderStyles(){
        $styles = '';
        if($this->styles){
            foreach($this->styles as $style){
                $styles .= $style;
            }
        }
        return $styles;
    }
    public function renderHeaderScripts(){
        $headerScripts = '';
        if($this->headerScripts){
            foreach($this->headerScripts as $script){
                $headerScripts .= $script;
            }
        }
        return $headerScripts;
    }
    public function renderFooterScripts(){
        $footerScripts = '';
        if($this->footerScripts){
            foreach($this->footerScripts as $script){
                $headerScripts .= $script;
            }
        }
        return $footerScripts;
    }
    private function buildInlineStyle($file){
        
        return $scriptString;
    }
    private function buildInlineScript($file){
        
        return $scriptString;
    }
    
}