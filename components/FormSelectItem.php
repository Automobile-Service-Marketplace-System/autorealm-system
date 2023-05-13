<?php

namespace app\components;

class FormSelectItem
{
    /**
     * @param string $id id for the input
     * @param string $label Label for the input
     * @param string $name Name for the input
     * @param string $required Required attribute for the input
     * @param string $disabled Disabled attribute for the input
     * @param string $error Error message for the input
     * @param bool $hasError Whether the input has an error
     * @param string | null $value Value for the input
     */
    public static function render(
        string      $id,
        string      $label,
        string      $name,
        string      $required = "required",
        string      $disabled = "",
        bool        $hasError = false,
        string      $error = "",
        string|null $value = null,
        array       $options = [],
    ): void
    {
        $errorClass = $hasError ? "form-item--error" : "";
        $errorElement = $hasError ? "<small>$error</small>" : "";
        $requiredIndicator = $required ? ($label != "" ? "<sup>*</sup>" : ""): "";
        $optionsGroup = "";
        foreach ($options as $optionId => $optionValue) {
            $isSelected = $optionId === $value ? "selected" : "";
            $optionsGroup .= "<option value='$optionId' $isSelected>$optionValue</option>";
        }

        echo "<div class='form-item $errorClass'>
                    <label for='$id'>$label$requiredIndicator</label>
                    <select  name='$name' id='$id'  $required $disabled> 
                        $optionsGroup
                    </select>
                    $errorElement
              </div>";
    }

}