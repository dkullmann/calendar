<?php
App::import('Lib', 'Calendar.CalendarDate');
/**
 * TimeZone Helper class file.
 *
 * PHP versions 5
 *
 */

/**
 * TimeZone Helper class for easy use of timezone manipulation.
 *
 * Manipulation of timezone data.
 *
 */ 
class TimeZoneHelper extends AppHelper {
/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Form', 'Time');

/**
 * List of time zones and descriptive names
 * 
 * @var array
 */
	public $timeZones = array(
	    "America/Atka" => "America/Atka (Hawaii-Aleutian Standard Time)",
		"America/Anchorage" => "America/Anchorage (Alaska Standard Time)",
		"America/Juneau" => "America/Juneau (Alaska Standard Time)",
		"America/Nome" => "America/Nome (Alaska Standard Time)",
		"America/Yakutat" => "America/Yakutat (Alaska Standard Time)",
		"America/Dawson" => "America/Dawson (Pacific Standard Time)",
		"America/Ensenada" => "America/Ensenada (Pacific Standard Time)",
		"America/Los_Angeles" => "America/Los_Angeles (Pacific Standard Time)",
		"America/Tijuana" => "America/Tijuana (Pacific Standard Time)",
		"America/Vancouver" => "America/Vancouver (Pacific Standard Time)",
		"America/Whitehorse" => "America/Whitehorse (Pacific Standard Time)",
		"Canada/Pacific" => "Canada/Pacific (Pacific Standard Time)",
		"Canada/Yukon" => "Canada/Yukon (Pacific Standard Time)",
		"Mexico/BajaNorte" => "Mexico/BajaNorte (Pacific Standard Time)",
		"America/Boise" => "America/Boise (Mountain Standard Time)",
		"America/Cambridge_Bay" => "America/Cambridge_Bay (Mountain Standard Time)",
		"America/Chihuahua" => "America/Chihuahua (Mountain Standard Time)",
		"America/Dawson_Creek" => "America/Dawson_Creek (Mountain Standard Time)",
		"America/Denver" => "America/Denver (Mountain Standard Time)",
		"America/Edmonton" => "America/Edmonton (Mountain Standard Time)",
		"America/Hermosillo" => "America/Hermosillo (Mountain Standard Time)",
		"America/Inuvik" => "America/Inuvik (Mountain Standard Time)",
		"America/Mazatlan" => "America/Mazatlan (Mountain Standard Time)",
		"America/Phoenix" => "America/Phoenix (Mountain Standard Time)",
		"America/Shiprock" => "America/Shiprock (Mountain Standard Time)",
		"America/Yellowknife" => "America/Yellowknife (Mountain Standard Time)",
		"Canada/Mountain" => "Canada/Mountain (Mountain Standard Time)",
		"Mexico/BajaSur" => "Mexico/BajaSur (Mountain Standard Time)",
		"America/Belize" => "America/Belize (Central Standard Time)",
		"America/Cancun" => "America/Cancun (Central Standard Time)",
		"America/Chicago" => "America/Chicago (Central Standard Time)",
		"America/Costa_Rica" => "America/Costa_Rica (Central Standard Time)",
		"America/El_Salvador" => "America/El_Salvador (Central Standard Time)",
		"America/Guatemala" => "America/Guatemala (Central Standard Time)",
		"America/Knox_IN" => "America/Knox_IN (Central Standard Time)",
		"America/Managua" => "America/Managua (Central Standard Time)",
		"America/Menominee" => "America/Menominee (Central Standard Time)",
		"America/Merida" => "America/Merida (Central Standard Time)",
		"America/Mexico_City" => "America/Mexico_City (Central Standard Time)",
		"America/Monterrey" => "America/Monterrey (Central Standard Time)",
		"America/Rainy_River" => "America/Rainy_River (Central Standard Time)",
		"America/Rankin_Inlet" => "America/Rankin_Inlet (Central Standard Time)",
		"America/Regina" => "America/Regina (Central Standard Time)",
		"America/Swift_Current" => "America/Swift_Current (Central Standard Time)",
		"America/Tegucigalpa" => "America/Tegucigalpa (Central Standard Time)",
		"America/Winnipeg" => "America/Winnipeg (Central Standard Time)",
		"Canada/Central" => "Canada/Central (Central Standard Time)",
		"Canada/East-Saskatchewan" => "Canada/East-Saskatchewan (Central Standard Time)",
		"Canada/Saskatchewan" => "Canada/Saskatchewan (Central Standard Time)",
		"Chile/EasterIsland" => "Chile/EasterIsland (Easter Is. Time)",
		"Mexico/General" => "Mexico/General (Central Standard Time)",
		"America/Atikokan" => "America/Atikokan (Eastern Standard Time)",
		"America/Bogota" => "America/Bogota (Colombia Time)",
		"America/Cayman" => "America/Cayman (Eastern Standard Time)",
		"America/Coral_Harbour" => "America/Coral_Harbour (Eastern Standard Time)",
		"America/Detroit" => "America/Detroit (Eastern Standard Time)",
		"America/Fort_Wayne" => "America/Fort_Wayne (Eastern Standard Time)",
		"America/Grand_Turk" => "America/Grand_Turk (Eastern Standard Time)",
		"America/Guayaquil" => "America/Guayaquil (Ecuador Time)",
		"America/Havana" => "America/Havana (Cuba Standard Time)",
		"America/Indianapolis" => "America/Indianapolis (Eastern Standard Time)",
		"America/Iqaluit" => "America/Iqaluit (Eastern Standard Time)",
		"America/Jamaica" => "America/Jamaica (Eastern Standard Time)",
		"America/Lima" => "America/Lima (Peru Time)",
		"America/Louisville" => "America/Louisville (Eastern Standard Time)",
		"America/Montreal" => "America/Montreal (Eastern Standard Time)",
		"America/Nassau" => "America/Nassau (Eastern Standard Time)",
		"America/New_York" => "America/New_York (Eastern Standard Time)",
		"America/Nipigon" => "America/Nipigon (Eastern Standard Time)",
		"America/Panama" => "America/Panama (Eastern Standard Time)",
		"America/Pangnirtung" => "America/Pangnirtung (Eastern Standard Time)",
		"America/Port-au-Prince" => "America/Port-au-Prince (Eastern Standard Time)",
		"America/Resolute" => "America/Resolute (Eastern Standard Time)",
		"America/Thunder_Bay" => "America/Thunder_Bay (Eastern Standard Time)",
		"America/Toronto" => "America/Toronto (Eastern Standard Time)",
		"Canada/Eastern" => "Canada/Eastern (Eastern Standard Time)",
		"America/Caracas" => "America/Caracas (Venezuela Time)",
		"America/Anguilla" => "America/Anguilla (Atlantic Standard Time)",
		"America/Antigua" => "America/Antigua (Atlantic Standard Time)",
		"America/Aruba" => "America/Aruba (Atlantic Standard Time)",
		"America/Asuncion" => "America/Asuncion (Paraguay Time)",
		"America/Barbados" => "America/Barbados (Atlantic Standard Time)",
		"America/Blanc-Sablon" => "America/Blanc-Sablon (Atlantic Standard Time)",
		"America/Boa_Vista" => "America/Boa_Vista (Amazon Time)",
		"America/Campo_Grande" => "America/Campo_Grande (Amazon Time)",
		"America/Cuiaba" => "America/Cuiaba (Amazon Time)",
		"America/Curacao" => "America/Curacao (Atlantic Standard Time)",
		"America/Dominica" => "America/Dominica (Atlantic Standard Time)",
		"America/Eirunepe" => "America/Eirunepe (Amazon Time)",
		"America/Glace_Bay" => "America/Glace_Bay (Atlantic Standard Time)",
		"America/Goose_Bay" => "America/Goose_Bay (Atlantic Standard Time)",
		"America/Grenada" => "America/Grenada (Atlantic Standard Time)",
		"America/Guadeloupe" => "America/Guadeloupe (Atlantic Standard Time)",
		"America/Guyana" => "America/Guyana (Guyana Time)",
		"America/Halifax" => "America/Halifax (Atlantic Standard Time)",
		"America/La_Paz" => "America/La_Paz (Bolivia Time)",
		"America/Manaus" => "America/Manaus (Amazon Time)",
		"America/Marigot" => "America/Marigot (Atlantic Standard Time)",
		"America/Martinique" => "America/Martinique (Atlantic Standard Time)",
		"America/Moncton" => "America/Moncton (Atlantic Standard Time)",
		"America/Montserrat" => "America/Montserrat (Atlantic Standard Time)",
		"America/Port_of_Spain" => "America/Port_of_Spain (Atlantic Standard Time)",
		"America/Porto_Acre" => "America/Porto_Acre (Amazon Time)",
		"America/Porto_Velho" => "America/Porto_Velho (Amazon Time)",
		"America/Puerto_Rico" => "America/Puerto_Rico (Atlantic Standard Time)",
		"America/Rio_Branco" => "America/Rio_Branco (Amazon Time)",
		"America/Santiago" => "America/Santiago (Chile Time)",
		"America/Santo_Domingo" => "America/Santo_Domingo (Atlantic Standard Time)",
		"America/St_Barthelemy" => "America/St_Barthelemy (Atlantic Standard Time)",
		"America/St_Kitts" => "America/St_Kitts (Atlantic Standard Time)",
		"America/St_Lucia" => "America/St_Lucia (Atlantic Standard Time)",
		"America/St_Thomas" => "America/St_Thomas (Atlantic Standard Time)",
		"America/St_Vincent" => "America/St_Vincent (Atlantic Standard Time)",
		"America/Thule" => "America/Thule (Atlantic Standard Time)",
		"America/Tortola" => "America/Tortola (Atlantic Standard Time)",
		"America/Virgin" => "America/Virgin (Atlantic Standard Time)",
		"Antarctica/Palmer" => "Antarctica/Palmer (Chile Time)",
		"Atlantic/Bermuda" => "Atlantic/Bermuda (Atlantic Standard Time)",
		"Atlantic/Stanley" => "Atlantic/Stanley (Falkland Is. Time)",
		"Brazil/Acre" => "Brazil/Acre (Amazon Time)",
		"Brazil/West" => "Brazil/West (Amazon Time)",
		"Canada/Atlantic" => "Canada/Atlantic (Atlantic Standard Time)",
		"Chile/Continental" => "Chile/Continental (Chile Time)",
		"America/St_Johns" => "America/St_Johns (Newfoundland Standard Time)",
		"Canada/Newfoundland" => "Canada/Newfoundland (Newfoundland Standard Time)",
		"America/Araguaina" => "America/Araguaina (Brasilia Time)",
		"America/Bahia" => "America/Bahia (Brasilia Time)",
		"America/Belem" => "America/Belem (Brasilia Time)",
		"America/Buenos_Aires" => "America/Buenos_Aires (Argentine Time)",
		"America/Catamarca" => "America/Catamarca (Argentine Time)",
		"America/Cayenne" => "America/Cayenne (French Guiana Time)",
		"America/Cordoba" => "America/Cordoba (Argentine Time)",
		"America/Fortaleza" => "America/Fortaleza (Brasilia Time)",
		"America/Godthab" => "America/Godthab (Western Greenland Time)",
		"America/Jujuy" => "America/Jujuy (Argentine Time)",
		"America/Maceio" => "America/Maceio (Brasilia Time)",
		"America/Mendoza" => "America/Mendoza (Argentine Time)",
		"America/Miquelon" => "America/Miquelon (Pierre & Miquelon Standard Time)",
		"America/Montevideo" => "America/Montevideo (Uruguay Time)",
		"America/Paramaribo" => "America/Paramaribo (Suriname Time)",
		"America/Recife" => "America/Recife (Brasilia Time)",
		"America/Rosario" => "America/Rosario (Argentine Time)",
		"America/Santarem" => "America/Santarem (Brasilia Time)",
		"America/Sao_Paulo" => "America/Sao_Paulo (Brasilia Time)",
		"Antarctica/Rothera" => "Antarctica/Rothera (Rothera Time)",
		"Brazil/East" => "Brazil/East (Brasilia Time)",
		"America/Noronha" => "America/Noronha (Fernando de Noronha Time)",
		"Atlantic/South_Georgia" => "Atlantic/South_Georgia (South Georgia Standard Time)",
		"Brazil/DeNoronha" => "Brazil/DeNoronha (Fernando de Noronha Time)",
		"America/Scoresbysund" => "America/Scoresbysund (Eastern Greenland Time)",
		"Atlantic/Azores" => "Atlantic/Azores (Azores Time)",
		"Atlantic/Cape_Verde" => "Atlantic/Cape_Verde (Cape Verde Time)",
		"Africa/Abidjan" => "Africa/Abidjan (Greenwich Mean Time)",
		"Africa/Accra" => "Africa/Accra (Ghana Mean Time)",
		"Africa/Bamako" => "Africa/Bamako (Greenwich Mean Time)",
		"Africa/Banjul" => "Africa/Banjul (Greenwich Mean Time)",
		"Africa/Bissau" => "Africa/Bissau (Greenwich Mean Time)",
		"Africa/Casablanca" => "Africa/Casablanca (Western European Time)",
		"Africa/Conakry" => "Africa/Conakry (Greenwich Mean Time)",
		"Africa/Dakar" => "Africa/Dakar (Greenwich Mean Time)",
		"Africa/El_Aaiun" => "Africa/El_Aaiun (Western European Time)",
		"Africa/Freetown" => "Africa/Freetown (Greenwich Mean Time)",
		"Africa/Lome" => "Africa/Lome (Greenwich Mean Time)",
		"Africa/Monrovia" => "Africa/Monrovia (Greenwich Mean Time)",
		"Africa/Nouakchott" => "Africa/Nouakchott (Greenwich Mean Time)",
		"Africa/Ouagadougou" => "Africa/Ouagadougou (Greenwich Mean Time)",
		"Africa/Sao_Tome" => "Africa/Sao_Tome (Greenwich Mean Time)",
		"Africa/Timbuktu" => "Africa/Timbuktu (Greenwich Mean Time)",
		"America/Danmarkshavn" => "America/Danmarkshavn (Greenwich Mean Time)",
		"Atlantic/Canary" => "Atlantic/Canary (Western European Time)",
		"Atlantic/Faeroe" => "Atlantic/Faeroe (Western European Time)",
		"Atlantic/Faroe" => "Atlantic/Faroe (Western European Time)",
		"Atlantic/Madeira" => "Atlantic/Madeira (Western European Time)",
		"Atlantic/Reykjavik" => "Atlantic/Reykjavik (Greenwich Mean Time)",
		"Atlantic/St_Helena" => "Atlantic/St_Helena (Greenwich Mean Time)",
		"Europe/Belfast" => "Europe/Belfast (Greenwich Mean Time)",
		"Europe/Dublin" => "Europe/Dublin (Greenwich Mean Time)",
		"Europe/Guernsey" => "Europe/Guernsey (Greenwich Mean Time)",
		"Europe/Isle_of_Man" => "Europe/Isle_of_Man (Greenwich Mean Time)",
		"Europe/Jersey" => "Europe/Jersey (Greenwich Mean Time)",
		"Europe/Lisbon" => "Europe/Lisbon (Western European Time)",
		"Europe/London" => "Europe/London (Greenwich Mean Time)",
		"Africa/Algiers" => "Africa/Algiers (Central European Time)",
		"Africa/Bangui" => "Africa/Bangui (Western African Time)",
		"Africa/Brazzaville" => "Africa/Brazzaville (Western African Time)",
		"Africa/Ceuta" => "Africa/Ceuta (Central European Time)",
		"Africa/Douala" => "Africa/Douala (Western African Time)",
		"Africa/Kinshasa" => "Africa/Kinshasa (Western African Time)",
		"Africa/Lagos" => "Africa/Lagos (Western African Time)",
		"Africa/Libreville" => "Africa/Libreville (Western African Time)",
		"Africa/Luanda" => "Africa/Luanda (Western African Time)",
		"Africa/Malabo" => "Africa/Malabo (Western African Time)",
		"Africa/Ndjamena" => "Africa/Ndjamena (Western African Time)",
		"Africa/Niamey" => "Africa/Niamey (Western African Time)",
		"Africa/Porto-Novo" => "Africa/Porto-Novo (Western African Time)",
		"Africa/Tunis" => "Africa/Tunis (Central European Time)",
		"Africa/Windhoek" => "Africa/Windhoek (Western African Time)",
		"Arctic/Longyearbyen" => "Arctic/Longyearbyen (Central European Time)",
		"Atlantic/Jan_Mayen" => "Atlantic/Jan_Mayen (Central European Time)",
		"Europe/Amsterdam" => "Europe/Amsterdam (Central European Time)",
		"Europe/Andorra" => "Europe/Andorra (Central European Time)",
		"Europe/Belgrade" => "Europe/Belgrade (Central European Time)",
		"Europe/Berlin" => "Europe/Berlin (Central European Time)",
		"Europe/Bratislava" => "Europe/Bratislava (Central European Time)",
		"Europe/Brussels" => "Europe/Brussels (Central European Time)",
		"Europe/Budapest" => "Europe/Budapest (Central European Time)",
		"Europe/Copenhagen" => "Europe/Copenhagen (Central European Time)",
		"Europe/Gibraltar" => "Europe/Gibraltar (Central European Time)",
		"Europe/Ljubljana" => "Europe/Ljubljana (Central European Time)",
		"Europe/Luxembourg" => "Europe/Luxembourg (Central European Time)",
		"Europe/Madrid" => "Europe/Madrid (Central European Time)",
		"Europe/Malta" => "Europe/Malta (Central European Time)",
		"Europe/Monaco" => "Europe/Monaco (Central European Time)",
		"Europe/Oslo" => "Europe/Oslo (Central European Time)",
		"Europe/Paris" => "Europe/Paris (Central European Time)",
		"Europe/Podgorica" => "Europe/Podgorica (Central European Time)",
		"Europe/Prague" => "Europe/Prague (Central European Time)",
		"Europe/Rome" => "Europe/Rome (Central European Time)",
		"Europe/San_Marino" => "Europe/San_Marino (Central European Time)",
		"Europe/Sarajevo" => "Europe/Sarajevo (Central European Time)",
		"Europe/Skopje" => "Europe/Skopje (Central European Time)",
		"Europe/Stockholm" => "Europe/Stockholm (Central European Time)",
		"Europe/Tirane" => "Europe/Tirane (Central European Time)",
		"Europe/Vaduz" => "Europe/Vaduz (Central European Time)",
		"Europe/Vatican" => "Europe/Vatican (Central European Time)",
		"Europe/Vienna" => "Europe/Vienna (Central European Time)",
		"Europe/Warsaw" => "Europe/Warsaw (Central European Time)",
		"Europe/Zagreb" => "Europe/Zagreb (Central European Time)",
		"Europe/Zurich" => "Europe/Zurich (Central European Time)",
		"Africa/Blantyre" => "Africa/Blantyre (Central African Time)",
		"Africa/Bujumbura" => "Africa/Bujumbura (Central African Time)",
		"Africa/Cairo" => "Africa/Cairo (Eastern European Time)",
		"Africa/Gaborone" => "Africa/Gaborone (Central African Time)",
		"Africa/Harare" => "Africa/Harare (Central African Time)",
		"Africa/Johannesburg" => "Africa/Johannesburg (South Africa Standard Time)",
		"Africa/Kigali" => "Africa/Kigali (Central African Time)",
		"Africa/Lubumbashi" => "Africa/Lubumbashi (Central African Time)",
		"Africa/Lusaka" => "Africa/Lusaka (Central African Time)",
		"Africa/Maputo" => "Africa/Maputo (Central African Time)",
		"Africa/Maseru" => "Africa/Maseru (South Africa Standard Time)",
		"Africa/Mbabane" => "Africa/Mbabane (South Africa Standard Time)",
		"Africa/Tripoli" => "Africa/Tripoli (Eastern European Time)",
		"Asia/Amman" => "Asia/Amman (Eastern European Time)",
		"Asia/Beirut" => "Asia/Beirut (Eastern European Time)",
		"Asia/Damascus" => "Asia/Damascus (Eastern European Time)",
		"Asia/Gaza" => "Asia/Gaza (Eastern European Time)",
		"Asia/Istanbul" => "Asia/Istanbul (Eastern European Time)",
		"Asia/Jerusalem" => "Asia/Jerusalem (Israel Standard Time)",
		"Asia/Nicosia" => "Asia/Nicosia (Eastern European Time)",
		"Asia/Tel_Aviv" => "Asia/Tel_Aviv (Israel Standard Time)",
		"Europe/Athens" => "Europe/Athens (Eastern European Time)",
		"Europe/Bucharest" => "Europe/Bucharest (Eastern European Time)",
		"Europe/Chisinau" => "Europe/Chisinau (Eastern European Time)",
		"Europe/Helsinki" => "Europe/Helsinki (Eastern European Time)",
		"Europe/Istanbul" => "Europe/Istanbul (Eastern European Time)",
		"Europe/Kaliningrad" => "Europe/Kaliningrad (Eastern European Time)",
		"Europe/Kiev" => "Europe/Kiev (Eastern European Time)",
		"Europe/Mariehamn" => "Europe/Mariehamn (Eastern European Time)",
		"Europe/Minsk" => "Europe/Minsk (Eastern European Time)",
		"Europe/Nicosia" => "Europe/Nicosia (Eastern European Time)",
		"Europe/Riga" => "Europe/Riga (Eastern European Time)",
		"Europe/Simferopol" => "Europe/Simferopol (Eastern European Time)",
		"Europe/Sofia" => "Europe/Sofia (Eastern European Time)",
		"Europe/Tallinn" => "Europe/Tallinn (Eastern European Time)",
		"Europe/Tiraspol" => "Europe/Tiraspol (Eastern European Time)",
		"Europe/Uzhgorod" => "Europe/Uzhgorod (Eastern European Time)",
		"Europe/Vilnius" => "Europe/Vilnius (Eastern European Time)",
		"Europe/Zaporozhye" => "Europe/Zaporozhye (Eastern European Time)",
		"Africa/Addis_Ababa" => "Africa/Addis_Ababa (Eastern African Time)",
		"Africa/Asmara" => "Africa/Asmara (Eastern African Time)",
		"Africa/Asmera" => "Africa/Asmera (Eastern African Time)",
		"Africa/Dar_es_Salaam" => "Africa/Dar_es_Salaam (Eastern African Time)",
		"Africa/Djibouti" => "Africa/Djibouti (Eastern African Time)",
		"Africa/Kampala" => "Africa/Kampala (Eastern African Time)",
		"Africa/Khartoum" => "Africa/Khartoum (Eastern African Time)",
		"Africa/Mogadishu" => "Africa/Mogadishu (Eastern African Time)",
		"Africa/Nairobi" => "Africa/Nairobi (Eastern African Time)",
		"Antarctica/Syowa" => "Antarctica/Syowa (Syowa Time)",
		"Asia/Aden" => "Asia/Aden (Arabia Standard Time)",
		"Asia/Baghdad" => "Asia/Baghdad (Arabia Standard Time)",
		"Asia/Bahrain" => "Asia/Bahrain (Arabia Standard Time)",
		"Asia/Kuwait" => "Asia/Kuwait (Arabia Standard Time)",
		"Asia/Qatar" => "Asia/Qatar (Arabia Standard Time)",
		"Europe/Moscow" => "Europe/Moscow (Moscow Standard Time)",
		"Europe/Volgograd" => "Europe/Volgograd (Volgograd Time)",
		"Indian/Antananarivo" => "Indian/Antananarivo (Eastern African Time)",
		"Indian/Comoro" => "Indian/Comoro (Eastern African Time)",
		"Indian/Mayotte" => "Indian/Mayotte (Eastern African Time)",
		"Asia/Tehran" => "Asia/Tehran (Iran Standard Time)",
		"Asia/Baku" => "Asia/Baku (Azerbaijan Time)",
		"Asia/Dubai" => "Asia/Dubai (Gulf Standard Time)",
		"Asia/Muscat" => "Asia/Muscat (Gulf Standard Time)",
		"Asia/Tbilisi" => "Asia/Tbilisi (Georgia Time)",
		"Asia/Yerevan" => "Asia/Yerevan (Armenia Time)",
		"Europe/Samara" => "Europe/Samara (Samara Time)",
		"Indian/Mahe" => "Indian/Mahe (Seychelles Time)",
		"Indian/Mauritius" => "Indian/Mauritius (Mauritius Time)",
		"Indian/Reunion" => "Indian/Reunion (Reunion Time)",
		"Asia/Kabul" => "Asia/Kabul (Afghanistan Time)",
		"Asia/Aqtau" => "Asia/Aqtau (Aqtau Time)",
		"Asia/Aqtobe" => "Asia/Aqtobe (Aqtobe Time)",
		"Asia/Ashgabat" => "Asia/Ashgabat (Turkmenistan Time)",
		"Asia/Ashkhabad" => "Asia/Ashkhabad (Turkmenistan Time)",
		"Asia/Dushanbe" => "Asia/Dushanbe (Tajikistan Time)",
		"Asia/Karachi" => "Asia/Karachi (Pakistan Time)",
		"Asia/Oral" => "Asia/Oral (Oral Time)",
		"Asia/Samarkand" => "Asia/Samarkand (Uzbekistan Time)",
		"Asia/Tashkent" => "Asia/Tashkent (Uzbekistan Time)",
		"Asia/Yekaterinburg" => "Asia/Yekaterinburg (Yekaterinburg Time)",
		"Indian/Kerguelen" => "Indian/Kerguelen (French Southern & Antarctic Lands Time)",
		"Indian/Maldives" => "Indian/Maldives (Maldives Time)",
		"Asia/Calcutta" => "Asia/Calcutta (India Standard Time)",
		"Asia/Colombo" => "Asia/Colombo (India Standard Time)",
		"Asia/Kolkata" => "Asia/Kolkata (India Standard Time)",
		"Asia/Katmandu" => "Asia/Katmandu (Nepal Time)",
		"Antarctica/Mawson" => "Antarctica/Mawson (Mawson Time)",
		"Antarctica/Vostok" => "Antarctica/Vostok (Vostok Time)",
		"Asia/Almaty" => "Asia/Almaty (Alma-Ata Time)",
		"Asia/Bishkek" => "Asia/Bishkek (Kirgizstan Time)",
		"Asia/Dacca" => "Asia/Dacca (Bangladesh Time)",
		"Asia/Dhaka" => "Asia/Dhaka (Bangladesh Time)",
		"Asia/Novosibirsk" => "Asia/Novosibirsk (Novosibirsk Time)",
		"Asia/Omsk" => "Asia/Omsk (Omsk Time)",
		"Asia/Qyzylorda" => "Asia/Qyzylorda (Qyzylorda Time)",
		"Asia/Thimbu" => "Asia/Thimbu (Bhutan Time)",
		"Asia/Thimphu" => "Asia/Thimphu (Bhutan Time)",
		"Indian/Chagos" => "Indian/Chagos (Indian Ocean Territory Time)",
		"Asia/Rangoon" => "Asia/Rangoon (Myanmar Time)",
		"Indian/Cocos" => "Indian/Cocos (Cocos Islands Time)",
		"Antarctica/Davis" => "Antarctica/Davis (Davis Time)",
		"Asia/Bangkok" => "Asia/Bangkok (Indochina Time)",
		"Asia/Ho_Chi_Minh" => "Asia/Ho_Chi_Minh (Indochina Time)",
		"Asia/Hovd" => "Asia/Hovd (Hovd Time)",
		"Asia/Jakarta" => "Asia/Jakarta (West Indonesia Time)",
		"Asia/Krasnoyarsk" => "Asia/Krasnoyarsk (Krasnoyarsk Time)",
		"Asia/Phnom_Penh" => "Asia/Phnom_Penh (Indochina Time)",
		"Asia/Pontianak" => "Asia/Pontianak (West Indonesia Time)",
		"Asia/Saigon" => "Asia/Saigon (Indochina Time)",
		"Asia/Vientiane" => "Asia/Vientiane (Indochina Time)",
		"Indian/Christmas" => "Indian/Christmas (Christmas Island Time)",
		"Antarctica/Casey" => "Antarctica/Casey (Western Standard Time (Australia))",
		"Asia/Brunei" => "Asia/Brunei (Brunei Time)",
		"Asia/Choibalsan" => "Asia/Choibalsan (Choibalsan Time)",
		"Asia/Chongqing" => "Asia/Chongqing (China Standard Time)",
		"Asia/Chungking" => "Asia/Chungking (China Standard Time)",
		"Asia/Harbin" => "Asia/Harbin (China Standard Time)",
		"Asia/Hong_Kong" => "Asia/Hong_Kong (Hong Kong Time)",
		"Asia/Irkutsk" => "Asia/Irkutsk (Irkutsk Time)",
		"Asia/Kashgar" => "Asia/Kashgar (China Standard Time)",
		"Asia/Kuala_Lumpur" => "Asia/Kuala_Lumpur (Malaysia Time)",
		"Asia/Kuching" => "Asia/Kuching (Malaysia Time)",
		"Asia/Macao" => "Asia/Macao (China Standard Time)",
		"Asia/Macau" => "Asia/Macau (China Standard Time)",
		"Asia/Makassar" => "Asia/Makassar (Central Indonesia Time)",
		"Asia/Manila" => "Asia/Manila (Philippines Time)",
		"Asia/Shanghai" => "Asia/Shanghai (China Standard Time)",
		"Asia/Singapore" => "Asia/Singapore (Singapore Time)",
		"Asia/Taipei" => "Asia/Taipei (China Standard Time)",
		"Asia/Ujung_Pandang" => "Asia/Ujung_Pandang (Central Indonesia Time)",
		"Asia/Ulaanbaatar" => "Asia/Ulaanbaatar (Ulaanbaatar Time)",
		"Asia/Ulan_Bator" => "Asia/Ulan_Bator (Ulaanbaatar Time)",
		"Asia/Urumqi" => "Asia/Urumqi (China Standard Time)",
		"Australia/Perth" => "Australia/Perth (Western Standard Time (Australia))",
		"Australia/West" => "Australia/West (Western Standard Time (Australia))",
		"Australia/Eucla" => "Australia/Eucla (Central Western Standard Time (Australia))",
		"Asia/Dili" => "Asia/Dili (Timor-Leste Time)",
		"Asia/Jayapura" => "Asia/Jayapura (East Indonesia Time)",
		"Asia/Pyongyang" => "Asia/Pyongyang (Korea Standard Time)",
		"Asia/Seoul" => "Asia/Seoul (Korea Standard Time)",
		"Asia/Tokyo" => "Asia/Tokyo (Japan Standard Time)",
		"Asia/Yakutsk" => "Asia/Yakutsk (Yakutsk Time)",
		"Australia/Adelaide" => "Australia/Adelaide (Central Standard Time (South Australia))",
		"Australia/Broken_Hill" => "Australia/Broken_Hill (Central Standard Time (South Australia/New South Wales))",
		"Australia/Darwin" => "Australia/Darwin (Central Standard Time (Northern Territory))",
		"Australia/North" => "Australia/North (Central Standard Time (Northern Territory))",
		"Australia/South" => "Australia/South (Central Standard Time (South Australia))",
		"Australia/Yancowinna" => "Australia/Yancowinna (Central Standard Time (South Australia/New South Wales))",
		"Antarctica/DumontDUrville" => "Antarctica/DumontDUrville (Dumont-d'Urville Time)",
		"Asia/Sakhalin" => "Asia/Sakhalin (Sakhalin Time)",
		"Asia/Vladivostok" => "Asia/Vladivostok (Vladivostok Time)",
		"Australia/ACT" => "Australia/ACT (Eastern Standard Time (New South Wales))",
		"Australia/Brisbane" => "Australia/Brisbane (Eastern Standard Time (Queensland))",
		"Australia/Canberra" => "Australia/Canberra (Eastern Standard Time (New South Wales))",
		"Australia/Currie" => "Australia/Currie (Eastern Standard Time (New South Wales))",
		"Australia/Hobart" => "Australia/Hobart (Eastern Standard Time (Tasmania))",
		"Australia/Lindeman" => "Australia/Lindeman (Eastern Standard Time (Queensland))",
		"Australia/Melbourne" => "Australia/Melbourne (Eastern Standard Time (Victoria))",
		"Australia/NSW" => "Australia/NSW (Eastern Standard Time (New South Wales))",
		"Australia/Queensland" => "Australia/Queensland (Eastern Standard Time (Queensland))",
		"Australia/Sydney" => "Australia/Sydney (Eastern Standard Time (New South Wales))",
		"Australia/Tasmania" => "Australia/Tasmania (Eastern Standard Time (Tasmania))",
		"Australia/Victoria" => "Australia/Victoria (Eastern Standard Time (Victoria))",
		"Australia/LHI" => "Australia/LHI (Lord Howe Standard Time)",
		"Australia/Lord_Howe" => "Australia/Lord_Howe (Lord Howe Standard Time)",
		"Asia/Magadan" => "Asia/Magadan (Magadan Time)",
		"Antarctica/McMurdo" => "Antarctica/McMurdo (New Zealand Standard Time)",
		"Antarctica/South_Pole" => "Antarctica/South_Pole (New Zealand Standard Time)",
		"Asia/Anadyr" => "Asia/Anadyr (Anadyr Time)",
		"Asia/Kamchatka" => "Asia/Kamchatka (Petropavlovsk-Kamchatski Time)",
	);
/**
 * Constructor
 *
 * @return void
 */
	public function __construct($options = array()) {
		$defaults = array(
			'appTimeZone' => Configure::read('App.defaultTimezone'),
			'userTimeZone' => Configure::read('App.User.timeZone'),
		);
		parent::__construct($options);
		$this->__options = array_merge($defaults, $options); 
	}

/**
 * Utility function to re-index the array returned
 * from getTimeZones(). The $a is integer indexed
 * from the order of DateTimeZone::listIdentifiers()
 * so we need to reindex it to match proper formating
 *
 * @param array;
 * @return new indexed array;
 */
	protected function __format(array $array) {
		$i=0;
		foreach ($array as $key => $val) {
			if (is_array($val)) {
				foreach ($val as $a => $b) {
					$name = $b['name'];
					$vname = str_replace('_', ' ', end(explode('/', $name)));
					$offset = $b['offset'];
					$voffset = $offset / 3600;
					$vminutes = 0;
					if (strpos($voffset, '.')) {
						list($voffset, $vminutes) = explode('.', $voffset);
					}
					$vminutes *= 6;
					$vminutes = str_pad($vminutes, 2, '0');
					if ($voffset >= 0) {
						$voffset = '+' . $voffset;
					}
					$display = sprintf("%s - %s (GMT %s:%s)", $vname, $key, $voffset, $vminutes);
					$arr[] = array(
						'name' => $display,
						'value' => $name,
						'utc_offset' => $b['offset'],
					);
				}
			}
		}

		uasort($arr, function($a, $b) {
			return strcmp($a['name'], $b['name']);
		});

		return $arr;
	}

/**
 * Converts the timezone of UTC time in another timezone
 *
 * @param string Time in UTC format
 * @param timezone
 * @return string UTC time
 */
	public function convert($time, $fromTimeZone = null, $toTimeZone = null, $format = 'Y-m-d H:i:s') {
		if (empty($fromTimeZone)) {
			$fromTimeZone = $this->__options['appTimeZone'];
		}
		if (empty($toTimeZone)) {
			$toTimeZone = $this->__options['userTimeZone'];
		}
		return CalendarDate::convertTimeZone($time, $fromTimeZone, $toTimeZone, $format);
	}

