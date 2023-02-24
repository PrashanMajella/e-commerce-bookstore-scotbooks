<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $StatesUSA = [
            [ "code" => "AL", "name" => "Alabama" ],
            [ "code" => "AK", "name" => "Alaska" ],
            [ "code" => "AZ", "name" => "Arizona" ],
            [ "code" => "AR", "name" => "Arkansas" ],
            [ "code" => "CA", "name" => "California" ],
            [ "code" => "CO", "name" => "Colorado" ],
            [ "code" => "CT", "name" => "Connecticut" ],
            [ "code" => "DE", "name" => "Delaware" ],
            [ "code" => "FL", "name" => "Florida" ],
            [ "code" => "GA", "name" => "Georgia" ],
            [ "code" => "HI", "name" => "Hawaii" ],
            [ "code" => "ID", "name" => "Idaho" ],
            [ "code" => "IL", "name" => "Illinois" ],
            [ "code" => "IN", "name" => "Indiana" ],
            [ "code" => "IA", "name" => "Iowa" ],
            [ "code" => "KS", "name" => "Kansas" ],
            [ "code" => "KY", "name" => "Kentucky" ],
            [ "code" => "LA", "name" => "Louisiana" ],
            [ "code" => "ME", "name" => "Maine" ],
            [ "code" => "MD", "name" => "Maryland" ],
            [ "code" => "MA", "name" => "Massachusetts" ],
            [ "code" => "MI", "name" => "Michigan" ],
            [ "code" => "MN", "name" => "Minnesota" ],
            [ "code" => "MS", "name" => "Mississippi" ],
            [ "code" => "MO", "name" => "Missouri" ],
            [ "code" => "MT", "name" => "Montana" ],
            [ "code" => "NE", "name" => "Nebraska" ],
            [ "code" => "NV", "name" => "Nevada" ],
            [ "code" => "NH", "name" => "New Hampshire" ],
            [ "code" => "NJ", "name" => "New Jersey" ],
            [ "code" => "NM", "name" => "New Mexico" ],
            [ "code" => "NY", "name" => "New York" ],
            [ "code" => "NC", "name" => "North Carolina" ],
            [ "code" => "ND", "name" => "North Dakota" ],
            [ "code" => "OH", "name" => "Ohio" ],
            [ "code" => "OK", "name" => "Oklahoma" ],
            [ "code" => "OR", "name" => "Oregon" ],
            [ "code" => "PA", "name" => "Pennsylvania" ],
            [ "code" => "RI", "name" => "Rhode Island" ],
            [ "code" => "SC", "name" => "South Carolina" ],
            [ "code" => "SD", "name" => "South Dakota" ],
            [ "code" => "TN", "name" => "Tennessee" ],
            [ "code" => "TX", "name" => "Texas" ],
            [ "code" => "UT", "name" => "Utah" ],
            [ "code" => "VT", "name" => "Vermont" ],
            [ "code" => "VA", "name" => "Virginia" ],
            [ "code" => "WA", "name" => "Washington" ],
            [ "code" => "WV", "name" => "West Virginia" ],
            [ "code" => "WI", "name" => "Wisconsin" ],
            [ "code" => "WY", "name" => "Wyoming" ]
        ];

        $statesIndia = [
            [ "code" => "AN", "name" => "Andaman and Nicobar Islands" ],
            [ "code" => "AP", "name" => "Andhra Pradesh" ],
            [ "code" => "AR", "name" => "Arunachal Pradesh" ],
            [ "code" => "AS", "name" => "Assam" ],
            [ "code" => "BR", "name" => "Bihar" ],
            [ "code" => "CG", "name" => "Chandigarh" ],
            [ "code" => "CH", "name" => "Chhattisgarh" ],
            [ "code" => "DN", "name" => "Dadra and Nagar Haveli" ],
            [ "code" => "DD", "name" => "Daman and Diu" ],
            [ "code" => "DL", "name" => "Delhi" ],
            [ "code" => "GA", "name" => "Goa" ],
            [ "code" => "GJ", "name" => "Gujarat" ],
            [ "code" => "HR", "name" => "Haryana" ],
            [ "code" => "HP", "name" => "Himachal Pradesh" ],
            [ "code" => "JK", "name" => "Jammu and Kashmir" ],
            [ "code" => "JH", "name" => "Jharkhand" ],
            [ "code" => "KA", "name" => "Karnataka" ],
            [ "code" => "KL", "name" => "Kerala" ],
            [ "code" => "LA", "name" => "Ladakh" ],
            [ "code" => "LD", "name" => "Lakshadweep" ],
            [ "code" => "MP", "name" => "Madhya Pradesh" ],
            [ "code" => "MH", "name" => "Maharashtra" ],
            [ "code" => "MN", "name" => "Manipur" ],
            [ "code" => "ML", "name" => "Meghalaya" ],
            [ "code" => "MZ", "name" => "Mizoram" ],
            [ "code" => "NL", "name" => "Nagaland" ],
            [ "code" => "OR", "name" => "Odisha" ],
            [ "code" => "PY", "name" => "Puducherry" ],
            [ "code" => "PB", "name" => "Punjab" ],
            [ "code" => "RJ", "name" => "Rajasthan" ],
            [ "code" => "SK", "name" => "Sikkim" ],
            [ "code" => "TN", "name" => "Tamil Nadu" ],
            [ "code" => "TS", "name" => "Telangana" ],
            [ "code" => "TR", "name" => "Tripura" ],
            [ "code" => "UP", "name" => "Uttar Pradesh" ],
            [ "code" => "UK", "name" => "Uttarakhand" ],
            [ "code" => "WB", "name" => "West Bengal" ]
        ];

        $countries = [
            [ "code" => "AFG", "name" => "Afghanistan", "states" => null ],
            [ "code" => "ALA", "name" => "Åland Islands", "states" => null ],
            [ "code" => "ALB", "name" => "Albania", "states" => null ],
            [ "code" => "DZA", "name" => "Algeria", "states" => null ],
            [ "code" => "ASM", "name" => "American Samoa", "states" => null ],
            [ "code" => "AND", "name" => "Andorra", "states" => null ],
            [ "code" => "AGO", "name" => "Angola", "states" => null ],
            [ "code" => "AIA", "name" => "Anguilla", "states" => null ],
            [ "code" => "ATA", "name" => "Antarctica", "states" => null ],
            [ "code" => "ATG", "name" => "Antigua and Barbuda", "states" => null ],
            [ "code" => "ARG", "name" => "Argentina", "states" => null ],
            [ "code" => "ARM", "name" => "Armenia", "states" => null ],
            [ "code" => "ABW", "name" => "Aruba", "states" => null ],
            [ "code" => "AUS", "name" => "Australia", "states" => null ],
            [ "code" => "AUT", "name" => "Austria", "states" => null ],
            [ "code" => "AZE", "name" => "Azerbaijan", "states" => null ],
            [ "code" => "BHS", "name" => "Bahamas", "states" => null ],
            [ "code" => "BHR", "name" => "Bahrain", "states" => null ],
            [ "code" => "BGD", "name" => "Bangladesh", "states" => null ],
            [ "code" => "BRB", "name" => "Barbados", "states" => null ],
            [ "code" => "BLR", "name" => "Belarus", "states" => null ],
            [ "code" => "BEL", "name" => "Belgium", "states" => null ],
            [ "code" => "BLZ", "name" => "Belize", "states" => null ],
            [ "code" => "BEN", "name" => "Benin", "states" => null ],
            [ "code" => "BMU", "name" => "Bermuda", "states" => null ],
            [ "code" => "BTN", "name" => "Bhutan", "states" => null ],
            [ "code" => "BOL", "name" => "Bolivia (Plurinational State of)", "states" => null ],
            [ "code" => "BES", "name" => "Bonaire, Sint Eustatius and Saba", "states" => null ],
            [ "code" => "BIH", "name" => "Bosnia and Herzegovina", "states" => null ],
            [ "code" => "BWA", "name" => "Botswana", "states" => null ],
            [ "code" => "BVT", "name" => "Bouvet Island", "states" => null ],
            [ "code" => "BRA", "name" => "Brazil", "states" => null ],
            [ "code" => "IOT", "name" => "British Indian Ocean Territory", "states" => null ],
            [ "code" => "VGB", "name" => "British Virgin Islands", "states" => null ],
            [ "code" => "BRN", "name" => "Brunei Darussalam", "states" => null ],
            [ "code" => "BGR", "name" => "Bulgaria", "states" => null ],
            [ "code" => "BFA", "name" => "Burkina Faso", "states" => null ],
            [ "code" => "BDI", "name" => "Burundi", "states" => null ],
            [ "code" => "CPV", "name" => "Cabo Verde", "states" => null ],
            [ "code" => "KHM", "name" => "Cambodia", "states" => null ],
            [ "code" => "CMR", "name" => "Cameroon", "states" => null ],
            [ "code" => "CAN", "name" => "Canada", "states" => null ],
            [ "code" => "CYM", "name" => "Cayman Islands", "states" => null ],
            [ "code" => "CAF", "name" => "Central African Republic", "states" => null ],
            [ "code" => "TCD", "name" => "Chad", "states" => null ],
            [ "code" => "CHL", "name" => "Chile", "states" => null ],
            [ "code" => "CHN", "name" => "China", "states" => null ],
            [ "code" => "HKG", "name" => "China, Hong Kong Special Administrative Region", "states" => null ],
            [ "code" => "MAC", "name" => "China, Macao Special Administrative Region", "states" => null ],
            [ "code" => "CXR", "name" => "Christmas Island", "states" => null ],
            [ "code" => "CCK", "name" => "Cocos (Keeling) Islands", "states" => null ],
            [ "code" => "COL", "name" => "Colombia", "states" => null ],
            [ "code" => "COM", "name" => "Comoros", "states" => null ],
            [ "code" => "COG", "name" => "Congo", "states" => null ],
            [ "code" => "COK", "name" => "Cook Islands", "states" => null ],
            [ "code" => "CRI", "name" => "Costa Rica", "states" => null ],
            [ "code" => "CIV", "name" => "Côte d'Ivoire", "states" => null ],
            [ "code" => "HRV", "name" => "Croatia", "states" => null ],
            [ "code" => "CUB", "name" => "Cuba", "states" => null ],
            [ "code" => "CUW", "name" => "Curaçao", "states" => null ],
            [ "code" => "CYP", "name" => "Cyprus", "states" => null ],
            [ "code" => "CZE", "name" => "Czechia", "states" => null ],
            [ "code" => "PRK", "name" => "Democratic People's Republic of Korea", "states" => null ],
            [ "code" => "COD", "name" => "Democratic Republic of the Congo", "states" => null ],
            [ "code" => "DNK", "name" => "Denmark", "states" => null ],
            [ "code" => "DJI", "name" => "Djibouti", "states" => null ],
            [ "code" => "DMA", "name" => "Dominica", "states" => null ],
            [ "code" => "DOM", "name" => "Dominican Republic", "states" => null ],
            [ "code" => "ECU", "name" => "Ecuador", "states" => null ],
            [ "code" => "EGY", "name" => "Egypt", "states" => null ],
            [ "code" => "SLV", "name" => "El Salvador", "states" => null ],
            [ "code" => "GNQ", "name" => "Equatorial Guinea", "states" => null ],
            [ "code" => "ERI", "name" => "Eritrea", "states" => null ],
            [ "code" => "EST", "name" => "Estonia", "states" => null ],
            [ "code" => "SWZ", "name" => "Eswatini", "states" => null ],
            [ "code" => "ETH", "name" => "Ethiopia", "states" => null ],
            [ "code" => "FLK", "name" => "Falkland Islands (Malvinas)", "states" => null ],
            [ "code" => "FRO", "name" => "Faroe Islands", "states" => null ],
            [ "code" => "FJI", "name" => "Fiji", "states" => null ],
            [ "code" => "FIN", "name" => "Finland", "states" => null ],
            [ "code" => "FRA", "name" => "France", "states" => null ],
            [ "code" => "GUF", "name" => "French Guiana", "states" => null ],
            [ "code" => "PYF", "name" => "French Polynesia", "states" => null ],
            [ "code" => "ATF", "name" => "French Southern Territories", "states" => null ],
            [ "code" => "GAB", "name" => "Gabon", "states" => null ],
            [ "code" => "GMB", "name" => "Gambia", "states" => null ],
            [ "code" => "GEO", "name" => "Georgia", "states" => null ],
            [ "code" => "DEU", "name" => "Germany", "states" => null ],
            [ "code" => "GHA", "name" => "Ghana", "states" => null ],
            [ "code" => "GIB", "name" => "Gibraltar", "states" => null ],
            [ "code" => "GRC", "name" => "Greece", "states" => null ],
            [ "code" => "GRL", "name" => "Greenland", "states" => null ],
            [ "code" => "GRD", "name" => "Grenada", "states" => null ],
            [ "code" => "GLP", "name" => "Guadeloupe", "states" => null ],
            [ "code" => "GUM", "name" => "Guam", "states" => null ],
            [ "code" => "GTM", "name" => "Guatemala", "states" => null ],
            [ "code" => "GGY", "name" => "Guernsey", "states" => null ],
            [ "code" => "GIN", "name" => "Guinea", "states" => null ],
            [ "code" => "GNB", "name" => "Guinea-Bissau", "states" => null ],
            [ "code" => "GUY", "name" => "Guyana", "states" => null ],
            [ "code" => "HTI", "name" => "Haiti", "states" => null ],
            [ "code" => "HMD", "name" => "Heard Island and McDonald Islands", "states" => null ],
            [ "code" => "VAT", "name" => "Holy See", "states" => null ],
            [ "code" => "HND", "name" => "Honduras", "states" => null ],
            [ "code" => "HUN", "name" => "Hungary", "states" => null ],
            [ "code" => "ISL", "name" => "Iceland", "states" => null ],
            [ "code" => "IND", "name" => "India", "states" => json_encode($statesIndia) ],
            [ "code" => "IDN", "name" => "Indonesia", "states" => null ],
            [ "code" => "IRN", "name" => "Iran (Islamic Republic of)", "states" => null ],
            [ "code" => "IRQ", "name" => "Iraq", "states" => null ],
            [ "code" => "IRL", "name" => "Ireland", "states" => null ],
            [ "code" => "IMN", "name" => "Isle of Man", "states" => null ],
            [ "code" => "ISR", "name" => "Israel", "states" => null ],
            [ "code" => "ITA", "name" => "Italy", "states" => null ],
            [ "code" => "JAM", "name" => "Jamaica", "states" => null ],
            [ "code" => "JPN", "name" => "Japan", "states" => null ],
            [ "code" => "JEY", "name" => "Jersey", "states" => null ],
            [ "code" => "JOR", "name" => "Jordan", "states" => null ],
            [ "code" => "KAZ", "name" => "Kazakhstan", "states" => null ],
            [ "code" => "KEN", "name" => "Kenya", "states" => null ],
            [ "code" => "KIR", "name" => "Kiribati", "states" => null ],
            [ "code" => "KWT", "name" => "Kuwait", "states" => null ],
            [ "code" => "KGZ", "name" => "Kyrgyzstan", "states" => null ],
            [ "code" => "LAO", "name" => "Lao People's Democratic Republic", "states" => null ],
            [ "code" => "LVA", "name" => "Latvia", "states" => null ],
            [ "code" => "LBN", "name" => "Lebanon", "states" => null ],
            [ "code" => "LSO", "name" => "Lesotho", "states" => null ],
            [ "code" => "LBR", "name" => "Liberia", "states" => null ],
            [ "code" => "LBY", "name" => "Libya", "states" => null ],
            [ "code" => "LIE", "name" => "Liechtenstein", "states" => null ],
            [ "code" => "LTU", "name" => "Lithuania", "states" => null ],
            [ "code" => "LUX", "name" => "Luxembourg", "states" => null ],
            [ "code" => "MDG", "name" => "Madagascar", "states" => null ],
            [ "code" => "MWI", "name" => "Malawi", "states" => null ],
            [ "code" => "MYS", "name" => "Malaysia", "states" => null ],
            [ "code" => "MDV", "name" => "Maldives", "states" => null ],
            [ "code" => "MLI", "name" => "Mali", "states" => null ],
            [ "code" => "MLT", "name" => "Malta", "states" => null ],
            [ "code" => "MHL", "name" => "Marshall Islands", "states" => null ],
            [ "code" => "MTQ", "name" => "Martinique", "states" => null ],
            [ "code" => "MRT", "name" => "Mauritania", "states" => null ],
            [ "code" => "MUS", "name" => "Mauritius", "states" => null ],
            [ "code" => "MYT", "name" => "Mayotte", "states" => null ],
            [ "code" => "MEX", "name" => "Mexico", "states" => null ],
            [ "code" => "FSM", "name" => "Micronesia (Federated States of)", "states" => null ],
            [ "code" => "MCO", "name" => "Monaco", "states" => null ],
            [ "code" => "MNG", "name" => "Mongolia", "states" => null ],
            [ "code" => "MNE", "name" => "Montenegro", "states" => null ],
            [ "code" => "MSR", "name" => "Montserrat", "states" => null ],
            [ "code" => "MAR", "name" => "Morocco", "states" => null ],
            [ "code" => "MOZ", "name" => "Mozambique", "states" => null ],
            [ "code" => "MMR", "name" => "Myanmar", "states" => null ],
            [ "code" => "NAM", "name" => "Namibia", "states" => null ],
            [ "code" => "NRU", "name" => "Nauru", "states" => null ],
            [ "code" => "NPL", "name" => "Nepal", "states" => null ],
            [ "code" => "NLD", "name" => "Netherlands", "states" => null ],
            [ "code" => "NCL", "name" => "New Caledonia", "states" => null ],
            [ "code" => "NZL", "name" => "New Zealand", "states" => null ],
            [ "code" => "NIC", "name" => "Nicaragua", "states" => null ],
            [ "code" => "NER", "name" => "Niger", "states" => null ],
            [ "code" => "NGA", "name" => "Nigeria", "states" => null ],
            [ "code" => "NIU", "name" => "Niue", "states" => null ],
            [ "code" => "NFK", "name" => "Norfolk Island", "states" => null ],
            [ "code" => "MKD", "name" => "North Macedonia", "states" => null ],
            [ "code" => "MNP", "name" => "Northern Mariana Islands", "states" => null ],
            [ "code" => "NOR", "name" => "Norway", "states" => null ],
            [ "code" => "OMN", "name" => "Oman", "states" => null ],
            [ "code" => "PAK", "name" => "Pakistan", "states" => null ],
            [ "code" => "PLW", "name" => "Palau", "states" => null ],
            [ "code" => "PAN", "name" => "Panama", "states" => null ],
            [ "code" => "PNG", "name" => "Papua New Guinea", "states" => null ],
            [ "code" => "PRY", "name" => "Paraguay", "states" => null ],
            [ "code" => "PER", "name" => "Peru", "states" => null ],
            [ "code" => "PHL", "name" => "Philippines", "states" => null ],
            [ "code" => "PCN", "name" => "Pitcairn", "states" => null ],
            [ "code" => "POL", "name" => "Poland", "states" => null ],
            [ "code" => "PRT", "name" => "Portugal", "states" => null ],
            [ "code" => "PRI", "name" => "Puerto Rico", "states" => null ],
            [ "code" => "QAT", "name" => "Qatar", "states" => null ],
            [ "code" => "KOR", "name" => "Republic of Korea", "states" => null ],
            [ "code" => "MDA", "name" => "Republic of Moldova", "states" => null ],
            [ "code" => "REU", "name" => "Réunion", "states" => null ],
            [ "code" => "ROU", "name" => "Romania", "states" => null ],
            [ "code" => "RUS", "name" => "Russian Federation", "states" => null ],
            [ "code" => "RWA", "name" => "Rwanda", "states" => null ],
            [ "code" => "BLM", "name" => "Saint Barthélemy", "states" => null ],
            [ "code" => "SHN", "name" => "Saint Helena", "states" => null ],
            [ "code" => "KNA", "name" => "Saint Kitts and Nevis", "states" => null ],
            [ "code" => "LCA", "name" => "Saint Lucia", "states" => null ],
            [ "code" => "MAF", "name" => "Saint Martin (French Part)", "states" => null ],
            [ "code" => "SPM", "name" => "Saint Pierre and Miquelon", "states" => null ],
            [ "code" => "VCT", "name" => "Saint Vincent and the Grenadines", "states" => null ],
            [ "code" => "WSM", "name" => "Samoa", "states" => null ],
            [ "code" => "SMR", "name" => "San Marino", "states" => null ],
            [ "code" => "STP", "name" => "Sao Tome and Principe", "states" => null ],
            [ "code" => "   ", "name" => "Sark", "states" => null ],
            [ "code" => "SAU", "name" => "Saudi Arabia", "states" => null ],
            [ "code" => "SEN", "name" => "Senegal", "states" => null ],
            [ "code" => "SRB", "name" => "Serbia", "states" => null ],
            [ "code" => "SYC", "name" => "Seychelles", "states" => null ],
            [ "code" => "SLE", "name" => "Sierra Leone", "states" => null ],
            [ "code" => "SGP", "name" => "Singapore", "states" => null ],
            [ "code" => "SXM", "name" => "Sint Maarten (Dutch part)", "states" => null ],
            [ "code" => "SVK", "name" => "Slovakia", "states" => null ],
            [ "code" => "SVN", "name" => "Slovenia", "states" => null ],
            [ "code" => "SLB", "name" => "Solomon Islands", "states" => null ],
            [ "code" => "SOM", "name" => "Somalia", "states" => null ],
            [ "code" => "ZAF", "name" => "South Africa", "states" => null ],
            [ "code" => "SGS", "name" => "South Georgia and the South Sandwich Islands", "states" => null ],
            [ "code" => "SSD", "name" => "South Sudan", "states" => null ],
            [ "code" => "ESP", "name" => "Spain", "states" => null ],
            [ "code" => "LKA", "name" => "Sri Lanka", "states" => null ],
            [ "code" => "PSE", "name" => "State of Palestine", "states" => null ],
            [ "code" => "SDN", "name" => "Sudan", "states" => null ],
            [ "code" => "SUR", "name" => "Suriname", "states" => null ],
            [ "code" => "SJM", "name" => "Svalbard and Jan Mayen Islands", "states" => null ],
            [ "code" => "SWE", "name" => "Sweden", "states" => null ],
            [ "code" => "CHE", "name" => "Switzerland", "states" => null ],
            [ "code" => "SYR", "name" => "Syrian Arab Republic", "states" => null ],
            [ "code" => "TJK", "name" => "Tajikistan", "states" => null ],
            [ "code" => "THA", "name" => "Thailand", "states" => null ],
            [ "code" => "TLS", "name" => "Timor-Leste", "states" => null ],
            [ "code" => "TGO", "name" => "Togo", "states" => null ],
            [ "code" => "TKL", "name" => "Tokelau", "states" => null ],
            [ "code" => "TON", "name" => "Tonga", "states" => null ],
            [ "code" => "TTO", "name" => "Trinidad and Tobago", "states" => null ],
            [ "code" => "TUN", "name" => "Tunisia", "states" => null ],
            [ "code" => "TUR", "name" => "Türkiye", "states" => null ],
            [ "code" => "TKM", "name" => "Turkmenistan", "states" => null ],
            [ "code" => "TCA", "name" => "Turks and Caicos Islands", "states" => null ],
            [ "code" => "TUV", "name" => "Tuvalu", "states" => null ],
            [ "code" => "UGA", "name" => "Uganda", "states" => null ],
            [ "code" => "UKR", "name" => "Ukraine", "states" => null ],
            [ "code" => "ARE", "name" => "United Arab Emirates", "states" => null ],
            [ "code" => "GBR", "name" => "United Kingdom of Great Britain and Northern Ireland", "states" => null ],
            [ "code" => "TZA", "name" => "United Republic of Tanzania", "states" => null ],
            [ "code" => "UMI", "name" => "United States Minor Outlying Islands", "states" => null ],
            [ "code" => "USA", "name" => "United States of America", "states" => json_encode($StatesUSA) ],
            [ "code" => "VIR", "name" => "United States Virgin Islands", "states" => null ],
            [ "code" => "URY", "name" => "Uruguay", "states" => null ],
            [ "code" => "UZB", "name" => "Uzbekistan", "states" => null ],
            [ "code" => "VUT", "name" => "Vanuatu", "states" => null ],
            [ "code" => "VEN", "name" => "Venezuela (Bolivarian Republic of)", "states" => null ],
            [ "code" => "VNM", "name" => "Viet Nam", "states" => null ],
            [ "code" => "WLF", "name" => "Wallis and Futuna Islands", "states" => null ],
            [ "code" => "ESH", "name" => "Western Sahara", "states" => null ],
            [ "code" => "YEM", "name" => "Yemen", "states" => null ],
            [ "code" => "ZMB", "name" => "Zambia", "states" => null ],
            [ "code" => "ZWE", "name" => "Zimbabwe", "states" => null ],
        ];

        Country::insert($countries);
    }
}
