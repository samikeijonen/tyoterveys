import classNames from 'classnames';

const { registerBlockType } = wp.blocks;
const { useBlockProps } = wp.blockEditor;

const { serverSideRender: ServerSideRender } = wp;

import metadata from './block.json';

const { name } = metadata;

const BLOCK_SLUG = 'social-links';

export default registerBlockType(name, {
    edit: (props) => {
        const { attributes } = props;

        const classes = classNames({
            [`${BLOCK_SLUG}`]: true,
        });

        const blockProps = useBlockProps({ // eslint-disable-line
            className: classes,
        });

        return (
            <div {...blockProps}>
                <ServerSideRender block={name} attributes={attributes} />
            </div>
        );
    },

    save: () => {
        return null;
    },
});