	public function longFormat($time = null) {
		$time = CalendarDate::convertTimeZone($time, $this->__options['appTimeZone'], $this->__options['userTimeZone'], 'c');
		$string = CalendarDate::formatDate($time, 'D, M nS Y', $this->__options['userTimeZone']);
		$string .= ' at ';
		$string .= CalendarDate::formatDate($time, 'g:iA', $this->__options['userTimeZone']);
		return $string;
	}

/**
 * This function is similiar to the dateTime::listabbreviations method
 * but this one weeds out those time zones that are not recognized.
 *
 * @param none;
 * @return array; a multidimensional [country][time zone abreviation][city/offset]
 */
	public function getTimeZones() {
		$ident = DateTimeZone::listIdentifiers();
		$cntIdent = count($ident);

		for ($j = 0; $j < $cntIdent; $j++) {
			$date = new DateTime(null, new DateTimeZone($ident[$j]));
			$zoneFormat = $date->format('T');
			$tz = $date->getTimezone();
			$tzName = $tz->getName();
			$offset = $date->getOffset();

			$ex = explode('/', $tzName);
			$array[$ex[0]][$j] = array('name' => $tzName, 'offset' => $offset, 'format' => $zoneFormat);
		}
		return $this->__format($array);
	}

/**
 * Generates a select dropdown with a list of timezones
 *
 * @param string $fieldname Name of the field
 * @param array $options Classic FormHelper::input options extended with:
 *	- utc_offset: if true the UTC offset will be added in an "utc_offset" html attribute for each option
 * @return string Html markup for the dropdown
 */
	public function select($fieldname, $options = array()) {

		$DateTime = new DateTime();
		
		$pattern = '/(\S+?)\s*\((.+?)\)/';
		$replace = '$2 - $1';
		
		foreach ($this->timeZones as $timeZone => $description) {
			$DateTimeZone = new DateTimeZone($timeZone);
			$DateTime->setTimezone($DateTimeZone);
			$gmtOffset = $DateTime->format('P');
			
			$description = preg_replace($pattern, $replace, $description);
			
			$options[$timeZone] = sprintf('(GMT %s) %s', $gmtOffset, $description);
		}
		return $this->Form->input($fieldname, array(
			'empty' => 'Select your time zone',
			'type' => 'select',
			'options' => $options,
			)
		);
	}

}