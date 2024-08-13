<?php

class Change_Password_Section
{


    public function __construct()
    {
        $this->action_url = admin_url('admin-ajax.php');
        $this->account_url = wc_get_page_permalink('myaccount');
    }

    public function sectionStyles(): array
    {

        return array(
            'auth' => TEMPLATE_PATH . '/css/sections/personal.css',
        );

    }

    public function sectionScripts(): array
    {

        return array(
            'auth' => TEMPLATE_PATH . '/js/sections/personal.js',
        );

    }

    public function render(): void
    {
        ?>

        <section class="personal">
            <div class="container">
                <div class="personal__container">
                    <aside class="personal__aside">
                        <ul>
                            <li>
                                <a href="<?php echo $this->account_url; ?>"><?php echo pll__('Personal Settings'); ?></a>
                            </li>
                            <li class="active">
                                <a href=""><?php echo pll__('Password'); ?></a>
                            </li>
                        </ul>
                    </aside>
                    <div class="personal__wrapper">
                        <form action="<?php echo $this->action_url; ?>" method="post" class="personal__form form">
                            <input type="hidden" name="action" value="change_password">
                            <div class="form__block">
                                <div class="form__subtitle">
                                    <span><?php echo pll__('Password Settings'); ?></span>
                                </div>
                                <div class="form__row">
                                    <div class="input">
                                        <input type="password" name="currentpassword"
                                               placeholder="<?php echo pll__('Current Password'); ?>" required>
                                    </div>
                                </div>
                                <div class="form__row">
                                    <div class="input">
                                        <input type="password" name="newpassword" "
                                               placeholder="<?php echo pll__('New Password'); ?>" required>
                                    </div>
                                </div>
                                <div class="form__row">
                                    <div class="input">
                                        <input type="password" name="repeatpassword" ç"
                                               placeholder="<?php echo pll__('Confirm New Password'); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form__btn">
                                <button type="submit" class="btn"><?php echo pll__('Save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?php
    }
}