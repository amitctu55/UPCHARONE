    </main>

    <!-- Master Pathlab Footer -->
    <footer class="pathlab-footer" style="background: #ffffff; border-top: 1px solid #e2e8f0; padding: 16px 25px; margin-top: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; font-size: 12.5px; color: #64748b;">
            <div>
                <span>&copy; <?=date('Y');?> <strong>Upchar Healthcare Systems</strong>. All rights reserved.</span>
            </div>
            <div style="display: flex; gap: 16px;">
                <a href="<?=base_url('tnc');?>" target="_blank" style="color: #64748b; text-decoration: none;">Terms &amp; Conditions</a>
                <a href="<?=base_url('privacy');?>" target="_blank" style="color: #64748b; text-decoration: none;">Privacy Policy</a>
                <a href="<?=base_url('contactus');?>" target="_blank" style="color: #00a896; text-decoration: none; font-weight: 600;">Partner Support</a>
            </div>
        </div>
    </footer>
</div> <!-- /pathlab-main-viewport -->
</div> <!-- /pathlab-layout -->

<script src="<?=base_url();?>assets/js/jquery-3.1.0.min.js"></script>
<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    // 1. Sidebar Toggle (Desktop & Mobile)
    $('#sidebar-toggle-btn').on('click', function(e) {
        e.preventDefault();
        if ($(window).width() <= 991) {
            $('body').toggleClass('sidebar-open');
        } else {
            $('body').toggleClass('sidebar-collapsed');
        }
    });

    // 2. Mobile Backdrop Click Closes Sidebar
    $('#sidebar-mobile-backdrop').on('click', function() {
        $('body').removeClass('sidebar-open');
    });

    // 3. User Profile Dropdown Toggle
    $('#user-profile-btn').on('click', function(e) {
        e.stopPropagation();
        $('#user-profile-menu').toggleClass('open');
    });

    // Close Dropdown on outside click
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#user-profile-menu').length) {
            $('#user-profile-menu').removeClass('open');
        }
    });

    // Close mobile sidebar on window resize if enlarged
    $(window).on('resize', function() {
        if ($(window).width() > 991) {
            $('body').removeClass('sidebar-open');
        }
    });
});
</script>
</body>
</html>
