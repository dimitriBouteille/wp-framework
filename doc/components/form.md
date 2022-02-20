# Form

Here is an example to add a form on the front

```php
use \Symfony\Component\HttpFoundation\Request;
use \Dbout\Wp\Framework\Form\AbstractForm;
use Symfony\Component\HttpFoundation\Response;

class ContactForm extends AbstractForm {

    protected string $action = 'contact_us';
    protected string $nonceName = 'contact_us_form_nonce';

    protected function execute(Request $request): Response
    {
        // Do someting ...
        // And return Response instance
    }
}
```