jQuery(document).ready(function($) {
    'use strict';
    
    // Tab functionality
    $('.vfm-tab').on('click', function() {
        var target = $(this).data('target');
        
        // Remove active class from all tabs and contents
        $('.vfm-tab').removeClass('active');
        $('.vfm-tab-content').removeClass('active');
        
        // Add active class to clicked tab and target content
        $(this).addClass('active');
        $('#' + target).addClass('active');
    });
    
    // Global settings apply to all tags
    $('#apply-global-to-all').on('click', function() {
        var globalFamily = $('#global_font_family').val();
        var globalSize = $('#global_font_size').val();
        var globalWeight = $('#global_font_weight').val();
        var globalStyle = $('#global_font_style').val();
        
        // Apply to all elementor tag inputs
        $('[id^="elementor_"]').each(function() {
            var id = $(this).attr('id');
            if (id.includes('font_family')) {
                $(this).val(globalFamily);
            } else if (id.includes('font_size')) {
                $(this).val(globalSize);
            } else if (id.includes('font_weight')) {
                $(this).val(globalWeight);
            } else if (id.includes('font_style')) {
                $(this).val(globalStyle);
            }
        });
        
        showNotice('تنظیمات عمومی به همه تگ‌ها اعمال شد.', 'success');
    });
    
    // Font preview functionality
    $('.vfm-form-group input, .vfm-form-group select').on('change', function() {
        updateFontPreview();
    });
    
    function updateFontPreview() {
        var family = $('#global_font_family').val() || 'Vazirmatn';
        var size = $('#global_font_size').val() || '16px';
        var weight = $('#global_font_weight').val() || '400';
        var style = $('#global_font_style').val() || 'normal';
        
        var previewStyle = 'font-family: "' + family + '", sans-serif; font-size: ' + size + '; font-weight: ' + weight + '; font-style: ' + style + ';';
        
        $('.vfm-font-preview').attr('style', previewStyle);
    }
    
    // Initialize font preview
    updateFontPreview();
    
    // Form validation
    $('form').on('submit', function(e) {
        var isValid = true;
        var errors = [];
        
        // Check required fields
        $('input[required], select[required]').each(function() {
            if (!$(this).val()) {
                isValid = false;
                errors.push($(this).prev('label').text() + ' الزامی است.');
                $(this).addClass('error');
            } else {
                $(this).removeClass('error');
            }
        });
        
        // Validate font sizes
        $('input[id*="font_size"]').each(function() {
            var value = $(this).val();
            if (value && !/^\d+(\.\d+)?(px|em|rem|%)$/.test(value)) {
                isValid = false;
                errors.push('سایز فونت باید به فرمت صحیح باشد (مثل: 16px, 1.2em)');
                $(this).addClass('error');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            showNotice('لطفاً خطاهای زیر را برطرف کنید:<br>' + errors.join('<br>'), 'error');
            return false;
        }
        
        // Show loading state
        var submitBtn = $(this).find('input[type="submit"]');
        var originalText = submitBtn.val();
        submitBtn.val('در حال ذخیره...').prop('disabled', true);
        
        // Re-enable after a delay (in case of validation errors)
        setTimeout(function() {
            submitBtn.val(originalText).prop('disabled', false);
        }, 3000);
    });
    
    // Show notice function
    function showNotice(message, type) {
        var noticeClass = 'vfm-notice ' + (type || 'info');
        var notice = $('<div class="' + noticeClass + '">' + message + '</div>');
        
        $('.vfm-admin-container').prepend(notice);
        
        // Auto remove after 5 seconds
        setTimeout(function() {
            notice.fadeOut(function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Reset to defaults
    $('#reset-to-defaults').on('click', function(e) {
        e.preventDefault();
        
        if (confirm('آیا مطمئن هستید که می‌خواهید همه تنظیمات را به حالت پیش‌فرض بازگردانید؟')) {
            // Reset global settings
            $('#global_font_family').val('Vazirmatn');
            $('#global_font_size').val('16px');
            $('#global_font_weight').val('400');
            $('#global_font_style').val('normal');
            
            // Reset elementor settings
            var defaultSettings = {
                'h1': { 'font_family': 'Vazirmatn', 'font_size': '32px', 'font_weight': '700', 'font_style': 'normal' },
                'h2': { 'font_family': 'Vazirmatn', 'font_size': '28px', 'font_weight': '600', 'font_style': 'normal' },
                'h3': { 'font_family': 'Vazirmatn', 'font_size': '24px', 'font_weight': '600', 'font_style': 'normal' },
                'h4': { 'font_family': 'Vazirmatn', 'font_size': '20px', 'font_weight': '500', 'font_style': 'normal' },
                'h5': { 'font_family': 'Vazirmatn', 'font_size': '18px', 'font_weight': '500', 'font_style': 'normal' },
                'h6': { 'font_family': 'Vazirmatn', 'font_size': '16px', 'font_weight': '500', 'font_style': 'normal' },
                'p': { 'font_family': 'Vazirmatn', 'font_size': '16px', 'font_weight': '400', 'font_style': 'normal' },
                'span': { 'font_family': 'Vazirmatn', 'font_size': '14px', 'font_weight': '400', 'font_style': 'normal' },
                'a': { 'font_family': 'Vazirmatn', 'font_size': '16px', 'font_weight': '400', 'font_style': 'normal' },
                'button': { 'font_family': 'Vazirmatn', 'font_size': '16px', 'font_weight': '500', 'font_style': 'normal' }
            };
            
            $.each(defaultSettings, function(tag, settings) {
                $('#elementor_' + tag + '_font_family').val(settings.font_family);
                $('#elementor_' + tag + '_font_size').val(settings.font_size);
                $('#elementor_' + tag + '_font_weight').val(settings.font_weight);
                $('#elementor_' + tag + '_font_style').val(settings.font_style);
            });
            
            // Reset checkboxes
            $('#enable_vazir_font').prop('checked', true);
            $('#dashboard_font').prop('checked', true);
            $('#elementor_font').prop('checked', true);
            
            updateFontPreview();
            showNotice('تنظیمات به حالت پیش‌فرض بازگردانده شد.', 'success');
        }
    });
    
    // Export/Import functionality
    $('#export-settings').on('click', function(e) {
        e.preventDefault();
        
        var settings = {
            enable_vazir_font: $('#enable_vazir_font').is(':checked'),
            dashboard_font: $('#dashboard_font').is(':checked'),
            elementor_font: $('#elementor_font').is(':checked'),
            global_settings: {
                font_family: $('#global_font_family').val(),
                font_size: $('#global_font_size').val(),
                font_weight: $('#global_font_weight').val(),
                font_style: $('#global_font_style').val()
            },
            elementor_settings: {}
        };
        
        // Collect elementor settings
        var tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'a', 'button'];
        tags.forEach(function(tag) {
            settings.elementor_settings[tag] = {
                font_family: $('#elementor_' + tag + '_font_family').val(),
                font_size: $('#elementor_' + tag + '_font_size').val(),
                font_weight: $('#elementor_' + tag + '_font_weight').val(),
                font_style: $('#elementor_' + tag + '_font_style').val()
            };
        });
        
        var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(settings, null, 2));
        var downloadAnchorNode = document.createElement('a');
        downloadAnchorNode.setAttribute("href", dataStr);
        downloadAnchorNode.setAttribute("download", "vazir-font-settings.json");
        document.body.appendChild(downloadAnchorNode);
        downloadAnchorNode.click();
        downloadAnchorNode.remove();
        
        showNotice('تنظیمات با موفقیت صادر شد.', 'success');
    });
    
    // Import settings
    $('#import-settings').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                try {
                    var settings = JSON.parse(e.target.result);
                    
                    // Apply settings
                    $('#enable_vazir_font').prop('checked', settings.enable_vazir_font);
                    $('#dashboard_font').prop('checked', settings.dashboard_font);
                    $('#elementor_font').prop('checked', settings.elementor_font);
                    
                    if (settings.global_settings) {
                        $('#global_font_family').val(settings.global_settings.font_family);
                        $('#global_font_size').val(settings.global_settings.font_size);
                        $('#global_font_weight').val(settings.global_settings.font_weight);
                        $('#global_font_style').val(settings.global_settings.font_style);
                    }
                    
                    if (settings.elementor_settings) {
                        $.each(settings.elementor_settings, function(tag, tagSettings) {
                            $('#elementor_' + tag + '_font_family').val(tagSettings.font_family);
                            $('#elementor_' + tag + '_font_size').val(tagSettings.font_size);
                            $('#elementor_' + tag + '_font_weight').val(tagSettings.font_weight);
                            $('#elementor_' + tag + '_font_style').val(tagSettings.font_style);
                        });
                    }
                    
                    updateFontPreview();
                    showNotice('تنظیمات با موفقیت وارد شد.', 'success');
                    
                } catch (error) {
                    showNotice('خطا در خواندن فایل تنظیمات.', 'error');
                }
            };
            reader.readAsText(file);
        }
    });
    
    // Auto-save functionality
    var autoSaveTimer;
    $('.vfm-form-group input, .vfm-form-group select, .vfm-checkbox-group input').on('change', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(function() {
            // Show auto-save indicator
            var indicator = $('<div class="vfm-notice info">در حال ذخیره خودکار...</div>');
            $('.vfm-admin-container').prepend(indicator);
            
            // Simulate auto-save (you can implement actual auto-save here)
            setTimeout(function() {
                indicator.fadeOut(function() {
                    $(this).remove();
                });
            }, 1000);
        }, 2000);
    });
    
    // Help tooltips
    $('.vfm-help').on('click', function(e) {
        e.preventDefault();
        var helpText = $(this).data('help');
        if (helpText) {
            showNotice(helpText, 'info');
        }
    });
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl/Cmd + S to save
        if ((e.ctrlKey || e.metaKey) && e.keyCode === 83) {
            e.preventDefault();
            $('form').submit();
        }
        
        // Ctrl/Cmd + R to reset
        if ((e.ctrlKey || e.metaKey) && e.keyCode === 82) {
            e.preventDefault();
            $('#reset-to-defaults').click();
        }
    });
    
    // Initialize tooltips
    $('[data-tooltip]').each(function() {
        $(this).attr('title', $(this).data('tooltip'));
    });
});
