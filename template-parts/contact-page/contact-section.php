<?php

class Contact_Page_Contact_Section
{

    private mixed $title;
    private mixed $text;
    private mixed $text_above_title;
    private mixed $phone;
    private mixed $schedule;
    private mixed $logo;
    private mixed $success_popup;

    public function __construct()
    {

        $contact_section = get_field('contact_section');
        $this->title = $contact_section['title'];
        $this->text = $contact_section['text'];
        $this->text_above_title = $contact_section['text_above_title'];
        $this->phone = $contact_section['phone_number'];
        $this->schedule = $contact_section['schedule'];
        $this->logo = $contact_section['logo'];
        $this->success_popup = $contact_section['success_popup'];

    }

    public function sectionStyles(): array
    {

        return array(
            'contact' => TEMPLATE_PATH . '/css/sections/contact.css',
        );

    }

    public function sectionScripts(): array
    {

        return array(
            'contact' => TEMPLATE_PATH . '/js/sections/contact.js'
        );

    }


    public function render(): void
    {

        ?>

            <section class="contact">
                <div class="container">
                    <div class="contact__container">
                        <div class="contact__inner">
                            <?php if( !empty( $this->text_above_title ) ) : ?>
                                <div class="subtitle">
                                    <span><?php echo $this->text_above_title; ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if( !empty( $this->title ) ) : ?>
                                <div class="contact__title title-h2">
                                    <h2><?php echo $this->title; ?></h2>
                                </div>
                            <?php endif; ?>
                            <?php if( !empty( $this->text ) ) : ?>
                                <div class="contact__text section-text">
                                    <p><?php echo $this->text; ?></p>
                                </div>
                            <?php endif; ?>
                            <div class="contact__info">
                                <?php if( !empty( $this->phone ) ) : ?>
                                    <a href="tel:+<?= preg_replace('/\D/', '', $this->phone); ?>" class="page-phone page-phone--transparent">
                                        <div class="page-phone__ico">
                                            <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14.6053 10.3067L11.092 9.9L9.41201 11.58C7.51947 10.6175 5.9812 9.07921 5.01868 7.18667L6.70534 5.5L6.29868 2H2.62534C2.23868 8.78667 7.81868 14.3667 14.6053 13.98V10.3067Z"
                                                      fill="white"></path>
                                            </svg>
                                        </div>
                                        <span><?php echo $this->phone; ?></span>
                                    </a>
                                <?php endif; ?>
                                <?php if( !empty( $this->schedule ) ) : ?>
                                    <div class="page-date">
                                        <?php foreach ( $this->schedule as $item ) : ?>
                                            <span><?php echo $item['text']; ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="contact__wrapper show-hide-on-success">
                            <form action="<?php echo admin_url('admin-ajax.php');?>" method="post" class="contact__form hide-on-success">
                                <input type="hidden" name="action" value="contact_form">
                                <?php if( !empty( $this->logo ) ) : ?>
                                    <a href="<?php echo home_url(); ?>" class="logo">
                                        <img src="<?php echo $this->logo; ?>" alt="" role="presentation">
                                    </a>
                                <?php endif; ?>
                                <div class="form__row">
                                    <div class="input">
                                        <input type="text" name="firstname" placeholder="<?php echo pll__('First Name'); ?>" required>
                                    </div>
                                </div>
                                <div class="form__row">
                                    <div class="input">
                                        <input type="email" name="email" placeholder="<?php echo pll__('Email'); ?>" data-validation="email"
                                               required>
                                    </div>
                                </div>
                                <div class="form__row">
                                    <div class="input">
                                        <textarea name="message" placeholder="<?php echo pll__('Message'); ?>" required></textarea>
                                    </div>
                                </div>
                                <div class="contact__btn">
                                    <button type="submit" class="btn"><?php echo pll__('Send Message'); ?></button>
                                </div>
                            </form>
                            <div class="contact__form-success show-on-success">
                                <?php if( !empty( $this->logo ) ) : ?>
                                    <a href="<?php echo home_url(); ?>" class="logo">
                                        <img src="<?php echo $this->logo; ?>" alt="" role="presentation">
                                    </a>
                                <?php endif; ?>
                                <?php if( !empty( $this->success_popup['text_above_title'] ) ) : ?>
                                    <div class="subtitle">
                                        <span><?php echo $this->success_popup['text_above_title']; ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if( !empty( $this->success_popup['title'] ) ) : ?>
                                    <div class="contact__form-success__title title-h2">
                                        <h2><?php echo $this->success_popup['title']; ?></h2>
                                    </div>
                                <?php endif; ?>
                                <?php if( !empty( $this->success_popup['text'] ) ) : ?>
                                    <div class="section-text">
                                        <p><?php echo $this->success_popup['text']; ?></p>
                                    </div>
                                <?php endif; ?>
                                <div class="contact__form-success__btn">
                                    <button type="button" class="btn"><?php echo pll__('Send Other Message'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        <?php
    }

}