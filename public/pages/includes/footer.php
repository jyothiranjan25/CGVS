<!-- partial:partials/_footer.html -->
<!-- <footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright ©
            <a href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com</a>
            2020</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Free
            <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard </a>templates from
            Bootstrapdash.com</span>
    </div>
</footer> -->
<!-- partial -->

<!-- base:js -->
<script src="../vendors/js/vendor.bundle.base.js"></script>
<script src="../vendors/datatables.net/jquery.dataTables.js"></script>
<script src="../vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="../js/off-canvas.js"></script>
<script src="../js/hoverable-collapse.js"></script>
<script src="../js/template.js"></script>
<script src="../js/settings.js"></script>
<script src="../js/todolist.js"></script>
<script src="../js/data-table.js"></script>
<!-- endinject -->
<!-- plugin js for this page -->
<script src="../vendors/progressbar.js/progressbar.min.js"></script>
<!-- Custom js for this page-->
<script src="../js/progress-bar.js"></script>
<!-- End custom js for this page-->
<script src="../vendors/chart.js/Chart.min.js"></script>
<!-- End plugin js for this page -->
<!-- Custom js for this page-->
<script src="../js/dashboard.js"></script>
<!-- End custom js for this page-->

<script src="../js/butterup.min.js"></script>

<script>
    function removeQueryParams() {
        const url = window.location.origin + window.location.pathname;
        window.history.pushState({}, document.title, url);
    }
</script>

<!-- Edit modal script-->
<?php
if (isset($_REQUEST['edit'])) {
?>
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#editModal').modal('show');
        });
    </script>
<?php
}
?>

<?php
if ((isset($_SESSION['toasts_title']) && $_SESSION['toasts_title'])) {
?>
    <script>
        butterup.options.maxToasts = 3;
        butterup.options.toastLife = 3000;
        butterup.toast({
            title: "<?php echo $_SESSION['toasts_title']; ?>",
            message: "<?php echo $_SESSION['toasts_message']; ?>",
            type: "<?php echo $_SESSION['toasts_type']; ?>",
            dismissable: true,
            icon: true,
        });
    </script>
<?php
    unset($_SESSION['toasts_title']);
    unset($_SESSION['toasts_message']);
    unset($_SESSION['toasts_type']);
    unset($_SESSION['inserted_id']);
}
?>