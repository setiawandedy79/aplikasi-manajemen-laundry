    </div> <!-- .main-content -->

    <!-- FOOTER -->
    <footer class="app-footer">
        <div class="copyright">
            All Rights Reserved-IT RSPM | &copy; <?php echo defined('SITE_NAME') ? SITE_NAME : 'Medika Laundry Pro'; ?> - <?php echo date('Y'); ?>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 4000);
    });
    </script>
</body>
</html>