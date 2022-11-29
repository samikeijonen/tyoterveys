# FeaturedImage

Because featured image is fetched via AJAX, block/react doesn't know easily when the image data is returned.

https://reactjs.org/docs/render-props.html

## Usage
```
<FeaturedImage>
	{(featuredImage) => {
		if (!featuredImage) return null;

		return <img src={featuredImage.source_url} />;
	}}
</FeaturedImage>
```

or 

```
<FeaturedImage /> // will render <img src="..." />
```
