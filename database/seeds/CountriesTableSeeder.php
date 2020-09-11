<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('countries')->delete();
        
        \DB::table('countries')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'China',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'United States',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Ukraine',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Russia',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'South Korea ',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Thailand',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Singapore',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Malaysia',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Australia',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'India',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Indonesia',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Brazil',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Pakistan',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Nigeria',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Bangladesh',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Mexico',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Japan',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Ethiopia',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Philippines',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Egypt',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Viet Nam',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'DR Congo',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Germany',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Iran',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Turkey',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'U.K.',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'France',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Italy',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Tanzania',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'South Africa',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Myanmar',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Kenya',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Colombia',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Spain',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Argentina',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Uganda',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Algeria',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Sudan',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Iraq',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Poland',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Canada',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Afghanistan',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Morocco',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Saudi Arabia',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Peru',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Venezuela',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Uzbekistan',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Angola',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'Mozambique',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'Nepal',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'Ghana',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Yemen',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Madagascar',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'North Korea',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'Côte d\'Ivoire',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'Cameroon',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'Niger',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'Sri Lanka',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'Burkina Faso',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'Romania',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'Malawi',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'Mali',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'Kazakhstan',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'Syria',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'Chile',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'Zambia',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'Guatemala',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'Netherlands',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'Zimbabwe',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'Ecuador',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'Senegal',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'Cambodia',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'Chad',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'Somalia',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'Guinea',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'South Sudan',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'Rwanda',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'Tunisia',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'Belgium',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'Cuba',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'Benin',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'Burundi',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'Bolivia',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'Greece',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'Haiti',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'Dominican Republic',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'Czech Republic',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'Portugal',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'Sweden',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'Azerbaijan',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'Jordan',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'Hungary',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'United Arab Emirates',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'Belarus',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'Honduras',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'Tajikistan',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'Serbia',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'Austria',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'Switzerland',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'Israel',
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'Papua New Guinea',
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'Togo',
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'Sierra Leone',
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'Bulgaria',
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'Laos',
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'Paraguay',
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'Libya',
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'El Salvador',
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'Nicaragua',
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'Kyrgyzstan',
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'Lebanon',
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'Turkmenistan',
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'Denmark',
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'Finland',
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'Slovakia',
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'Congo',
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'Norway',
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'Eritrea',
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'State of Palestine',
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'Costa Rica',
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'Liberia',
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'Oman',
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'Ireland',
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'New Zealand',
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'Central African Republic',
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'Mauritania',
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'Kuwait',
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'Croatia',
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'Panama',
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'Moldova',
            ),
            130 => 
            array (
                'id' => 131,
                'name' => 'Georgia',
            ),
            131 => 
            array (
                'id' => 132,
                'name' => 'Bosnia & Herzegovina',
            ),
            132 => 
            array (
                'id' => 133,
                'name' => 'Uruguay',
            ),
            133 => 
            array (
                'id' => 134,
                'name' => 'Mongolia',
            ),
            134 => 
            array (
                'id' => 135,
                'name' => 'Albania',
            ),
            135 => 
            array (
                'id' => 136,
                'name' => 'Armenia',
            ),
            136 => 
            array (
                'id' => 137,
                'name' => 'Jamaica',
            ),
            137 => 
            array (
                'id' => 138,
                'name' => 'Lithuania',
            ),
            138 => 
            array (
                'id' => 139,
                'name' => 'Qatar',
            ),
            139 => 
            array (
                'id' => 140,
                'name' => 'Namibia',
            ),
            140 => 
            array (
                'id' => 141,
                'name' => 'Botswana',
            ),
            141 => 
            array (
                'id' => 142,
                'name' => 'Lesotho',
            ),
            142 => 
            array (
                'id' => 143,
                'name' => 'Gambia',
            ),
            143 => 
            array (
                'id' => 144,
                'name' => 'TFYR Macedonia',
            ),
            144 => 
            array (
                'id' => 145,
                'name' => 'Slovenia',
            ),
            145 => 
            array (
                'id' => 146,
                'name' => 'Gabon',
            ),
            146 => 
            array (
                'id' => 147,
                'name' => 'Latvia',
            ),
            147 => 
            array (
                'id' => 148,
                'name' => 'Guinea-Bissau',
            ),
            148 => 
            array (
                'id' => 149,
                'name' => 'Bahrain',
            ),
            149 => 
            array (
                'id' => 150,
                'name' => 'Swaziland',
            ),
            150 => 
            array (
                'id' => 151,
                'name' => 'Trinidad and Tobago',
            ),
            151 => 
            array (
                'id' => 152,
                'name' => 'Timor-Leste',
            ),
            152 => 
            array (
                'id' => 153,
                'name' => 'Equatorial Guinea',
            ),
            153 => 
            array (
                'id' => 154,
                'name' => 'Estonia',
            ),
            154 => 
            array (
                'id' => 155,
                'name' => 'Mauritius',
            ),
            155 => 
            array (
                'id' => 156,
                'name' => 'Cyprus',
            ),
            156 => 
            array (
                'id' => 157,
                'name' => 'Djibouti',
            ),
            157 => 
            array (
                'id' => 158,
                'name' => 'Fiji',
            ),
            158 => 
            array (
                'id' => 159,
                'name' => 'Comoros',
            ),
            159 => 
            array (
                'id' => 160,
                'name' => 'Bhutan',
            ),
            160 => 
            array (
                'id' => 161,
                'name' => 'Guyana',
            ),
            161 => 
            array (
                'id' => 162,
                'name' => 'Montenegro',
            ),
            162 => 
            array (
                'id' => 163,
                'name' => 'Solomon Islands',
            ),
            163 => 
            array (
                'id' => 164,
                'name' => 'Luxembourg',
            ),
            164 => 
            array (
                'id' => 165,
                'name' => 'Suriname',
            ),
            165 => 
            array (
                'id' => 166,
                'name' => 'Cabo Verde',
            ),
            166 => 
            array (
                'id' => 167,
                'name' => 'Maldives',
            ),
            167 => 
            array (
                'id' => 168,
                'name' => 'Brunei',
            ),
            168 => 
            array (
                'id' => 169,
                'name' => 'Malta',
            ),
            169 => 
            array (
                'id' => 170,
                'name' => 'Bahamas',
            ),
            170 => 
            array (
                'id' => 171,
                'name' => 'Belize',
            ),
            171 => 
            array (
                'id' => 172,
                'name' => 'Iceland',
            ),
            172 => 
            array (
                'id' => 173,
                'name' => 'Barbados',
            ),
            173 => 
            array (
                'id' => 174,
                'name' => 'Vanuatu',
            ),
            174 => 
            array (
                'id' => 175,
                'name' => 'Sao Tome & Principe',
            ),
            175 => 
            array (
                'id' => 176,
                'name' => 'Samoa',
            ),
            176 => 
            array (
                'id' => 177,
                'name' => 'Saint Lucia',
            ),
            177 => 
            array (
                'id' => 178,
                'name' => 'Kiribati',
            ),
            178 => 
            array (
                'id' => 179,
                'name' => 'St. Vincent & Grenadines',
            ),
            179 => 
            array (
                'id' => 180,
                'name' => 'Tonga',
            ),
            180 => 
            array (
                'id' => 181,
                'name' => 'Grenada',
            ),
            181 => 
            array (
                'id' => 182,
                'name' => 'Micronesia',
            ),
            182 => 
            array (
                'id' => 183,
                'name' => 'Antigua and Barbuda',
            ),
            183 => 
            array (
                'id' => 184,
                'name' => 'Seychelles',
            ),
            184 => 
            array (
                'id' => 185,
                'name' => 'Andorra',
            ),
            185 => 
            array (
                'id' => 186,
                'name' => 'Dominica',
            ),
            186 => 
            array (
                'id' => 187,
                'name' => 'Saint Kitts & Nevis',
            ),
            187 => 
            array (
                'id' => 188,
                'name' => 'Marshall Islands',
            ),
            188 => 
            array (
                'id' => 189,
                'name' => 'Monaco',
            ),
            189 => 
            array (
                'id' => 190,
                'name' => 'Liechtenstein',
            ),
            190 => 
            array (
                'id' => 191,
                'name' => 'San Marino',
            ),
            191 => 
            array (
                'id' => 192,
                'name' => 'Palau',
            ),
            192 => 
            array (
                'id' => 193,
                'name' => 'Nauru',
            ),
            193 => 
            array (
                'id' => 194,
                'name' => 'Tuvalu',
            ),
            194 => 
            array (
                'id' => 195,
                'name' => 'Holy See',
            ),
        ));
        
        
    }
}