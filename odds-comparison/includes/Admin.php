<?php
namespace Odds;

class Admin {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_settings_page() {
        add_menu_page(
            'Odds Comparison Settings',
            'Odds Comparison',
            'manage_options',
            'odds-comparison-settings',
            [$this, 'settings_page']
        );
    }

    public function register_settings() {
        register_setting('odds_comparison_options', 'odds_comparison_settings');
        add_settings_section('odds_comparison_main_section', 'Configure Bookmakers and Markets', null, 'odds-comparison-settings');

        add_settings_field(
            'odds_comparison_bookmakers',
            'Select Bookmakers',
            [$this, 'bookmakers_field'],
            'odds-comparison-settings',
            'odds_comparison_main_section'
        );

        add_settings_field(
            'odds_comparison_markets',
            'Select Markets',
            [$this, 'markets_field'],
            'odds-comparison-settings',
            'odds_comparison_main_section'
        );
    }

    public function settings_page() {
        ?>
        <div class="wrap">
            <h1>Odds Comparison Settings</h1>
            <form method="post" action="options.php">
                <?php
                    settings_fields('odds_comparison_options');
                    do_settings_sections('odds-comparison-settings');
                    submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function bookmakers_field() {
        $options = get_option('odds_comparison_settings');
        ?>
        <input type="text" name="odds_comparison_settings[bookmakers]" value="<?php echo esc_attr($options['bookmakers'] ?? ''); ?>" />
        <p class="description">Enter the bookmaker names or URLs (comma-separated) to display.</p>
        <?php
    }

    public function markets_field() {
        $options = get_option('odds_comparison_settings');
        ?>
        <input type="text" name="odds_comparison_settings[markets]" value="<?php echo esc_attr($options['markets'] ?? ''); ?>" />
        <p class="description">Enter the markets you want to display (comma-separated, e.g., 'h2h, spreads').</p>
        <?php
    }
}
