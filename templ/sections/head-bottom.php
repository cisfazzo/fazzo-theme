<?php
namespace fazzo;

if ( has_nav_menu( 'meta-head-nav' ) ) { ?>
<div id="head-bottom-full-wrapper">
    <div class="container" id="head-bottom-wrapper">
        <div class="row">
            <div id="meta-head-nav-wrapper" style="width:100%">
				<?php
				get_template_part( 'templ/nav/head' );
				?>
            </div><!-- col-12 -->
        </div><!-- row -->
    </div><!-- head-meta-wrapper -->
</div><!-- head-meta-full-wrapper -->
<?php }
