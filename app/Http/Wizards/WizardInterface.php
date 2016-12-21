<?php

namespace GitScrum\Http\Wizards;

use Illuminate\Http\Request;

interface WizardInterface
{
    public static function step1();

    public static function step2(Request $request);

    public static function step3();
}
