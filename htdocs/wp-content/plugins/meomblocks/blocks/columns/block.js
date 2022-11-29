import classNames from 'classnames';

const { registerBlockType } = wp.blocks;
const { InnerBlocks, useBlockProps, useInnerBlocksProps } = wp.blockEditor;

/**
 * Internal dependencies
 */
import block from './block.json';
import Sidebar from './components/sidebar';

const BLOCK_SLUG = 'columns';

const ALLOWED_BLOCKS = ['meomblocks/column'];

const TEMPLATE = [
    ['meomblocks/column', {}],
    ['meomblocks/column', {}],
];

export default registerBlockType(block.name, {
    edit: (props) => {
        const {
            attributes: { columnCount },
        } = props;

        const classes = classNames({
            [`${BLOCK_SLUG}`]: true,
            grid: true,
            [`has-${columnCount}-columns`]: true,
        });

        const blockProps = useBlockProps({ // eslint-disable-line
            className: classes,
        });

        const innerBlocksProps = useInnerBlocksProps(blockProps, { // eslint-disable-line
            allowedBlocks: ALLOWED_BLOCKS,
            template: TEMPLATE,
            renderAppender: InnerBlocks.ButtonBlockAppender,
        });

        return (
            <>
                <div {...innerBlocksProps}></div>
                <Sidebar {...props} />
            </>
        );
    },

    save: () => {
        return <InnerBlocks.Content />;
    },
});
