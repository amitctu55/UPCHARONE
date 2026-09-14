        <!-- Standardized Chemist Footer -->
        <footer class="footer" style="background: #ffffff; border-top: 1px solid #e2e8f0; padding: 16px 28px; margin-top: auto;">
            <div class="copyright" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; color: #64748b; font-size: 13px;">
                <p style="margin: 0;">
                    <span>Copyright &copy; <?=date('Y');?> </span>
                    <strong style="color: #043d5b;">Upchar Healthcare Technologies</strong>.
                    <span>All rights reserved.</span>
                </p>
                <div style="font-size: 12px; color: #94a3b8; display: flex; align-items: center; gap: 8px;">
                    <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></span>
                    <span>Chemist Partner Command Center v2.5</span>
                </div>
            </div>
        </footer>
    </div>
    <!-- END MAIN CONTENT -->
</section>

    <a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>
	
    <script src="<?=base_url();?>assets/js/jquery-3.1.0.min.js"></script>
    <script src="<?=base_url();?>assets/js/jquery-migrate-3.0.0.min.js"></script>
    <script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>

    <script>
    $(document).ready(function() {
        // Toggle sidebar on mobile and condensed views
        $('.menutoggle, [data-toggle="sidebar-collapsed"]').on('click', function(e) {
            e.preventDefault();
            $('body').toggleClass('sidebar-show');
        });

        // Auto close sidebar on mobile when clicking outside
        $(document).on('click', function(e) {
            if ($(window).width() < 992) {
                if (!$(e.target).closest('.sidebar, .menutoggle').length) {
                    $('body').removeClass('sidebar-show');
                }
            }
        });
    });
    </script>
</body>
</html>
