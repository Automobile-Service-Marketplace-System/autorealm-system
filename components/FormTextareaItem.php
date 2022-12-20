<?php

namespace app\components;

class FormTextareaItem
{
    /**
     * @param string $id id for the input
     * @param string $label Label for the input
     * @param string $name Name for the input
     * @param string $required Required attribute for the input
     * @param string $placeholder Placeholder for the input
     * @param string $disabled Disabled attribute for the input
     * @param string $error Error message for the input
     * @param bool $hasError Whether the input has an error
     * @param string | null $value Value for the input
     * @param int $rows Number of rows for the textarea
     * @param int $cols Number of columns for the textarea
     * @param string|null $additionalAttributes Additional attributes for the input
     */
    public static function render(
        string      $id,
        string      $label,
        string      $name,
        string      $required = "required",
        string      $type = "text",
        string      $placeholder = "",
        string      $disabled = "",
        bool        $hasError = false,
        string      $error = "",
        string|null $value = null,
        int         $rows = 5,
        int         $cols = 30,
        string|null $additionalAttributes = null,
    ): void
    {
        $errorClass = $hasError ? "form-item--error" : "";
        $errorElement = $hasError ? "<small>$error</small>" : "";
        $requiredIndicator = $required ? "<sup>*</sup>" : "";
        $additionalAttributes = $additionalAttributes ?? "";

        echo "<div class='form-item $errorClass'>
                    <label for='$id'>$label.$requiredIndicator</label>
                    <textarea type='$type' name='$name' id='$id' placeholder='$placeholder'  rows='$rows' cols='$cols'  $required $disabled  $additionalAttributes >
                        $value 
                    </textarea>
                    $errorElement
              </div>";
    }

}