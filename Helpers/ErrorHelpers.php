<?php

declare(strict_types=1);

namespace app\Helpers;

class ErrorHelpers
{
    public static function errorsToStr ($errorsArray)
    {
        $errors = [];

        if(!empty($errorsArray)) {

            foreach ($errorsArray as $fieldErrors) {
                array_push($errors, implode(';', $fieldErrors));
            }

            return implode(' ', $errors);
        }

        return '';
    }

}