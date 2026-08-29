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

