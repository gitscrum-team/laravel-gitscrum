<?php

namespace GitScrum\Http\Controllers;

class WizardController extends Controller
{
    public function call($provider, $step)
    {
        $provider = ucfirst($provider).'Wizard';
        return call_user_func("\\GitScrum\\Http\\Wizards\\".$provider."::".$step);
    }
}
