const { withSelect } = wp.data;

const FeaturedImageRenderProps = ({ children, featuredImage }) => {
    if (!featuredImage) return <></>;

    if (!children) {
        return <img src={featuredImage.source_url} alt="" />;
    }

    return <>{children(featuredImage)}</>;
};

const FeaturedImage = withSelect(function (select) {
    const featuredImageId =
        select('core/editor').getEditedPostAttribute('featured_media');

    return {
        featuredImage: select('core').getMedia(featuredImageId),
    };
})(FeaturedImageRenderProps);

export default FeaturedImage;
