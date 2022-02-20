# PostType

To learn more about the arguments, please see the Worpdress documentation: [Doc](https://codex.wordpress.org/Function_Reference/register_post_type).

```php
add_action('init', function() {
    PostType::make('custom_post_type', "Custom", "Customs")
        ->addLabels([
            'all_items' => '...',
            'add_new' => '...',
            ...
        ])
        ->addArguments([
            'post_status' => 'private',
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            ...
        ])
        ->register();
});
```