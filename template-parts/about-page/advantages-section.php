<?php

class About_Page_Advantages_Section
{

    private mixed $title;
    private mixed $image;
    private mixed $advantages;

    public function __construct()
    {

        $advantages_section = get_field('advantages_section');
        $this->title = $advantages_section['title'];
        $this->advantages = $advantages_section['advantages'];

    }

    public function sectionStyles(): array
    {

        return array(
            'choose' => TEMPLATE_PATH . '/css/sections/choose.css',
        );

    }

    public function sectionScripts(): array
    {

        return array();

    }

    public function render(): void
    {
        ?>

        <section class="choose">
            <div class="container">
                <?php if (!empty($this->title)) : ?>
                    <div class="choose__title title-h2">
                        <h2><?php echo $this->title; ?></h2>
                    </div>
                <?php endif; ?>
                <?php if (!empty($this->advantages)) : ?>
                    <div class="choose__list choose__list--simple">
                        <?php foreach ($this->advantages as $item) : ?>
                            <article class="choose-card">
                                <?php if (!empty($item['icon'])) : ?>
                                    <div class="choose-card__img">
                                        <img src="<?php echo $item['icon']; ?>" alt="" role="presentation" width="80"
                                             height="80">
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($item['text'])) : ?>
                                    <div class="section-text">
                                        <p><?php echo $item['text']; ?></p>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </section>

        <?php
    }
}