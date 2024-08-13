<?php

class Single_Product_Delivery_Section {


    private mixed $title;
    private mixed $text_above_title;
    private mixed $text;
    private mixed $button_text;
    private mixed $image;
    private mixed $image_mob;

    public function __construct() {

        $delivery_section = get_field('map_section', get_option('page_on_front'));
        $this->title = $delivery_section['title'];
        $this->text_above_title = $delivery_section['text_above_title'];
        $this->text = $delivery_section['text'];
        $this->button_text = $delivery_section['button_text'];
        $this->image = $delivery_section['image'];
        $this->image_mob = $delivery_section['image_mob'];

    }

    public function sectionStyles(): array
    {

        return array(
            'delivery' => TEMPLATE_PATH . '/css/sections/delivery.css',
        );

    }

    public function sectionScripts(): array
    {

        return array();

    }

    public function render() : void {
        ?>

        <section class="delivery">
            <div class="container">
                <div class="delivery__info">
                    <?php if( !empty( $this->text_above_title ) ) : ?>
                        <div class="subtitle">
                            <span><?php echo $this->text_above_title; ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if( !empty( $this->title ) ) : ?>
                        <div class="delivery__title title-h2">
                            <h2><?php echo $this->title; ?></h2>
                        </div>
                    <?php endif; ?>
                    <?php if( !empty( $this->text ) ) : ?>
                        <div class="delivery__text section-text">
                            <p><?php echo $this->text; ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if( !empty( $this->image ) ) : ?>
                    <div class="delivery__img">
                        <picture>
                            <?php if($this->image_mob): ?>
                                <source media="(max-width: 768px)" srcset="<?php echo $this->image_mob; ?>">
                            <?php endif; ?>
                            <img src="<?php echo $this->image; ?>" alt="" role="presentation" width="1720" height="600">
                        </picture>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
    }
}