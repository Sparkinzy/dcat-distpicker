<?php

namespace Sparkinzy\Dcat\Distpicker;

use Dcat\Admin\Form\Field;
use Illuminate\Support\Arr;


class Distpicker extends Field
{

    protected $view = 'sparkinzy.dcat-distpicker::select';
    /**
     * @var array
     */
    protected $columnKeys = ['province', 'city', 'district'];

    /**
     * @var array
     */
    protected $placeholder = ['选择省', '选择市', '选择区'];

    public function __construct($column, $arguments = [])
    {
        parent::__construct($column, $arguments);
        if (!Arr::isAssoc($column)) {

            $this->column = array_combine($this->columnKeys, $column);
        } else {
            $this->column      = array_combine($this->columnKeys, array_keys($column));
            $this->placeholder = array_combine($this->placeholder, $column);
        }
        $this->label = empty($arguments) ? "地区选择" : current($arguments);
    }

    public function getValidator(array $input)
    {
        if ($this->validator) {
            return $this->validator->call($this, $input);
        }

        $rules = $attributes = [];

        if (!$fieldRules = $this->getRules()) {
            return false;
        }

        foreach ($this->column as $key => $column) {
            if (!Arr::has($input, $column)) {
                continue;
            }
            $input[$column]      = Arr::get($input, $column);
            $rules[$column]      = $fieldRules;
            $attributes[$column] = $this->label . "[$column]";
        }
        return \validator($input, $rules, $this->getValidationMessages(), $attributes);
    }

    /**
     * @param int $count
     * @return Distpicker
     */
    public function autoselect($count = 0)
    {
        return $this->attribute('data-autoselect', $count);
    }

    public function default($default = null, bool $edit = false)
    {
        if (!$default){
            return parent::default($default, $edit);
        }
        $default = Arr::only($default, ['province','city','district']);
        foreach ($default as $key => $value)
        {
            $this->attribute('data-'.$key,$value);
        }
        return parent::default($default, $edit);
    }

    /**
     * @deprecated
     * 设置默认省
     * @param $province
     * @return Distpicker
     */
    public function province($province)
    {
        return $this->attribute('data-province',$province);
    }

    /**
     * @deprecated
     * 设置默认城市
     * @param $city
     * @return Distpicker
     */
    public function city($city)
    {
        return $this->attribute('data-city',$city);
    }

    /**
     * @deprecated
     * 设置默认区域
     * @param $district
     * @return Distpicker
     */
    public function district($district)
    {
        return $this->attribute('data-district',$district);
    }

    /**
     * 默认开启select2模式，主要目的是优化展示
     * @param bool $enable
     * @return Distpicker
     */
    public function select2($enable=true)
    {
        return $this->addVariables(['enable_select2'=>true]);
    }

    /**
     * 设置返回值是name,还是code
     * @param string $valueType
     * @return $this
     */
    public function type($valueType='name')
    {
        if (!in_array($valueType, ['name','code']))return $this;
        return $this->attribute('data-value-type',$valueType);
    }

    public function render()
    {
        if (!array_key_exists('enable_select2', $this->variables())){
            $this->addVariables(['enable_select2'=>false]);
        }
        $this->attribute('data-toggle','distpicker');
        $id = uniqid('distpicker-');
        $this->addVariables(compact('id'));
        return parent::render();
    }


}
