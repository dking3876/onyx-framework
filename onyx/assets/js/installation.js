$(document).ready(function(){
    var $back = $('[class$="pass"]');
    console.log($back);
    
});
(function(Onyx){
    Onyx.Installation = {
        checkRequirements: function(){
            console.log(Onyx);
            console.log("Checking my Requirments");
            /*
            Onyx.$o.get("onyx/?installer&onyxajax=requirementCheck&requirement=database", function(data){
                        console.log(data);
            });
            */
            Onyx.get({
                method: "requirementCheck",
                data: {
                    "installer":"",
                    "requirement": "database"
                }
            }, function(data){
                console.log(data);
            });
        }(),
        debug: function(){

        },
        CheckDatabaseConnection: function(){
            console.log(Onyx);
        }
    };
    Onyx.CheckDatabaseConnection = function(){
        this.Installation.CheckDatabaseConnection();
        alert(this.ajaxUrl + " Can not proceed");
        return false;
    };

}(Onyx))