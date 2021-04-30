<?php

namespace Sparkinzy\Dcat\Distpicker;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;

class DcatDistpickerServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/distpicker.js',
    ];
	protected $css = [
	];

	public function init()
	{
		parent::init();
		Admin::requireAssets('@sparkinzy.distpicker');
		Form::extend('distpicker', Distpicker::class);

	}




}
