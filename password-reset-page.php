<?php /* Template name: Password reset page */

global $this_page_styles;
global $this_page_scripts;

$pageSections = [
    new Change_Password_Section(),
];

$this_page_styles = [];
$this_page_scripts = [];

foreach ($pageSections as $pageSection) :

    $this_page_styles = array_merge($this_page_styles, $pageSection->sectionStyles());
    $this_page_scripts = array_merge($this_page_scripts, $pageSection->sectionScripts());

endforeach;

?>
<?php get_header(); ?>
    <main class="main">
        <?php
            foreach ( $pageSections as $pageSection ) :

                $pageSection->render();

            endforeach;
        ?>
    </main>
<?php get_footer(); ?>
