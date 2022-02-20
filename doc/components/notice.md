# Notice

Example to display messages in the admin.

```php
add_action('admin_init', function() {
    $noticeByTypes = ...;
    foreach($noticeByTypes as $type => $notices) {
        foreach ($notices as $notice) {
            switch ($type) {
                case 'success':
                    (new NoticeManager())->success($notice);
                    break;
                case 'error':
                    (new NoticeManager())->error($notice);
                    break;
                default:
                    (new NoticeManager())->info($notice);
            }
        }
    }
});
```