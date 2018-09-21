## creating a message

```php
<?php

use DZMC\Mandrill as SDK;

// get the message dispatcher
$dispatcher = (new SDK\DispatcherFactory('your_api_key'))->createMessageDispatcher();

// create a basic message
$message = new SDK\Message\Message();
$message->setFrom('from@example.com');
$message->setText('An email body');
$message->setSubject('A subject for your email');

// add a recipient
$message->addTo('example@example.com', 'Example Recipient');
```

_**Note:**_ `Message::addTo()`, `Message::addCc()`, and `Message::addBcc()` all return an instance of [RecipientBuilderInterface](../src/Mandrill/Message/RecipientBuilderInterface.php)
