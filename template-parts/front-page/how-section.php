<?php

class Front_Page_How_Section {

    private mixed $process;
    private mixed $text_above_title;
    private mixed $title;
    private mixed $subtitle;

    public function __construct() {

        $how_section = get_field('how_section');
        $this->text_above_title = $how_section['text_above_title'];
        $this->title = $how_section['title'];
        $this->subtitle = $how_section['subtitle'];
        $this->process = $how_section['process'];

    }

    public function sectionStyles(): array
    {

        return array(
            'how' => TEMPLATE_PATH . '/css/sections/how.css',
        );

    }

    public function sectionScripts(): array
    {

        return array();

    }

    public function render() : void {
        ?>

            <section class="how">
                <div class="container">
                    <div class="how__info">
                        <?php if( !empty( $this->text_above_title ) ) : ?>
                            <div class="subtitle">
                                <span><?php echo $this->text_above_title; ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if( !empty( $this->title ) ) : ?>
                            <div class="how__title title-h2">
                                <h2><?php echo $this->title; ?></h2>
                            </div>
                        <?php endif; ?>
                        <?php if( !empty( $this->subtitle ) ) : ?>
                            <div class="how__text section-text">
                                <p><?php echo $this->subtitle; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if( !empty( $this->process ) ) : ?>
                        <div class="how__wrapper">
                            <?php foreach ( $this->process as $key => $item ) : ?>
                                <div class="how-item">
                                    <div class="how-item__descr">
                                        <div class="how-item__title title-h3">
                                            <h3><?php echo $key + 1; ?>.
                                                <?php if( !empty( $item['title'] ) ) : ?>
                                                    <?php echo $item['title']; ?>
                                                <?php endif; ?>
                                            </h3>
                                        </div>
                                        <?php if( !empty( $item['subtitle'] ) ) : ?>
                                            <div class="how-item__text section-text">
                                                <p><?php echo $item['subtitle']; ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if( !empty( $item['image'] ) ) : ?>
                                        <div class="how-item__inner">
                                            <div class="how-item__img">
                                                <img src="<?php echo $item['image']; ?>" alt="" role="presentation" width="547" height="326">
                                            </div>
                                            <?php if( !empty( $item['background_image'] ) ) : ?>
                                                <div class="how-item__bg el-<?=$key+1?>">
                                                    <img src="<?php echo $item['background_image']; ?>" alt="" role="presentation" width="526" height="512">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

        <?php
    }
}