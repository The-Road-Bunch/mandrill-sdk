# theroadbunch/mandrill-sdk [![build status](https://scrutinizer-ci.com/g/The-Road-Bunch/mandrill-sdk/badges/build.png?b=master)](https://scrutinizer-ci.com/g/theroadbunch/mandrill-sdk/)
_An OOP library for interfacing with Mandrill's API_

[![Latest Stable Version](https://img.shields.io/packagist/v/theroadbunch/mandrill-sdk.svg)](https://packagist.org/packages/theroadbunch/domain-validator)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

### Contents
1. [Release Notes](doc/release.md)
2. [Installation](#installation)  
    a. [Bundles](#bundle-installation)
3. [Basic Usage](#basic-usage)  
    a. [Creating and Sending a Basic Email](#basic-email)  
4. [License](LICENSE)

### <a name="installation">Install using composer</a> <sup><small>[[?]](https://getcomposer.org)</a></small></sup>

`composer require theroadbunch/mandrill-sdk`

### <a name="basic-usage">Basic Usage</a>

#### <a name="basic-email">Creating and Sending an Email</a>
```php
<?php

// optional alias for cleanliness/readability
use RoadBunch\Mandrill as SDK;

// create a dispatcher factory
$factory = new SDK\DispatcherFactory('your_mandrill_api_key');

// create the dispatcher for the type of API call you'd like to make
$dispatcher = $factory->createMessageDispatcher();

// create an email message
$message = new SDK\Message\Message();

// build the email
$message->setSubject('An email subject');
$message->setText('The text body of the email');
$message->setHtml('The HTML email body');

// set recipients
$message->addTo('recipient@example.com', 'Recipient Name');
$message->addCc('cc_recipient@example.com', 'CC Recipient Name');

// set senders
$message->setFrom('from@example.com', 'Admin');
$message->setReplyTo('replyto@example.com');

/** @var SDK\Message\SendResponse[] $response */
$response = $dispatcher->send($message);

```

example response array
```
array:2 [
  0 => RoadBunch\Mandrill\Message\SendResponse {#22
    +id: "118a7d900f5c48ec9a91cf55c63a7d97"
    +email: "recipient@example.com"
    +status: "sent"
    +rejectReason: null
  }
  1 => RoadBunch\Mandrill\Message\SendResponse {#23
    +id: "e19fb3f794ab4b99bd2a6a8ce4396a3f"
    +email: "cc_recipient@example.com"
    +status: "sent"
    +rejectReason: null
  }
]
````

&copy; 2018 Dan McAdams
