var Onyx = (function(){
    $o = jQuery;
    global = window;

    var Onyx = function(){
        this.ajaxUrl = '/onyx/Ajax';
        this.$o = $o;
    };
    Onyx.prototype.GetCurrentUrl = function(){
        console.log(window.location);
        this.currentLocation = window.location.href;
    };
    Onyx.prototype.get = function(obj, success, failure){
      
    };
    Onyx.prototype.post = function(obj, success, failure){

    };
    return new Onyx();
}())