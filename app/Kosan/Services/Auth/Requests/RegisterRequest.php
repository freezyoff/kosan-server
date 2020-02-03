<?php

namespace App\Kosan\Services\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'email' 			=> 'required|email:rfc,dns|unique:kosan_system.users,email',
			'password' 			=> 'required|min:6',
			'password_confirm' 	=> 'required|same:password',
			'name'				=> 'required|max:100',
			'gender'			=>['required', Rule::in(['m', 'f'])],
			'address_province'	=> 'required|exists:kosan_system.regions,code',
			'address_regency'	=> 'required|exists:kosan_system.regions,code',
			'address_district'	=> 'required|exists:kosan_system.regions,code',
			'address_village'	=> 'required|exists:kosan_system.regions,code',
			'address_address'	=> 'required|max:255',
			'address_postcode'	=> 'required|alpha_num|max:25',
			'phone_number'		=> 'required|alpha_num|max:25',
			'picture_idcard'	=> 'required|image|mimes:jpeg,jpg,png,gif|max:1000',
        ];
    }
	
	public function messages(){
		
		return [
			'address_province.required'	=> 'Lengkapi Alamat.',
			'address_regency.required'	=> 'Lengkapi Alamat.',
			'address_district.required'	=> 'Lengkapi Alamat.',
			'address_village.required'	=> 'Lengkapi Alamat.',
			'address_address.required'	=> 'Lengkapi Alamat.',
			'address_postcode.required'	=> 'Lengkapi Alamat.',
			
			'picture_idcard.required' 	=> "Upload foto :attribute",
			'picture_idcard.image' 		=> "Upload foto :attribute dengan format .jpeg, .jpg, .png, atau .gif",
			'picture_idcard.mimes' 		=> "Upload foto :attribute dengan format .jpeg, .jpg, .png, atau .gif",
			'picture_idcard.max' 		=> "File foto :attribute maksimal 1Mb"
		];
	}
	
	public function attributes()
	{
		return [
			'email' 			=> 'Alamat Email',
			'password' 			=> 'Sandi',
			'password_confirm' 	=> 'Konfirmasi Sandi',
			'name'				=> 'Nama',
			'gender'			=> 'Gender',
			'address_province'	=> 'Provinsi',
			'address_regency'	=> 'Kabupaten / Kota',
			'address_district'	=> 'Kecamatan',
			'address_village'	=> 'Kelurahan / Desa',
			'address_address'	=> 'Alamat',
			'address_postcode'	=> 'Kode Pos',
			'phone_number'		=> 'Nomor Telepon',
			'picture_idcard'	=> 'Kartu Tanda Penduduk (KTP)',
		];
	}
	
}
