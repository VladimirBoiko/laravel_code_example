<?php

namespace App\Services\Base;

use Illuminate\Pagination\LengthAwarePaginator;

class ViewService
{
    /**
     * @param string $view_name
     * @param LengthAwarePaginator $data
     * @return string
     */
    public static function getView(string $view_name, LengthAwarePaginator $data)
    {
        return (string) view($view_name)->with(['data' => $data]);
    }
}