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
        
        // dashboard
        [
            'path' => '/banner',
            'name' => 'Banner',
            'component' => 'Banner',
            'meta' => ['title' => 'Banner', 'keepAlive' => true, 'icon' => 'file-image'],
            'children' => [],
        ],

        // account
        [
            'path' => '/account',
            'component' => 'RouteView',
            'redirect' => '/account/settings',
            'name' => 'Account',
            'meta' => ['title' => 'Account', 'icon' => 'user', 'keepAlive' => true],
            'children' => [
                [
                    'path' => '/account/settings',
                    'name' => 'AccountSettings',
                    'component' => 'AccountSettings',
                    'meta' => ['title' => 'AccountSettings', 'hideHeader' => true, 'hideChildren' => true],
                    'redirect' => '/account/settings/basic',
                    'children' => [
                        [
                            'path' => '/account/settings/basic',
                            'name' => 'BasicSetting',
                            'component' => 'BasicSetting',
                            'meta' => ['title' => 'BaseSetting', 'hidden' => true],
                        ],
                        [
                            'path' => '/account/settings/security',
                            'name' => 'SecuritySettings',
                            'component' => 'SecuritySettings',
                            'meta' => ['title' => 'SecuritySetting', 'hidden' => true, 'keepAlive' => true],
                        ],
                        [
                            'path' => '/account/settings/notification',
                            'name' => 'NotificationSettings',
                            'component' => 'NotificationSettings',
                            'meta' => ['title' => 'Notification', 'hidden' => true, 'keepAlive' => true],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
