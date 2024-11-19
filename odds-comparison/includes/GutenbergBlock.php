<?php
namespace Odds;

class GutenbergBlock {
    public function __construct() {
        add_action('init', [$this, 'register_block']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_editor_assets']);
    }

    public function register_block() {
        // Register block type
        register_block_type('odds/comparison', [
            'editor_script' => 'odds-comparison-block',
            'render_callback' => [$this, 'render_block'],
        ]);
    }

    public function enqueue_editor_assets() {
        // Enqueue block editor script for Gutenberg block
        wp_enqueue_script(
            'odds-comparison-block', 
            plugins_url('/assets/js/block.js', __FILE__), 
            ['wp-blocks', 'wp-element', 'wp-editor'], 
            false, 
            true
        );
    }

    public function render_block($attributes) {
        $api = new API();
        $odds = $api->fetch_odds();  // Fetch live odds

        if (empty($odds)) {
            return '<p>No odds available at the moment.</p>';
        }

        ob_start();
        ?>
        <table class="odds-table">
            <thead>
                <tr>
                    <th>Bookmaker</th>
                    <th>Odds (Decimal)</th>
                    <th>Odds (Fractional)</th>
                    <th>Odds (American)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($odds as $event): ?>
                    <?php foreach ($event['bookmakers'] as $bookmaker): ?>
                        <tr>
                            <td><?php echo esc_html($bookmaker['title']); ?></td>
                            <td><?php echo esc_html($bookmaker['markets'][0]['outcomes'][0]['price']); ?></td>
                            <td><?php echo esc_html(OddsConverter::to_fractional($bookmaker['markets'][0]['outcomes'][0]['price'])); ?></td>
                            <td><?php echo esc_html(OddsConverter::to_american($bookmaker['markets'][0]['outcomes'][0]['price'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        return ob_get_clean();
    }
}
