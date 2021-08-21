<?php


namespace YeeJiaWei\FormGenerator;


use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class FormGenerator
{
    private $layout = 'layouts.app';
    private $fields;
    private $form_name = 'Create Form';

    private $routeName;
    private $updateRouteObj = null;


    private $fieldNames;

    public function __construct($item = null)
    {
        $this->fields = collect();
        $this->fieldNames = collect();

        return $this;
    }

    public static function create($item = null)
    {
        return new self($item);
    }

    public function setFormName(string $formName): FormGenerator
    {
        $this->form_name = $formName;

        return $this;
    }

    public function setLayout(string $layout): FormGenerator
    {
        $this->layout = $layout;

        return $this;
    }

    public function addInputField(
        string $fieldName, bool $isRow = false, string $value = null, string $inputType = 'text',
        string $label = null
    ): FormGenerator
    {
        $this->fields = $this->fields->push(
            $this->buildInputField($fieldName, $isRow, $value, $inputType, $label)
        );

        return $this;
    }

    public function addTextareaField(
        string $fieldName, bool $isRow = false, string $value = null, int $rowNumber = 2, string $label = null
    ): FormGenerator
    {
        $this->fields = $this->fields->push(
            $this->buildTextareaField($fieldName, $isRow, $value, $rowNumber, $label)
        );

        return $this;
    }

    public function addRow(FormGenerator $formGenerator): FormGenerator
    {
        if ($formGenerator->fields->count() < 2) {
            throw new \Exception("Use normal function instead of 'addRow' when ony 1 field");
        }

        $row = collect();

        foreach ($formGenerator->fields as $field) {
            switch ($field['type']) {
                case 'input':
                    $row = $row->push(
                        $this->buildInputField(
                            $field['name'], $field['is_row'], $field['value'], $field['input_type'], $field['label']
                        )
                    );
                    break;
                case 'textarea':
                    throw new \Exception("Textarea in row is temporary not supported");
//                    $row = $row->push(
//                        $this->buildTextareaField(
//                            $field['name'], $field['is_row'], $field['value'], $field['rows'], $field['label']
//                        )
//                    );
                    break;
            }
        }

        $this->fields = $this->fields->push([
            'row' => $row
        ]);

        return $this;
    }

    public function setCreateRouteName(string $routeName): FormGenerator
    {
        $this->checkRouteIsSet();

        $this->routeName = $routeName;
        return $this;
    }

    public function setUpdateRouteName(string $routeName, $object): FormGenerator
    {
        $this->checkRouteIsSet();

        $this->routeName = $routeName;
        $this->updateRouteObj = $object;
        return $this;
    }

    public function render()
    {
        if (!$this->routeName) {
            throw new \Exception('The route name of create or update must be set');
        }

        $this->layout = View::make($this->layout);
        $this->layout->header = $this->form_name;

        $this->layout->slot = View::make('form-generator::form')
            ->with('fields', $this->fields)
            ->with('route_name', $this->routeName)
            ->with('update_route_obj', $this->updateRouteObj);

        return $this->layout;
    }

    private function buildInputField(
        string $fieldName, bool $isRow = false, string $value = null, string $inputType = 'text',
        string $label = null
    )
    {
        $this->checkFieldName($fieldName);

        if (!collect(['text', 'number', 'date'])->contains($inputType)) {
            throw new \Exception("Field type can only be 'input' and 'textarea");
        }

        $this->fieldNames = $this->fieldNames->push($fieldName);

        return [
            'type' => 'input',
            'input_type' => $inputType,
            'label' => $label ? $label : Str::of($fieldName)->replace('_', ' ')->ucfirst(),
            'name' => $fieldName,
            'is_row' => $isRow,
            'value' => $value
        ];
    }

    private function buildTextareaField(
        string $fieldName, bool $isRow = false,
        string $value = null, int $rowNumber = 2, string $label = null)
    {
        $this->checkFieldName($fieldName);

        $this->fieldNames = $this->fieldNames->push($fieldName);

        return [
            'type' => 'textarea',
            'rows' => $rowNumber,
            'label' => $label ? $label : Str::of($fieldName)->replace('_', ' ')->ucfirst(),
            'name' => $fieldName,
            'is_row' => $isRow,
            'value' => $value
        ];
    }

    private function checkFieldName(string $fieldName): void
    {
        $filtered = $this->fieldNames->search(function ($value, $key) use ($fieldName) {
            return $value == $fieldName;
        });

        if ($filtered) {
            throw new \Exception("Field name '{$fieldName}' cannot defined more than once");
        }
    }

    private function checkRouteIsSet()
    {
        if ($this->routeName) {
            throw new \Exception("Action name can only set once");
        }
    }
}

