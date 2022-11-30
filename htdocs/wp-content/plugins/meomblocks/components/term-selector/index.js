/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { useDispatch, useSelect } = wp.data;
const { SelectControl, Spinner } = wp.components;

/**
 * Term picker from wanted taxonomy.
 *
 * @param {Object} props Props for component.
 */
function TermSelector(props) {
    const {
        attributes: { termId },
        setAttributes,
    } = props;
    const options = [];

    // Set correct taxonomy.
    const taxonomy = props.taxonomyName;

    const [terms, isLoading, invalidateRequest] = useRequestData(
        'taxonomy',
        taxonomy
    );

    options.push({
        value: 0,
        label: __('Kaikista kategorioista', 'meomblocks'),
    });

    if (!isLoading && terms && terms.length > 0) {
        terms.forEach((term) => {
            options.push({
                value: term.id,
                label: term.name,
            });
        });
    }

    return (
        <>
            {isLoading && <Spinner />}

            {!isLoading && (
                <>
                    <SelectControl
                        label={__('Valitse kategoria', 'meomblocks')}
                        options={options}
                        onChange={(newTermId) => {
                            setAttributes({ termId: newTermId });
                        }}
                        value={termId}
                    />

                    <button
                        className="button"
                        type="button"
                        onClick={invalidateRequest}
                    >
                        {__('Päivitä kategorialista', 'meomblocks')}
                    </button>
                </>
            )}
        </>
    );
}

/**
 * Hook for retrieving data from the WordPress REST API.
 * See: https://github.com/10up/block-components/blob/develop/hooks/use-request-data.js
 *
 * @param {string}          entity  The entity to retrieve. ie. postType
 * @param {string}          kind    The entity kind to retrieve. ie. posts
 * @param {Object | number} [query] Optional. Query to pass to the geEntityRecords request. Defaults to an empty object. If a number is passed, it is used as the ID of the entity to retrieve via getEntityRecord.
 * @return {Array} The data returned from the request.
 */
function useRequestData(entity, kind, query = {}) {
    const { invalidateResolution } = useDispatch('core/data');
    const { data, isLoading } = useSelect((select) => {
        return {
            data: select('core').getEntityRecords(entity, kind, query),
            isLoading: select('core/data').isResolving(
                'core',
                'getEntityRecords',
                [entity, kind, query]
            ),
        };
    });

    const invalidateResolver = () => {
        invalidateResolution('core', 'getEntityRecords', [entity, kind, query]);
    };

    return [data, isLoading, invalidateResolver];
}

export default TermSelector;
