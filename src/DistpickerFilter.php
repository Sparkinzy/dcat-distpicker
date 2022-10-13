<?php


namespace Sparkinzy\Dcat\Distpicker;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Filter\AbstractFilter;
use Dcat\Admin\Traits\HasHtmlAttributes;
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

    public $attributes = [];
    /**
     * distpicker element id
     * @var string
     */
    protected $distpickerId = '';

    protected $selectIds    = [];

    /**
     * level 1 表示省
     * level 2 表示省市
     * level 3 表示省市区
     * @var int
     */
    protected $level = 3;
    /**
     * @var array
     */
    protected $defaultValue = [];

    /**
     * DistpickerFilter constructor.
     * @param array $column
     * @param string $arguments
     */
    public function __construct(array $column=[], string $arguments = '')
    {

        if (!Arr::isAssoc($column)) {
            $this->column = implode('-', $column);
            $this->names  = array_combine($this->columnKeys, $column);
        } else {
            $this->column      = implode('-', array_keys($column));
            $this->names       = array_combine($this->columnKeys, array_keys($column));
            $this->placeholder = array_combine($this->placeholder, $column);
        }
        $this->label = empty($arguments) ? "地区选择" : $arguments;

    }

    /**
     * !!! most important
     *
     * @return false|string|string[]
     */
    public function getElementName()
    {
        return explode('-', $this->column);
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
        $script = <<<JS
    $("#{$this->distpickerId}").distpicker();
JS;
        Admin::script($script);
    }

    /**
     * 展示的级别
     * @param int $level
     */
    public function level(int $level = 1)
    {
        $this->level = ($level>3 || $level<1) ? 1 :$level;
        return $this;
    }
    /**
     * 设置返回值是name,还是code
     * @param string $valueType
     * @return $this
     */
    public function type($valueType='name')
    {

        if (!in_array($valueType, ['name','code']))return $this;
        $this->attribute('data_value_type',$valueType);
        return  $this;
    }

    protected function attribute($name,$value)
    {
        $this->attributes[$name]=$value;
        return $this;
    }

    protected function attributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function variables()
    {
        $this->selectIds    = $this->formatId($this->names);
        $this->distpickerId = uniqid('distpicker-filter-');
        $this->setupScript();


        return array_merge([
            'id'           => $this->id,
            'column'       => $this->column,
            'level'        => $this->level,
            'selectIds'    => $this->selectIds,
            'distpickerId' => $this->distpickerId,
            'name'         => $this->formatName($this->names),
            'label'        => $this->label,
            'value'        => $this->value ?: $this->defaultValue,
            'presenter'    => $this->presenter(),
            'width'        => $this->width,
            'data_value_type'=> 'name',
        ], $this->presenter()->variables(),$this->attributes());
    }

    public function render()
    {
        return view('sparkinzy.dcat-distpicker::select-filter', $this->variables());
    }

}
