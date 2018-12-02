<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class FileExtentionIn implements Rule
{
    private $allowedExtentions;

    public function __construct(array $allowedExtentions)
    {
        $this->allowedExtentions = $allowedExtentions;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid file type. Allowed types ' . implode(', ', $this->allowedExtentions);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $file)
    {
        if ($file instanceof UploadedFile) {
            $extension = strtolower($file->getClientOriginalExtension());
            return in_array($extension, $this->allowedExtentions);
        }

        return false;
    }
}
