<?php 

/* Template Name: Dashboard Page */ 

get_header();
?>
<main class="sts-main-dashboard">
    <aside class="sts-sidebar-dashboard">
        <?php require('inc/dashboard/sidebar-dashboard.php'); ?>
    </aside>
    <div class="sts-content-dashboard">
        <?php require('inc/dashboard/content-dashboard.php'); ?>
    </div>
</main>
<?php
get_footer();