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
    ], $atts);

    // Validate and sanitize shortcode attributes
    $atts = pc_validate_carousel_attributes($atts);

    // Check if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        return '<div class="product-carousel-error" style="padding:20px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;border-radius:8px;">BD Product Carousel Pro krever WooCommerce for å fungere.</div>';
    }

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
    <div class="product-carousel swiper" data-speed="<?= esc_attr($atts['speed']) ?>">
        <div class="swiper-wrapper">
            <?php foreach ($products as $product): ?>
                <div class="swiper-slide">
                    <a href="<?= esc_url(get_permalink($product->get_id())) ?>" class="product-carousel-link" style="display:block;text-align:center;">
                        <?php
                        $class = 'bd-carousel-image' . ($atts['shadow'] === 'true' ? ' bd-shadow' : '');
                        $img_html = $product->get_image('medium');
                        $img_html = str_replace('<img', '<img class="' . esc_attr($class) . '" style="height:250px;width:100%;object-fit:contain;"', $img_html);
                        echo $img_html;
                        ?>
                        <p><?= esc_html($product->get_name()) ?></p>
                        <strong><?= wc_price($product->get_price()) ?></strong>
                        
                        <?php if ($product->is_purchasable() && $product->is_in_stock()): ?>
                            <div style="margin-top:15px;">
                                <?php
                                woocommerce_template_loop_add_to_cart();
                                ?>
                            </div>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-button-prev" aria-label="Previous product"></div>
        <div class="swiper-button-next" aria-label="Next product"></div>
        <div class="swiper-pagination"></div>
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

    // Get all carousel speeds from shortcodes on the page
    global $post;
    $carousel_speeds = [];
    if ($post && has_shortcode($post->post_content, 'product_carousel')) {
        // Extract speed values from shortcodes
        preg_match_all('/\[product_carousel[^\]]*speed="(\d+)"[^\]]*\]/', $post->post_content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $speed) {
                $carousel_speeds[] = intval($speed);
            }
        }
    }

    // Default speed if no specific speeds found
    if (empty($carousel_speeds)) {
        $carousel_speeds[] = 3000;
    }

    $inline_script = '
        document.addEventListener("DOMContentLoaded", function () {
            const carousels = document.querySelectorAll(".product-carousel");
            const speeds = ' . json_encode($carousel_speeds) . ';
            let speedIndex = 0;
            
            carousels.forEach(function(carousel, index) {
                const speed = speeds[speedIndex] || 3000;
                speedIndex = (speedIndex + 1) % speeds.length;
                
                new Swiper(carousel, {
                    loop: true,
                    spaceBetween: 20,
                    navigation: {
                        nextEl: carousel.querySelector(".swiper-button-next"),
                        prevEl: carousel.querySelector(".swiper-button-prev")
                    },
                    autoplay: {
                        delay: speed,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                        touchRatio: 1,
                        simulateTouch: true,
                        grabCursor: true
                    },
                    pagination: {
                        el: carousel.querySelector(".swiper-pagination"),
                        clickable: true,
                        dynamicBullets: true
                    },
                    breakpoints: {
                        320: {
                            slidesPerView: 1,
                            spaceBetween: 15
                        },
                        480: {
                            slidesPerView: 2,
                            spaceBetween: 15
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 20
                        },
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 20
                        },
                        1200: {
                            slidesPerView: 5,
                            spaceBetween: 25
                        }
                    },
                    // Enhanced touch and grab settings
                    touchEventsTarget: "container",
                    simulateTouch: true,
                    allowTouchMove: true,
                    touchRatio: 1,
                    touchAngle: 45,
                    grabCursor: true,
                    
                    // Smooth transitions
                    speed: 400,
                    effect: "slide",
                    
                    // Accessibility
                    a11y: {
                        enabled: true,
                        prevSlideMessage: "Previous product",
                        nextSlideMessage: "Next product"
                    }
                });
            });
        });
    ';

    wp_add_inline_script('swiper', $inline_script);
}

// Validate and sanitize shortcode attributes
function pc_validate_carousel_attributes($atts) {
    // Ensure limit is reasonable
    $atts['limit'] = max(1, min(100, intval($atts['limit'])));
    
    // Ensure speed is reasonable (1 second to 30 seconds)
    $speed = intval($atts['speed']);
    if ($speed < 1000) $speed = $speed * 1000; // Convert seconds to milliseconds if needed
    $atts['speed'] = max(1000, min(30000, $speed));
    
    // Validate order values
    $atts['order'] = in_array(strtoupper($atts['order']), ['ASC', 'DESC']) ? strtoupper($atts['order']) : 'DESC';
    
    // Validate orderby values
    $valid_orderby = ['date', 'price', 'title', 'menu_order', 'popularity', 'rating'];
    $atts['orderby'] = in_array($atts['orderby'], $valid_orderby) ? $atts['orderby'] : '';
    
    // Convert boolean strings
    $boolean_attrs = ['latest', 'sale', 'featured', 'best_sellers', 'shadow'];
    foreach ($boolean_attrs as $attr) {
        $atts[$attr] = in_array(strtolower($atts[$attr]), ['true', '1', 'yes', 'on']) ? 'true' : 'false';
    }
    
    return $atts;
}
