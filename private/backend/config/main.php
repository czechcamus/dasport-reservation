<?php
use backend\modules\reservation\Module;
use common\models\UserRecord;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
	'language' => 'cs',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
    	'reservation' => [
    		'class' => Module::className()
	    ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => UserRecord::className(),
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n' => [
	        'translations' => [
		        'back*' => [
			        'class' => 'yii\i18n\PhpMessageSource',
			        'basePath' => '@backend/messages',
			        'fileMap' => [
				        'back' => 'back.php',
				        'back/error' => 'error.php',
			        ],
		        ],
		        'app*' => [
			        'class' => 'yii\i18n\PhpMessageSource',
			        'basePath' => '@common/messages',
			        'fileMap' => [
				        'app' => 'app.php',
				        'app/error' => 'error.php',
			        ],
		        ],
	        ],
        ],
	    /*
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
			],
		],
		*/
    ],
    'params' => $params,
];
