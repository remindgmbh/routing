# REMIND - Routing Extension

This extension provides additional Route Enhancers and Aspects.

## ExtbaseQuery Route Enhancer

ExtbaseQuery Route Enhancer replaces extbase plugin query parameters with custom names and omits action and controller parameters.

### limitToPages
Optional, Route Enhancer only matches if correct CType exists on page.

### defaults
Behave the same as described [here](https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/Routing/AdvancedRoutingConfiguration.html#enhancers).

### namespace, extension, plugin, \_controller
Behave the same as described [here](https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/Routing/AdvancedRoutingConfiguration.html#extbase-plugin-enhancer).

### parameters
Parameters are divided into keys and values. In both, use the original parameter name as the key and the aspect name as the value. In keys it is possible to simply use a new parameter name as value instead of an aspect.

### aspects
Aspects used for keys and values defined in parameters. Aspects for parameter keys must implement `ModifiableAspectInterface` while aspects for parameter values must implement `MappableAspectInterface`.

### types
Limit the route enhancer to certain page types, for example to enhance solr search result routes but not autocomplete routes. Defaults to `[0]`.

### example for News Extension

```yaml
  News:
    limitToPages: [20]
    type: ExtbaseQuery
    extension: News
    plugin: Pi1
    _controller: 'News::list'
    defaults:
      page: '1'
    parameters:
      values:
        currentPage: pageValueAspect
        overwriteDemand/categories: categoryValueAspect
      keys:
        currentPage: page
        overwriteDemand/categories: categoryKeyAspect
    aspects:
      pageValueAspect:
        type: StaticRangeMapper
        start: '1'
        end: '5'
      categoryValueAspect:
        type: PersistedAliasMapper
        tableName: sys_category
        routeFieldName: slug
      categoryKeyAspect:
        type: LocaleModifier
        default: category
        localeMap:
          -
            locale: 'de_DE.*'
            value: kategorie

```

With these settings, the query parameters will look like this:

English: `?page=...&category=...`

German: `?page=...&kategorie=...`