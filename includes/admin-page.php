<?php
// Include BD Menu Helper
require_once plugin_dir_path(__FILE__) . '../bd-menu-helper.php';

add_action('admin_menu', 'pc_add_carousel_admin_page');

function pc_add_carousel_admin_page() {
    // Use BD Menu Helper to add to Buene Data menu
    bd_add_buene_data_menu(
        'Product Carousel Pro',
        'bd-product-carousel-pro',
        'pc_render_carousel_admin_page',
        '🎠'
    );
}

function pc_render_carousel_admin_page() {
    $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    ?>
    <div class="wrap bd-product-carousel-admin">
        <!-- Modern BD Header -->
        <div class="bd-admin-header">
            <div class="bd-branding">
                <h2>🎠 Product Carousel Pro</h2>
                <p>Skape responsiv produktkarusell fra WooCommerce med avanserte innstillinger</p>
            </div>
            <div class="bd-actions">
                <button type="button" id="generate-shortcode" class="button button-primary">Generer Shortcode</button>
                <button type="button" id="copy-shortcode" class="button button-secondary" style="display:none;">Kopier Shortcode</button>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <nav class="nav-tab-wrapper">
            <a href="#generator" class="nav-tab nav-tab-active">Shortcode Generator</a>
            <a href="#preview" class="nav-tab">Forhåndsvisning</a>
            <a href="#documentation" class="nav-tab">Dokumentasjon</a>
        </nav>

        <!-- Generator Tab -->
        <div id="generator" class="tab-content active">
            <div class="bd-settings-section">
                <h3>Produktutvalg</h3>
                <form id="carousel-settings" class="bd-settings-grid">
                    <div class="bd-form-group">
                        <label class="bd-radio-group">
                            <input type="radio" name="mode" value="latest" checked>
                            <span class="bd-radio-label">
                                <strong>Nyeste produkter</strong>
                                <small>Viser de nyeste produktene i butikken automatisk</small>
                            </span>
                        </label>
                        
                        <label class="bd-radio-group">
                            <input type="radio" name="mode" value="category">
                            <span class="bd-radio-label">
                                <strong>Fra kategori</strong>
                                <small>Velg en spesifikk produktkategori</small>
                            </span>
                        </label>
                        <select name="category" class="bd-select">
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= esc_attr($cat->slug) ?>"><?= esc_html($cat->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="bd-form-group">
                        <h4>Produktfiltre</h4>
                        <label class="bd-checkbox-group">
                            <input type="checkbox" name="sale">
                            <span class="bd-checkbox-label">
                                <strong>På salg</strong>
                                <small>Vis kun produkter som er på salg</small>
                            </span>
                        </label>
                        
                        <label class="bd-checkbox-group">
                            <input type="checkbox" name="featured">
                            <span class="bd-checkbox-label">
                                <strong>Fremhevet</strong>
                                <small>Vis kun produkter som er merket som fremhevet</small>
                            </span>
                        </label>
                        
                        <label class="bd-checkbox-group">
                            <input type="checkbox" name="best_sellers">
                            <span class="bd-checkbox-label">
                                <strong>Bestselgere</strong>
                                <small>Vis produkter sortert etter mest solgte</small>
                            </span>
                        </label>
                    </div>

                    <div class="bd-form-group">
                        <h4>Sortering</h4>
                        <div class="bd-input-row">
                            <div>
                                <label for="orderby" class="bd-label">Sorter etter</label>
                                <select name="orderby" class="bd-select">
                                    <option value="">Standard</option>
                                    <option value="price">Pris</option>
                                    <option value="date">Dato</option>
                                </select>
                            </div>
                            <div>
                                <label for="order" class="bd-label">Rekkefølge</label>
                                <select name="order" class="bd-select">
                                    <option value="DESC">Synkende</option>
                                    <option value="ASC">Stigende</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bd-form-group">
                        <h4>Visningsinnstillinger</h4>
                        <div class="bd-input-row">
                            <div>
                                <label for="limit" class="bd-label">Antall produkter</label>
                                <input type="number" name="limit" value="6" min="1" max="100" class="bd-input">
                            </div>
                            <div>
                                <label for="speed" class="bd-label">Karusellhastighet (sekunder)</label>
                                <input type="number" name="speed" id="carousel-speed" min="1" step="1" value="3" class="bd-input">
                            </div>
                        </div>
                        
                        <label class="bd-checkbox-group">
                            <input type="checkbox" id="shadow-checkbox" name="shadow" value="true">
                            <span class="bd-checkbox-label">
                                <strong>Skyggeeffekt</strong>
                                <small>Legg til visuell skygge bak produktbilder</small>
                            </span>
                        </label>
                    </div>
                </form>
            </div>

            <div class="bd-settings-section">
                <h3>Generert Shortcode</h3>
                <div class="bd-shortcode-output">
                    <code id="shortcode-output">[product_carousel limit="6"]</code>
                </div>
                <p class="bd-help-text">Kopier denne shortcode-en og lim den inn på siden eller innlegget hvor du vil vise karusellen.</p>
            </div>
        </div>

        <!-- Preview Tab -->
        <div id="preview" class="tab-content">
            <div class="bd-settings-section">
                <h3>Forhåndsvisning</h3>
                <div id="carousel-preview">
                    <p class="bd-help-text">Klikk "Generer Shortcode" for å se forhåndsvisning av karusellen.</p>
                </div>
            </div>
        </div>

        <!-- Documentation Tab -->
        <div id="documentation" class="tab-content">
            <div class="bd-settings-section">
                <h3>Hvordan bruke Product Carousel Pro</h3>
                <div class="bd-documentation">
                    <h4>Grunnleggende bruk</h4>
                    <p>Bruk shortcode-generatoren for å enkelt lage tilpassede produktkaruseller. Du kan vise:</p>
                    <ul>
                        <li><strong>Nyeste produkter</strong> - Automatisk oppdatert med de nyeste produktene</li>
                        <li><strong>Produkter fra kategori</strong> - Velg spesifikke kategorier</li>
                        <li><strong>Produkter på salg</strong> - Vis kun salgsprodukter</li>
                        <li><strong>Fremhevede produkter</strong> - Produkter merket som featured</li>
                        <li><strong>Bestselgere</strong> - Sortert etter salgsvolum</li>
                    </ul>

                    <h4>Avanserte innstillinger</h4>
                    <ul>
                        <li><strong>Antall produkter</strong> - Bestem hvor mange produkter som skal vises</li>
                        <li><strong>Sortering</strong> - Sorter etter pris eller dato</li>
                        <li><strong>Karusellhastighet</strong> - Kontroller hvor raskt karusellen roterer</li>
                        <li><strong>Skyggeeffekt</strong> - Legg til visuell dybde med skygger</li>
                    </ul>

                    <h4>Eksempel shortcodes</h4>
                    <div class="bd-code-examples">
                        <code>[product_carousel latest="true" limit="8"]</code>
                        <small>Viser 8 nyeste produkter</small>
                        
                        <code>[product_carousel category="electronics" sale="true"]</code>
                        <small>Viser produkter på salg fra elektronikk-kategorien</small>
                        
                        <code>[product_carousel best_sellers="true" shadow="true" speed="5000"]</code>
                        <small>Bestselgere med skygge og 5 sekunders intervall</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BD Modern Styling -->
    <style>
        /* BD Admin Interface Styling */
        .bd-product-carousel-admin {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            margin: 0 -20px;
            padding: 30px;
            min-height: 100vh;
        }

        /* Modern Header Section */
        .bd-admin-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 50px 60px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08), 0 2px 10px rgba(0,0,0,0.04);
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(255,255,255,0.8);
            position: relative;
            overflow: hidden;
        }

        .bd-admin-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .bd-branding h2 {
            margin: 0 0 15px 0;
            color: #1a202c;
            font-size: 2.4em;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }

        .bd-branding p {
            color: #64748b;
            margin: 0;
            font-size: 16px;
        }

        .bd-actions {
            display: flex;
            gap: 15px;
        }

        /* Navigation Tabs */
        .nav-tab-wrapper {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 12px 12px 0 0;
            padding: 0;
            margin: 0;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .nav-tab {
            background: transparent;
            border: none;
            border-radius: 12px 12px 0 0;
            color: #64748b;
            font-weight: 600;
            padding: 18px 28px;
            margin: 0;
            position: relative;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .nav-tab:hover {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #334155;
            transform: translateY(-1px);
        }

        .nav-tab-active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom: none;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        /* Tab Content */
        .tab-content {
            display: none;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 40px;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08), 0 2px 10px rgba(0,0,0,0.04);
            margin-bottom: 30px;
            border: 1px solid rgba(255,255,255,0.8);
            border-top: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeInUp 0.4s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Settings Sections */
        .bd-settings-section {
            margin-bottom: 50px;
            padding: 35px;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
            overflow: hidden;
        }

        .bd-settings-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .bd-settings-section h3 {
            margin: 0 0 25px 0;
            color: #1a202c;
            font-size: 1.5em;
            font-weight: 700;
            padding-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
            position: relative;
        }

        .bd-settings-section h3::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .bd-settings-section h4 {
            color: #374151;
            font-size: 1.1em;
            font-weight: 600;
            margin: 0 0 15px 0;
        }

        /* Form Elements */
        .bd-settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .bd-form-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .bd-input-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .bd-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: block;
        }

        .bd-input, .bd-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }

        .bd-input:focus, .bd-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Radio and Checkbox Groups */
        .bd-radio-group, .bd-checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .bd-radio-group:hover, .bd-checkbox-group:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.02);
        }

        .bd-radio-group input, .bd-checkbox-group input {
            margin: 0;
            accent-color: #667eea;
        }

        .bd-radio-label, .bd-checkbox-label {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .bd-radio-label strong, .bd-checkbox-label strong {
            color: #374151;
            font-weight: 600;
        }

        .bd-radio-label small, .bd-checkbox-label small {
            color: #64748b;
            font-size: 13px;
        }

        /* Shortcode Output */
        .bd-shortcode-output {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .bd-shortcode-output code {
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 14px;
            color: #374151;
            font-weight: 600;
            background: none;
            padding: 0;
        }

        .bd-help-text {
            color: #64748b;
            font-size: 14px;
            margin: 10px 0;
        }

        /* Documentation */
        .bd-documentation h4 {
            color: #667eea;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .bd-documentation ul {
            margin: 15px 0;
            padding-left: 20px;
        }

        .bd-documentation li {
            margin-bottom: 8px;
            color: #374151;
        }

        .bd-code-examples {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        .bd-code-examples code {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 12px 16px;
            border-radius: 8px;
            display: block;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            border: 1px solid #e2e8f0;
        }

        .bd-code-examples small {
            color: #64748b;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        /* Buttons */
        .button-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .button-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .button-secondary {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border: 1px solid #e2e8f0;
            color: #374151;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .button-secondary:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: translateY(-1px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .bd-product-carousel-admin {
                padding: 15px;
            }
            
            .bd-admin-header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
                padding: 30px 20px;
            }
            
            .bd-settings-grid {
                grid-template-columns: 1fr;
            }
            
            .bd-input-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("carousel-settings");
        const output = document.getElementById("shortcode-output");
        const copyBtn = document.getElementById("copy-shortcode");
        const generateBtn = document.getElementById("generate-shortcode");

        // Tab functionality
        const tabs = document.querySelectorAll('.nav-tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('nav-tab-active'));
                tabContents.forEach(tc => tc.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                this.classList.add('nav-tab-active');
                document.getElementById(targetId).classList.add('active');
            });
        });

        // Generate initial shortcode
        generateShortcode();

        // Auto-generate shortcode on form changes
        form.addEventListener('change', generateShortcode);
        form.addEventListener('input', generateShortcode);

        generateBtn.addEventListener("click", generateShortcode);

        function generateShortcode() {
            const mode = form.mode.value === "latest" ? ' latest="true"' : '';
            const category = form.mode.value === "category" ? ' category="' + form.category.value + '"' : '';
            const sale = form.sale.checked ? ' sale="true"' : '';
            const featured = form.featured.checked ? ' featured="true"' : '';
            const bestSellers = form.best_sellers.checked ? ' best_sellers="true"' : '';
            const orderby = form.orderby.value ? ' orderby="' + form.orderby.value + '"' : '';
            const order = form.order.value && form.order.value !== 'DESC' ? ' order="' + form.order.value + '"' : '';
            const limit = form.limit.value && form.limit.value !== '6' ? ' limit="' + form.limit.value + '"' : '';
            const shadow = document.getElementById("shadow-checkbox").checked ? ' shadow="true"' : '';
            const speed = document.getElementById("carousel-speed").value && document.getElementById("carousel-speed").value !== '3' ? ' speed="' + (parseInt(document.getElementById("carousel-speed").value, 10) * 1000) + '"' : '';

            const shortcode = `[product_carousel${mode}${category}${sale}${featured}${bestSellers}${orderby}${order}${limit}${shadow}${speed}]`;
            output.textContent = shortcode;
            copyBtn.style.display = "inline-block";
        }

        copyBtn.addEventListener("click", () => {
            const text = output.textContent || output.innerText;
            navigator.clipboard.writeText(text).then(() => {
                const originalText = copyBtn.textContent;
                copyBtn.textContent = "Kopiert!";
                copyBtn.style.background = "linear-gradient(135deg, #10b981 0%, #059669 100%)";
                setTimeout(() => {
                    copyBtn.textContent = originalText;
                    copyBtn.style.background = "";
                }, 2000);
            });
        });
    });
    </script>
<?php
}
