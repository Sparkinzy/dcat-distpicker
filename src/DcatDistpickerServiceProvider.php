<?php

namespace Sparkinzy\Dcat\Distpicker;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;

class DcatDistpickerServiceProvider extends ServiceProvider
{
    protected $js = [
        'js/distpicker.js',
    ];

    public function init()
    {
        parent::init();
        Admin::requireAssets('@select2');
        Admin::requireAssets('@sparkinzy.dcat-distpicker');

        Form::extend('distpicker', Distpicker::class);
        Filter::extend('distpicker', DistpickerFilter::class);

    }




}
