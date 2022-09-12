    </div>
    <!-- ============================================================== -->
    <!-- End Main Wrapper -->
    <!-- ============================================================== -->
    
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?= base_url() ?>/public/assets/plugins/jquery/jquery.min.js"></script>
    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url() ?>/public/assets/plugins/bootstrap/js/tether.min.js"></script>
    <script src="<?= base_url() ?>/public/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?= base_url() ?>/public/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?= base_url() ?>/public/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?= base_url() ?>/public/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?= base_url() ?>/public/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url() ?>/public/js/custom.min.js"></script>
    <!--PHP Project Finder JavaScript -->
    <script src="<?= base_url() ?>/public/js/ProjectFinder.min.js"></script>    
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    
    <script type="text/javascript">
        $(document).ready(function (){
            
            //Initialize the ProjectFinder object. Record CSRF hash/tokens for ajax requests.
            ProjectFinder.csrfHash = "<?= csrf_hash() ?>";
            ProjectFinder.csrfToken = "<?= csrf_token() ?>";
            ProjectFinder.initialize();
        });
    </script>
</body>

</html>
