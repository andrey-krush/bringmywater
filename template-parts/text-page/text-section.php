<?php

class Text_Page_Text_Section {


    private mixed $texts;
    private mixed $title;
    private mixed $text_above_title;

    public function __construct() {

        $text_section = get_field('text_section');
        $this->title = $text_section['title'];
        $this->text_above_title = $text_section['text_above_title'];
        $this->title = $text_section['title'];
        $this->texts = $text_section['texts_containers'];

    }

    public function sectionStyles(): array
    {

        return array(
            'text' => TEMPLATE_PATH . '/css/sections/terms.css',
        );

    }

    public function sectionScripts(): array
    {

        return array();

    }

    public function render() : void {
        ?>

            <section class="terms">
                <div class="container">
                    <div class="terms__container">
                        <div class="section-text">
                            <?php if( !empty( $this->text_above_title ) ) : ?>
                                <span class="subtitle"><?php echo $this->text_above_title; ?></span>
                            <?php endif; ?>
                            <?php if( !empty( $this->title ) ) : ?>
                                <h2><?php echo $this->title; ?></h2>
                            <?php endif; ?>
                        </div>
                        <?php if( !empty( $this->texts ) ) : ?>
                            <?php foreach ( $this->texts as $item ) : ?>
                            <div class="section-text">
                                <?php echo $item['text']; ?>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

        <?php
    }
}