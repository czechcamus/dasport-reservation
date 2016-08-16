<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main backend application asset bundle.
 */
class AngularJSAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
    	'http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js',
    ];
	public $jsOptions = [
		'position' => View::POS_HEAD,
	];
	public $depends = [
        'backend\assets\AppAsset',
    ];
}
