<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        if (File::exists(base_path().DIRECTORY_SEPARATOR.'.env')) {
            return view('wizard.install');
        }
    }

    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
