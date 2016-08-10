<?php
use kartik\datecontrol\Module;

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
	        'defaultTimeZone' => 'Europe/Prague',
	        'timeZone' => 'Europe/Prague'
        ]
    ],
	'modules' => [
		'datecontrol' => [
			'class' => 'kartik\datecontrol\Module',
			'displaySettings' => [
				Module::FORMAT_DATE => 'php:d.m.Y',
				Module::FORMAT_TIME => 'php:H:i',
				Module::FORMAT_DATETIME => 'php:d.m.Y H:i:s'
			],
			'saveSettings' => [
				Module::FORMAT_DATE => 'php:Y-m-d',
				Module::FORMAT_TIME => 'php:H:i',
				Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s'
			],
			'autoWidget' => false,
			'widgetSettings' => [
				Module::FORMAT_DATE => [
					'class' => 'yii\jui\DatePicker',
					'options' => [
						'dateFormat' => 'php:d.m.Y',
						'options' => [
							'class' => 'form-control',
							'style' => 'position: relative; z-index: 1'
						],
					]
				]
			]
		]
	]
];
