<?php

namespace App\Kosan\Services\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Kosan\Services\Auth\ResetPasswordService;

class ResetPwdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		$email = ResetPasswordService::resolveRequest(request('token'));
        return $email? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "password"	=> "required|min:6",
			"confirm"	=> "required|same:password",
        ];
    }
	
	public function attributes()
	{
		return [
			'password' => 'Sandi Baru',
			'confirm' => 'Konfirmasi Sandi',
		];
	}
}
