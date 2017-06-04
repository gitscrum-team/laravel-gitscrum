<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'frm_notes_title' => 'required|min:2',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'frm_notes_title.required' => trans('gitscrum.field-cannot-be-blank'),
            'frm_notes_title.min' => trans('gitscrum.field-must-be-at-least-2-characters'),
        ];
    }

    protected function getValidatorInstance()
    {
        $data = $this->all();
        $data['title'] = $data['frm_notes_title'];
        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
