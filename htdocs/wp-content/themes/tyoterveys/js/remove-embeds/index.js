/* global kalaGutenbergData */
const { getBlockVariations, unregisterBlockVariation } = wp.blocks;

wp.domReady(() => {
    // Allow only listed embeds from array.
    // @link: https://github.com/WordPress/gutenberg/issues/27913#issuecomment-771505654
    // Filterable, only `youtube` allowed by default.
    const allowedEmbedVariants = kalaGutenbergData.allowedEmbedVariants;

    getBlockVariations('core/embed').forEach((variant) => {
        if (!allowedEmbedVariants.includes(variant.name)) {
            unregisterBlockVariation('core/embed', variant.name);
        }
    });
});
