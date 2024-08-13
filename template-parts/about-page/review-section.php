<?php

class About_Page_Review_Section {

    private mixed $title;
    private mixed $text;
    private mixed $reviewer_name;
    private mixed $reviewer_position;
    private mixed $stars_count;

    public function __construct() {

        $review_section = get_field('review_section');
        $this->reviews = $review_section['reviews'];
//        $this->title = $review_section['title'];
//        $this->text = $review_section['text'];
//        $this->reviewer_name = $review_section['reviewer_name'];
//        $this->reviewer_position = $review_section['reviewer_position'];
//        $this->stars_count = $review_section['stars_count'];

    }

    public function sectionStyles(): array
    {

        return array(
            'banner' => TEMPLATE_PATH . '/css/sections/banner.css',
        );

    }

    public function sectionScripts(): array
    {

        return array(
            'item_raring' => TEMPLATE_PATH . '/js/sections/item-rating.js',
            'banner' => TEMPLATE_PATH . '/js/sections/banner.js',
        );

    }

    public function render(): void
    {
        if( !empty( $this->reviews ) ) : ?>

            <section class="banner banner-slider">
                <div class="banner-slider__btns">
                    <button type="button" class="banner-slider__btn swiper__btn--prev">
                        <img src="<?=TEMPLATE_PATH?>/img/swiper-btn-prev.svg" alt="Prev" width="80" height="1">
                    </button>
                    <button type="button" class="banner-slider__btn swiper__btn--next">
                        <img src="<?=TEMPLATE_PATH?>/img/swiper-btn-next.svg" alt="Prev" width="80" height="1">
                    </button>
                </div>
                <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ( $this->reviews as $index=>$item ) : ?>
                                <div class="swiper-slide banner__inner">
                                    <?php if( !empty( $item['title'] ) ) : ?>
                                        <div class="banner__title title-h2">
                                            <h2><?php echo $item['title']; ?></h2>
                                        </div>
                                    <?php endif; ?>
                                    <?php if( !empty( $item['text'] ) ) : ?>
                                        <div class="banner__text section-text">
                                            <p><?php echo $item['text']; ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <div class="banner__info">
                                        <?php if( !empty( $item['reviewer_name'] ) ) :  ?>
                                            <span><?php echo $item['reviewer_name']; ?></span>
                                        <?php endif; ?>
                                        <?php if( !empty( $item['reviewer_position'] ) ) :  ?>
                                            <span><?php echo $item['reviewer_position']; ?></span>
                                        <?php endif; ?>

                                        <div class="item-rating" data-rating="<?php echo !empty( $item['stars_count'] ) ? $item['stars_count'] : 0; ?>">
                                            <svg class="star" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 17.2698L16.15 19.7798C16.91 20.2398 17.84 19.5598 17.64 18.6998L16.54 13.9798L20.21 10.7998C20.88 10.2198 20.52 9.11977 19.64 9.04977L14.81 8.63977L12.92 4.17977C12.58 3.36977 11.42 3.36977 11.08 4.17977L9.19001 8.62977L4.36001 9.03977C3.48001 9.10977 3.12001 10.2098 3.79001 10.7898L7.46001 13.9698L6.36001 18.6898C6.16001 19.5498 7.09001 20.2298 7.85001 19.7698L12 17.2698Z"
                                                      fill="#ECD931"></path>
                                                <mask class="star-mask" id="star-mask-<?=$index?>-1" style="mask-type:alpha" maskUnits="userSpaceOnUse"
                                                      x="4" y="4" width="16" height="16">
                                                    <rect class="star-mask" x="4" y="4" width="16" height="16" fill="#D9D9D9"></rect>
                                                </mask>
                                                <g mask="url(#star-mask-<?=$index?>-1)">
                                                    <path d="M12.1294 17.0558L12.0003 16.9778L11.871 17.0556L7.72101 19.5556L7.72056 19.5559C7.15075 19.9008 6.45337 19.392 6.60351 18.7464L7.70349 14.0265L7.73772 13.8796L7.62372 13.7808L3.95372 10.6008L3.95364 10.6008C3.45027 10.165 3.72238 9.34128 4.37984 9.28898L4.38116 9.28887L9.21116 8.87887L9.36124 8.86613L9.42012 8.7275L11.3101 4.2775L11.3105 4.27653C11.5648 3.67085 12.4353 3.67085 12.6895 4.27653L12.6898 4.27731L14.5798 8.73731L14.6386 8.87612L14.7889 8.88887L19.6189 9.29887L19.6202 9.29898C20.2776 9.35128 20.5498 10.175 20.0464 10.6108L20.0463 10.6108L16.3763 13.7908L16.2623 13.8896L16.2965 14.0365L17.3965 18.7564C17.3965 18.7564 17.3965 18.7565 17.3965 18.7565C17.5466 19.4021 16.8492 19.9108 16.2795 19.5659L16.2794 19.5658L12.1294 17.0558Z"
                                                          fill="white" stroke="white" stroke-width="0.5"></path>
                                                </g>
                                            </svg>
                                            <svg class="star" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 17.2698L16.15 19.7798C16.91 20.2398 17.84 19.5598 17.64 18.6998L16.54 13.9798L20.21 10.7998C20.88 10.2198 20.52 9.11977 19.64 9.04977L14.81 8.63977L12.92 4.17977C12.58 3.36977 11.42 3.36977 11.08 4.17977L9.19001 8.62977L4.36001 9.03977C3.48001 9.10977 3.12001 10.2098 3.79001 10.7898L7.46001 13.9698L6.36001 18.6898C6.16001 19.5498 7.09001 20.2298 7.85001 19.7698L12 17.2698Z"
                                                      fill="#ECD931"></path>
                                                <mask class="star-mask" id="star-mask-<?=$index?>-2" style="mask-type:alpha" maskUnits="userSpaceOnUse"
                                                      x="4" y="4" width="16" height="16">
                                                    <rect class="star-mask" x="4" y="4" width="16" height="16" fill="#D9D9D9"></rect>
                                                </mask>
                                                <g mask="url(#star-mask-<?=$index?>-2)">
                                                    <path d="M12.1294 17.0558L12.0003 16.9778L11.871 17.0556L7.72101 19.5556L7.72056 19.5559C7.15075 19.9008 6.45337 19.392 6.60351 18.7464L7.70349 14.0265L7.73772 13.8796L7.62372 13.7808L3.95372 10.6008L3.95364 10.6008C3.45027 10.165 3.72238 9.34128 4.37984 9.28898L4.38116 9.28887L9.21116 8.87887L9.36124 8.86613L9.42012 8.7275L11.3101 4.2775L11.3105 4.27653C11.5648 3.67085 12.4353 3.67085 12.6895 4.27653L12.6898 4.27731L14.5798 8.73731L14.6386 8.87612L14.7889 8.88887L19.6189 9.29887L19.6202 9.29898C20.2776 9.35128 20.5498 10.175 20.0464 10.6108L20.0463 10.6108L16.3763 13.7908L16.2623 13.8896L16.2965 14.0365L17.3965 18.7564C17.3965 18.7564 17.3965 18.7565 17.3965 18.7565C17.5466 19.4021 16.8492 19.9108 16.2795 19.5659L16.2794 19.5658L12.1294 17.0558Z"
                                                          fill="white" stroke="white" stroke-width="0.5"></path>
                                                </g>
                                            </svg>
                                            <svg class="star" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 17.2698L16.15 19.7798C16.91 20.2398 17.84 19.5598 17.64 18.6998L16.54 13.9798L20.21 10.7998C20.88 10.2198 20.52 9.11977 19.64 9.04977L14.81 8.63977L12.92 4.17977C12.58 3.36977 11.42 3.36977 11.08 4.17977L9.19001 8.62977L4.36001 9.03977C3.48001 9.10977 3.12001 10.2098 3.79001 10.7898L7.46001 13.9698L6.36001 18.6898C6.16001 19.5498 7.09001 20.2298 7.85001 19.7698L12 17.2698Z"
                                                      fill="#ECD931"></path>
                                                <mask class="star-mask" id="star-mask-<?=$index?>-3" style="mask-type:alpha" maskUnits="userSpaceOnUse"
                                                      x="4" y="4" width="16" height="16">
                                                    <rect class="star-mask" x="4" y="4" width="16" height="16" fill="#D9D9D9"></rect>
                                                </mask>
                                                <g mask="url(#star-mask-<?=$index?>-3)">
                                                    <path d="M12.1294 17.0558L12.0003 16.9778L11.871 17.0556L7.72101 19.5556L7.72056 19.5559C7.15075 19.9008 6.45337 19.392 6.60351 18.7464L7.70349 14.0265L7.73772 13.8796L7.62372 13.7808L3.95372 10.6008L3.95364 10.6008C3.45027 10.165 3.72238 9.34128 4.37984 9.28898L4.38116 9.28887L9.21116 8.87887L9.36124 8.86613L9.42012 8.7275L11.3101 4.2775L11.3105 4.27653C11.5648 3.67085 12.4353 3.67085 12.6895 4.27653L12.6898 4.27731L14.5798 8.73731L14.6386 8.87612L14.7889 8.88887L19.6189 9.29887L19.6202 9.29898C20.2776 9.35128 20.5498 10.175 20.0464 10.6108L20.0463 10.6108L16.3763 13.7908L16.2623 13.8896L16.2965 14.0365L17.3965 18.7564C17.3965 18.7564 17.3965 18.7565 17.3965 18.7565C17.5466 19.4021 16.8492 19.9108 16.2795 19.5659L16.2794 19.5658L12.1294 17.0558Z"
                                                          fill="white" stroke="white" stroke-width="0.5"></path>
                                                </g>
                                            </svg>
                                            <svg class="star" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 17.2698L16.15 19.7798C16.91 20.2398 17.84 19.5598 17.64 18.6998L16.54 13.9798L20.21 10.7998C20.88 10.2198 20.52 9.11977 19.64 9.04977L14.81 8.63977L12.92 4.17977C12.58 3.36977 11.42 3.36977 11.08 4.17977L9.19001 8.62977L4.36001 9.03977C3.48001 9.10977 3.12001 10.2098 3.79001 10.7898L7.46001 13.9698L6.36001 18.6898C6.16001 19.5498 7.09001 20.2298 7.85001 19.7698L12 17.2698Z"
                                                      fill="#ECD931"></path>
                                                <mask class="star-mask" id="star-mask-<?=$index?>-4" style="mask-type:alpha" maskUnits="userSpaceOnUse"
                                                      x="4" y="4" width="16" height="16">
                                                    <rect class="star-mask" x="4" y="4" width="16" height="16" fill="#D9D9D9"></rect>
                                                </mask>
                                                <g mask="url(#star-mask-<?=$index?>-4)">
                                                    <path d="M12.1294 17.0558L12.0003 16.9778L11.871 17.0556L7.72101 19.5556L7.72056 19.5559C7.15075 19.9008 6.45337 19.392 6.60351 18.7464L7.70349 14.0265L7.73772 13.8796L7.62372 13.7808L3.95372 10.6008L3.95364 10.6008C3.45027 10.165 3.72238 9.34128 4.37984 9.28898L4.38116 9.28887L9.21116 8.87887L9.36124 8.86613L9.42012 8.7275L11.3101 4.2775L11.3105 4.27653C11.5648 3.67085 12.4353 3.67085 12.6895 4.27653L12.6898 4.27731L14.5798 8.73731L14.6386 8.87612L14.7889 8.88887L19.6189 9.29887L19.6202 9.29898C20.2776 9.35128 20.5498 10.175 20.0464 10.6108L20.0463 10.6108L16.3763 13.7908L16.2623 13.8896L16.2965 14.0365L17.3965 18.7564C17.3965 18.7564 17.3965 18.7565 17.3965 18.7565C17.5466 19.4021 16.8492 19.9108 16.2795 19.5659L16.2794 19.5658L12.1294 17.0558Z"
                                                          fill="white" stroke="white" stroke-width="0.5"></path>
                                                </g>
                                            </svg>
                                            <svg class="star" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 17.2698L16.15 19.7798C16.91 20.2398 17.84 19.5598 17.64 18.6998L16.54 13.9798L20.21 10.7998C20.88 10.2198 20.52 9.11977 19.64 9.04977L14.81 8.63977L12.92 4.17977C12.58 3.36977 11.42 3.36977 11.08 4.17977L9.19001 8.62977L4.36001 9.03977C3.48001 9.10977 3.12001 10.2098 3.79001 10.7898L7.46001 13.9698L6.36001 18.6898C6.16001 19.5498 7.09001 20.2298 7.85001 19.7698L12 17.2698Z"
                                                      fill="#ECD931"></path>
                                                <mask class="star-mask" id="star-mask-<?=$index?>-5" style="mask-type:alpha" maskUnits="userSpaceOnUse"
                                                      x="4" y="4" width="16" height="16">
                                                    <rect class="star-mask" x="4" y="4" width="16" height="16" fill="#D9D9D9"></rect>
                                                </mask>
                                                <g mask="url(#star-mask-<?=$index?>-5)">
                                                    <path d="M12.1294 17.0558L12.0003 16.9778L11.871 17.0556L7.72101 19.5556L7.72056 19.5559C7.15075 19.9008 6.45337 19.392 6.60351 18.7464L7.70349 14.0265L7.73772 13.8796L7.62372 13.7808L3.95372 10.6008L3.95364 10.6008C3.45027 10.165 3.72238 9.34128 4.37984 9.28898L4.38116 9.28887L9.21116 8.87887L9.36124 8.86613L9.42012 8.7275L11.3101 4.2775L11.3105 4.27653C11.5648 3.67085 12.4353 3.67085 12.6895 4.27653L12.6898 4.27731L14.5798 8.73731L14.6386 8.87612L14.7889 8.88887L19.6189 9.29887L19.6202 9.29898C20.2776 9.35128 20.5498 10.175 20.0464 10.6108L20.0463 10.6108L16.3763 13.7908L16.2623 13.8896L16.2965 14.0365L17.3965 18.7564C17.3965 18.7564 17.3965 18.7565 17.3965 18.7565C17.5466 19.4021 16.8492 19.9108 16.2795 19.5659L16.2794 19.5658L12.1294 17.0558Z"
                                                          fill="white" stroke="white" stroke-width="0.5"></path>
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
            </section>

        <?php endif;
    }
}