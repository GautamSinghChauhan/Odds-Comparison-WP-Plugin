<?php
use Odds\API;
use Odds\OddsConverter;

// Instantiate the API class and fetch the odds
$api = new API();
$odds = $api->fetch_odds();  // You can customize sport, region, or markets if needed

if (empty($odds)) {
    echo '<p>No odds available at the moment.</p>';
    return;
}
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
                    <td>
                        <?php
                        // Assume odds are in decimal format; otherwise, handle accordingly
                        echo esc_html($bookmaker['markets'][0]['outcomes'][0]['price']);
                        ?>
                    </td>
                    <td>
                        <?php
                        $decimal_odds = $bookmaker['markets'][0]['outcomes'][0]['price'];
                        echo esc_html(OddsConverter::to_fractional($decimal_odds));
                        ?>
                    </td>
                    <td>
                        <?php
                        $decimal_odds = $bookmaker['markets'][0]['outcomes'][0]['price'];
                        echo esc_html(OddsConverter::to_american($decimal_odds));
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>
