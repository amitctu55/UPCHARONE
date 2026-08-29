                <div class="footer">
                    <div class="copyright">
                        <p class="">
                            <span>Copyright <span class="copyright">©</span> <?=date('Y');?> </span>
                            <span>Upchar</span>.
                            <span>All rights reserved. </span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END MAIN CONTENT -->
    </section>

    <a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>
	
    <script src="<?=base_url();?>assets/js/jquery-3.1.0.min.js"></script>
    <script src="<?=base_url();?>assets/js/jquery-migrate-3.0.0.min.js"></script>
    <script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url();?>assets/js/application.js"></script>
    <!-- Main Application Script -->
    <script src="<?=base_url();?>assets/js/layout.js"></script>

    <script>
    $(document).ready(function () {
        // Sidebar Sub-menu Slide Down / Up Toggle Handler
        $('body').on('click', '.nav-sidebar li.nav-parent > a', function (e) {
            e.preventDefault();
            var $parent = $(this).parent('li.nav-parent');
            var $sub = $parent.children('.children');
            
            if ($parent.hasClass('active') || $sub.is(':visible')) {
                $sub.slideUp(200);
                $parent.removeClass('active');
                $(this).find('.arrow').removeClass('active');
            } else {
                $parent.siblings('.nav-parent.active').removeClass('active').children('.children').slideUp(200);
                $parent.siblings('.nav-parent').find('.arrow').removeClass('active');
                
                $sub.slideDown(200);
                $parent.addClass('active');
                $(this).find('.arrow').addClass('active');
            }
        });

        // Ensure active menu children are visible on load
        $('.nav-sidebar li.nav-parent.active > .children').show();
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

