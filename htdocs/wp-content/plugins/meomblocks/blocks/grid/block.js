import classNames from 'classnames';

const { registerBlockType } = wp.blocks;
const { InnerBlocks, useBlockProps, useInnerBlocksProps } = wp.blockEditor;

/**
 * Internal dependencies
 */
import block from './block.json';
import Sidebar from './components/sidebar';

const BLOCK_SLUG = 'grid';

const ALLOWED_BLOCKS = ['meomblocks/grid-column'];

const TEMPLATE = [
    ['meomblocks/grid-column', {}],
    ['meomblocks/grid-column', {}],
];

export default registerBlockType(block.name, {
    edit: (props) => {
        const {
            attributes: { columnCount, hasSmallerSpacing },
        } = props;

        const classes = classNames({
            [`${BLOCK_SLUG}`]: true,
            'grid-auto': true,
            'width-wide': true,
            'module-top-margin': true,
            [`has-${columnCount}-columns`]: true,
            [`has-smaller-spacing`]: hasSmallerSpacing,
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
