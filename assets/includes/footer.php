        <footer class="footer">
            <div class="copyright" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; color: #64748b; font-size: 13px;">
                <p style="margin: 0;">
                    <span>Copyright <span class="copyright">©</span> <?=date('Y');?> </span>
                    <strong style="color: #043d5b;">Upchar Healthcare Technologies</strong>.
                    <span>All rights reserved. </span>
                </p>
                <div style="font-size: 12px; color: #94a3b8;">
                    <span>Clinical Practitioner Workspace v2.4</span>
                </div>
            </div>
        </footer>
    </main>
    <!-- END MAIN CONTENT -->
</div>
<!-- END DASHBOARD-LAYOUT -->

    <a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>
	
    <script src="<?=base_url();?>assets/js/jquery-3.1.0.min.js"></script>
    <script src="<?=base_url();?>assets/js/jquery-migrate-3.0.0.min.js"></script>
    <script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url();?>assets/js/application.js"></script>
    <!-- Main Application Script -->
    <script src="<?=base_url();?>assets/js/layout.js"></script>
    
    <script>
    $(document).ready(function() {
        // Submenu accordion handler for doctor side-menu
        $('.sidebar .has-submenu > a, .sidebar .nav-parent > a').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var $parent = $(this).closest('li');
            var $sub = $parent.find('> .children, > .submenu');
            var $arrow = $(this).find('.arrow-icon, .arrow');
            
            // Close siblings
            $parent.siblings('.has-submenu, .nav-parent').removeClass('active nav-active').find('> .children, > .submenu').slideUp(200);
            $parent.siblings('.has-submenu, .nav-parent').find('.arrow-icon, .arrow').css('transform', 'rotate(0deg)');

            if ($sub.is(':visible')) {
                $sub.slideUp(200);
                $parent.removeClass('active nav-active');
                $arrow.css('transform', 'rotate(0deg)');
            } else {
                $sub.slideDown(200);
                $parent.addClass('active nav-active');
                $arrow.css('transform', 'rotate(90deg)');
            }
        });
    });
    </script>
	<script>
 $(window).load(function(){        
   $('#myModal').modal('show');
    }); 
</script>

<script>
var imagefilerequired='<?=@$imagerequired;?>';
(function ( $ ) {
 
    $.fn.imagePicker = function( options ) {
        
        // Define plugin options
        var settings = $.extend({
            // Input name attribute
            name: "",
            required: "",
            // Classes for styling the input
            class: "form-control btn btn-default btn-block",
            // Icon which displays in center of input
            icon: "glyphicon glyphicon-plus"
        }, options );
        
        // Create an input inside each matched element
        return this.each(function() {
            $(this).html(create_btn(this, settings)).append('<div class="imgpreviewdiv"></div>');
        });
 
    };
 
    // Private function for creating the input element
    function create_btn(that, settings) {
        // The input icon element
        var picker_btn_icon = $('<i class="'+settings.icon+'"></i>');
        
        // The actual file input which stays hidden
        var picker_btn_input = $('<input type="file" name="'+settings.name+'" '+settings.required+' />');
        
        // The actual element displayed
        var picker_btn = $('<div class="'+settings.class+' img-upload-btn"></div>')
            .append(picker_btn_icon)
            .append(picker_btn_input);
           // alert(picker_btn);//.parent()
        // File load listener
        picker_btn_input.change(function() {
            if ($(this).prop('files')[0]) {
                // Use FileReader to get file
                var reader = new FileReader();
                
                // Create a preview once image has loaded
                reader.onload = function(e) {
                    var preview = create_preview(that, e.target.result, settings);
                   // $(that).html(preview);
                    $('.imgpreviewdiv').html(preview);
                }
                
                // Load image
                reader.readAsDataURL(picker_btn_input.prop('files')[0]);
            }                
        });

        return picker_btn
    };
    
    // Private function for creating a preview element
    function create_preview(that, src, settings) {
        
            // The preview image
            var picker_preview_image = $('<img src="'+src+'" class="img-responsive img-rounded" />');
            
            // The remove image button
            var picker_preview_remove = $('<button type="button" class="btn btn-link"><small>Remove</small></button>');
            
            // The preview element
            var picker_preview = $('<div class="text-center"></div>')
                .append(picker_preview_image)
                .append(picker_preview_remove);

            // Remove image listener
            picker_preview_remove.click(function() {
                var btn = create_btn(that, settings);
                $(that).html(btn).append('<div class="imgpreviewdiv"></div>');
               // $(that).append(btn);
            });
            
            return picker_preview;
    };
    
}( jQuery ));
$(document).ready(function() {
    $('.img-picker').imagePicker({name: 'images',required: imagefilerequired});
})

$(window).load(function () {
    $(".trigger_popup_fricc").click(function(){
       $('.hover_bkgr_fricc').show();
    });
    $('.hover_bkgr_fricc').click(function(){
        $('.hover_bkgr_fricc').hide();
    });
    $('.popupCloseButton').click(function(){
        $('.hover_bkgr_fricc').hide();
    });
	
	 $('.clinic_days ul li a').click(function(){
    $('li a').removeClass("active");
    $(this).addClass("active");
});

 
	
	
   
});
</script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css"><script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script><script>function myalert(content='',title='Alert!'){	$.alert({    title: title,    content: content,});}
<?php if($this->session->flashdata('flashmsg')) {echo "myalert('".$this->session->flashdata('flashmsg')."')"; } ?>

</script>
</body>

