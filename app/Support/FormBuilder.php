<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FormBuilder
{
    protected $model;

    public function open(array $options = [])
    {
        $method = strtoupper($options['method'] ?? 'POST');
        $url = $options['url'] ?? '';
        $attributes = [];

        if (! empty($options['class'])) {
            $attributes['class'] = $options['class'];
        }

        if (! empty($options['files'])) {
            $attributes['enctype'] = 'multipart/form-data';
        }

        $attributes['method'] = $method === 'GET' ? 'GET' : 'POST';
        $attributes['action'] = $url;

        $html = '<form';
        foreach ($attributes as $key => $value) {
            $html .= ' ' . $key . '="' . e($value) . '"';
        }
        $html .= '>';

        if ($method !== 'GET' && $method !== 'POST') {
            $html .= method_field($method);
        }

        if ($method === 'POST') {
            $html .= csrf_field();
        }

        return $html;
    }

    public function close()
    {
        return '</form>';
    }

    public function label($name, $value = null, array $options = [])
    {
        $attributes = $this->attributes($options);
        return '<label for="' . e($name) . '"' . $attributes . '>' . e($value ?? $name) . '</label>';
    }

    public function text($name, $value = null, array $options = [])
    {
        return $this->input('text', $name, $value, $options);
    }

    public function number($name, $value = null, array $options = [])
    {
        return $this->input('number', $name, $value, $options);
    }

    public function password($name, $value = null, array $options = [])
    {
        return $this->input('password', $name, $value, $options);
    }

    public function file($name, $value = null, array $options = [])
    {
        return $this->input('file', $name, $value, $options);
    }

    public function select($name, $list = [], $selected = null, array $options = [])
    {
        $attributes = $this->attributes($options, ['name' => $name]);
        $html = '<select' . $attributes . '>';
        foreach ($list as $value => $label) {
            $selectedAttr = ((string) $value === (string) $selected) ? ' selected' : '';
            $html .= '<option value="' . e($value) . '"' . $selectedAttr . '>' . e($label) . '</option>';
        }
        $html .= '</select>';

        return $html;
    }

    public function radio($name, $value, $checked = false, array $options = [])
    {
        $attributes = $this->attributes($options, ['name' => $name, 'type' => 'radio', 'value' => $value]);
        if ($checked) {
            $attributes .= ' checked';
        }

        return '<input' . $attributes . '>';
    }

    public function checkbox($name, $value = 1, $checked = false, array $options = [])
    {
        $attributes = $this->attributes($options, ['name' => $name, 'type' => 'checkbox', 'value' => $value]);
        if ($checked) {
            $attributes .= ' checked';
        }

        return '<input' . $attributes . '>';
    }

    public function submit($value = null, array $options = [])
    {
        $attributes = $this->attributes($options, ['type' => 'submit', 'value' => $value]);
        return '<input' . $attributes . '>';
    }

    protected function input($type, $name, $value = null, array $options = [])
    {
        $attributes = $this->attributes($options, ['name' => $name, 'type' => $type, 'value' => $value]);
        return '<input' . $attributes . '>';
    }

    protected function attributes(array $options = [], array $defaults = [])
    {
        $attributes = array_merge($defaults, $options);
        $html = '';

        foreach ($attributes as $key => $value) {
            if (is_int($key)) {
                $html .= ' ' . e($value);
                continue;
            }

            if ($value === true) {
                $html .= ' ' . $key . '="' . $key . '"';
                continue;
            }

            if ($value !== null && $value !== false) {
                $html .= ' ' . $key . '="' . e($value) . '"';
            }
        }

        return $html;
    }
}
