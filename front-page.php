<?php
    global $this_page_styles;
    global $this_page_scripts;

    $pageSections = [
        new Front_Page_Promo_Section(),
        new Front_Page_Advantages_Section(),
        new Front_Page_How_Section(),
        new Front_Page_Our_Section(),
        new Front_Page_Delivery_Section(),
        new Front_Page_Banner_Section()
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