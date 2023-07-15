<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
class OwnerImport implements ToModel, WithHeadingRow, WithValidation,SkipsEmptyRows
{
    use Importable;
    /**
    * @param Collection $collection
    */
    
    public function model(array $row)
    {
        $user = User::create([
            'name'     => $row['firstname'].''.$row['lastname'],
            'email'    => $row['email1'],
            'type'     => 'Owner',
            'password' => Hash::make('123456'),
        ]);

      
        return Owner::create([
            'firstname'     => $row['firstname'],
            'lastname'    => $row['lastname'], 
            'middlename'    => $row['middlename'], 
            'landline'    => $row['landline'], 
            'primary_mobile'    => $row['mobile1'], 
            'secondary_mobile'    => $row['mobile2'], 
            'primary_email'    => $row['email1'], 
            'secondary_email'    => $row['email2'], 
            'atlernate_email'    => $row['email3'], 
            'contact_person'    => $row['emergencycontactperson'], 
            'contact_number'    => $row['emergencynumber'], 
        ]);
    }
    public function rules(): array
    {
        return [
            'firstname' => [
                'required',
                'string',
            ],
            'lastname' => [
                'required',
                'string',
            ],
            'email1' => [
                'required',
                'email',
                'unique:users,email'
            ],
        ];
    }
}
