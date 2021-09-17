<?php


namespace Sparkinzy\Dcat\Distpicker;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Filter\AbstractFilter;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Dcat\Admin\Grid\Filter;

class DistpickerFilter extends AbstractFilter
{
    protected $view = 'sparkinzy.dcat-distpicker::select-filter';
    /**
     * @var array
     */
    protected $columnKeys = ['province', 'city', 'district'];

    /**
     * @var array
     */
    protected $placeholder = ['选择省', '选择市', '选择区'];
    /**
     * @var array
     */
    protected $names = [];

    /**
     * @var array
     */
    protected $value = [];

    /**
     * @var array
     */
    protected $defaultValue = [];


    public function __construct($column, $arguments = [])
    {
//        $this->column = implode('-', array_keys($column));
        $this->column = 'distpicker-filter';

        if (!Arr::isAssoc($column)) {

            $this->names = array_combine($this->columnKeys, $column);
        } else {
            $this->names       = array_combine($this->columnKeys, array_keys($column));
            $this->placeholder = array_combine($this->placeholder, $column);
        }
        $this->label = empty($arguments) ? "地区选择" : current($arguments);

//        $this->setPresenter(new FilterPresenter());
    }

    public function setParent(Filter $filter)
    {
        $this->parent = $filter;

        $this->id = $this->formatId($this->column);
    }


    public function getColumn()
    {
        $columns = [];

        $parentName = $this->parent->getName();

        foreach ($this->column as $column) {
            $columns[] = $parentName ? "{$parentName}_{$column}" : $column;
        }

        return $columns;
    }


    public function condition($inputs)
    {
        $value = array_filter([
            $this->names['province'] => Arr::get($inputs, $this->names['province']),
            $this->names['city']     => Arr::get($inputs, $this->names['city']),
            $this->names['district'] => Arr::get($inputs, $this->names['district']),
        ]);
        if (!isset($value)) {
            return;
        }

        $this->value = $value;

        if (!$this->value) {
            return [];
        }


        if (Str::contains(key($value), '.')) {
            return $this->buildRelationQuery($value);
        }
        return [$this->query => [$value]];
    }


    public function formatName($column)
    {
        $columns = [];

        foreach ($column as $col => $name) {
            $columns[$col] = parent::formatName($name);
        }

        return $columns;
    }

    /**
     * Setup js scripts.
     */
    protected function setupScript()
    {
        $province = Arr::get($this->value, $this->names['province']);
        $city     = Arr::get($this->value, $this->names['city']);
        $district = Arr::get($this->value, $this->names['district']);

        if (request()->pjax()){
            $script = <<<JS
    $("#{$this->id}").distpicker({
      province: '$province',
      city: '$city',
      district: '$district'
    });
JS;
        }else{
            // 兼容页面直接刷新
            $script = <<<JS
Dcat.ready(function(){
        $("#{$this->id}").distpicker({
      province: '$province',
      city: '$city',
      district: '$district'
    });
});
JS;
        }

        Admin::script($script);
    }

    /**
     * {@inheritdoc}
     */
    public function variables()
    {
        $this->id = uniqid('distpicker-filter-');

        $this->setupScript();

        return array_merge([
            'id'        => $this->id,
            'name'      => $this->formatName($this->names),
            'label'     => $this->label,
            'value'     => $this->value ?: $this->defaultValue,
            'presenter' => $this->presenter(),
            'width'     => $this->width,
        ], $this->presenter()->variables());
    }

    public function render()
    {
        return view('sparkinzy.dcat-distpicker::select-filter', $this->variables());
    }
}
