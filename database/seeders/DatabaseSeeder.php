<?php

namespace Database\Seeders;

use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('TTypeCards')->insert(
            [
                [
                    "name" => "Carte d'électeur",
                    'created_at' => (Carbon::now())->toDateTimeString(),
                    'updated_at' => (Carbon::now())->toDateTimeString()
                ],
                [
                    "name" => "Passeport",
                    'created_at' => (Carbon::now())->toDateTimeString(),
                    'updated_at' => (Carbon::now())->toDateTimeString()
                ],
                [
                    "name" => "Autres",
                    'created_at' => (Carbon::now())->toDateTimeString(),
                    'updated_at' => (Carbon::now())->toDateTimeString()
                ]
            ]
        );

        DB::table('TTypeAccounts')->insert(
            [
                [
                    "name" => "Propriètaire",
                    'created_at' => (Carbon::now())->toDateTimeString(),
                    'updated_at' => (Carbon::now())->toDateTimeString()
                ],
                [
                    "name" => "Locataire",
                    'created_at' => (Carbon::now())->toDateTimeString(),
                    'updated_at' => (Carbon::now())->toDateTimeString()
                ],
                [
                    "name" => "Commissionnaire",
                    'created_at' => (Carbon::now())->toDateTimeString(),
                    'updated_at' => (Carbon::now())->toDateTimeString()
                ]
            ]
        );


        DB::table('TCommunes')->insert([
            [
                "name" => "Bandalungwa",
                "DistrictId" => 1,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Barumbu",
                "DistrictId" => 3,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Bumbu",
                "DistrictId" => 1,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Gombe",
                "DistrictId" => 3,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Kalamu",
                "DistrictId" => 1,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Kasa-Vubu",
                "DistrictId" => 1,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Kimbanseke",
                "DistrictId" => 4,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Kinshasa",
                "DistrictId" => 3,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Kintambo",
                "DistrictId" => 3,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Kisenso",
                "DistrictId" => 2,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Lemba",
                "DistrictId" => 2,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Limete",
                "DistrictId" => 2,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Lingwala",
                "DistrictId" => 3,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Makala",
                "DistrictId" => 1,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Maluku",
                "DistrictId" => 4,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Masina",
                "DistrictId" => 4,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Matete",
                "DistrictId" => 2,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Mont-Ngafula",
                "DistrictId" => 2,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Ndjili",
                "DistrictId" => 4,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Ngaba",
                "DistrictId" => 2,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Ngaliema",
                "DistrictId" => 2,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Ngiri-Ngiri",
                "DistrictId" => 1,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Nsele",
                "DistrictId" => 4,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Selembao",
                "DistrictId" => 1,
                "is_active" => false,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ]
        ]);

        DB::table('TDistricts')->insert([
            [
                "name" => "Funa",
                "CityId" => 1,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Mont-Amba",
                "CityId" => 1,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Lukunga",
                "CityId" => 1,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
            [
                "name" => "Tshangu",
                "CityId" => 1,
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ]
        ]);
        DB::table('TCities')->insert([
            [
                "name" => "Kinshasa",
                'created_at' => (Carbon::now())->toDateTimeString(),
                'updated_at' => (Carbon::now())->toDateTimeString()
            ],
        ]);
        DB::table('TQuartiers')->insert([
            //C_bandalungwa1
            [
                "name" => "TSHIBANGU",
                "CommuneId" => 1
            ],
            [
                "name" => "MAKELELE",
                "CommuneId" => 1
            ],
            [
                "name" => "KASA-VUBU",
                "CommuneId" => 1
            ],
            [
                "name" => "BISENGO",
                "CommuneId" => 1
            ],
            [
                "name" => "ADOULA",
                "CommuneId" => 1
            ],
            [
                "name" => "LUBUNDI",
                "CommuneId" => 1
            ],
            [
                "name" => "MOLAERT",
                "CommuneId" => 1
            ],
            [
                "name" => "LUMUMBA",
                "CommuneId" => 1
            ],
            // BARUMBU2
            [
                "name" => "BITSHAKA",
                "CommuneId" => 2
            ],
            [
                "name" => "FUNA I",
                "CommuneId" => 2
            ],
            [
                "name" => "FUNA II",
                "CommuneId" => 2
            ],
            [
                "name" => "KAPINGA BAPU",
                "CommuneId" => 2
            ],
            [
                "name" => "KASAFI",
                "CommuneId" => 2
            ],
            [
                "name" => "LIBULU",
                "CommuneId" => 2
            ],
            [
                "name" => "MOZINDO",
                "CommuneId" => 2
            ],
            [
                "name" => "N'DOLO",
                "CommuneId" => 2
            ],
            [
                "name" => "TSHIMANGA",
                "CommuneId" => 2
            ],
            // Bumbu3
            [
                "name" => "DIPIYA",
                "CommuneId" => 3
            ],
            [
                "name" => "MONGALA",
                "CommuneId" => 3
            ],
            [
                "name" => "UBANGI",
                "CommuneId" => 3
            ],
            [
                "name" => "LOKORO",
                "CommuneId" => 2
            ],
            [
                "name" => "KASAI",
                "CommuneId" => 3
            ],
            [
                "name" => "KWANGO",
                "CommuneId" => 3
            ],
            [
                "name" => "LUKENIE",
                "CommuneId" => 3
            ],
            [
                "name" => "MAI-NDOMBE",
                "CommuneId" => 3
            ],
            [
                "name" => "MATADI",
                "CommuneId" => 3
            ],
            [
                "name" => "LIEUTENANT MBAKI",
                "CommuneId" => 3
            ],
            [
                "name" => "MBANDAKA",
                "CommuneId" => 3
            ],
            [
                "name" => "MFIMI",
                "CommuneId" => 3
            ],
            [
                "name" => "NTOMBA",
                "CommuneId" => 3
            ],
            //Gombe4
            [
                "name" => "BATETELA",
                "CommuneId" => 4
            ],
            [
                "name" => "HAUT COMMANDEMENT",
                "CommuneId" => 4
            ],
            [
                "name" => "CROIX-ROUGE",
                "CommuneId" => 4
            ],
            [
                "name" => "LEMERA",
                "CommuneId" => 4
            ],
            [
                "name" => "GOLF",
                "CommuneId" => 4
            ],
            [
                "name" => "FLEUVE",
                "CommuneId" => 4
            ],
            [
                "name" => "COMMERCE",
                "CommuneId" => 4
            ],
            [
                "name" => "GARE",
                "CommuneId" => 4
            ],
            [
                "name" => "REVOLUTION",
                "CommuneId" => 4
            ],
            [
                "name" => "CLINIQUE",
                "CommuneId" => 4
            ],
            //kALAMU5
            [
                "name" => "MATONGE I",
                "CommuneId" => 5
            ],
            [
                "name" => "MATONGE II",
                "CommuneId" => 5
            ],
            [
                "name" => "MATONGE III",
                "CommuneId" => 5
            ],
            [
                "name" => "YOLO NORD I",
                "CommuneId" => 5
            ],
            [
                "name" => "YOLO NORD II",
                "CommuneId" => 5
            ],
            [
                "name" => "YOLO NORD III",
                "CommuneId" => 5
            ],
            [
                "name" => "YOLO SUD I",
                "CommuneId" => 5
            ],
            [
                "name" => "YOLO SUD II",
                "CommuneId" => 5
            ],
            [
                "name" => "YOLO SUD III",
                "CommuneId" => 5
            ],
            [
                "name" => "YOLO SUD IV",
                "CommuneId" => 5
            ],
            [
                "name" => "KAUKA I",
                "CommuneId" => 5
            ],
            [
                "name" => "KAUKA II",
                "CommuneId" => 5
            ],
            [
                "name" => "KAUKA III",
                "CommuneId" => 5
            ],
            [
                "name" => "PINZI",
                "CommuneId" => 5
            ],
            [
                "name" => "IMMO CONGO",
                "CommuneId" => 5
            ],
            // KASA-VUBU6
            [
                "name" => "ANCIENS COMBATTANTS",
                "CommuneId" => 6
            ],
            [
                "name" => "ASSOSSA",
                "CommuneId" => 6
            ],
            [
                "name" => "KATANGA",
                "CommuneId" => 6
            ],
            [
                "name" => "LODJA",
                "CommuneId" => 6
            ],
            [
                "name" => "LUBUMBASHI",
                "CommuneId" => 6
            ],
            [
                "name" => "ONC",
                "CommuneId" => 6
            ],
            [
                "name" => "SALANGO",
                "CommuneId" => 6
            ],
            //Kimbanseke7
            [
                "name" => "17 MAI",
                "CommuneId" => 7
            ],
            [
                "name" => "BAHUMBI",
                "CommuneId" => 7
            ],
            [
                "name" => "BAMBOMA",
                "CommuneId" => 7
            ],
            [
                "name" => "BIYELA",
                "CommuneId" => 7
            ],
            [
                "name" => "BOMA",
                "CommuneId" => 7
            ],
            [
                "name" => "DISSASI",
                "CommuneId" => 7
            ],
            [
                "name" => "ESANGA",
                "CommuneId" => 7
            ],
            [
                "name" => "KAMBA MULUMBA",
                "CommuneId" => 7
            ],
            [
                "name" => "KASA-VUBU",
                "CommuneId" => 7
            ],
            [
                "name" => "KIKIMI",
                "CommuneId" => 7
            ],
            [
                "name" => "KISANGANI",
                "CommuneId" => 7
            ],
            [
                "name" => "KISANTU IR BEN",
                "CommuneId" => 7
            ],
            [
                "name" => "KUTU",
                "CommuneId" => 7
            ],
            [
                "name" => "LUEBO",
                "CommuneId" => 7
            ],
            [
                "name" => "MALONDA",
                "CommuneId" => 7
            ],
            [
                "name" => "MANGANA",
                "CommuneId" => 7
            ],
            [
                "name" => "MAVIOKELE",
                "CommuneId" => 7
            ],
            [
                "name" => "MBUALA",
                "CommuneId" => 7
            ],
            [
                "name" => "MFUMU NKENTO",
                "CommuneId" => 7
            ],
            [
                "name" => "MIKONDO",
                "CommuneId" => 7
            ],
            [
                "name" => "MOKALI",
                "CommuneId" => 7
            ],
            [
                "name" => "MULIE",
                "CommuneId" => 7
            ],
            [
                "name" => "NGAMAZIDA",
                "CommuneId" => 7
            ],
            [
                "name" => "NGAMPANI",
                "CommuneId" => 7
            ],
            [
                "name" => "NGANDU",
                "CommuneId" => 7
            ],
            [
                "name" => "NGANGA",
                "CommuneId" => 7
            ],
            [
                "name" => "NSUMABWA",
                "CommuneId" => 7
            ],
            [
                "name" => "REVOLUTION",
                "CommuneId" => 7
            ],
            [
                "name" => "SAKOMBI",
                "CommuneId" => 7
            ],
            [
                "name" => "SALONGO",
                "CommuneId" => 7
            ],
            //Kinshasa8
            [
                "name" => "AKETI",
                "CommuneId" => 8
            ],
            [
                "name" => "BOYOMA",
                "CommuneId" => 8
            ],
            [
                "name" => "DJALO",
                "CommuneId" => 8
            ],
            [
                "name" => "MADIMBA",
                "CommuneId" => 8
            ],
            [
                "name" => "MONGALA",
                "CommuneId" => 8
            ],
            [
                "name" => "NGBAKA",
                "CommuneId" => 8
            ],
            [
                "name" => "PENDE",
                "CommuneId" => 8
            ],
            //Kintambo9
            [
                "name" => "ITIMBIRI",
                "CommuneId" => 9
            ],
            [
                "name" => "KILIMANI",
                "CommuneId" => 9
            ],
            [
                "name" => "LISALA",
                "CommuneId" => 9
            ],
            [
                "name" => "LUBUDILUKA",
                "CommuneId" => 9
            ],
            [
                "name" => "NGANDA",
                "CommuneId" => 9
            ],
            [
                "name" => "SALONGO",
                "CommuneId" => 9
            ],
            [
                "name" => "TSHINKELA",
                "CommuneId" => 9
            ],
            [
                "name" => "WENZE",
                "CommuneId" => 9
            ],
            //Kinseso10
            [
                "name" => "REGIDESO",
                "CommuneId" => 10
            ],
            [
                "name" => "KUMBU",
                "CommuneId" => 10
            ],
            [
                "name" => "MBUKU",
                "CommuneId" => 10
            ],
            [
                "name" => "AMBA",
                "CommuneId" => 10
            ],
            [
                "name" => "MISSION MUJINGA",
                "CommuneId" => 10
            ],
            [
                "name" => "LIBERATION",
                "CommuneId" => 10
            ],
            [
                "name" => "17 MAI",
                "CommuneId" => 10
            ],
            [
                "name" => "NSOLA",
                "CommuneId" => 10
            ],
            [
                "name" => "BIKANGA",
                "CommuneId" => 10
            ],
            //Lemba11
            [
                "name" => "MADRANDELLE",
                "CommuneId" => 11
            ],
            [
                "name" => "MASANO",
                "CommuneId" => 11
            ],
            [
                "name" => "KIMPWANZA",
                "CommuneId" => 11
            ],
            [
                "name" => "COMMERCIALE",
                "CommuneId" => 11
            ],
            [
                "name" => "MOLO",
                "CommuneId" => 11
            ],
            [
                "name" => "FOIRE",
                "CommuneId" => 11
            ],
            [
                "name" => "DE L'ECOLE",
                "CommuneId" => 11
            ],
            [
                "name" => "ECHANGEUR",
                "CommuneId" => 11
            ],
            [
                "name" => "GOMBELI",
                "CommuneId" => 11
            ],
            [
                "name" => "SALONGO",
                "CommuneId" => 11
            ],
            [
                "name" => "LIVULU",
                "CommuneId" => 11
            ],
            [
                "name" => "KEMI",
                "CommuneId" => 11
            ],
            [
                "name" => "MBANZA-LEMBA",
                "CommuneId" => 11
            ],
            //Limete12
            [
                "name" => "AGRICOLE",
                "CommuneId" => 12
            ],
            [
                "name" => "FUNA",
                "CommuneId" => 12
            ],
            [
                "name" => "INDUSTRIEL",
                "CommuneId" => 12
            ],
            [
                "name" => "KINGABWA",
                "CommuneId" => 12
            ],
            [
                "name" => "MASIALA",
                "CommuneId" => 12
            ],
            [
                "name" => "MAYULU",
                "CommuneId" => 12
            ],
            [
                "name" => "MBAMU",
                "CommuneId" => 12
            ],
            [
                "name" => "MOMBELE",
                "CommuneId" => 12
            ],
            [
                "name" => "MOSOSO",
                "CommuneId" => 12
            ],
            [
                "name" => "MOTEBA",
                "CommuneId" => 12
            ],
            [
                "name" => "NDANU",
                "CommuneId" => 12
            ],
            [
                "name" => "NZADI",
                "CommuneId" => 12
            ],
            [
                "name" => "RESIDENTIEL",
                "CommuneId" => 12
            ],
            [
                "name" => "SALONGO",
                "CommuneId" => 12
            ],
            //Lingwala13
            [
                "name" => "LUFUNGULA",
                "CommuneId" => 13
            ],
            [
                "name" => "SINGA",
                "CommuneId" => 13
            ],
            [
                "name" => "MOPEPE",
                "CommuneId" => 13
            ],
            [
                "name" => "WENZE",
                "CommuneId" => 13
            ],
            [
                "name" => "PLC",
                "CommuneId" => 13
            ],
            [
                "name" => "30 JUIN",
                "CommuneId" => 13
            ],
            [
                "name" => "LOKOLE",
                "CommuneId" => 13
            ],
            [
                "name" => "PAKA-DJUMA",
                "CommuneId" => 13
            ],
            [
                "name" => "VOIX DU PEUPLE",
                "CommuneId" => 13
            ],
            [
                "name" => "NGUNDA-LOKOMBE",
                "CommuneId" => 13
            ],
            //Makala14
            [
                "name" => "BAGOTA",
                "CommuneId" => 14
            ],
            [
                "name" => "BAHUMBU",
                "CommuneId" => 14
            ],
            [
                "name" => "BOLIMA",
                "CommuneId" => 14
            ],
            [
                "name" => "KABILA",
                "CommuneId" => 14
            ],
            [
                "name" => "KISANTU",
                "CommuneId" => 14
            ],
            [
                "name" => "KWANGO",
                "CommuneId" => 14
            ],
            [
                "name" => "LEMBA VILLAGE",
                "CommuneId" => 14
            ],
            [
                "name" => "MABULU",
                "CommuneId" => 14
            ],
            //Maluku 15
            [
                "name" => "BU",
                "CommuneId" => 15
            ],
            [
                "name" => "DUMI",
                "CommuneId" => 15
            ],
            [
                "name" => "KIKIMI",
                "CommuneId" => 15
            ],
            [
                "name" => "KIMPONGO",
                "CommuneId" => 15
            ],
            [
                "name" => "KINGAKATI",
                "CommuneId" => 15
            ],
            [
                "name" => "KINGONO",
                "CommuneId" => 15
            ],
            [
                "name" => "KINZONO",
                "CommuneId" => 15
            ],
            [
                "name" => "MBANKANA",
                "CommuneId" => 15
            ],
            [
                "name" => "MALUKU",
                "CommuneId" => 15
            ],
            [
                "name" => "MAI-DOMBE",
                "CommuneId" => 15
            ],
            [
                "name" => "MANGE-NGENGE",
                "CommuneId" => 15
            ],
            [
                "name" => "MENKAO",
                "CommuneId" => 15
            ],
            [
                "name" => "MONACO",
                "CommuneId" => 15
            ],
            [
                "name" => "MONGATA",
                "CommuneId" => 15
            ],
            [
                "name" => "MWE",
                "CommuneId" => 15
            ],
            [
                "name" => "NGAMA",
                "CommuneId" => 15
            ],
            [
                "name" => "NGUMA",
                "CommuneId" => 15
            ],
            [
                "name" => "YOSO",
                "CommuneId" => 15
            ],
            [
                "name" => "YO",
                "CommuneId" => 15
            ],
            //MASINA16
            [
                "name" => "ABBATOIR",
                "CommuneId" => 16
            ],
            [
                "name" => "BOBA",
                "CommuneId" => 16
            ],
            [
                "name" => "LONGO",
                "CommuneId" => 16
            ],
            [
                "name" => "EFOLOKO",
                "CommuneId" => 16
            ],
            [
                "name" => "KASAI",
                "CommuneId" => 16
            ],
            [
                "name" => "KIMBANGU",
                "CommuneId" => 16
            ],
            [
                "name" => "MAFUTA-KIZOLA",
                "CommuneId" => 16
            ],
            [
                "name" => "MATADI",
                "CommuneId" => 16
            ],
            [
                "name" => "MFUMU-SUKA",
                "CommuneId" => 16
            ],
            [
                "name" => "NZUNZI WA MBOMBO",
                "CommuneId" => 16
            ],
            [
                "name" => "PELENDE",
                "CommuneId" => 16
            ],
            [
                "name" => "SANS-FIL",
                "CommuneId" => 16
            ],
            [
                "name" => "TSHANGO",
                "CommuneId" => 16
            ],
            [
                "name" => "TSHUENZE",
                "CommuneId" => 16
            ],
            [
                "name" => "TELEVISION",
                "CommuneId" => 16
            ],
            //Matete17
            [
                "name" => "MANDINA",
                "CommuneId" => 17
            ],
            [
                "name" => "MAI-NDOMBE",
                "CommuneId" => 17
            ],
            [
                "name" => "MBOKOLO",
                "CommuneId" => 17
            ],
            [
                "name" => "KWENGE I",
                "CommuneId" => 17
            ],
            [
                "name" => "KWENGE II",
                "CommuneId" => 17
            ],
            [
                "name" => "NGILIMA I",
                "CommuneId" => 17
            ],
            [
                "name" => "NGILIMA II",
                "CommuneId" => 17
            ],
            [
                "name" => "LOKORO",
                "CommuneId" => 17
            ],
            [
                "name" => "ANUNGA",
                "CommuneId" => 17
            ],
            [
                "name" => "NGUFU",
                "CommuneId" => 17
            ],
            [
                "name" => "KINDA I",
                "CommuneId" => 17
            ],
            [
                "name" => "KINDA II",
                "CommuneId" => 17
            ],
            [
                "name" => "KUNDA I",
                "CommuneId" => 17
            ],
            [
                "name" => "KUNDA II",
                "CommuneId" => 17
            ],
            [
                "name" => "VIAZA",
                "CommuneId" => 17
            ],
            [
                "name" => "BANUNU I",
                "CommuneId" => 17
            ],
            [
                "name" => "BANUNU II",
                "CommuneId" => 17
            ],
            [
                "name" => "BATANDU I",
                "CommuneId" => 17
            ],
            [
                "name" => "BATANDU II",
                "CommuneId" => 17
            ],
            [
                "name" => "DEBONHOMME",
                "CommuneId" => 17
            ],
            [
                "name" => "PULULU I",
                "CommuneId" => 17
            ],
            [
                "name" => "PULULU II",
                "CommuneId" => 17
            ],
            [
                "name" => "BABOMA",
                "CommuneId" => 17
            ],
            [
                "name" => "KINZAZI",
                "CommuneId" => 17
            ],
            [
                "name" => "TOMBA",
                "CommuneId" => 17
            ],
            [
                "name" => "MONGO",
                "CommuneId" => 17
            ],
            [
                "name" => "VITAMINE I",
                "CommuneId" => 17
            ],
            [
                "name" => "VITAMINE II",
                "CommuneId" => 17
            ],
            [
                "name" => "BATENDE",
                "CommuneId" => 17
            ],
            [
                "name" => "KINSATU",
                "CommuneId" => 17
            ],
            [
                "name" => "MUTOTO",
                "CommuneId" => 17
            ],
            [
                "name" => "MPUNDI",
                "CommuneId" => 17
            ],
            [
                "name" => "BAHUMBU I",
                "CommuneId" => 17
            ],
            [
                "name" => "BAHUMBU II",
                "CommuneId" => 17
            ],
            [
                "name" => "MALANDI I",
                "CommuneId" => 17
            ],
            [
                "name" => "MALANDI II",
                "CommuneId" => 17
            ],
            [
                "name" => "LOKELE I",
                "CommuneId" => 17
            ],
            [
                "name" => "LOKELE II",
                "CommuneId" => 17
            ],
            [
                "name" => "BATEKE",
                "CommuneId" => 17
            ],
            [
                "name" => "SINGA",
                "CommuneId" => 17
            ],
            [
                "name" => "KINSIMBU",
                "CommuneId" => 17
            ],
            //Mon-Ngafula18
            [
                "name" => "CPA MUSHIE",
                "CommuneId" => 18
            ],
            [
                "name" => "KIMBONDO",
                "CommuneId" => 18
            ],
            [
                "name" => "KIMBUTA",
                "CommuneId" => 18
            ],
            [
                "name" => "KIMWENZO",
                "CommuneId" => 18
            ],
            [
                "name" => "KIMBUALA",
                "CommuneId" => 18
            ],
            [
                "name" => "KINDELE",
                "CommuneId" => 18
            ],
            [
                "name" => "LUTUNDELE",
                "CommuneId" => 18
            ],
            [
                "name" => "MAMA MOBUTU",
                "CommuneId" => 18
            ],
            [
                "name" => "MAMA YEMO",
                "CommuneId" => 18
            ],
            [
                "name" => "MASANGA MBILA",
                "CommuneId" => 18
            ],
            [
                "name" => "MUSAGU-TELECOM",
                "CommuneId" => 18
            ],
            [
                "name" => "MAZAMBA",
                "CommuneId" => 18
            ],
            [
                "name" => "MATADI KIBALA",
                "CommuneId" => 18
            ],
            [
                "name" => "MATADI MAYO",
                "CommuneId" => 18
            ],
            [
                "name" => "MITENDI",
                "CommuneId" => 18
            ],
            [
                "name" => "MBUKI",
                "CommuneId" => 18
            ],
            [
                "name" => "NDJILI-KILAMBA",
                "CommuneId" => 18
            ],
            [
                "name" => "NGANSELE",
                "CommuneId" => 18
            ],
            [
                "name" => "PLATEAU I",
                "CommuneId" => 18
            ],
            [
                "name" => "PLATEAU II",
                "CommuneId" => 18
            ],
            [
                "name" => "VUNDA-MANENGA",
                "CommuneId" => 18
            ],
            //N'DJILI19
            [
                "name" => "QUARTIER 1",
                "CommuneId" => 19
            ],
            [
                "name" => "QUARTIER 2",
                "CommuneId" => 19
            ],
            [
                "name" => "QUARTIER 3",
                "CommuneId" => 19
            ],
            [
                "name" => "QUARTIER 4",
                "CommuneId" => 19
            ],
            [
                "name" => "QUARTIER 5",
                "CommuneId" => 19
            ],
            [
                "name" => "QUARTIER 6",
                "CommuneId" => 19
            ],
            [
                "name" => "QUARTIER 7",
                "CommuneId" => 19
            ],
            [
                "name" => "QUARTIER 8",
                "CommuneId" => 19
            ],
            [
                "name" => "QUARTIER 9",
                "CommuneId" => 19
            ],
            [
                "name" => "QUARTIER 10",
                "CommuneId" => 19
            ],
            [
                "name" => "QUARTIER 11",
                "CommuneId" => 19
            ],
            [
                "name" => "QUARTIER 12",
                "CommuneId" => 19
            ],
            [
                "name" => "QUARTIER 13",
                "CommuneId" => 19
            ],
            //ngaba20
            [
                "name" => "MUKULUA",
                "CommuneId" => 20
            ],
            [
                "name" => "BULA-MBEMBA",
                "CommuneId" => 20
            ],
            [
                "name" => "MATEBA",
                "CommuneId" => 20
            ],
            [
                "name" => "LUYI",
                "CommuneId" => 20
            ],
            [
                "name" => "MPILA",
                "CommuneId" => 20
            ],
            [
                "name" => "BAOBAB",
                "CommuneId" => 20
            ],
            //ngaliema21
            [
                "name" => "LUKUNGA",
                "CommuneId" => 21
            ],
            [
                "name" => "NGOMBA KIKUSA",
                "CommuneId" => 21
            ],
            [
                "name" => "BUMBA",
                "CommuneId" => 21
            ],
            [
                "name" => "BINZA PIGEON DJELO BINZA",
                "CommuneId" => 21
            ],
            [
                "name" => "BANGU",
                "CommuneId" => 21
            ],
            [
                "name" => "PUNDA",
                "CommuneId" => 21
            ],
            [
                "name" => "KIMPE",
                "CommuneId" => 21
            ],
            [
                "name" => "ANCIENS COMBATTANTS",
                "CommuneId" => 21
            ],
            [
                "name" => "BASOKO",
                "CommuneId" => 21
            ],
            [
                "name" => "CONGO",
                "CommuneId" => 21
            ],
            [
                "name" => "JOLI PARC",
                "CommuneId" => 21
            ],
            [
                "name" => "KINKENDA",
                "CommuneId" => 21
            ],
            [
                "name" => "KINSUKA PECHEUR",
                "CommuneId" => 21
            ],
            [
                "name" => "LONZO",
                "CommuneId" => 21
            ],
            [
                "name" => "MUSEYI",
                "CommuneId" => 21
            ],
            [
                "name" => "MAMAN-YEMO",
                "CommuneId" => 21
            ],
            [
                "name" => "MANENGA",
                "CommuneId" => 21
            ],
            [
                "name" => "MFINDA",
                "CommuneId" => 21
            ],
            [
                "name" => "MONGANYA",
                "CommuneId" => 21
            ],
            [
                "name" => "LUBUDI",
                "CommuneId" => 21
            ],

            //Ngiri-ngiri22
            [
                "name" => "DIANGENDA",
                "CommuneId" => 22
            ],
            [
                "name" => "24 NOVEMBRE",
                "CommuneId" => 22
            ],
            [
                "name" => "SAIO",
                "CommuneId" => 22
            ],
            [
                "name" => "PETIT-PETIT",
                "CommuneId" => 22
            ],
            [
                "name" => "ASSOSSA",
                "CommuneId" => 22
            ],
            [
                "name" => "DIOMI",
                "CommuneId" => 22
            ],
            [
                "name" => "KARTHOUM",
                "CommuneId" => 22
            ],
            [
                "name" => "ELENGESA",
                "CommuneId" => 22
            ],
            //N'Sele23
            [
                "name" => "BADARA",
                "CommuneId" => 23
            ],
            [
                "name" => "BIBWA",
                "CommuneId" => 23
            ],
            [
                "name" => "D.I.C",
                "CommuneId" => 23
            ],
            [
                "name" => "DINGI-DINGI",
                "CommuneId" => 23
            ],
            [
                "name" => "DOMAINE",
                "CommuneId" => 23
            ],
            [
                "name" => "MIKALA I",
                "CommuneId" => 23
            ],
            [
                "name" => "MIKALA II",
                "CommuneId" => 23
            ],
            [
                "name" => "KINKOLE",
                "CommuneId" => 23
            ],
            [
                "name" => "PECHEURS",
                "CommuneId" => 23
            ],
            [
                "name" => "BAHUMBU I",
                "CommuneId" => 23
            ],
            [
                "name" => "BAHUMBU II",
                "CommuneId" => 23
            ],
            [
                "name" => "SICOTRA/COKALI",
                "CommuneId" => 23
            ],
            [
                "name" => "MIKONDO(BRASSERIE)",
                "CommuneId" => 23
            ],
            [
                "name" => "MIKONGA(CITE DE MPASA)",
                "CommuneId" => 23
            ],
            [
                "name" => "MAI-NDOMBE(VILLAGE)",
                "CommuneId" => 23
            ],
            [
                "name" => "MPASSA MABA",
                "CommuneId" => 23
            ],
            [
                "name" => "KINZONO",
                "CommuneId" => 23
            ],
            [
                "name" => "MANGENGE",
                "CommuneId" => 23
            ],
            [
                "name" => "MOBA NSE",
                "CommuneId" => 23
            ],
            [
                "name" => "MENKAO(VILLAGE)",
                "CommuneId" => 23
            ],
            [
                "name" => "MONACO",
                "CommuneId" => 23
            ],
            [
                "name" => "NGIMA(VILLAGE)",
                "CommuneId" => 23
            ],
            [
                "name" => "KINGAKATI(VILLAGE)",
                "CommuneId" => 23
            ],
            [
                "name" => "TALANGAI",
                "CommuneId" => 23
            ],
            //SELEMBOA24
            [
                "name" => "BADIADING",
                "CommuneId" => 24
            ],
            [
                "name" => "CITE VERTE",
                "CommuneId" => 24
            ],
            [
                "name" => "INGA",
                "CommuneId" => 24
            ],
            [
                "name" => "HERADY",
                "CommuneId" => 24
            ],
            [
                "name" => "KALUNGA",
                "CommuneId" => 24
            ],
            [
                "name" => "KINGU",
                "CommuneId" => 24
            ],
            [
                "name" => "KONDE",
                "CommuneId" => 24
            ],
            [
                "name" => "LIBERATION",
                "CommuneId" => 24
            ],
            [
                "name" => "LUBUDI",
                "CommuneId" => 24
            ],
            [
                "name" => "MADIATA",
                "CommuneId" => 24
            ],
            [
                "name" => "MBOLA",
                "CommuneId" => 24
            ],
            [
                "name" => "MOLENDE",
                "CommuneId" => 24
            ],
            [
                "name" => "MUANA",
                "CommuneId" => 24
            ],
            [
                "name" => "NTUNU",
                "CommuneId" => 24
            ],
            [
                "name" => "NDOBE",
                "CommuneId" => 24
            ],
            [
                "name" => "NGAFANI",
                "CommuneId" => 24
            ],
            [
                "name" => "KOMBE",
                "CommuneId" => 24
            ],
            [
                "name" => "NKULU",
                "CommuneId" => 24
            ],
            [
                "name" => "PULULU MBAMBU",
                "CommuneId" => 24
            ]
        ]);
    }
}
