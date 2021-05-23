<?php

namespace Bootstrap\Requests\Helpers;

class Filter
{
    /**
     * @param array $rules
     * @param array $custom_data
     * @return array|false|null
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public static function validate(array $rules, array $custom_data = [])
    {
        $validated = static::passes($rules, $custom_data);

        $errors = [];
        foreach ($validated as $formname => $validate) {
            if ($validate === false)
                $errors[$formname] = sprintf(
                    '%s input field should be %s', $formname, $rules[$formname]
                );
        }

        if (!empty($errors) && empty($custom_data))
            return app('request')->back()
                ->with($errors);

        if (!empty($errors) && !empty($custom_data))
            return $errors;

        return $validated;
    }

    /**
     * @param array $unfiltereds
     * @param array $custom_data
     * @return array|false|null
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public static function passes(array $unfiltereds, array $custom_data = [])
    {
        foreach ($unfiltereds as $formname => $filtername) {
            if (in_array($filtername, array_keys(Filters::all()))) {
                $unfiltereds[$formname] = Filters::get($filtername);
            }
        }

        if (!empty($custom_data))
            return filter_var_array($custom_data, $unfiltereds);

        return filter_var_array(
            app('request')->where(array_keys($unfiltereds)), $unfiltereds
        );
    }
}