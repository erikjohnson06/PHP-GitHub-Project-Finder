
/******************************
 *                            *
 *  PHP Project Finder JS     *
 *                            *
 ******************************/

"use strict"; 
/*
var ProjectFinder = {
    

    initialize : function(){
        this.addHandlers();
    },

    addHandlers : function(){
        
        var self = this;
    }   
};
*/

(function ()
{

    var baseUrl = "";
    
    /**
     * PHP Project Finder. Main class to manage the functionality of the GitHub Project Finder site. 
     * 
     * @type object
     */
    var ProjectFinder = {
                
        eventListenersLoaded : false, 
        baseUrl : "",
        csrfHash : "",
        csrfToken : "",
        
        initialize : function(url){
            
            if (url){
                baseUrl = url;
            }
            
            console.log("Project Finder is loaded, baby!", baseUrl);
            
            if (!this.eventListenersLoaded){
                addHandlers();
            }
            
            test();
            
            //this.getProjectListData();
        },

        getProjectListData : function(){

            console.log("getProjectListData...");
            var self = this;

    //        if (true){
    //            return false;
    //        }

            jQuery.ajax({
                type      : "GET",
                url       :  "ProjectFinderJS/getProjectListData", 
                data      : {
                    val : "testVal",
                    [self.csrfToken] : self.csrfHash
                },
                dataType  : 'json',
                cache     : false,
                beforeSend: function ()
                {
                    //jQuery('div.overlay').fadeIn('fast');
                },
                complete  : function (a)
                {
                    //jQuery('div.overlay').fadeOut('fast');
                },
                success   : function (result)
                {
                    console.log(result);

                    if (result.error){
                        
                        return false;
                    }

                    if (result.data.project_data){
                        
                    }

                    //self.csrfHash = result.data.token; //Refresh token

    //                if (data.error)
    //                {
    //                    Common.displayMessage(data.error_msg, 'danger');
    //                    return false;
    //                }
    //
    //                div.find('select#route').html(data.data);

                },
                error     : function (a, b, c)
                {
                    console.log(a, b, c);
    //                jQuery('div.overlay').fadeOut('fast');
    //                Common.displayMessage("An Error Occurred. If this persists please contact your Administrator.", "danger", 5);
                }
            });

        }
        
    };
    
    var addHandlers = function(){

        //var self = this;

        console.log("addHandlers...");
        
        ProjectFinder.eventListenersLoaded = true;
    };   
    
    var test = function(){
        
        console.log("updateProjectList...");
        
//        if (true){
//            return false;
//        }
        
        jQuery.ajax({
            type      : "POST",
            url       :  "ProjectFinderJS/test", //"/ajax-test", //+ "/ProjectFinderController/test" ProjectFinder.baseUrl + 
            data      : {
                val : "testVal",
                [ProjectFinder.csrfToken] : ProjectFinder.csrfHash
            },
            dataType  : 'json',
            cache     : false,
            beforeSend: function ()
            {
                //jQuery('div.overlay').fadeIn('fast');
            },
            complete  : function (a)
            {
                //jQuery('div.overlay').fadeOut('fast');
            },
            success   : function (data)
            {
                console.log(data);
                
//                if (data.error)
//                {
//                    Common.displayMessage(data.error_msg, 'danger');
//                    return false;
//                }
//
//                div.find('select#route').html(data.data);

            },
            error     : function (a, b, c)
            {
                console.log(a, b, c);
//                jQuery('div.overlay').fadeOut('fast');
//                Common.displayMessage("An Error Occurred. If this persists please contact your Administrator.", "danger", 5);
            }
        });
        
    };
    

    
    //Add the object to the window
    window.ProjectFinder = ProjectFinder;

    //Initialize the confirm modal
    //jQuery(document).on('ready', function ()
    //{
    //    confirm_modal.initialize();
    //});
})();