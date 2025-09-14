<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Municipality;
use App\Models\Municipility;
use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $provinces = [
            'Koshi Province' => [
                'Bhojpur' => [
                    'Bhojpur Municipality', 'Shadanand Municipality', 'Tyamke Mai Municipality',
                ],
                'Dhankuta' => [
                    'Dhankuta Municipality', 'Pakhribas Municipality', 'Sangurigadhi Municipality',
                ],
                'Ilam' => [
                    'Ilam Municipality', 'Deumai Municipality', 'Mai Municipality',
                ],
                'Jhapa' => [
                    'Mechinagar Municipality', 'Bhadrapur Municipality', 'Damak Municipality',
                    'Kankai Municipality', 'Shivasatakshi Municipality', 'Arjundhara Municipality',
                ],
                'Khotang' => [
                    'Diktel Rupakot Majhuwagadhi Municipality', 'Halesi Tuwachung Municipality', 'Ainselu Kharka Rural Municipality',
                    'Rupakot Rural Municipality', 'Yasok Rural Municipality', 'Kepilasagadhi Rural Municipality',
                ],
                'Morang' => [
                    'Biratnagar Metropolitan City', 'Urlabari Municipality', 'Rangeli Municipality',
                    'Sundar Haraicha Municipality', 'Belbari Municipality', 'Pathari Sanischare Municipality',
                    'Letang Bhogateni Rural Municipality', 'Kerounse Municipality', 'Gangapipara Rural Municipality',
                    'Miklajung Rural Municipality',
                ],
                'Okhaldhunga' => [
                    'Siddhicharan Municipality', 'Champadevi Rural Municipality', 'Molung Rural Municipality',
                    'Likhu Rural Municipality', 'Chisankhugadhi Rural Municipality', 'Khiji Demba Rural Municipality',
                    'Mane Bhanjyang Rural Municipality', 'Sunkoshi Rural Municipality',
                ],
                'Panchthar' => [
                    'Phidim Municipality', 'Phalelung Rural Municipality', 'Hilihang Rural Municipality',
                    'Miklajung Rural Municipality', 'Tumbewa Rural Municipality', 'Yangbarak Rural Municipality',
                ],
                'Sankhuwasabha' => [
                    'Khandbari Municipality', 'Chainpur Municipality', 'Madi Municipality',
                    'Makalu Rural Municipality', 'Dharmadevi Municipality', 'Panchakanya Rural Municipality',
                    'Chichila Rural Municipality', 'Silichong Rural Municipality',
                ],
                'Solukhumbu' => [
                    'Dudhkunda Municipality', 'Sotang Rural Municipality', 'Necha Salyan Rural Municipality',
                    'Maha Kulung Rural Municipality', 'Bhotang Rural Municipality', 'Likhu Pike Rural Municipality',
                    'Khumbu Pasang Lhamu Rural Municipality',
                ],
                'Sunsari' => [
                    'Inaruwa Municipality', 'Dharan Municipality', 'Itahari Municipality',
                    'Duhabi Municipality', 'Ramdhuni Municipality', 'Barahachhetra Municipality',
                    'Koshi Rural Municipality', 'Harinagar Rural Municipality', 'Barju Rural Municipality',
                    'Bhokraha Rural Municipality', 'Dewanganj Rural Municipality',
                ],
                'Taplejung' => [
                    'Phungling Municipality', 'Aathrai Tribeni Rural Municipality', 'Miklajung Rural Municipality',
                    'Maiwakhola Rural Municipality', 'Sidingwa Rural Municipality', 'Sirijangha Rural Municipality',
                ],
                'Terhathum' => [
                    'Myanglung Municipality', 'Laligurans Municipality', 'Aathrai Rural Municipality',
                    'Chhathar Rural Municipality', 'Phedap Rural Municipality', 'Menchayayem Rural Municipality',
                ],
                'Udayapur' => [
                    'Gaighat Municipality', 'Belaka Municipality', 'Triyuga Municipality',
                    'Rautamai Rural Municipality', 'Chaudandigadhi Municipality', 'Tapli Rural Municipality',
                    'Sunkoshi Rural Municipality', 'Katari Municipality',
                ],
                ],
               'Madhesh Province' =>[
                    'Bara' => [
                        'Kalaiya Sub-Metropolitan City', 'Jeetpur Simara Sub-Metropolitan City', 'Nijgadh Municipality',
                        'Parwanipur Rural Municipality', 'Pheta Rural Municipality', 'Pipara Rural Municipality',
                        'Prasauni Rural Municipality', 'Ritpur Simara Sub-Metropolitan City'
                    ],
                    'Dhanusha' => [
                        'Janakpurdham Sub-Metropolitan City', 'Chhireshwornath Municipality', 'Mithila Municipality',
                        'Hansapur Municipality', 'Bideha Municipality', 'Nagarain Municipality', 'Sabaila Municipality',
                        'Kamala Municipality', 'Mukhiyapatti Musaharniya Rural Municipality', 'Mithila Bihari Municipality'
                    ],
                    'Mahottari' => [
                        'Jaleshwor Municipality', 'Bardibas Municipality', 'Gaushala Municipality', 'Mahottari Municipality',
                        'Manara Shiswa Rural Municipality', 'Matihani Municipality', 'Ramgopalpur Municipality', 'Balawa Municipality'
                    ],
                    'Parsa' => [
                        'Birgunj Metropolitan City', 'Parsagadhi Municipality', 'Bahudarmai Municipality', 'Pokhariya Municipality',
                        'Jagarnathpur Rural Municipality', 'Bindabasini Rural Municipality', 'Dhobini Rural Municipality',
                        'Pakaha Mainpur Rural Municipality'
                    ],
                    'Rautahat' => [
                        'Gaur Municipality', 'Dewahi Gonahi Municipality', 'Brindaban Municipality', 'Chandrapur Municipality',
                        'Gujara Municipality', 'Madhav Narayan Municipality', 'Rajdevi Municipality', 'Phatuwa Bijayapur Municipality',
                        'Yamunamai Rural Municipality', 'Maulapur Municipality'
                    ],
                    'Sarlahi' => [
                        'Malangawa Municipality', 'Haripur Municipality', 'Balara Municipality', 'Bagmati Municipality',
                        'Godaita Municipality', 'Ishworpur Municipality', 'Kabilasi Municipality', 'Basbariya Municipality',
                        'Bishnu Rural Municipality', 'Chandranagar Rural Municipality', 'Dhankaul Rural Municipality',
                        'Haripurwa Rural Municipality', 'Kaudena Rural Municipality', 'Ramnagar Rural Municipality', 'Sakhuwa Prasauni Rural Municipality',
                        'Santapur Rural Municipality'
                    ],
                    'Saptari' => [
                        'Rajbiraj Municipality', 'Bodebarsain Municipality', 'Kanchanrup Municipality', 'Dakneshwori Municipality',
                        'Hanumannagar Kankalini Municipality', 'Rupani Rural Municipality', 'Saptakoshi Municipality', 'Surunga Municipality',
                        'Tirahut Rural Municipality'
                    ],
                    'Siraha' => [
                        'Lahan Municipality', 'Dhangadhimai Municipality', 'Golbazar Municipality', 'Mirchaiya Municipality',
                        'Aurahi Municipality', 'Bishnupur Rural Municipality', 'Auraha Rural Municipality', 'Laxmipur Patari Rural Municipality',
                        'Kalyanpur Municipality', 'Karjanha Municipality', 'Sukhipur Municipality'
                    ],
                ],


            'Bagmati Province' => [
                'Bhaktapur' => [
                    'Bhaktapur Municipality', 'Changunarayan Municipality', 'Nagarkot Municipality',
                    'Dhurkot Rural Municipality', 'Suryabinayak Municipality'
                ],
                'Chitwan' => [
                    'Bharatpur Metropolitan City', 'Khairahani Municipality', 'Ratnanagar Municipality',
                    'Ichchhakamana Rural Municipality', 'Madi Municipality'
                ],
                'Dhading' => [
                    'Nilkantha Municipality', 'Khaniyabas Rural Municipality', 'Netrawati Dabajong Rural Municipality',
                    'Thakre Rural Municipality', 'Galchhi Rural Municipality', 'Jwalamukhi Rural Municipality'
                ],
                'Dolakha' => [
                    'Bhimeshwar Municipality', 'Jiri Municipality', 'Gaurishankar Rural Municipality',
                    'Melung Rural Municipality', 'Bigu Rural Municipality', 'Tamakoshi Rural Municipality'
                ],
                'Kathmandu' => [
                    'Kathmandu Metropolitan City', 'Chandragiri Municipality', 'Nagarjun Municipality',
                    'Kirtipur Municipality', 'Tokha Municipality', 'Gokarneshwar Municipality', 'Shankharapur Municipality'
                ],
                'Kavrepalanchok' => [
                    'Panauti Municipality', 'Dhulikhel Municipality', 'Banepa Municipality',
                    'Namobuddha Municipality', 'Mandandeupur Municipality', 'Panchkhal Municipality',
                    'Roshi Rural Municipality', 'Bethanchowk Rural Municipality', 'Mahabharat Rural Municipality'
                ],
                'Lalitpur' => [
                    'Lalitpur Metropolitan City', 'Mahalaxmi Municipality', 'Godawari Municipality',
                    'Konjyosom Rural Municipality', 'Bagmati Rural Municipality'
                ],
                'Makwanpur' => [
                    'Hetauda Sub-Metropolitan City', 'Thaha Municipality', 'Bakaiya Rural Municipality',
                    'Bagmati Rural Municipality', 'Kailash Rural Municipality', 'Indrasarovar Rural Municipality'
                ],
                'Nuwakot' => [
                    'Bidur Municipality', 'Dupcheshwar Rural Municipality', 'Kakani Rural Municipality',
                    'Belkotgadhi Municipality', 'Shivapuri Rural Municipality', 'Tadi Rural Municipality'
                ],
                'Ramechhap' => [
                    'Manthali Municipality', 'Umakunda Rural Municipality', 'Gokulganga Rural Municipality',
                    'Doramba Rural Municipality', 'Sunapati Rural Municipality'
                ],
                'Rasuwa' => [
                    'Kalika Municipality', 'Naukunda Rural Municipality', 'Uttargaya Rural Municipality',
                    'Gatlang Rural Municipality', 'Gosainkunda Rural Municipality', 'Haku Rural Municipality'
                ],
                'Sindhuli' => [
                    'Kamalamai Municipality', 'Sunkoshi Rural Municipality', 'Marin Rural Municipality',
                    'Golanjor Rural Municipality', 'Dudhauli Municipality'
                ],
                'Sindhupalchok' => [
                    'Chautara Sangachokgadhi Municipality', 'Melamchi Municipality', 'Indrawati Rural Municipality',
                    'Jugal Rural Municipality', 'Panchpokhari Thangpal Rural Municipality', 'Bhotekoshi Rural Municipality','Barhabise Municipality',
                    'Helambu Rural Municipality'
                ],
            ],

        'Gandaki Province' => [
                'Gorkha' => [
                    'Gorkha Municipality', 'Palungtar Municipality', 'Ajirkot Rural Municipality', 'Aarughat Rural Municipality',
                    'Bhimsen Rural Municipality', 'Sulikot Rural Municipality', 'Sahid Lakhan Rural Municipality', 'Sirdibas Rural Municipality'
                ],
                'Kaski' => [
                    'Pokhara Metropolitan City', 'Lekhnath Metropolitan City', 'Annapurna Rural Municipality',
                    'Machhapuchchhre Rural Municipality', 'Madi Rural Municipality'
                ],
                'Lamjung' => [
                    'Besisahar Municipality', 'Madhya Nepal Municipality', 'Rainas Municipality', 'Dordi Rural Municipality',
                    'Kwhola Rural Municipality', 'Marsyangdi Rural Municipality'
                ],
                'Manang' => [
                    'Chame Rural Municipality', 'Narphu Rural Municipality'
                ],
                'Mustang' => [
                    'Mustang Rural Municipality', 'Gharpajhong Rural Municipality', 'Thasang Rural Municipality', 'Barhagaun Muktichhetra Rural Municipality'
                ],
                'Myagdi' => [
                    'Beni Municipality', 'Annapurna Rural Municipality', 'Dhaulagiri Rural Municipality', 'Malika Rural Municipality',
                    'Mangala Rural Municipality', 'Raghuganga Rural Municipality'
                ],
                'Nawalpur' => [
                    'Kawasoti Municipality', 'Madhyabindu Municipality', 'Hupsekot Rural Municipality', 'Bulingtar Rural Municipality',
                    'Binayi Tribeni Rural Municipality'
                ],
                'Parbat' => [
                    'Kushma Municipality', 'Phalewas Municipality', 'Jaljala Rural Municipality', 'Paiyun Rural Municipality'
                ],
                'Syangja' => [
                    'Putalibazar Municipality', 'Waling Municipality', 'Aandhikhola Rural Municipality', 'Bhirkot Municipality',
                    'Chapakot Municipality', 'Galyang Municipality', 'Harinas Rural Municipality'
                ],
                'Tanahun' => [
                    'Byas Municipality', 'Shuklagandaki Municipality', 'Bhanu Municipality', 'Devghat Rural Municipality',
                    'Bandipur Rural Municipality', 'Rhishing Rural Municipality'
                ],
            ],
            'Lumbini Province' => [
                'Arghakhanchi' => [
                    'Sandhikharka Municipality', 'Bhumikasthan Municipality', 'Chhatradev Rural Municipality',
                    'Malarani Rural Municipality', 'Shitganga Municipality', 'Sitganga Municipality'
                ],
                'Gulmi' => [
                    'Gulmi Darbar Rural Municipality', 'Kaligandaki Rural Municipality', 'Chandrakot Rural Municipality',
                    'Satyawati Rural Municipality', 'Isma Rural Municipality', 'Musikot Municipality'
                ],
                'Kapilvastu' => [
                    'Kapilvastu Municipality', 'Banganga Municipality', 'Bijayanagar Rural Municipality',
                    'Kapilvastu Dayanagar Rural Municipality', 'Krishnanagar Rural Municipality', 'Maharajgunj Municipality',
                    'Mayadevi Rural Municipality', 'Shivapur Municipality', 'Yashodhara Rural Municipality'
                ],
                'Nawalparasi East' => [
                    'Bardaghat Municipality', 'Devachuli Municipality', 'Gaidakot Municipality', 'Binayi Tribeni Rural Municipality',
                    'Hupsekot Rural Municipality', 'Kawasoti Municipality', 'Madhyabindu Municipality', 'Sarawal Rural Municipality'
                ],
                'Nawalparasi West' => [
                    'Ramgram Municipality', 'Parasi Municipality', 'Susta Rural Municipality', 'Bardaghat Susta Rural Municipality',
                    'Sunwal Municipality', 'Tilottama Municipality', 'Gaindakot Municipality'
                ],
                'Palpa' => [
                    'Tansen Municipality', 'Rampur Municipality', 'Rainadevi Chhahara Municipality', 'Bagnaskali Rural Municipality',
                    'Ribdikot Rural Municipality', 'Mathagadhi Rural Municipality', 'Rambha Rural Municipality'
                ],
                'Rupandehi' => [
                    'Butwal Sub-Metropolitan City', 'Sainamaina Municipality', 'Tilottama Municipality',
                    'Lumbini Sanskritik Municipality', 'Siddharthanagar Municipality', 'Gaidahawa Rural Municipality',
                    'Kanchan Rural Municipality', 'Marchawari Rural Municipality', 'Om Adarsha Rural Municipality', 'Rohini Rural Municipality'
                ],
            ],

            'Karnali Province' => [
                'Dailekh' => [
                    'Narayan Municipality', 'Aathabis Municipality', 'Bhagawatimai Municipality',
                    'Mahawai Rural Municipality', 'Thantikandh Rural Municipality', 'Dullu Municipality'
                ],
                'Dolpa' => [
                    'Tripurasundari Municipality', 'Dolpo Buddha Rural Municipality', 'She-Phoksundo Rural Municipality',
                    'Jagadulla Rural Municipality', 'Thuli Bheri Municipality'
                ],
                'Humla' => [
                    'Simkot Rural Municipality', 'Namkha Rural Municipality', 'Chankheli Rural Municipality',
                    'Sarkegad Rural Municipality', 'Kharpunath Rural Municipality', 'Adanchuli Rural Municipality'
                ],
                'Jajarkot' => [
                    'Bheri Municipality', 'Chhedagad Municipality', 'Junichande Rural Municipality',
                    'Shivalaya Rural Municipality'
                ],
                'Jumla' => [
                    'Chandannath Municipality', 'Sinja Rural Municipality', 'Hima Rural Municipality',
                    'Tila Rural Municipality', 'Guthichaur Rural Municipality', 'Patrasi Rural Municipality'
                ],
                'Kalikot' => [
                    'Khandachakra Municipality', 'Palata Rural Municipality', 'Sanni Triveni Rural Municipality',
                    'Tilagufa Municipality', 'Mahawai Rural Municipality'
                ],
                'Mugu' => [
                    'Chhayanath Rara Municipality', 'Soru Rural Municipality', 'Khatyad Rural Municipality',
                    'Mugum Karmarong Rural Municipality'
                ],
                'Salyan' => [
                    'Bagchaur Municipality', 'Shaarda Municipality', 'Kalimati Rural Municipality',
                    'Kapurkot Municipality', 'Bangad Kupinde Municipality', 'Triveni Rural Municipality'
                ],
                'Surkhet' => [
                    'Birendranagar Municipality', 'Chaukune Rural Municipality', 'Gurbhakot Municipality',
                    'Panchapuri Municipality', 'Barahatal Rural Municipality', 'Lekbesi Municipality'
                ],
            ],

        'Sudurpachhim Province' =>[
                'Achham' => [
                    'Mangalsen Municipality', 'Kamalbazar Municipality', 'Sanphebagar Municipality',
                    'Panchadewal Binayak Municipality', 'Chaurpati Rural Municipality', 'Dhakari Rural Municipality',
                    'Turmakhand Rural Municipality', 'Mellekh Rural Municipality', 'Ramaroshan Rural Municipality',
                    'Bannigadhi Jayagadh Rural Municipality',
                ],
                'Baitadi' => [
                    'Dasharathchand Municipality', 'Purchaudi Municipality', 'Shivanath Rural Municipality',
                    'Bhimdatta Municipality', 'Melauli Municipality', 'Patan Municipality', 'Dogdakedar Rural Municipality',
                    'Sigas Rural Municipality',
                ],
                'Bajhang' => [
                    'Jayaprithvi Municipality', 'Bungal Municipality', 'Bajhang Rural Municipality', 'Khaptadchhanna Rural Municipality',
                    'Thalara Rural Municipality',
                ],
                'Bajura' => [
                    'Badimalika Municipality', 'Triveni Municipality', 'Budhiganga Municipality', 'Jagannath Rural Municipality',
                    'Gaumul Rural Municipality',
                ],
                'Dadeldhura' => [
                    'Amargadhi Municipality', 'Parshuram Municipality', 'Nawadurga Rural Municipality', 'Ajayameru Rural Municipality',
                    'Aalitaal Rural Municipality',
                ],
                'Darchula' => [
                    'Mahakali Municipality', 'Malikarjun Rural Municipality', 'Apihimal Rural Municipality',
                ],
                'Doti' => [
                    'Dipayal Silgadhi Municipality', 'Shikhar Municipality', 'Purbichauki Rural Municipality', 'Badikedar Rural Municipality',
                    'Sayal Rural Municipality', 'Bogtan Fudsil Rural Municipality', 'Aadarsha Rural Municipality',
                ],
                'Kailali' => [
                    'Dhangadhi Sub-Metropolitan City', 'Tikapur Municipality', 'Lamki Chuha Municipality', 'Gauriganga Municipality',
                    'Bardagoriya Rural Municipality', 'Mohanyal Rural Municipality', 'Janaki Rural Municipality', 'Kailari Rural Municipality',
                ],
                'Kanchanpur' => [
                    'Bhimdatta Municipality', 'Belauri Municipality', 'Shuklaphanta Municipality', 'Krishnapur Municipality',
                    'Bedkot Municipality', 'Mahakali Municipality',
                ],
            ]
        ];

        foreach ($provinces as $provinceName => $districts) {
            foreach ($districts as $districtName => $municipalities) {
                foreach ($municipalities as $municipalityName) {
                    $district = District::where('name', $districtName)->first();
                    Municipility::create(['name' => $municipalityName, 'district_id' => $district->id]);
                }
            }
        }
    }

}
