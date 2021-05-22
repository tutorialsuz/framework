<?php

namespace Bootstrap\Requests\Helpers;

class Filter
{
    public static function validate(array $rules)
    {
        $validated = static::passes($rules);

        $errors = [];
        foreach ($validated as $formname => $validate) {
            if ($validate === false)
                $errors[$formname] = sprintf(
                    '%s input field should be %s', $formname, $rules[$formname]
                );
        }

        if (!empty($errors)) {
            return app('request')->back()
                ->with($errors);
        }

        return $validated;
    }

    public static function passes(array $unfiltereds)
    {
        foreach ($unfiltereds as $formname => $filtername) {
            if (in_array($filtername, array_keys(Filters::all()))) {
                $unfiltereds[$formname] = Filters::get($filtername);
            }
        }

        return filter_var_array(
            app('request')->where(array_keys($unfiltereds)), $unfiltereds
        );
    }
}