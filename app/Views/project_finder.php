
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-12 col-12 align-self-center">
                        <h3 class="text-themecolor">GitHub Project Finder</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Language</a></li>
                            <li class="breadcrumb-item active">PHP</li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row" id="projectListContainer">
                    <!-- Column -->
                    
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-6 col-6">
                                        <div class="d-flex flex-wrap">
                                            <div>
                                                <h3 class="card-title">Public PHP Projects</h3>
                                                <h6 class="card-subtitle">Most-Starred Projects on GitHub</h6> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 align-right">
                                        <span id="last_update_timestamp">Last Updated: [None]</span>
                                        <span id="launch_update_request">[Update Now]</span>
                                    </div>
                                </div>
                                <div  class="row">
                                    <div class="col-12" id="info-msg-container"></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <hr />
                                        <div class="table-container" style="min-height: 360px;">
                                            <table id="projectListResults" class="table table-bordered table-hover">
                                                <thead>
                                                    <th>Repository Name</th>
                                                    <th>Number of Stars</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" class="empty-table">No Results</td>
                                                    </tr>
                                                </tbody>
                                            </table>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row -->
                <!-- Row -->
                
                <!-- ============================================================== -->
                <!-- End Page Content -->
                <!-- ============================================================== -->
            </div>

            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            
            <!-- Project Detail Modal -->
            <div id="project_detail_modal" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="modal-title">Project Detail</span>
                            <a class="close" data-dismiss="modal" aria-label="Close" title="Close Window">[X]</a>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">?? 2022 Erik Johnson Studios</footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
