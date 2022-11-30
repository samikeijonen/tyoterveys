import classNames from 'classnames';

const { registerBlockType } = wp.blocks;
const { InnerBlocks, useBlockProps, useInnerBlocksProps } = wp.blockEditor;

/**
 * Internal dependencies
 */
import block from './block.json';
import ImageSelect from '../../components/image-select';

const ALLOWED_BLOCKS = ['core/paragraph', 'core/heading', 'core/buttons'];
const TEMPLATE = [
    ['core/heading', { level: 1 }],
    ['core/paragraph', {}],
];

export default registerBlockType(block.name, {
    edit: (props) => {
        const {
            attributes: { image },
            setAttributes,
        } = props;

        const classes = classNames({
            hero: true,
            'content-row': true,
            'width-full': true,
            'x-padding': true,
            'cover-bg': true,
            'module-top-margin': true,
        });

        const blockProps = useBlockProps({ className: classes });

        const contentClasses = classNames({
            hero__content: true,
            'top-margin': true,
        });

        const innerBlocksProps = useInnerBlocksProps(
            {
                className: contentClasses,
            },
            {
                allowedBlocks: ALLOWED_BLOCKS,
                template: TEMPLATE,
            }
        );

        return (
            <div {...blockProps}>
                <div className={`hero__container mx-auto width-wide-plus`}>
                    <div {...innerBlocksProps}></div>
                    <figure className={`hero__image`}>
                        <ImageSelect
                            image={image}
                            classes="cover-img"
                            onChange={(newImage) =>
                                setAttributes({ image: newImage })
                            }
                        />
                    </figure>
                </div>
            </div>
        );
    },

    save: () => <InnerBlocks.Content />,
});
