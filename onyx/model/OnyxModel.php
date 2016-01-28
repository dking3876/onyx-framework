<?php
/**/
class OnyxModel {
    
    public $connection;
    
    public $styles;
    
    public $headerScripts;
    
    public $footerScripts;
    
    public $metaData;
    //static $instance = null;
    public $Onyx;

    /**
     *
     *
     */
    final public function __construct(){
        $this->Onyx = &OnyxService::GetInstance();
        if(file_exists(BASE_PATH.'settings/database/IOnyxCreds.php')){ 
            $this->connection  = &OnyxConnectionService::GetInstance();
        }
        //possible remove this method as nothing else "should" fire for the method
        $this->main();
    }
    /**
     * enque styles to appear in the head of th page
     * @param array  $file            Array containing type => inline|external, title => identify this embeed, file => file name
     * @param string [$path           = null]   string to identify the path of the enqued script Onyx|extensions If ommitted uses default assets folder
     * @param string [$plugin         = null] If plugin is specified in path identify the extention folder
     */
    public function styles($file, $path = null, $plugin = null){

        if( !isset( $file['name'] ) || !isset( $file['file'] ) ){
            return false;
        }
        if( array_search($file['name'], OnyxService::$LoggedStyles) !== false){

            return false;   
        }else{
            array_push(OnyxService::$LoggedStyles, $file['name'] );

        }
        array_merge(
            array(
                'name'  => '',
                'type'  => '',
                'title' => '',
                'rel'   => 'stylesheet'
                ), $file );
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
        if(!is_array($file) && array_key_exists($file, $this->GetSupportedScripts())){
            
            $exists = $this->GetSupportedScripts();          
            $file = array(
                'name'  => $file,
                'file'  => $exists[$file][1]
                );

            
            
            $type = $exists[$file['name']][0];
        }
        if( !isset( $file['name'] ) || !isset( $file['file'] ) ){
            return false;
        }
        if( array_search($file['name'], OnyxService::$LoggedScripts) !== false){
            return false;   
        }else{
            array_push(OnyxService::$LoggedScripts, $file['name'] );
        }
        array_merge(
            array(
                'name'  => '',
                'type'  => '',
                'title' => '',
                'rel'   => 'stylesheet'
                ), $file );
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
            $i = 0;
            foreach($this->styles as $style){
                $styles .= ( $i>0 ? "\t" : "").$style;
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
            $i = 0;
            foreach($this->headerScripts as $script){
                $headerScripts .= ( $i>0 ? "\t" : "").$script;
                ++$i;
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
                ),
            'onyx'  => array(
                'headerScripts',
                'Onyx.js'
                ),
            'bootstrap' => array(
                'headerScripts',
                'bootstrap.min.js'
                )
        );
        return $array;
    }
    private function GetSupportedStyles(){
        $array = array(
            'reset' => array(
                'reset.css'
                )
        );
        return $array;
    }
    public function setting($key, $value = null){
        $args = array(
            'table' => 'onyx_settings',
            'data'  => '*',
            'conditions'    => array(
                'WHERE' =>  array(
                    "setting = '$key'"
                    )
                )
            );
        $result = $this->connection->retrieveData($args);
        if($result){
            return $result[0]["value"];
        }
        else{
            return $value;
        }
    }
    
    public function updateSetting($key, $value){
        $args = array(
            'table' => 'onyx_settings',
            'data'  => array(
                'value' => $value
            ),
            'conditions'    => array(
                'WHERE' =>  array(
                    "setting = '$key'"
                    )
                )
            );
        $result = $this->connection->updateData($args);
        //Handle a false 
        if($result){
            return $result;
        }
        else{
            
        }
    }
    
    public function addMeta($metaEntry){
        if(is_array($metaEntry)){
            $meta = sprintf('<meta name="%s" content="%s" />', $metaEntry['name'], $metaEntry['content']);
        }
        return false;
    }
    
}