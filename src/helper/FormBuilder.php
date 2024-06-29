<?php
namespace App\Helper;

class FormBuilder
{
    private $method;

    private $action;

    public function __construct(string $method, string $action)
    {
        $this->method = $method;
        $this->action = $action;
    }

    public function openForm()
    {
        return "<form method='{$this->method}' action='{$this->action}'>";
    }

    public function addInput(string $type, string $name, string $placeholder, string $value = null)
    {
        return "<div class='mb-3'>
                    <label for='{$name}' class='form-label'>{$name}</label>
                    <input type='{$type}' class='form-control' name='{$name}' placeholder='{$placeholder}' value='{$value}'>
                </div>";
    }

    public function addTextarea(string $name, string $placeholder, string $value = null)
    {
        return "<div class='mb-3'>
                    <label for='{$name}' class='form-label'>{$name}</label>
                    <textarea class='form-control' name='{$name}' rows='15'>{$value}</textarea>
                </div>";
    }

    public function closeForm()
    {
        return "</form>";
    }
  }