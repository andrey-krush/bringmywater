<?php

class Contact_Page_Promo_Section
{

    private mixed $title;
    private mixed $subtitle;
    private mixed $background_image;

    public function __construct()
    {

        $promo_section = get_field('promo_section');
        $this->title = $promo_section['title'];
        $this->subtitle = $promo_section['subtitle'];
        $this->background_image = $promo_section['background_image'];

    }

    public function sectionStyles(): array
    {

        return array(
            'promo' => TEMPLATE_PATH . '/css/sections/promo.css',
        );

    }

    public function sectionScripts(): array
    {

        return array();

    }


    public function render(): void
    {

        ?>

        <section class="promo promo--small">
            <?php if( !empty( $this->background_image ) ) : ?>
                <div class="promo__bg">
                    <img src="<?php echo $this->background_image ?>" alt="" role="presentation" width="1920" height="400">
                </div>
            <?php endif; ?>
            <div class="container">
                <div class="promo__container">
                    <?php if( !empty( $this->title ) ) : ?>
                        <div class="promo__title title-h1">
                            <h1><?php echo $this->title; ?></h1>
                        </div>
                    <?php endif;  ?>
                    <?php if( !empty( $this->subtitle ) ) : ?>
                        <div class="promo__text section-text">
                            <p><?php echo $this->subtitle; ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

    <?php
    }

}