<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
        </div><!-- /.ops-main-body -->
    </main><!-- /.ops-main -->
</div><!-- /.ops-layout-wrap -->

<script>
function toggleSidebar() {
    var sb = document.getElementById('opsSidebar');
    if (sb) {
        sb.classList.toggle('open');
    }
}
// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(e) {
    var sb = document.getElementById('opsSidebar');
    var btn = document.querySelector('.ops-mobile-toggle');
    if (window.innerWidth <= 991 && sb && sb.classList.contains('open')) {
        if (!sb.contains(e.target) && (!btn || !btn.contains(e.target))) {
            sb.classList.remove('open');
        }
    }
});
</script>
</body>
</html>