<?php
/**
 * Plugin Name: CUNY WPBakery Custom Accessible Tabs/Accordion Element
 * Plugin URI: https://github.com/millaw/cuny-wpbakery-custom-accessible-accordion-element
 * Description: Adds a WCAG-compliant responsive tabs/accordion element to WPBakery Page Builder that displays as tabs on desktop and accordion on mobile.
 * Version: 2.1.5
 * Author: Milla Wynn
 * Author URI: https://github.com/millaw
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cuny-wpbakery-custom-accessible-tabs-accordion
 */

if (!defined('ABSPATH')) exit;

// Load the VC component
add_action('vc_before_init', function () {
    require_once plugin_dir_path(__FILE__) . 'includes/vc-tabs-accordion-element.php';
});

// Enqueue JS and CSS for frontend
add_action('wp_enqueue_scripts', function () {
    $js_path  = plugin_dir_path(__FILE__) . 'assets/tabs-accordion.js';
    $css_path = plugin_dir_path(__FILE__) . 'assets/tabs-accordion.css';

    $js_version  = file_exists($js_path)  ? filemtime($js_path)  : time();
    $css_version = file_exists($css_path) ? filemtime($css_path) : time();

    wp_enqueue_style('fontawesome-free', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

    wp_enqueue_style(
        'cuny-wbta-tabs-style',
        plugins_url('assets/tabs-accordion.css', __FILE__),
        [],
        $css_version
    );

    wp_enqueue_script(
        'cuny-wbta-tabs-script',
        plugins_url('assets/tabs-accordion.js', __FILE__),
        ['jquery'],
        $js_version,
        true
    );
});