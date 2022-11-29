# Image Select

## How to use

import

```
import ImageSelect from "../../components/image-select";
```

Set attribute. Attribute will contain object like this: { id: 1, url: 'http//...' }

```
attributes: {
    image: {
      type: "object"
    },
  },
```

Use

```
<ImageSelect
	image={props.attributes.image}
	onChange={(image) => setAttributes({ image })}
/>

```
