const { __ } = wp.i18n;
const { PanelBody, RadioControl } = wp.components;
const { InspectorControls } = wp.blockEditor;

const Sidebar = (props) => {
    const {
        attributes: { imagePosition },
        setAttributes,
    } = props;

    return (
        <InspectorControls>
            <PanelBody title={__('Settings', 'meomblocks')} initalOpen={true}>
                <RadioControl
                    label={__('Image position', 'meomblocks')}
                    selected={imagePosition}
                    options={[
                        {
                            label: __('Left', 'meomblocks'),
                            value: 'left',
                        },
                        {
                            label: __('Right', 'meomblocks'),
                            value: 'right',
                        },
                    ]}
                    onChange={(newImagePosition) => {
                        setAttributes({ imagePosition: newImagePosition });
                    }}
                />
            </PanelBody>
        </InspectorControls>
    );
};

export default Sidebar;
