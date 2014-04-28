<?php

return array(
    'message' => array(
        'listeners' => array(
            array(
                'id'     => 'Contact\Service\Command',
                'event'  => 'persist.post',
                'type'   => 'mail', // change to adapter with adapter options
                'filter' => 'Contact\Service\Filter\Message'
            ),
        ),
    ),
);
