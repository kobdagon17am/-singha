<?php

namespace App\Http\View\Composers;

use App\Repositories\UserRepository;
use Illuminate\View\View;
use Auth;
use App\Model\Banner;
class MasterComposer
{

    public function compose(View $view)
    {

        $view->with('authdata', json_decode(Auth::user()->status_admin));

    }
}
