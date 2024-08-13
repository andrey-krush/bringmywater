<?php

class Thankyou_Banner_Section {

    private mixed $title;
    private mixed $text;
    private mixed $link;

    public function __construct() {

        $banner_section = get_field('banner_section', get_option('page_on_front'));
        $this->title = $banner_section['title'];
        $this->text = $banner_section['text'];
        $this->link = $banner_section['link'];

    }

    public function sectionStyles(): array
    {

        return array(
            'banner' => TEMPLATE_PATH . '/css/sections/banner.css',
        );

    }

    public function sectionScripts(): array
    {

        return array();

    }

    public function render() : void {
        ?>

        <section class="banner">
            <div class="banner__inner">
                <?php if( !empty( $this->title ) ) : ?>
                    <div class="banner__title title-h2">
                        <h2><?php echo $this->title; ?></h2>
                    </div>
                <?php endif; ?>
                <?php if( !empty( $this->text ) ) : ?>
                    <div class="banner__text section-text">
                        <p><?php echo $this->text; ?></p>
                    </div>
                <?php endif; ?>
                <?php if( !empty( $this->link ) ) : ?>
                    <div class="banner__btn">
                        <a href="<?php echo $this->link['url']; ?>" class="btn btn--white"><?php echo $this->link['title']; ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
    }
}