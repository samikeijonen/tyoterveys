module.exports = {
    root: true,
    extends: ['plugin:@wordpress/eslint-plugin/recommended'],
    parserOptions: {
        requireConfigFile: false,
        babelOptions: {
            presets: [require.resolve('@wordpress/babel-preset-default')],
        },
    },
    rules: {
        // Use spaces.
        indent: ['error', 4],
    },
};
