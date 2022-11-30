import classNames from 'classnames';

const { registerBlockType } = wp.blocks;
const { InnerBlocks, useBlockProps, useInnerBlocksProps } = wp.blockEditor;

/**
 * Internal dependencies
 */
import block from './block.json';
import ImageSelect from '../../components/image-select';

import Sidebar from './components/sidebar';

const ALLOWED_BLOCKS = [
    'core/heading',
    'core/paragraph',
    'core/button',
    'core/list',
    'core/list-item',
    'gravityforms/form',
];

const TEMPLATE = [['core/heading', { level: 2 }]];

export default registerBlockType(block.name, {
    edit: (props) => {
        const {
            attributes: { imagePosition, image },
            setAttributes,
        } = props;

        const classes = classNames({
            'image-and-text': true,
            [`image-and-text--position-${imagePosition}`]: true,
            'width-wide': true,
            'module-top-margin': true,
        });

        const blockProps = useBlockProps({ // eslint-disable-line
            className: classes,
        });

        const innerBlocksProps = useInnerBlocksProps( // eslint-disable-line
            {
                className: `image-and-text__content top-margin}`,
            },
            {
                allowedBlocks: ALLOWED_BLOCKS,
                template: TEMPLATE,
            }
        );

        return (
            <div {...blockProps}>
                <Sidebar {...props} />
                <div className={`image-and-text__container grid-auto`}>
                    <figure
                        className={`image-and-text__image aspect-ratio aspect-ratio--1-1`}
                    >
                        <ImageSelect
                            image={image}
                            onChange={(newImage) =>
                                setAttributes({ image: newImage })
                            }
                        />
                    </figure>
                    <div {...innerBlocksProps}></div>
                </div>
            </div>
        );
    },

    save: () => <InnerBlocks.Content />,
});
