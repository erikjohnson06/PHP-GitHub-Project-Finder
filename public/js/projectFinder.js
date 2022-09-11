
/****************************
 *                          *
 *  PHP Project Finder JS   *
 *                          *
 ****************************/

"use strict"; 

(function ()
{
    /**
     * PHP Project Finder. Main class to manage the functionality of the GitHub Project Finder site. 
     * 
     * @type object
     */
    var ProjectFinder = {
                
        csrfHash : "",
        csrfToken : "",
        
        eventListenersLoaded : false, 
        initialLoadComplete : false, 
        loadProcessRunning : false, 
        
        /**
         * @type Array
         */
        projectListData : [],
        
        initialize : function(){
                        
            addHandlers();
            
            this.getProjectListData();
        },

        getProjectListData : function(){
            
            var self = this;
            var table = jQuery("table#projectListResults");

            if (!this.initialLoadComplete){
                table.find("tbody").html(
                        "<tr>" + 
                            "<td colspan='2' class='empty-table'>Loading Data... " + 
                            //"<div class='spinner-border spinner-border-sm' role='status'><span class='sr-only'>Loading...</span></div>" + 
                            "<i class='fas fa-spinner fa-spin'></i>" + 
                            "</td>" + 
                        "</tr>"
                        );
            }

            jQuery.ajax({
                type : "GET",
                url : "ProjectFinderJS/getProjectListData", 
                data : {
                    [self.csrfToken] : self.csrfHash
                },
                dataType : 'json',
                cache : false,
                beforeSend : function (){
                    //jQuery('div.overlay').fadeIn('fast');
                },
                complete : function (a){
                    //jQuery('div.overlay').fadeOut('fast');
                    self.initialLoadComplete = true;
                },
                success : function (result){
                    
                    console.log(result);

                    if (result.error){
                        
                        return false;
                    }

                    self.projectListData = result.data.project_data;

                    if (self.projectListData){
                        
                        buildProjectListTable(self.projectListData); //table#projectListResults
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
                error : function (a, b, c){
                    table.find("tbody").html("<tr><td colspan='2' class='empty-table'>Unable to load project data. </td></tr>");
                    console.log(a, b, c);
    //                jQuery('div.overlay').fadeOut('fast');
    //                Common.displayMessage("An Error Occurred. If this persists please contact your Administrator.", "danger", 5);
                }
            });

        },
        
        populateRepositoryDetail : function(id){
            
            console.log(id);
            
            var self = this;
            var modal = jQuery("div#projectDetailModal");
            
            jQuery.ajax({
                type : "GET",
                url : "ProjectFinderJS/getProjectListDetail", 
                data : {
                    id : id,
                    [self.csrfToken] : self.csrfHash
                },
                dataType : 'json',
                cache : false,
                beforeSend : function (){
                    //jQuery('div.overlay').fadeIn('fast');
                },
                complete : function (a){
                    //jQuery('div.overlay').fadeOut('fast');
                    //self.initialLoadComplete = true;
                },
                success : function (result){
                    
                    console.log(result);

                    if (result.error){
                        
                        return false;
                    }

/*
                    self.projectListData = result.data.project_data;

                    if (self.projectListData){
                        
                        buildProjectListTable(self.projectListData); //table#projectListResults
                    }

                    //self.csrfHash = result.data.token; //Refresh token

    //                if (data.error)
    //                {
    //                    Common.displayMessage(data.error_msg, 'danger');
    //                    return false;
    //                }
    //
    //                div.find('select#route').html(data.data);
*/
                },
                error : function (a, b, c){
                    table.find("tbody").html("<tr><td colspan='2' class='empty-table'>Unable to load project data. </td></tr>");
                    console.log(a, b, c);
    //                jQuery('div.overlay').fadeOut('fast');
    //                Common.displayMessage("An Error Occurred. If this persists please contact your Administrator.", "danger", 5);
                }
            });
        },
        
        loadGitHubProjects : function(){

            console.log("loadGitHubProjects...");

            var self = this;

            if (this.loadProcessRunning){
                return false;
            }

            jQuery.ajax({
                type : "POST",
                url : "ProjectFinderJS/loadGitHubProjects",
                data : {
                    [self.csrfToken] : self.csrfHash
                },
                dataType : 'json',
                cache : false,
                beforeSend: function (){
                    //jQuery('div.overlay').fadeIn('fast');
                },
                complete : function (a){
                    //jQuery('div.overlay').fadeOut('fast');
                    self.loadProcessRunning = false;
                },
                success : function (data){
                    console.log(data);

    //                if (data.error)
    //                {
    //                    Common.displayMessage(data.error_msg, 'danger');
    //                    return false;
    //                }
    //
    //                div.find('select#route').html(data.data);

                },
                error : function (a, b, c){
                    console.log(a, b, c);
    //                jQuery('div.overlay').fadeOut('fast');
    //                Common.displayMessage("An Error Occurred. If this persists please contact your Administrator.", "danger", 5);
                }
            });
        }
        
    };
    
    /*
     * Helper functions
     */
    
    /**
     * 
     * @returns {Boolean}
     */
    var addHandlers = function(){

        //var self = this;

        console.log("addHandlers...");
        
        if (ProjectFinder.eventListenersLoaded){
            return false;
        }
        
        jQuery("table#projectListResults").on("click", "tbody tr", function(){
            
            var id = jQuery(this).attr("data-repo-id");
            
            //Display modal with detail
            ProjectFinder.populateRepositoryDetail(id);
        });
        
        ProjectFinder.eventListenersLoaded = true;
    };   
    
    var buildProjectListTable = function(){
        
        if (!ProjectFinder.projectListData || !ProjectFinder.projectListData.length){
            return false;
        }
        
        var table = jQuery("table#projectListResults");
        var html = "";
        var i = 0;
        
        for (i = 0; i < ProjectFinder.projectListData.length; i++){
            
            html += "<tr data-repo-id='" + ProjectFinder.projectListData[i].repository_id + "'>";
            html += "<td>" + ProjectFinder.projectListData[i].name + "</td>";
            html += "<td>" + formatNumber(ProjectFinder.projectListData[i].stargazers_count) + "</td>";
            html += "</tr>";
        }
        
        //Clear table and remove DataTable formatting before re-writing
        initDataTable.emptyTable(table);
        initDataTable.destroy(table);    
        
        table.find("tbody").html(html);
        
        //Now use DataTable to format and add functionality to the table
        initDataTable.activate(table);
    };
        
    /**
     * Manage DataTable formatting
     * 
     * @type object
     */
    var initDataTable = {

        activate : function(el){

            if (!el.length){
                return false;
            }

            try {
                el.dataTable({
                    iDisplayLength: 50,
                    autoWidth: false,
                    aaSorting: [],
                    language: {
                        searchPlaceholder: 'Filter Results',
                        search: '',
                        emptyTable : 'No results',
                        infoEmpty : '',
                        lengthMenu : 'Display _MENU_'}
                });
            }
            catch (err){
                console.log(err);
            }
        },

        destroy : function(el){

            if (!el.length){
                return false;
            }

            var table = el.DataTable();
            table.clear().destroy(); //Remove dataTable formatting
        },
        
        emptyTable : function(el){

            if (!el.length){
                return false;
            }

            el.find('tbody').html("");
        }
    };

    var formatNumber = function(val){
        
        if (!val){
            return val;
        }
        
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };
    
    //Add the object to the window
    window.ProjectFinder = ProjectFinder;

    //Initialize the confirm modal
    //jQuery(document).on('ready', function ()
    //{
    //    confirm_modal.initialize();
    //});
})();