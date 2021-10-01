<?php

return [
    'path' => '/',
    'name' => 'index',
    'component' => 'BasicLayout',
    'meta' => ['title' => 'menu.home'],
    'redirect' => '/account/settings',
    'children' => [
        // dashboard
        [
            'path' => '/dashboard',
            'name' => 'Dashboard',
            'redirect' => '/dashboard/workplace',
            'component' => 'RouteView',
            'meta' => ['title' => 'Dashboard', 'keepAlive' => true, 'icon' => 'dashboard'],
            'children' => [
                [
                    'path' => '/dashboard/analysis/:pageNo([1-9]\\d*)?',
                    'name' => 'Analysis',
                    'component' => 'Analysis',
                    'meta' => ['title' => 'Analysis', 'keepAlive' => false],
                ],
                [
                    'path' => '/dashboard/workplace',
                    'name' => 'Workplace',
                    'component' => 'Workplace',
                    'meta' => ['title' => 'Workplace', 'keepAlive' => true],
                ],
            ],
        ],
        
        // banner
        [
            'path' => '/banner',
            'name' => 'Banner',
            'component' => 'Banner',
            'meta' => ['title' => 'Banner', 'keepAlive' => true, 'icon' => 'picture'],
            'children' => [],
        ],
        
        // list
        [
            'path' => '/list',
            'name' => 'List',
            'redirect' => '/list/info-list',
            'component' => 'RouteView',
            'meta' => ['title' => 'List', 'keepAlive' => true, 'icon' => 'table'],
            'children' => [
                [
                    'path' => '/list/info-list',
                    'name' => 'InfoList',
                    'component' => 'InfoList',
                    'meta' => ['title' => 'Info List', 'keepAlive' => false],
                ],
                [
                    'path' => '/list/info-list/edit/:id([1-9]\\d*)?',
                    'name' => 'ListEdit',
                    'component' => 'ListEdit',
                    'meta' => ['title' => 'List Edit', 'keepAlive' => false, 'hidden' => true],
                ]
            ],
        ],

        // account
        [
            'path' => '/settings',
            'component' => 'RouteView',
            'redirect' => '/account/settings',
            'name' => 'Settings',
            'meta' => ['title' => 'Settings', 'icon' => 'setting', 'keepAlive' => true],
            'children' => [
                [
                    'path' => '/settings/account',
                    'name' => 'AccountSettings',
                    'component' => 'AccountSettings',
                    'meta' => ['title' => 'AccountSettings', 'hideHeader' => true, 'hideChildren' => true],
                    'redirect' => '/settings/account/basic',
                    'children' => [
                        [
                            'path' => '/settings/account/basic',
                            'name' => 'BasicSetting',
                            'component' => 'BasicSetting',
                            'meta' => ['title' => 'BaseSetting', 'hidden' => true],
                        ],
                        [
                            'path' => '/settings/account/notification',
                            'name' => 'NotificationSettings',
                            'component' => 'NotificationSettings',
                            'meta' => ['title' => 'Notification', 'hidden' => true, 'keepAlive' => true],
                        ],
                    ],
                ],
                [
                    'path' => '/settings/web',
                    'name' => 'WebSettings',
                    'component' => 'WebSettings',
                    'meta' => ['title' => 'WebSettings', 'hideHeader' => true, 'hideChildren' => true],
                    'redirect' => '/settings/web/basic',
                    'children' => [
                        [
                            'path' => '/settings/web/basic',
                            'name' => 'WebBasicSetting',
                            'component' => 'WebBasicSetting',
                            'meta' => ['title' => 'WebBasicSetting', 'hidden' => true],
                        ],
                        [
                            'path' => '/settings/web/contact',
                            'name' => 'WebContactSetting',
                            'component' => 'WebContactSetting',
                            'meta' => ['title' => 'WebContactSetting', 'hidden' => true],
                        ],
                        [
                            'path' => '/settings/web/section',
                            'name' => 'WebSectionSetting',
                            'component' => 'WebSectionSetting',
                            'meta' => ['title' => 'WebSectionSetting', 'hidden' => true],
                        ],
                        [
                            'path' => '/settings/web/other',
                            'name' => 'WebOtherSetting',
                            'component' => 'WebOtherSetting',
                            'meta' => ['title' => 'WebOtherSetting', 'hidden' => true],
                        ]
                    ],
                ],
            ],
        ],
    ],
];
