import config from '../meom-blocks.config.json';

config.blocks.forEach((block) => {
    require(`../blocks/${block.slug}/block.js`);
});
