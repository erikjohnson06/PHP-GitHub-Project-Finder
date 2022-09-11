
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
        //projectListData : [],
        
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
                success : function (results){
                    
                    console.log(results);

                    //Update CSRF token
                    if (results && results.data.token){
                        self.csrfHash = results.data.token;
                    }

                    if (results.error){
                        
                        return false;
                    }

                    //self.projectListData = results.data.project_data;

                    if (results.data.project_data){
                        
                        buildProjectListTable(results.data.project_data); //table#projectListResults
                    }
                },
                error : function (a, b, c){
                    table.find("tbody").html("<tr><td colspan='2' class='empty-table'>Unable to load project data. </td></tr>");
                    console.log(a, b, c);
    //                jQuery('div.overlay').fadeOut('fast');
    //                Common.displayMessage("An Error Occurred. If this persists please contact your Administrator.", "danger", 5);
                }
            });
        },
        
        getProjectListDetail : function(id){
                        
            if (!id){
                console.log("Missing repository id:", id);
                return false;
            }
            
            var self = this;
            var modal = jQuery("div#project_detail_modal");
            var body  = modal.find("div.modal-body");
            var title = modal.find("div.modal-header span.modal-title");
            var html = "";
            
            jQuery.ajax({
                type : "GET",
                url : "ProjectFinderJS/getProjectListDetail", 
                data : {
                    repo_id : id,
                    [self.csrfToken] : self.csrfHash
                },
                dataType : 'json',
                cache : false,
                beforeSend : function (){
                    //jQuery('div.overlay').fadeIn('fast');
                    body.html("<div class='modal_overlay' style='display: block;'><i class='fas fa-spinner fa-spin'></i></div>");
                    modal.modal("show");
                },
                complete : function (a){
                    //jQuery('div.overlay').fadeOut('fast');
                    //self.initialLoadComplete = true;
                },
                success : function (results){
                    
                    console.log(results);

                    //Update CSRF token
                    if (results && results.data.token){
                        self.csrfHash = results.data.token;
                    }

                    if (results.error){
                        
                        return false;
                    }
                    
                    /**
            $data->repository_id = (int) $row->repository_id;
            $data->name = utf8_decode(htmlentities($row->name, ENT_QUOTES));
            $data->description = utf8_decode(htmlentities($row->description, ENT_QUOTES));
            $data->html_url = htmlentities($row->html_url, ENT_QUOTES);
            $data->stargazers_count = (int) $row->stargazers_count;
            $data->created_at = $row->create_date;
            $data->pushed_at = $row->pushed_date;    
                     */
                    
                    if (results.data.project_data){
                        
                        html = "<div class='row'>";
                        html += "<table class='table table-bordered'><tbody>";
                        html += "<tr><td class='noWrap'>Repository ID</td><td>" + results.data.project_data.repository_id + "</td></tr>";
                        html += "<tr><td class='noWrap'>Name</td><td>" + results.data.project_data.name + "</td></tr>";
                        html += "<tr><td class='noWrap'>Description</td><td>" + (results.data.project_data.description ? results.data.project_data.description : "[None]")+ "</td></tr>";
                        html += "<tr><td class='noWrap'>Link to Project</td><td><a target='_blank' href='" + results.data.project_data.html_url + "'>" + results.data.project_data.html_url + "</a></td></tr>";
                        html += "<tr><td class='noWrap'>Stargazer Count</td><td>" + formatNumber(results.data.project_data.stargazers_count)  + "</td></tr>";
                        html += "<tr><td class='noWrap'>Date Created</td><td>" + results.data.project_data.created_at + "</td></tr>";
                        html += "<tr><td class='noWrap'>Last Push Date</td><td>" + results.data.project_data.pushed_at + "</td></tr>";
                        html += "</tbody></table>";
                        html += "</div>";
                        
                        body.html(html);
                    }
                },
                error : function (a, b, c){
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
                success : function (results){

                    //Update CSRF token
                    if (results && results.data.token){
                        self.csrfHash = results.data.token;
                    }

                    if (results.error){
                        console.log("results: ", results);
                        return false;
                    }

                    if (results.data.success_msg){
                        
                    }

    //                if (data.error)
    //                {
    //                    Common.displayMessage(data.error_msg, 'danger');
    //                    return false;
    //                }
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
            ProjectFinder.getProjectListDetail(id);
        });
        
        ProjectFinder.eventListenersLoaded = true;
    };   
    
    var buildProjectListTable = function(data){
        
        if (!data || !data.length){
            return false;
        }
        
        var table = jQuery("table#projectListResults");
        var html = "";
        var i = 0;
        
        for (i = 0; i < data.length; i++){
            
            html += "<tr data-repo-id='" + data[i].repository_id + "'>";
            html += "<td>" + data[i].name + "</td>";
            html += "<td>" + formatNumber(data[i].stargazers_count) + "</td>";
            html += "</tr>";
        }
        
        //Clear table and remove DataTable formatting before re-writing
        initDataTable.emptyTable(table);
        initDataTable.destroy(table);    
        
        //Populate table
        table.find("tbody").html(html);
        
        //Now use DataTable to format and add functionality to the table
        initDataTable.activate(table);
    };
        
    var populateModalProjectDetail = function(data){
        
        console.log(data);
        
        if (!data){
            
            return false;
        }
        
        var modal  = jQuery("div#project_detail_modal");
        var title  = modal.find("div.modal-header span.modal-title");
        var body   = modal.find("div.modal-body");
        var html = "";
        
        
        
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