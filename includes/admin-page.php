<?php
add_action('admin_menu', 'pc_add_carousel_admin_page');

function pc_add_carousel_admin_page() {
    add_menu_page(
        'Product Carousel Pro',
        'Product Carousel Pro',
        'manage_options',
        'product-carousel-settings',
        'pc_render_carousel_admin_page',
        'dashicons-images-alt2',
        56
    );
}

function pc_render_carousel_admin_page() {
    $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    ?>
    <div class="wrap">
        <h1>Product Carousel Shortcode Generator</h1>
        <form id="carousel-settings">
            <label><input type="radio" name="mode" value="latest" checked> Show latest products <span title="Viser de nyeste produktene i butikken automatisk." style="cursor:help; color:#0073aa;">(?)</span></label><br>
            <label><input type="radio" name="mode" value="category"> Show products from category: <span title="Velg en spesifikk produktkategori for karusellen." style="cursor:help; color:#0073aa;">(?)</span></label>
            <select name="category">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= esc_attr($cat->slug) ?>"><?= esc_html($cat->name) ?></option>
                <?php endforeach; ?>
            </select>
            <br><br>

            <label><input type="checkbox" name="sale"> On Sale <span title="Vis kun produkter som er på salg." style="cursor:help; color:#0073aa;">(?)</span></label><br>
            <label><input type="checkbox" name="featured"> Featured <span title="Vis kun produkter som er merket som fremhevet." style="cursor:help; color:#0073aa;">(?)</span></label><br>
            <label><input type="checkbox" name="best_sellers"> Best Sellers <span title="Vis produkter sortert etter mest solgte." style="cursor:help; color:#0073aa;">(?)</span></label><br><br>

            <label>Order by: <span title="Velg hvordan produktene skal sorteres i karusellen." style="cursor:help; color:#0073aa;">(?)</span></label>
            <select name="orderby">
                <option value="">Default</option>
                <option value="price">Price</option>
                <option value="date">Date</option>
            </select>
            <br>
            <select name="order">
                <option value="DESC">Descending</option>
                <option value="ASC">Ascending</option>
            </select>
            <br><br>

            <label><input type="checkbox" id="shadow-checkbox" name="shadow" value="true"> Show shadow around product images <span title="Legg til en visuell skygge bak hvert produktbilde." style="cursor:help; color:#0073aa;">(?)</span></label><br><br>

            <label for="limit">Number of products: <span title="Antall produkter som skal vises i karusellen." style="cursor:help; color:#0073aa;">(?)</span></label>
            <input type="number" name="limit" value="6" min="1" max="100"><br><br>

            
            <label for="speed">Carousel speed (seconds): <span title="Tiden mellom hvert bildebytte i karusellen, i sekunder." style="cursor:help; color:#0073aa;">(?)</span></label>
            <input type="number" name="speed" id="carousel-speed"  min="100" step="100"><br><br>
<button type="button" id="generate-shortcode" class="button button-primary">Generate Shortcode</button>
        </form>

        <h3>Result</h3>
        <code id="shortcode-output"></code><br>
        <button type="button" id="copy-shortcode" class="button button-primary">Copy Shortcode</button>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("carousel-settings");
        const output = document.getElementById("shortcode-output");
        const copyBtn = document.getElementById("copy-shortcode");
        const generateBtn = document.getElementById("generate-shortcode");

        copyBtn.style.display = "none";

        generateBtn.addEventListener("click", () => {
            const mode = form.mode.value === "latest" ? ' latest="true"' : '';
            const category = form.mode.value === "category" ? ' category="' + form.category.value + '"' : '';
            const sale = form.sale.checked ? ' sale="true"' : '';
            const featured = form.featured.checked ? ' featured="true"' : '';
            const bestSellers = form.best_sellers.checked ? ' best_sellers="true"' : '';
            const orderby = form.orderby.value ? ' orderby="' + form.orderby.value + '"' : '';
            const order = form.order.value ? ' order="' + form.order.value + '"' : '';
            const limit = form.limit.value ? ' limit="' + form.limit.value + '"' : '';
            const shadow = document.getElementById("shadow-checkbox").checked ? ' shadow="true"' : '';
            const speed = document.getElementById("carousel-speed").value ? ' speed="' + (parseInt(document.getElementById("carousel-speed").value, 10) * 1000) + '"' : '';

            const shortcode = `[product_carousel${mode}${category}${sale}${featured}${bestSellers}${orderby}${order}${limit}${shadow}${speed}]`;
            output.textContent = shortcode;
            copyBtn.style.display = "inline-block";
        });

        copyBtn.addEventListener("click", () => {
            const text = output.textContent || output.innerText;
            navigator.clipboard.writeText(text).then(() => {
                copyBtn.textContent = "Copied!";
                setTimeout(() => copyBtn.textContent = "Copy Shortcode", 2000);
            });
        });
    });
    </script>
<?php
}
