<?php
add_shortcode('product_carousel', 'pc_render_product_carousel');

function pc_render_product_carousel($atts) {
    $atts = shortcode_atts([
        'category' => '',
        'limit' => 10,
        'latest' => 'false',
        'sale' => 'false',
        'featured' => 'false',
        'best_sellers' => 'false',
        'orderby' => '',
        'order' => 'DESC',
        'shadow' => 'false',
        'speed' => '3000',
        'shadow' => 'false',
    ], $atts);

    $args = [
        'limit' => intval($atts['limit']),
        'status' => 'publish',
    ];

    if ($atts['latest'] === 'true') {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }

    if (!empty($atts['category'])) {
        $args['category'] = [$atts['category']];
    }

    if ($atts['sale'] === 'true') {
        $args['on_sale'] = true;
    }

    if ($atts['featured'] === 'true') {
        $args['featured'] = true;
    }

    if ($atts['best_sellers'] === 'true') {
        $args['orderby'] = 'total_sales';
        $args['order'] = 'DESC';
    }

    if (!empty($atts['orderby']) && $atts['best_sellers'] !== 'true') {
        $args['orderby'] = sanitize_text_field($atts['orderby']);
        $args['order'] = sanitize_text_field($atts['order']);
    }

    $query = new WC_Product_Query($args);
    $products = $query->get_products();

    ob_start();
    ?>
    <div class="product-carousel swiper">
        <div class="swiper-wrapper">
            <?php foreach ($products as $product): ?>
                <div class="swiper-slide">
                    <a href="<?= esc_url(get_permalink($product->get_id())) ?>" class="product-carousel-link" style="display:block;text-align:center;">
<?php
    $class = 'bd-carousel-image' . ($atts['shadow'] === 'true' ? ' bd-shadow' : '');
    $img_html = $product->get_image('medium');
    $img_html = str_replace('<img', '<img class="' . esc_attr($class) . '" style="height:200px;object-fit:contain;"', $img_html);
    echo $img_html;
?>
                        <p><?= esc_html($product->get_name()) ?></p>
                        <strong><?= wc_price($product->get_price()) ?></strong>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-button-prev" aria-label="Previous product"></div>
        <div class="swiper-button-next" aria-label="Next product"></div>
    </div>
    <?php
    return ob_get_clean();
}

add_action('wp_enqueue_scripts', 'pc_enqueue_carousel_assets');
function pc_enqueue_carousel_assets() {
    wp_register_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], null);
    wp_register_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], null, true);

    wp_enqueue_style('swiper');
    wp_enqueue_script('swiper');

    wp_add_inline_script('swiper', '
        document.addEventListener("DOMContentLoaded", function () {
            new Swiper(".product-carousel", {
                loop: true,
                spaceBetween: 20,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                },
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                pauseOnMouseEnter: true,
                touchRatio: 1,
                simulateTouch: true,
                grabCursor: true
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1
                    },
                    480: {
                        slidesPerView: 2
                    },
                    768: {
                        slidesPerView: 3
                    },
                    1024: {
                        slidesPerView: 4
                    }
                }
            });
        });
    ');
}


    $shadow_class = $atts['shadow'] === 'true' ? ' bd-shadow' : '';
