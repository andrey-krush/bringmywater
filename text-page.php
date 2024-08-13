<?php /* Template name: Text page */
    global $this_page_styles;
    global $this_page_scripts;

    $pageSections = [
        new Text_Page_Promo_Section(),
        new Text_Page_Text_Section(),
        new Text_Page_Banner_Section(),
    ];

    $this_page_styles = [];
    $this_page_scripts = [];

    foreach ($pageSections as $pageSection) :

    $this_page_styles = array_merge($this_page_styles, $pageSection->sectionStyles());
    $this_page_scripts = array_merge($this_page_scripts, $pageSection->sectionScripts());

    endforeach;
    get_header();
    ?>

    <main class="main">
        <?php
            foreach ( $pageSections as $pageSection ) :

                $pageSection->render();

            endforeach;
        ?>
    </main>
<?php get_footer(); ?>