<?php
/**
 * Colletion of Commonly used functions in the Onyx Framework
 */

/**
 * Renders and image with the approriate path
 * @param string $fileName      The filename for the image you would like to render
 * @param st [$path = null] path for the image either Onyx or extensions
 */
function renderImage($fileName, $path = null){
    $file = BASE_PATH.($path != null? $path.'/':'/').'assets/images/'.$fileName;
    if(file_exists($file)){
     ?><img src="<?php echo BASE_URL.($path != null? $path.'/':'/').'assets/images/'.$fileName; ?>"><?php
    }
}
function ensureArray(&$array){
    $array = (array)$array;
    foreach($array as $key => $value){
        if(is_object($array[$key])){
            $array[$key] = (array)$array[$key];   
        }
        if(is_array($array[$key])){
            foreach($array[$key] as $k => $v){
                if(is_object($array[$key][$k])){
                    $array[$key][$k] = (array)$array[$key][$k];
                }
            }
        }
    }
    //var_dump($array);
}
function return_Onyx_file_array($searchArray, $key = null, $value = null){
    ensureArray($searchArray);
    if($fv = array_column($searchArray, $key)){
        return $fv[0];
    }
    foreach($searchArray as $akey){
        $akey = (array)$akey;
        $akey = array('supportedType' => array('mysql', 'pdo'));
        if($v = array_column($akey, $key)){
            return $v[0];
        }
        foreach($akey as $bkey){
            if($v = array_column($bkey, $key)){
                return $v[0];
            }
        }
    }
}