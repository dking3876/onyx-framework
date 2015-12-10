<?php
/**/
class OnyxModel {
    
    public $connection;
    
    public $styles;
    
    public $headerScripts;
    
    public $footerScripts;
    
    
    //static $instance = null;
    public $Onyx;

    /**
     *
     *
     */
    final public function __construct(){
        $this->Onyx = &OnyxService::GetInstance();
        
        $this->main();
    }
    /**
     * enque styles to appear in the head of th page
     * @param array  $file            Array containing type => inline|external, title => identify this embeed, file => file name
     * @param string [$path           = null]   string to identify the path of the enqued script Onyx|extensions If ommitted uses default assets folder
     * @param string [$plugin         = null] If plugin is specified in path identify the extention folder
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
    /**
     * [[Description]]
     * @param [[Type]] $file            [[Description]]
     * @param [[Type]] [$path = null]   [[Description]]
     * @param [[Type]] [$plugin = null] [[Description]]
     */
    public function headerScripts($file, $path = null, $plugin = null){
        $this->scriptSwitch($file, $path, $plugin, 'headerScripts');
    }
    /**
     * [[Description]]
     * @param [[Type]] $file            [[Description]]
     * @param [[Type]] [$path = null]   [[Description]]
     * @param [[Type]] [$plugin = null] [[Description]]
     */
    public function footerScripts($file, $path = null, $plugin = null){
        $this->scriptSwitch($file, $path,$plugin, 'footerScripts');
    }
    /**
     * [[Description]]
     * @param [[Type]] $file            [[Description]]
     * @param [[Type]] $type            [[Description]]
     * @param [[Type]] [$path = null]   [[Description]]
     * @param [[Type]] [$plugin = null] [[Description]]
     */
    private function scriptSwitch($file, $path, $plugin = null, $type){
        $path = BASE_URL.($path != null ? $path.'/' : '').($plugin != null ? $plugin.'/' :'');
        $scriptString;
        if(is_array($file) && (isset($file['type']) && $file['type'] == 'inline')){
            $scriptString = $this->buildInlineSript($file);
        }else if(is_array($file)){
            $scriptString = sprintf('<script src="%s"></script>%s', $path.'assets/js/'.$file['file'], "\r\n");
        }else{
            $native = $this->GetSupportedScripts();
            if(array_key_exists($file, $native)){
                $type = $native[$file][0];
                $scriptString = sprintf('<script type="text/javascript" src="%s"></script>%s', BASE_URL.'onyx/assets/js/'.$native[$file][1], "\r\n");
            }
        }
        $this->{$type}[] = $scriptString;
    }
    /**
     * [[Description]]
     * @return [[Type]] [[Description]]
     */
    public function renderStyles(){
        $styles = '';
        if($this->styles){
            foreach($this->styles as $style){
                $styles .= $style;
            }
        }
        return $styles;
    }
    /**
     * [[Description]]
     * @return [[Type]] [[Description]]
     */
    public function renderHeaderScripts(){
        $headerScripts = '';
        if($this->headerScripts){
            foreach($this->headerScripts as $script){
                $headerScripts .= $script;
            }
        }
        return $headerScripts;
    }
    /**
     * [[Description]]
     * @return [[Type]] [[Description]]
     */
    public function renderFooterScripts(){
        $footerScripts = '';
        if($this->footerScripts){
            foreach($this->footerScripts as $script){
                $footerScripts .= $script;
            }
        }
        return $footerScripts;
    }
    /**
     * [[Description]]
     * @param  [[Type]] $file [[Description]]
     * @return [[Type]] [[Description]]
     */
    private function buildInlineStyle($file){
        
        return $scriptString;
    }
    /**
     * [[Description]]
     * @param  [[Type]] $file [[Description]]
     * @return [[Type]] [[Description]]
     */
    private function buildInlineScript($file){
        
        return $scriptString;
    }
    
    private function GetSupportedScripts(){
        $array = array(
            'jquery' => array(
                'headerScripts',
                "jquery-1.11.3.min.js"
                ),
            'angular' => array(
                'headerScripts', 
                'angular.min.js'
                )
        );
        return $array;
    }
    
}