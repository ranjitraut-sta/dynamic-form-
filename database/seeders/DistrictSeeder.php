<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create districts for each province
        $districts = [
            'Koshi Province' => [
                'Bhojpur', 'Dhankuta', 'Ilam', 'Jhapa', 'Khotang', 'Morang', 'Okhaldhunga', 'Panchthar', 'Sankhuwasabha',
                'Solukhumbu', 'Sunsari', 'Taplejung', 'Terhathum', 'Udayapur',
            ],
            'Bagmati Province' => [
                'Bhaktapur', 'Chitwan', 'Dhading', 'Dolakha', 'Kathmandu', 'Kavrepalanchok', 'Lalitpur', 'Makwanpur',
                'Nuwakot', 'Ramechhap', 'Rasuwa', 'Sindhuli', 'Sindhupalchok',
            ],
            'Madhesh Province' => [
                'Bara', 'Dhanusha', 'Mahottari', 'Parsa', 'Rautahat', 'Sarlahi', 'Saptari', 'Siraha',
            ],
            'Gandaki Province' => [
                'Gorkha', 'Kaski', 'Lamjung', 'Manang', 'Mustang', 'Myagdi', 'Nawalpur', 'Parbat', 'Syangja', 'Tanahun',
            ],
            'Lumbini Province' => [
                'Arghakhanchi', 'Gulmi', 'Kapilvastu', 'Nawalparasi East', 'Nawalparasi West', 'Palpa', 'Rupandehi',
            ],
            'Karnali Province' => [
                'Dailekh', 'Dolpa', 'Humla', 'Jajarkot', 'Jumla', 'Kalikot', 'Mugu', 'Salyan', 'Surkhet',
            ],
            'Sudurpachhim Province' => [
                'Achham', 'Baitadi', 'Bajhang', 'Bajura', 'Dadeldhura', 'Darchula', 'Doti', 'Kailali', 'Kanchanpur',
            ],
        ];

        foreach ($districts as $provinceName => $districtNames) {
            $provinceId = Province::where('name', $provinceName)->value('id');
            foreach ($districtNames as $districtName) {
                District::create(['name' => $districtName, 'province_id' => $provinceId]);
            }
        }
    }
}
