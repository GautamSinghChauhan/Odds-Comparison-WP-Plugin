const { registerBlockType } = wp.blocks;
const { useState } = wp.element;
const { BlockControls, AlignmentToolbar } = wp.editor;

registerBlockType('odds/comparison', {
    title: 'Odds Comparison',
    icon: 'grid-view', // You can change this to any icon you like
    category: 'widgets',
    attributes: {
        bookmaker: {
            type: 'string',
            default: 'Bet365',
        },
        odds: {
            type: 'string',
            default: 'Loading...',
        },
    },
    edit({ attributes, setAttributes }) {
        const [odds, setOdds] = useState(attributes.odds);

        // Fetch odds (example static data)
        const fetchOdds = async () => {
            const response = await fetch('https://api.the-odds-api.com/v4/odds/', {
                headers: { 'API-Key': '7c520709b4bded12a1a6b1bf12a6e1e0' },
            });
            const data = await response.json();
            setOdds(data.odds || 'No odds available');
        };

        // Call the API to fetch odds
        if (attributes.odds === 'Loading...') {
            fetchOdds();
        }

        return (
            <div className="odds-comparison-block">
                <h3>{attributes.bookmaker}</h3>
                <p>Odds: {odds}</p>
            </div>
        );
    },
    save({ attributes }) {
        return (
            <div className="odds-comparison-block">
                <h3>{attributes.bookmaker}</h3>
                <p>Odds: {attributes.odds}</p>
            </div>
        );
    },
});
