<?php
namespace Odds;

class API {
    private $api_key = '7c520709b4bded12a1a6b1bf12a6e1e0';
    private $endpoint = 'https://api.the-odds-api.com/v4/sports/upcoming/odds/';

    // Function to fetch odds
    public function fetch_odds($sport = 'upcoming', $region = 'us', $markets = 'h2h') {
        $url = $this->endpoint . "?apiKey={$this->api_key}&sport={$sport}&region={$region}&markets={$markets}";

        // Make the API request
        $response = wp_remote_get($url);

        // Handle errors
        if (is_wp_error($response)) {
            return []; // Return an empty array if the request fails
        }

        // Parse and return the response data
        $data = wp_remote_retrieve_body($response);
        return json_decode($data, true);
    }
}
