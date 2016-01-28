<?php
class OnyxUpateCore {
    private $path_to_upload;
    private $zip;
    private $status;
    private static $instance = null;
    
    public static function getInstance(){
		if(!isset($_FILES['OnyxCore_update'])){
            return OnyxUpdateCore::$instance;
        }
		if( OnyxUpdateCore::$instance === null ) {
			OnyxUpdateCore::$instance = new OnyxUpdateCore();
		}
		
		return $instance;
	}
    private function __construct(){  
        $this->zip = new ZipArchive;
        return $this->status;
    }
    
    private function verify_system(){
        
    }
    
    private function version_compare(){
        
    }
    
    private function load_zip(){
        $tmp_path = $_FILES['update_file']['tmp_name'];
        $this->path_to_upload = $tmp_path;
    }
    private function update(){
        $res = $this->zip->open($this->path_to_upload);
        if ($res === TRUE) {
            $folders = array(
                'admin',
                'install',
                'onyx'
            );
            foreach($folders as $folder){
                $folderName = ucfirst($folder);
                echo "Updating your {$folderName}'s folder";
                $this->zip->extractTo(BASE_PATH, $folder);
                echo ' : status <span class="status ok">OK</span><br/>';
            }
            $this->zip->close();
            $this->status 'ok';
        } else {
            $this->status 'Failed to load the update file at '.$this->path_to_upload;
        }
    }
}
//OnyxUpateCore::getInstance();