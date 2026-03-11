<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Applicant;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ApplicantSeeder extends Seeder
{
    public function run(): void
    {

        $members = $members = [

                    ['Red Amber Enterprises','Red Amber','Red Manchos','09178721018','redamber.enterprises@gmail.com'],
                    ['Bañez, Bañez & Associates','N/A','Julius Carmelo J. Bañez','09228400232','attyjcjbanez@yahoo.com'],
                    // ['Charizm Enterprise','N/A','Alicia D. Manarang','09332932303','alicedmanarang@yahoo.com.ph'],
                    // ['China Banking Corporation','N/A','Alicia S. Gavino','09177146127','asgavino@chinabank.ph'],
                    // ['Food Grade Trading','N/A','Gemma K. Ong','09178386886','jem_933@yahoo.com'],
                    // ['Ideatechs Packaging Corp.','Greenpak','Helen Lising','09196299993','helen.lising@outlook.ph'],
                    // ['JAPS Delight Food Store','N/A','Amelyn Roderos','9281880121','amelyn.roderos@yahoo.com'],
                    // ['Jhamae\'s Food and Beverages','N/A','Lovely E. Cajucom','09051952435','cajucomlovely10@gmail.com'],
                    // ['Nisco Phils Enterprise','N/A','Yolanda R. Dela Cruz','09189008000','niscophils@gmail.com'],
                    // ['O.T. Oliveros & Co.','N/A','Ofelia T. Oliveros','09178731914','oliveroscpa@yahoo.com'],
                    // ['ORS Foodservice','N/A','Sonia R. Sy','09185204096','orsfoodservice@yahoo.com'],
                    // ['ZYD General Construction','N/A','Dianne Phoebe Kaye L. De Leon','09478156833','pbkdeleon@gmail.com'],
                    // ['El Biko Kakanin','N/A','Lysyia S. Gatoc','09606037474','lhaysanchez69@gmail.com'],
                    // ['O\'BURP FOOD HUB','N/A','Mark Anthony Varga','09696416549','markanthonyvarga13@gmail.com'],
                    // ['Plaswealth Phils Corp','N/A','Bingo Pabelonia','09178100586','plaswealth@yahoo.com'],
                    // ['Kyla Amazing Soya Co., Ltd.','N/A','Garry Sevilla','09154777444',null],
                    // ['Mang Delfin\'s Putong Polo, Palabok & Native Kakanin','N/A','Delfin Florencio Gutierrez Jr.','09423723535','delfingutierrez1024@gmail.com'],
                    // ['MABEST FROZEN FOOD STORE','N/A','Lourdes Judit Empil Oranga','09308410724','mabestfoodph@gmail.com'],
                    // ['BMC Pasta House','N/A','Jan Nigel Bo Meret Santos','09088967954','bmcpastahouse@gmail.com'],
                    // ['IM Ramos Sugar & Salt','N/A','Imelda M Ramos','09686418505','immendozaramos168@gmail.com'],
                    // ['KM14 Gastro Garage','N/A','Alicia P. Miranda','09088940265','Alice.miranda918@gmail.com'],
                    // ['QUALITY PLUS MGT CONSULTING CO.','N/A','Pauline C. Galino','09178366254','mail@qplusconsulting.com'],
                    // ['TIPLER AIRCONDITION & REFRIGERATION SUPPLY','N/A','John Charles R. Rubiato','09192719098','Tiplerph@gmil.com'],
                    // ['CHYMS FOOD OPC','N/A','Joannaflor F. Gomez','09079127533','chynnsfoodopc@gmail.com'],
                    // ['Dechieries\'s Sari-sari Store','N/A','Cherry Uy Nario','09074688948','cherrynario@yahoo.com'],
                    // ['JM Sports Wear & Tailoring','N/A','Ma. Lourdes L. Cabaddu','09197453997','maialourdescabaddu@gmail.com'],
                    // ['Rosalinda\'s Sari-sari Store','N/A','Linda Y. Ramirez','09423460143',null],
                    // ['Angel\'s Sari-sari Store','N/A','Edelyn Quinto Celorico','09935015576','celoricoedelyn2180@gmail.com'],
                    // ['DD Kartel Distributions','N/A','Yodgie de Guzman','09399021497','ysdeguzman0909@gmail.com'],
                    // ['Grated Cassava Cake & Frozen Grated Cassava','N/A','Penelope Huelva Cadagat','7284962','bhbinching71@gmail.com'],
                    // ['TOPPERSWARE INDUSTRIAL CO.','N/A','Sunny S. Yao','09178470223','yaosongho@yahoo.com'],
                    // ['GRENNYS FOOD AND BEVERAGE STALL','N/A','Grenny C. Gulmatico','09950448330','grennykitchen2014@gmail.com'],
                    // ['COPACABANA IVORY TRADING CORP.','BILISBENTA CORP.','Allaine Chester S. Sy','09054532471','chestersiasy@yahoo.com'],
                    // ['Double Alpha Enterprises Inc','N/A','Adrian Lester Santiago','09399821382','asantiago@firstmegasaver.com'],
                    // ['LITHOS MANUFACTURING','N/A','Eleanor Oligario','9209129187','Zeolithos@yahoo.com'],
                    // ['ANCHER SALON AND SPA','N/A','Anna Che Dasing','00000000000','annache_sandiego@yahoo.com'],
                    // ['D & E Bukolicious Homemade Food Retailing','N/A','R. Subillaga','9765228094','rosesorianosabangan@gmail.com'],
                    // ['MANLY PLASTIC','N/A','Jonathan Co','9209239960','Joco@manlyplastics.com'],
                    // ['SHEKINAH PASTRY','N/A','Shekinah Mae De Castro','9954613904','shekinahspastry21@gmail.com'],
                    // ['Macchiato Bar','N/A','Vincent Lorenz Francisco','9771000858','vinceeeeeent14@gmail.com'],
                    // ['Powerhouse Pest Control Services, Inc.','N/A','Ana Marie Escober','9154448197','powerhousepestcontrolinc@gmail.com'],
                    // ['J316 Online store','N/A','Jennifer Bautista','00000000000',null],
                    // ['Tazza','N/A','Jairah Sebastian','09154890636','tazzascafeph@gmail.com'],
                    // ['TIPTOP FOODS OPC','N/A','Rico Cabalquinto','9227371468','rico.cabalquinto@gmail.com'],
                    // ['ELISACHEM INDUSTRIES OPC','N/A','Elisa Cabalquinto','9333044665','engineeryayay@yahoo.com'],
                    // ['SER REMZ CCTV AND COMPUTER INSTALLATION SERVICES','N/A','Remier Espinosa','9511399759',null],
                    // ['BALAY SINING MANILA INC.','N/A','Maria Elena L. Sioson','9185049461','malensioson.13@gmail.com'],
                    // ['CRAFTING TIME SPECIALTY SHOP','N/A','Filomena T. Gumop-as','9266829649','craftingtime@gmail.com'],
                    // ['CELEDONIA\'S FOOD PRODUCTS TRADING','N/A','Ronald Ivan G. Alzate','09176329052','genalyng13@gmail.com'],
                    // ['STARCH IND HOMEMADE FOOD TRADING','N/A','Glen Philip L. Beason','00000000000','glenphilipb@yahoo.com'],
                    // ['GREENLEAF 2024','N/A','Jose Englis','09987622664','inglesjose13@gmail.com'],
                    // ['PV\'S FROZEN FOODS','N/A','Patricia Mae P. Velasquez','9554071762','patricia14.velasquez@gmail.com'],
                    // ['MOMMY ICE FOOD CORP','N/A','Albert D. Angeles','9985951183','mommyiceonlinekitchen@gmail.com'],
                    // ['Reon Food Mfg. Corp.','N/A','Joyce Beltran','9171176019','reonfoodma@gmail.com'],
                    // ['4s Leather Works','N/A','Shen Cea Martinez','9955067530','xhen.martinez@gmail.com'],
                    // ['Dulce Coffee Shop','N/A','Dulce Fontanilla','9155474944','dulcecoffeeph@gmail.com'],
                    // ['Ryan and Monica Meat Stall','N/A','Monica Zapanta','9295091271','rykurt0718@gmai.com'],
                    // ['Airoms Leather Craft','N/A','Ayalyn Bensurto','9051210963','bensurtoayalyn@gmail.com'],
                    // ['Duchess Coffee House','N/A','Kendra Rae Manansala','9267350219','duchesscoffeehouse@gmail.com'],
                    // ['Sanny Tusok Tusok Street Food Cart','N/A','Sanny Dizon','9270095000','sannydizon.sd05@gmail.com'],
                    // ['RLM7 Enterprise','N/A','Remedios Medina','9477569098','botmedine.bm@gmail.com'],
                    // ['Harvey 23 Dried Food Trading','N/A','Harvey Mondragon','9951231191','harveymondragon@icloud.com'],
                    // ['The TRND Shop','N/A','Ana Liza Del Moral Angeles','9174014723','TheTrndShop@gmail.com'],
                    // ['8Con Academy','N/A','Eugene Francisco','9541968332','jimfrancisco07@gmail.com'],
                    // ['MLJJ Consumer Goods Trading','N/A','Janneth Fermin','9423299585','jannethfermin94@gmail.com'],
                    // ['GB & G Provider Enterprise Corp.','N/A','Almario Narvasa','9178219007','gbg.providerenterprise.ph@gmail.com'],

        ];

        foreach ($members as $member) {

            $names = explode(' ', $member[2]);
            $first = $names[0];
            $last = end($names);

            Applicant::create([

                'registered_business_name' => $member[0],
                'trade_name' => $member[1],
                'business_address' => 'N/A',
                'city_municipality' => 'N/A',
                'province' => 'N/A',
                'region' => 'N/A',
                'zip_code' => '0000',

                'telephone_no' => 'N/A',
                'website_socmed' => 'N/A',

                'member_dob' => Carbon::parse('2000-01-01'),
                'email' => $member[4] ?? Str::random(5).'@example.com',
                'tin_no' => 'N/A',

                'rep_first_name' => $first,
                'rep_mid_name' => 'N/A',
                'rep_surname' => $last,
                'rep_designation' => 'N/A',
                'rep_dob' => Carbon::parse('1980-01-01'),
                'rep_contact_no' => $member[3],

                'alt_first_name' => 'N/A',
                'alt_mid_name' => 'N/A',
                'alt_surname' => 'N/A',
                'alt_designation' => 'N/A',
                'alt_dob' => Carbon::parse('2000-01-01'),
                'alt_contact_no' => 'N/A',

                'name_of_organization' => 'N/A',
                'registration_number' => 'N/A',
                'date_of_registration' => Carbon::parse('2000-01-01'),

                'type_of_company' => 'Single Proprietorship',
                'number_of_employees' => 0,
                'year_established' => 2000,

                'photo_path' => 'N/A',
                'mayors_permit_path' => 'N/A',
                'dti_sec_path' => 'N/A',
                'proof_of_payment_path' => 'N/A',

                'recommending_approval' => 'N/A',
                'status' => 'paid',

                'date_submitted' => Carbon::now(),

            ]);
        }

        $this->command->info('68 Applicants Seeded Successfully!');
    }
}