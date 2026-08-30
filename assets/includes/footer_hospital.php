        <footer class="footer">
            <div class="copyright">
                <p>
                    <span>Copyright <span class="copyright">©</span> <?=date('Y');?> </span>
                    <span>Upchar</span>.
                    <span>All rights reserved. </span>
                </p>
            </div>
        </footer>
    </main>
    <!-- END MAIN CONTENT -->
</div>
<!-- END DASHBOARD LAYOUT -->

    <a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>
	
    <script src="<?=base_url();?>assets/js/jquery-3.1.0.min.js"></script>
    <script src="<?=base_url();?>assets/js/jquery-migrate-3.0.0.min.js"></script>
    <script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url();?>assets/js/application.js"></script>
    <!-- Main Application Script -->
    <script src="<?=base_url();?>assets/js/layout.js"></script>

    <script>
    $(document).ready(function () {
        // Multi-selector event delegation for nested sub-menus
        $(document).on('click', '.nav-sidebar .submenu-toggle, .nav-sidebar li.has-submenu > a, .nav-sidebar li.nav-parent > a', function (e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $trigger = $(this);
            var $parentLi = $trigger.closest('li.has-submenu, li.nav-parent');
            var $submenu = $parentLi.children('.submenu, .children');
            var $arrow = $trigger.find('.arrow-icon, .arrow');

            if ($submenu.length) {
                if ($submenu.is(':visible') || $parentLi.hasClass('active')) {
                    $submenu.stop(true, true).slideUp(200, function() {
                        $submenu.removeClass('show');
                    });
                    $parentLi.removeClass('active');
                    $arrow.css('transform', 'rotate(0deg)').removeClass('active');
                } else {
                    // Close sibling submenus (Accordion effect)
                    $parentLi.siblings('.has-submenu, .nav-parent').removeClass('active').each(function() {
                        var $other = $(this);
                        $other.children('.submenu, .children').stop(true, true).slideUp(200).removeClass('show');
                        $other.find('.arrow-icon, .arrow').css('transform', 'rotate(0deg)').removeClass('active');
                    });

                    // Open current submenu
                    $submenu.stop(true, true).slideDown(200, function() {
                        $submenu.addClass('show');
                    });
                    $parentLi.addClass('active');
                    $arrow.css('transform', 'rotate(90deg)').addClass('active');
                }
            }
        });

        // Ensure active menu children are visible on load
        $('.nav-sidebar li.has-submenu.active, .nav-sidebar li.nav-parent.active').each(function() {
            var $sub = $(this).children('.submenu, .children');
            var $arr = $(this).find('.arrow-icon, .arrow');
            $sub.show().addClass('show');
            $arr.css('transform', 'rotate(90deg)').addClass('active');
        });
    });

    $(window).on('load', function () {
        $(".trigger_popup_fricc").click(function(){
            $('.hover_bkgr_fricc').show();
        });
        $('.hover_bkgr_fricc').click(function(){
            $('.hover_bkgr_fricc').hide();
        });
        $('.popupCloseButton').click(function(){
            $('.hover_bkgr_fricc').hide();
        });
    });
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    <script>
    function myalert(content='',title='Alert!'){
        $.alert({ title: title, content: content });
    }
    <?php 
    $flashmsg = $this->session->flashdata('flashmsg');
    if (is_array($flashmsg) && !empty($flashmsg['msg'])) {
        echo "myalert('".addslashes($flashmsg['msg'])."', '".addslashes($flashmsg['status'])."');";
    } elseif (is_string($flashmsg) && !empty($flashmsg)) {
        // If string message
        echo "/* flashmsg */";
    }
    ?>
    </script>
</body>
</html>

