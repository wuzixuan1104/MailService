<?php

$config['ebs'] = [
    'topic' => 'Tripresso EBS',
    'acer' => [
        'hotel' => [
            'subject' => 'Acer 飯店',
            'order' => [
                'create'  => [
                    'title'  => '訂單成立',
                    'view'   => 'edm/hotel/order/confirm/V1',
                ],
                'confirm' => [
                    'title'  => '訂單確認',
                    'view'   => 'edm/hotel/order/confirm/V1',
                ],
            ],
            'apply'   => [
                'confirm' => [
                    'title'  => '團員申請確認',
                    'view'   => 'edm/hotel/apply/confirm/Member_v1',
                ],
                'review' => [
                    'title' => '審核測試',
                    'view'  =>  'edm/hotel/order/confirm/V1',
                ]
            ]
        ] 
    ]
];

$config['cts'] = [
    'topic' => 'Tripresso CTS',
    'hotel' => [
        'subject' => '差旅',
        'confirm' => [
            'title'  => '飯店訂單確認',
            'view'   => 'edm/hotel/order/confirm/V1',
        ],
    ] 
];