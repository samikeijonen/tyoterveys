import classNames from 'classnames';

const { registerBlockType } = wp.blocks;
const {
    InnerBlocks,
    useBlockProps,
    useInnerBlocksProps,
    store: blockEditorStore,
} = wp.blockEditor;

const { useSelect } = wp.data;

/**
 * Internal dependencies
 */
import block from './block.json';

const BLOCK_SLUG = 'column';

const ALLOWED_BLOCKS = [
    'core/heading',
    'core/paragraph',
    'core/list',
    'core/image',
    'core/buttons',
    'meomblocks/social-links',
];

export default registerBlockType(block.name, {
    edit: (props) => {
        const {
            attributes: {},
            clientId,
        } = props;

        const { hasChildBlocks } = useSelect( // eslint-disable-line
            (select) => {
                const { getBlockOrder } = select(blockEditorStore);

                return {
                    hasChildBlocks: getBlockOrder(clientId).length > 0,
                };
            },
            [clientId]
        );

        const classes = classNames({
            [`${BLOCK_SLUG}`]: true,
        });

        const blockProps = useBlockProps({ // eslint-disable-line
            className: classes,
        });

        const innerBlocksProps = useInnerBlocksProps( // eslint-disable-line
            {
                ...blockProps,
            },
            {
                allowedBlocks: ALLOWED_BLOCKS,
                renderAppender: hasChildBlocks
                    ? undefined
                    : InnerBlocks.ButtonBlockAppender,
            }
        );

        return <div {...innerBlocksProps} />;
    },

    save: () => {
        return <InnerBlocks.Content />;
    },
});
