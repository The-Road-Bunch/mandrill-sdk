## creating a message

```php
<?php

use DZMC\Mandrill as SDK;

// get the message dispatcher
$dispatcher = (new SDK\DispatcherFactory('your_api_key'))->createMessageDispatcher();

// create a basic message
$message = new SDK\Message\Message();
$message->setFrom('test@example.com');
$message->setText('An email body');

// add a recipient
$message->addTo('dan@homeceu.com');
```

_Note:_ `Message::addTo()`, `Message::addCc()`, and `Message::addBcc()` all return an instance of [RecipientBuilderInterface](src/Mandrill/Message/RecipientBuilderInterface.php)
