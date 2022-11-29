const { __ } = wp.i18n;
const { PanelBody, RadioControl } = wp.components;
const { InspectorControls } = wp.blockEditor;

const Sidebar = (props) => {
    const {
        attributes: { columnCount },
        setAttributes,
    } = props;

    return (
        <InspectorControls>
            <PanelBody title={__('Settings', 'meomblocks')} initialOpen={true}>
                <RadioControl
                    label={__('Select column count in a row', 'meomblocks')}
                    selected={columnCount}
                    options={[
                        {
                            label: __('2', 'meomblocks'),
                            value: '2',
                        },
                        {
                            label: __('3', 'meomblocks'),
                            value: '3',
                        },
                        {
                            label: __('4', 'meomblocks'),
                            value: '4',
                        },
                    ]}
                    onChange={(newCount) => {
                        setAttributes({ columnCount: newCount });
                    }}
                />
            </PanelBody>
        </InspectorControls>
    );
};

export default Sidebar;
