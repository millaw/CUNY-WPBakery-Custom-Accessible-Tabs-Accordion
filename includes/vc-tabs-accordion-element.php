<?php
if (!defined('ABSPATH')) exit;

if (!function_exists('cuny_wbta_register_tabs_accordion')) {
    function cuny_wbta_register_tabs_accordion() {
        vc_map(array(
            'name' => __('Accessible Tabs/Accordion', 'cuny-wbta'),
            'base' => 'accessible_tabs_accordion',
            'as_parent' => array('only' => 'accessible_tabs_accordion_section'),
            'content_element' => true,
            'category' => __('Custom Elements', 'cuny-wbta'),
            'icon' => 'dashicons-exerpt-view',
            'js_view' => 'VcColumnView',
            'show_settings_on_create' => true,
            'params' => array(
                array(
                    'type' => 'checkbox',
                    'heading' => __('Tabs/Accordion', 'cuny-wbta'),
                    'param_name' => 'responsive',
                    'value' => array(__('Enable', 'cuny-wbta') => 'true'),
                    'std' => 'true'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __('Allow Collapse All', 'cuny-wbta'),
                    'param_name' => 'collapse_all',
                    'value' => array(__('Yes', 'cuny-wbta') => 'true'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Active Section (0 = none)', 'cuny-wbta'),
                    'param_name' => 'active_section',
                    'value' => '1'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Style', 'cuny-wbta'),
                    'param_name' => 'style',
                    'value' => array(
                        'White' => 'white',
                        'Chino' => 'chino',
                        'Blue' => 'blue'
                    ),
                    'std' => 'white'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Extra class name', 'cuny-wbta'),
                    'param_name' => 'el_class'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Element ID', 'cuny-wbta'),
                    'param_name' => 'el_id'
                )
            )
        ));

        vc_map(array(
            'name' => __('Tab/Accordion Section', 'cuny-wbta'),
            'base' => 'accessible_tabs_accordion_section',
            'as_child' => array('only' => 'accessible_tabs_accordion'),
            'as_parent' => array('except' => 'accessible_tabs_accordion_section'),
            'content_element' => true,
            'category' => __('Custom Elements', 'cuny-wbta'),
            'icon' => 'dashicons-align-left',
            'js_view' => 'VcColumnView',
            'show_settings_on_create' => true,
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __('Title', 'cuny-wbta'),
                    'param_name' => 'title',
                    'value' => __('Section Title', 'cuny-wbta'),
                    'admin_label' => true
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Section ID', 'cuny-wbta'),
                    'param_name' => 'section_id'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Heading Tag', 'cuny-wbta'),
                    'param_name' => 'heading_tag',
                    'value' => array(
                        'H2' => 'h2',
                        'H3' => 'h3',
                        'H4' => 'h4',
                        'DIV' => 'div',
                        'P' => 'p'
                    ),
                    'std' => 'h3'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Extra class name', 'cuny-wbta'),
                    'param_name' => 'el_class'
                )
            )
        ));
    }
}

cuny_wbta_register_tabs_accordion();

if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Accessible_Tabs_Accordion extends WPBakeryShortCodesContainer {
        public function content($atts, $content = null) {
            $atts = shortcode_atts(array(
                'responsive' => 'true',
                'collapse_all' => '',
                'active_section' => '1',
                'style' => 'white',
                'el_class' => '',
                'el_id' => ''
            ), $atts);

            $classes = 'cuny-wbta-tabs-accordion ' . esc_attr($atts['style']) . ' ' . esc_attr($atts['el_class']);
            if ($atts['responsive'] === 'true') {
                $classes .= ' cuny-wbta-responsive';
            }
            $id = $atts['el_id'] ? 'id="' . esc_attr($atts['el_id']) . '"' : '';

            // Parse sections from content
            preg_match_all('/\[accessible_tabs_accordion_section(.*?)\](.*?)\[\/accessible_tabs_accordion_section\]/s', $content, $matches, PREG_SET_ORDER);

            $tab_headers = '';
            $tab_bodies = '';
            $accordion_headers_bodies = '';
            $i = 1;
            foreach ($matches as $m) {
                // Extract title
                preg_match('/title="([^"]*)"/', $m[1], $titleMatch);
                $title = isset($titleMatch[1]) ? $titleMatch[1] : 'Section ' . $i;
                // Extract section id
                preg_match('/section_id="([^"]*)"/', $m[1], $idMatch);
                $section_id = isset($idMatch[1]) ? $idMatch[1] : 'tab-section-' . $i;
                $body = $m[2];

                $tab_headers .= '<div class="tab-header-' . $i . '">' . esc_html($title) . '</div>';
                // $tab_bodies .= '<div class="tab-accordion-body-' . $i . '">' . wpb_js_remove_wpautop($body, true) . '</div>';
                $tab_bodies .= '';
                $accordion_headers_bodies .= '<div class="accordion-header-' . $i . '">' . esc_html($title) . '</div>';
                // $accordion_headers_bodies .= '<div class="accordion-body-' . $i . '">' . wpb_js_remove_wpautop($body, true) . '</div>';
                $accordion_headers_bodies .= '<div class="tab-accordion-body-' . $i . '">' . wpb_js_remove_wpautop($body, true) . '</div>';
                $i++;
            }

            $output = '<div ' . $id . ' class="' . $classes . '">';
            $output .= '<div class="tabs-container">' . $tab_headers . $tab_bodies . '</div>';
            $output .= '<div class="accordion-container">' . $accordion_headers_bodies . '</div>';
            $output .= '</div>';
            return $output;
        }
    }

    class WPBakeryShortCode_Accessible_Tabs_Accordion_Section extends WPBakeryShortCodesContainer {
        public function content($atts, $content = null) {
            // Output nothing, handled by parent shortcode
            return '';
        }
    }
}
