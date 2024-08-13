<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $this_page_styles;
global $this_page_scripts;

$pageSections = [
    new Single_Product_Product_Section(),
    new Single_Product_Delivery_Section(),
    new Single_Product_Banner_Section()
];

$this_page_styles = [];
$this_page_scripts = [];

foreach ($pageSections as $pageSection) :

    $this_page_styles = array_merge($this_page_styles, $pageSection->sectionStyles());
    $this_page_scripts = array_merge($this_page_scripts, $pageSection->sectionScripts());

endforeach;

get_header(); ?>

	<main class="main">
        <?php
        foreach ( $pageSections as $pageSection ) :

            $pageSection->render();

        endforeach;
        ?>


	</main>

<?php
get_footer();

