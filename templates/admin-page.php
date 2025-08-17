<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap vfm-admin-container">
    <div class="vfm-header">
        <div class="vfm-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
                <defs>
                    <linearGradient id="header-ir-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#60A5FA;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#1E40AF;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <rect x="1" y="1" width="22" height="22" rx="6" fill="#000000" stroke="url(#header-ir-gradient)" stroke-width="1"/>
                <text x="12" y="15" font-family="Arial, Helvetica, sans-serif" font-size="11" font-weight="700" text-anchor="middle" fill="url(#header-ir-gradient)" letter-spacing="0.5">IR</text>
            </svg>
        </div>
        <h1>ایران المنت</h1>
        <p>ایرانی‌سازی وردپرس و المنتور - مدیریت کامل فونت‌ها، سایزها و استایل‌ها</p>
    </div>

    <div class="vfm-info-box">
        <h4>📋 راهنمای استفاده</h4>
        <p>این افزونه به شما امکان می‌دهد فونت وزیر را به عنوان فونت اصلی دشبورد وردپرس و المنتور تنظیم کنید. می‌توانید برای هر تگ HTML تنظیمات جداگانه‌ای تعریف کنید.</p>
    </div>

    <div class="vfm-tabs">
        <button class="vfm-tab active" data-target="general-settings">تنظیمات عمومی</button>
        <button class="vfm-tab" data-target="elementor-settings">تنظیمات المنتور</button>
        <button class="vfm-tab" data-target="advanced-settings">تنظیمات پیشرفته</button>
    </div>

    <form method="post" action="">
        <?php wp_nonce_field('iranelement_save_settings', 'iranelement_nonce'); ?>
        
        <!-- General Settings Tab -->
        <div id="general-settings" class="vfm-tab-content active">
            <div class="vfm-section">
                <h3>🔧 تنظیمات اصلی</h3>
                
                <div class="vfm-checkbox-group">
                    <input type="checkbox" id="enable_vazir_font" name="enable_vazir_font" <?php checked($options['enable_vazir_font'] ?? true); ?>>
                    <label for="enable_vazir_font">فعال‌سازی فونت وزیر</label>
                </div>
                
                <div class="vfm-checkbox-group">
                    <input type="checkbox" id="dashboard_font" name="dashboard_font" <?php checked($options['dashboard_font'] ?? true); ?>>
                    <label for="dashboard_font">اعمال فونت وزیر در دشبورد وردپرس</label>
                </div>
                
                <div class="vfm-checkbox-group">
                    <input type="checkbox" id="elementor_font" name="elementor_font" <?php checked($options['elementor_font'] ?? true); ?>>
                    <label for="elementor_font">اعمال فونت وزیر در المنتور</label>
                </div>
                
                <div class="vfm-checkbox-group">
                    <input type="checkbox" id="elementor_persian_font" name="elementor_persian_font" <?php checked($options['elementor_persian_font'] ?? true); ?>>
                    <label for="elementor_persian_font">اعمال خودکار فونت وزیر در المنتور برای سایت‌های فارسی</label>
                </div>
            </div>

            <div class="vfm-global-settings">
                <h3>🌐 تنظیمات عمومی فونت</h3>
                <p>این تنظیمات به عنوان پیش‌فرض برای تمام المان‌ها اعمال می‌شود.</p>
                
                <div class="vfm-form-grid">
                    <div class="vfm-form-group">
                        <label for="global_font_family">خانواده فونت:</label>
                        <select id="global_font_family" name="global_font_family" required>
                            <option value="Vazirmatn" <?php selected(($options['global_settings']['font_family'] ?? 'Vazirmatn'), 'Vazirmatn'); ?>>Vazirmatn (وزیر)</option>
                            <option value="Tahoma" <?php selected(($options['global_settings']['font_family'] ?? 'Vazirmatn'), 'Tahoma'); ?>>Tahoma</option>
                            <option value="Arial" <?php selected(($options['global_settings']['font_family'] ?? 'Vazirmatn'), 'Arial'); ?>>Arial</option>
                        </select>
                    </div>
                    
                    <div class="vfm-form-group">
                        <label for="global_font_size">سایز فونت:</label>
                        <input type="text" id="global_font_size" name="global_font_size" value="<?php echo esc_attr($options['global_settings']['font_size'] ?? '16px'); ?>" placeholder="16px" required>
                    </div>
                </div>
                
                <div class="vfm-form-grid">
                    <div class="vfm-form-group">
                        <label for="global_font_weight">وزن فونت:</label>
                        <select id="global_font_weight" name="global_font_weight" required>
                            <option value="100" <?php selected(($options['global_settings']['font_weight'] ?? '400'), '100'); ?>>100 - Thin</option>
                            <option value="200" <?php selected(($options['global_settings']['font_weight'] ?? '400'), '200'); ?>>200 - Extra Light</option>
                            <option value="300" <?php selected(($options['global_settings']['font_weight'] ?? '400'), '300'); ?>>300 - Light</option>
                            <option value="400" <?php selected(($options['global_settings']['font_weight'] ?? '400'), '400'); ?>>400 - Regular</option>
                            <option value="500" <?php selected(($options['global_settings']['font_weight'] ?? '400'), '500'); ?>>500 - Medium</option>
                            <option value="600" <?php selected(($options['global_settings']['font_weight'] ?? '400'), '600'); ?>>600 - Semi Bold</option>
                            <option value="700" <?php selected(($options['global_settings']['font_weight'] ?? '400'), '700'); ?>>700 - Bold</option>
                            <option value="800" <?php selected(($options['global_settings']['font_weight'] ?? '400'), '800'); ?>>800 - Extra Bold</option>
                            <option value="900" <?php selected(($options['global_settings']['font_weight'] ?? '400'), '900'); ?>>900 - Black</option>
                        </select>
                    </div>
                    
                    <div class="vfm-form-group">
                        <label for="global_font_style">استایل فونت:</label>
                        <select id="global_font_style" name="global_font_style" required>
                            <option value="normal" <?php selected(($options['global_settings']['font_style'] ?? 'normal'), 'normal'); ?>>Normal</option>
                            <option value="italic" <?php selected(($options['global_settings']['font_style'] ?? 'normal'), 'italic'); ?>>Italic</option>
                        </select>
                    </div>
                </div>
                
                <button type="button" id="apply-global-to-all" class="vfm-save-button" style="background: rgba(255,255,255,0.2); margin-top: 15px;">
                    اعمال تنظیمات عمومی به همه تگ‌ها
                </button>
            </div>

            <div class="vfm-font-preview">
                <h4>پیش‌نمایش فونت:</h4>
                <h1>عنوان اصلی (H1)</h1>
                <h2>عنوان فرعی (H2)</h2>
                <h3>عنوان متوسط (H3)</h3>
                <p>این یک متن نمونه است که نشان می‌دهد فونت وزیر چگونه نمایش داده می‌شود. متن فارسی به زیبایی نمایش داده می‌شود و خوانایی بالایی دارد.</p>
                <a href="#">لینک نمونه</a>
                <button>دکمه نمونه</button>
            </div>
        </div>

        <!-- Elementor Settings Tab -->
        <div id="elementor-settings" class="vfm-tab-content">
            <div class="vfm-section">
                <h3>🎨 تنظیمات المنتور</h3>
                <p>برای هر تگ HTML در المنتور تنظیمات جداگانه‌ای تعریف کنید:</p>
            </div>

            <div class="vfm-tag-settings">
                <?php
                $tags = array(
                    'h1' => 'عنوان اصلی',
                    'h2' => 'عنوان فرعی',
                    'h3' => 'عنوان متوسط',
                    'h4' => 'عنوان کوچک',
                    'h5' => 'عنوان خیلی کوچک',
                    'h6' => 'عنوان حداقل',
                    'p' => 'پاراگراف',
                    'span' => 'متن کوتاه',
                    'a' => 'لینک',
                    'button' => 'دکمه'
                );

                foreach ($tags as $tag => $label) {
                    $tag_settings = $options['elementor_settings'][$tag] ?? array();
                    ?>
                    <div class="vfm-tag-card">
                        <h4><?php echo esc_html($label); ?> (<?php echo strtoupper($tag); ?>)</h4>
                        
                        <div class="vfm-form-group">
                            <label for="elementor_<?php echo $tag; ?>_font_family">خانواده فونت:</label>
                            <select id="elementor_<?php echo $tag; ?>_font_family" name="elementor_<?php echo $tag; ?>_font_family">
                                <option value="Vazirmatn" <?php selected(($tag_settings['font_family'] ?? 'Vazirmatn'), 'Vazirmatn'); ?>>Vazirmatn (وزیر)</option>
                                <option value="Tahoma" <?php selected(($tag_settings['font_family'] ?? 'Vazirmatn'), 'Tahoma'); ?>>Tahoma</option>
                                <option value="Arial" <?php selected(($tag_settings['font_family'] ?? 'Vazirmatn'), 'Arial'); ?>>Arial</option>
                            </select>
                        </div>
                        
                        <div class="vfm-form-group">
                            <label for="elementor_<?php echo $tag; ?>_font_size">سایز فونت:</label>
                            <input type="text" id="elementor_<?php echo $tag; ?>_font_size" name="elementor_<?php echo $tag; ?>_font_size" value="<?php echo esc_attr($tag_settings['font_size'] ?? '16px'); ?>" placeholder="16px">
                        </div>
                        
                        <div class="vfm-form-group">
                            <label for="elementor_<?php echo $tag; ?>_font_weight">وزن فونت:</label>
                            <select id="elementor_<?php echo $tag; ?>_font_weight" name="elementor_<?php echo $tag; ?>_font_weight">
                                <option value="100" <?php selected(($tag_settings['font_weight'] ?? '400'), '100'); ?>>100 - Thin</option>
                                <option value="200" <?php selected(($tag_settings['font_weight'] ?? '400'), '200'); ?>>200 - Extra Light</option>
                                <option value="300" <?php selected(($tag_settings['font_weight'] ?? '400'), '300'); ?>>300 - Light</option>
                                <option value="400" <?php selected(($tag_settings['font_weight'] ?? '400'), '400'); ?>>400 - Regular</option>
                                <option value="500" <?php selected(($tag_settings['font_weight'] ?? '400'), '500'); ?>>500 - Medium</option>
                                <option value="600" <?php selected(($tag_settings['font_weight'] ?? '400'), '600'); ?>>600 - Semi Bold</option>
                                <option value="700" <?php selected(($tag_settings['font_weight'] ?? '400'), '700'); ?>>700 - Bold</option>
                                <option value="800" <?php selected(($tag_settings['font_weight'] ?? '400'), '800'); ?>>800 - Extra Bold</option>
                                <option value="900" <?php selected(($tag_settings['font_weight'] ?? '400'), '900'); ?>>900 - Black</option>
                            </select>
                        </div>
                        
                        <div class="vfm-form-group">
                            <label for="elementor_<?php echo $tag; ?>_font_style">استایل فونت:</label>
                            <select id="elementor_<?php echo $tag; ?>_font_style" name="elementor_<?php echo $tag; ?>_font_style">
                                <option value="normal" <?php selected(($tag_settings['font_style'] ?? 'normal'), 'normal'); ?>>Normal</option>
                                <option value="italic" <?php selected(($tag_settings['font_style'] ?? 'normal'), 'italic'); ?>>Italic</option>
                            </select>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

        <!-- Advanced Settings Tab -->
        <div id="advanced-settings" class="vfm-tab-content">
            <div class="vfm-section">
                <h3>⚙️ تنظیمات پیشرفته</h3>
                
                <div class="vfm-form-group">
                    <button type="button" id="reset-to-defaults" class="vfm-save-button" style="background: #dc3545;">
                        بازگردانی به تنظیمات پیش‌فرض
                    </button>
                </div>
                
                <div class="vfm-form-group">
                    <button type="button" id="export-settings" class="vfm-save-button" style="background: #28a745;">
                        صادر کردن تنظیمات
                    </button>
                </div>
                
                <div class="vfm-form-group">
                    <label for="import-settings">وارد کردن تنظیمات:</label>
                    <input type="file" id="import-settings" accept=".json" style="padding: 10px; border: 2px dashed #ddd; border-radius: 6px; width: 100%;">
                </div>
            </div>

            <div class="vfm-info-box">
                <h4>💡 نکات مهم</h4>
                <ul style="margin: 10px 0; padding-right: 20px;">
                    <li>فونت وزیر به صورت خودکار در سایت شما بارگذاری می‌شود</li>
                    <li>تنظیمات المنتور فقط روی صفحات المنتور اعمال می‌شود</li>
                    <li>می‌توانید تنظیمات را صادر کرده و در سایت دیگری وارد کنید</li>
                    <li>برای اعمال تغییرات، صفحه را رفرش کنید</li>
                </ul>
            </div>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <input type="submit" name="iranelement_save_settings" value="ذخیره تنظیمات" class="vfm-save-button">
        </div>
    </form>
</div>

<style>
/* Additional inline styles for better compatibility */
.vfm-admin-container {
    font-family: 'Vazirmatn', 'Tahoma', 'Arial', sans-serif !important;
}

.vfm-admin-container input,
.vfm-admin-container select,
.vfm-admin-container textarea,
.vfm-admin-container button {
    font-family: 'Vazirmatn', 'Tahoma', 'Arial', sans-serif !important;
}

/* WordPress admin compatibility */
.wp-admin .vfm-admin-container {
    direction: rtl;
    text-align: right;
}

/* Elementor compatibility */
.elementor .vfm-admin-container {
    font-family: 'Vazirmatn', 'Tahoma', 'Arial', sans-serif !important;
}

/* Force Vazirmatn font on all admin elements */
.wp-admin .vfm-admin-container * {
    font-family: 'Vazirmatn', 'Tahoma', 'Arial', sans-serif !important;
}

/* Admin page specific styles */
.settings_page_iranelement {
    font-family: 'Vazirmatn', 'Tahoma', 'Arial', sans-serif !important;
}

.settings_page_iranelement * {
    font-family: 'Vazirmatn', 'Tahoma', 'Arial', sans-serif !important;
}
</style>
