<?php

namespace App\Services;

use App\{Country, ForumTopic, GameVersion, Replay, ReplayMap, UserMessage, UserRole};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminViewHelper
{
    protected $menu_name;
    protected $notifications;
    protected $role;
    protected $countries;
    protected $user_role;
    protected $maps;
    protected $game_versions;

    /**
     * Get URI name for admin panel
     *
     * @return string
     */
    public function getMenuName()
    {
        $this->menu_name = $this->menu_name??str_ireplace('admin_panel/','',Request::capture()->path());

        return $this->menu_name;
    }

    /**
     * User is admin
     *
     * @return bool
     */
    public function admin()
    {
        $this->role = $this->role??(Auth::user()->role?(Auth::user()->role->name == 'admin'):false);
        return $this->role;
    }

    /**
     * @return Country[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCountries()
    {
        $this->countries = $this->countries??Country::all();
        return $this->countries;
    }

    /**
     * @return Country[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUserRole()
    {
        $this->user_role = $this->user_role??UserRole::all();
        return $this->user_role;
    }
}