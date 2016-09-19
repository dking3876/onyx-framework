<?php
class user extends OnyxModel {
        
        private $OUID = null;
        private $AccessLevel;
        private $UserName;
        private $FirstName;
        private $lastName;
        private $Email;
        private $Password;
        
        public function get($parm){
            if($parm == 'Password'){
                return $this->Onyx->AuthenticateService->decrypt($this->Password);   
            }
            return $this->$parm;
        }
        public function set($parm, $value){
            if($parm == 'Password'){
                   $value = $this->Onyx->AuthenticateService->encrypt($value);
            }
            $this->$parm = $value;   
        }
        public function newUser($array){
               
        }
        public function getUser($id){
            
        }
        public function getUserBy($field, $value){

        }
        public function save(){
            //save the user
            if(null != $this->ouid){
                
            }else{
                
            }
            return $this;
        }
    }