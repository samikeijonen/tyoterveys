const { __ } = wp.i18n;
const { Button } = wp.components;
const { MediaPlaceholder } = wp.blockEditor;

const ImageSelect = (props) => {
    const { image, onChange, classes } = props;
    const imageId = image && image.id;
    const imageUrl = image && image.url;

    return (
        <>
            {!imageId ? (
                <MediaPlaceholder
                    onSelect={({ id, url }) => {
                        onChange({ id, url });
                    }}
                    allowedTypes={['image']}
                ></MediaPlaceholder>
            ) : (
                <>
                    <img className={classes} src={imageUrl} alt="" />

                    <Button
                        className="button button-large meom-media-button"
                        onClick={() => onChange(null)}
                    >
                        {__('Poista kuva', 'meom-gutenberg')}
                    </Button>
                </>
            )}
        </>
    );
};

export default ImageSelect;
