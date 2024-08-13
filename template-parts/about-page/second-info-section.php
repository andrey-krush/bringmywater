<?php

class About_Page_Second_Info_Section {

    private mixed $title;
    private mixed $text_above_title;
    private mixed $text;
    private mixed $button_text;
    private mixed $image;

    public function __construct() {

        $our_section = get_field('second_info_section');
        $this->title = $our_section['title'];
        $this->text_above_title = $our_section['text_above_title'];
        $this->text = $our_section['text'];
        $this->button_text = $our_section['button_text'];
        $this->image = $our_section['image'];

    }

    public function sectionStyles(): array
    {

        return array(
            'our' => TEMPLATE_PATH . '/css/sections/our.css',
        );

    }

    public function sectionScripts(): array
    {

        return array();

    }

    public function render(): void
    {
        ?>

        <section class="our">
            <div class="our__container">
                <div class="our__info">
                    <?php if( !empty( $this->text_above_title ) ) : ?>
                        <div class="subtitle">
                            <span><?php echo $this->text_above_title; ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if( !empty( $this->title ) ) : ?>
                        <div class="our__title title-h2">
                            <h2><?php echo $this->title; ?></h2>
                        </div>
                    <?php endif; ?>
                    <?php if( !empty( $this->text ) ) : ?>
                        <div class="our__text section-text">
                            <?php echo $this->text; ?>
                        </div>
                    <?php endif; ?>
                    <div class="our__btn">
                        <a href="#popup-zip" class="btn"><?php echo $this->button_text; ?></a>
                    </div>
                </div>
                <?php if( !empty( $this->image ) ) : ?>
                    <div class="our__img our__img--small">
                        <img src="<?php echo $this->image; ?>" alt="" role="presentation" width="1031" height="800">
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
    }
}