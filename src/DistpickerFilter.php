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
     * distpicker element id
     * @var string
     */
    protected $distpickerId = '';
    protected $selectIds    = [];

    /**
     * @var array
     */
    protected $defaultValue = [];


    public function __construct($column, $arguments = [])
    {

        if (!Arr::isAssoc($column)) {
            $this->column = implode('-', $column);
            $this->names  = array_combine($this->columnKeys, $column);
        } else {
            $this->column      = implode('-', array_keys($column));
            $this->names       = array_combine($this->columnKeys, array_keys($column));
            $this->placeholder = array_combine($this->placeholder, $column);
        }
        $this->label = empty($arguments) ? "地区选择" : current($arguments);

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
            'selectIds'    => $this->selectIds,
            'distpickerId' => $this->distpickerId,
            'name'         => $this->formatName($this->names),
            'label'        => $this->label,
            'value'        => $this->value ?: $this->defaultValue,
            'presenter'    => $this->presenter(),
            'width'        => $this->width,
        ], $this->presenter()->variables());
    }

    public function render()
    {
        return view('sparkinzy.dcat-distpicker::select-filter', $this->variables());
    }

}
