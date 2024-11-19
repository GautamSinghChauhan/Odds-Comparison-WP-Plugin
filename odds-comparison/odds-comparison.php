<?php
/**
 * Plugin Name: Odds Comparison
 * Description: A plugin for live odds comparison with bookmakers.
 * Version: 1.0.0
 * Author: Gautam Singh
 */

if (!defined('ABSPATH')) exit;

define('ODDS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ODDS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Includes
require_once ODDS_PLUGIN_DIR . 'includes/Admin.php';
require_once ODDS_PLUGIN_DIR . 'includes/API.php';
require_once ODDS_PLUGIN_DIR . 'includes/GutenbergBlock.php';
require_once ODDS_PLUGIN_DIR . 'includes/OddsConverter.php';
require_once ODDS_PLUGIN_DIR . 'includes/Cache.php';

// Initialize
add_action('plugins_loaded', function() {
    new Odds\Admin();
    new Odds\GutenbergBlock();
});

// Enqueue the Gutenberg Block assets (JS and CSS)
function enqueue_odds_comparison_block_assets() {
    wp_enqueue_script(
        'odds-comparison-block',
        plugin_dir_url(__FILE__) . 'assets/js/block.js', // Path to your block.js file
        array('wp-blocks', 'wp-element', 'wp-editor'), // Dependencies
        null, // Version (optional)
        true // Load in the footer
    );

    wp_enqueue_style(
        'odds-comparison-block-styles',
        plugin_dir_url(__FILE__) . 'assets/css/styles.css', // Path to your styles.css file
        array('wp-edit-blocks'), // Dependencies (required for Gutenberg styles)
        null // Version (optional)
    );
}
add_action('enqueue_block_editor_assets', 'enqueue_odds_comparison_block_assets');

// Render the Odds Comparison block in frontend
function render_odds_comparison_block($attributes) {
    return '<div class="odds-comparison-block">
                <p>Live odds will be displayed here...</p>
            </div>';
}
add_filter('render_block_odds/comparison', 'render_odds_comparison_block');
