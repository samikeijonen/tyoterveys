const { __ } = wp.i18n;

wp.domReady(() => {
    // Unregister button style
    wp.blocks.unregisterBlockStyle('core/button', 'default');
    wp.blocks.unregisterBlockStyle('core/button', 'outline');
    wp.blocks.unregisterBlockStyle('core/button', 'squared');
    wp.blocks.unregisterBlockStyle('core/button', 'fill');

    // Register button styles.
    wp.blocks.registerBlockStyle('core/button', {
        name: 'secondary',
        label: __('Secondary', 'kala'),
    });

    wp.blocks.registerBlockStyle('core/button', {
        name: 'white-bg',
        label: __('White background', 'kala'),
    });

    // Unregister quote styles.
    wp.blocks.unregisterBlockStyle('core/quote', 'large');
    wp.blocks.unregisterBlockStyle('core/quote', 'default');

    // Unregister table styles.
    wp.blocks.unregisterBlockStyle('core/table', 'stripes');
});
