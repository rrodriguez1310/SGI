"use strict";
var http = require('http');
var fs = require('fs');
var request = require('request');
var m = require('moment');
var tz = require('moment-timezone');
var path = require('path');
var f01s = require('../models/f01s');
var f40s = require('../models/f40s');
var posts = require('../models/posts');
var ned = require('./ned');
var altavoz = require('./altavoz');
var _ = require('lodash');

var paisesIdNed = {
    "argentina": "1",
    "españa": "2",
    "italia": "3",
    "bolivia": "4",
    "brasil": "5",
    "chile": "6",
    "colombia": "7",
    "ecuador": "8",
    "méxico": "9",
    "paraguay": "10",
    "per&uacute;": "11",
    "uruguay": "12",
    "venezuela": "13",
    "estados unidos": "14",
    "panamá": "15",
    "camerún": "16",
    "nueva zelanda": "17",
    "haití": "18",
    "australia": "19",
    "japón": "20",
    "armenia": "21",
    "costa rica": "22",
    "dinamarca": "23",
    "cuba": "24",
    "nigeria": "25",
    "alemania": "26",
    "angola": "27",
    "arabia saudita": "28",
    "costa de marfil": "29",
    "croacia": "30",
    "francia": "31",
    "ghana": "32",
    "holanda": "33",
    "inglaterra": "34",
    "ir&aacute;n": "35",
    "polonia": "36",
    "portugal": "37",
    "rep&uacute;blica checa": "38",
    "corea del sur": "39",
    "serbia y montenegro": "40",
    "suecia": "41",
    "suiza": "42",
    "togo": "43",
    "trinidad y tobago": "44",
    "t&uacute;nez": "45",
    "ucrania": "46",
    "b&eacute;lgica": "47",
    "rumania": "49",
    "yugoslavia": "50",
    "austria": "51",
    "checoslovaquia": "52",
    "egipto": "53",
    "hungr&iacute;a": "54",
    "indias holandesas": "55",
    "noruega": "56",
    "escocia": "57",
    "turqu&iacute;a": "58",
    "gales": "59",
    "irlanda del norte": "60",
    "rep&uacute;blica federal alemana": "62",
    "bulgaria": "63",
    "corea del norte": "64",
    "el salvador": "65",
    "israel": "66",
    "marruecos": "67",
    "rep&uacute;blica democr&aacute;tica alemana": "68",
    "zaire": "69",
    "argelia": "70",
    "honduras": "71",
    "kuwait": "72",
    "canadá": "73",
    "irak": "74",
    "emiratos arabes unidos": "75",
    "rep&uacute;blica de irlanda": "76",
    "grecia": "77",
    "rusia": "78",
    "jamaica": "79",
    "sudáfrica": "80",
    "eslovenia": "81",
    "china": "82",
    "senegal": "83",
    "l&iacute;bano": "84",
    "lituania": "85",
    "puerto rico": "86",
    "qatar": "87",
    "eslovaquia": "88",
    "mozambique": "89",
    "finlandia": "90",
    "república dominicana": "91",
    "malasia": "92",
    "guatemala": "93",
    "uganda": "94",
    "congo": "95",
    "gambia": "96",
    "jordania": "97",
    "zambia": "98",
    "islandia": "99",
    "serbia": "100",
    "montenegro": "101",
    "albania": "103",
    "bielorusia": "104",
    "chipre": "105",
    "letonia": "106",
    "tailandia": "107",
    "taipei": "108",
    "pakist&aacute;n": "109",
    "luxemburgo": "110",
    "uzbekist&aacute;n": "111",
    "surinam": "112",
    "georgia": "113",
    "bosnia": "114",
    "macedonia": "115",
    "namibia": "116",
    "siria": "118",
    "tajikistan": "119",
    "samoa": "120",
    "tonga": "121",
    "fiji": "122",
    "irlanda": "123",
    "seychelles": "124",
    "mali": "125",
    "guinea": "126",
    "gab&oacute;n": "127",
    "burkina faso": "128",
    "cabo verde": "129",
    "benin": "130",
    "islas salom&oacute;n": "131",
    "afganistán": "132",
    "andorra": "133",
    "aruba": "134",
    "bahamas": "135",
    "bangladesh": "136",
    "barbados": "137",
    "brunei": "138",
    "india": "139",
    "gran bretaña": "140",
    "antigua y barbuda": "141",
    "antillas holandesas": "142",
    "azerbaiyán": "143",
    "bahr&eacute;in": "144",
    "belice": "145",
    "bermudas": "146",
    "birmania": "147",
    "botsuana": "148",
    "burundi": "149",
    "but&aacute;n": "150",
    "camboya": "151",
    "chad": "152",
    "comoras": "153",
    "dominica": "154",
    "eritrea": "155",
    "estonia": "156",
    "etiop&iacute;a": "157",
    "filipinas": "158",
    //"gab&oacute;n": "159",
    "granada": "160",
    "guam": "161",
    "guinea ecuatorial": "162",
    "guinea bissau": "163",
    "guyana": "164",
    "hong kong": "165",
    "indonesia": "166",
    "islas caim&aacute;n": "167",
    "islas cook": "168",
    "islas marshall": "169",
    "islas vírgenes británicas": "170",
    "islas vírgenes estadounidenses": "171",
    "kazajist&aacute;n": "172",
    "kenia": "173",
    "kirguist&aacute;n": "174",
    "kiribati": "175",
    "laos": "176",
    "lesoto": "177",
    "liberia": "178",
    "libia": "179",
    "liechtenstein": "180",
    "macao": "181",
    "madagascar": "182",
    "malawi": "183",
    "maldivas": "184",
    "malta": "185",
    "mauricio": "186",
    "mauritania": "187",
    "micronesia": "188",
    "moldavia": "189",
    "m&oacute;naco": "190",
    "mongolia": "191",
    "nauru": "192",
    "nepal": "193",
    "nicaragua": "194",
    "n&iacute;ger": "195",
    "om&aacute;n": "196",
    "palaos": "197",
    "palestina": "198",
    "pap&uacute;a nueva guinea": "199",
    "rep&uacute;blica centroafricana": "200",
    "rep. del congo": "201",
    "ruanda": "202",
    "samoa americana": "203",
    "san marino": "205",
    "san vicente y las granadinas": "206",
    "santa lucía": "207",
    "santo tom&eacute; y pr&iacute;ncipe": "208",
    //"seychelles": "209",
    "sierra leona": "210",
    "singapur": "211",
    "somalia": "212",
    "sri lanka": "213",
    "suazilandia": "214",
    "sud&aacute;n": "215",
    "tanzania": "216",
    "timor oriental": "217",
    "turkmenist&aacute;n": "218",
    "tuvalu": "219",
    "vanuatu": "220",
    "vietnam": "221",
    "yemen": "222",
    "yibuti": "223",
    "zimbawe": "224",
    "islas feroe": "225",
    "guadalupe": "226",
    "tahit&iacute;": "227",
    "san cristóbal y nevis": "228",
    "guyana francesa": "231",
    "kosovo": "232",
    "nueva caledonia": "233",
    "curazao": "234",
    "martinica": "235",
    "anguila": "236",
    "sint maarten": "237",
    "saint martin": "238",
    "turcos y caicos": "239",
    "montserrat": "240",
    "bonaire": "241",
    "gibraltar": "242"
}

var paisesJson = {
    "aruba": "aruba",
    "afghanistan": "afganistán",
    "angola": "angola",
    "anguilla": "anguilla",
    "åland islands": "alandia",
    "albania": "albania",
    "andorra": "andorra",
    "united arab emirates": "emiratos árabes unidos",
    "argentina": "argentina",
    "armenia": "armenia",
    "american samoa": "samoa americana",
    "antarctica": "antártida",
    "french southern and antarctic lands": "tierras australes y antárticas francesas",
    "antigua and barbuda": "antigua y barbuda",
    "australia": "australia",
    "austria": "austria",
    "azerbaijan": "azerbaiyán",
    "burundi": "burundi",
    "belgium": "bélgica",
    "benin": "benín",
    "burkina faso": "burkina faso",
    "bangladesh": "bangladesh",
    "bulgaria": "bulgaria",
    "bahrain": "bahrein",
    "bahamas": "bahamas",
    "bosnia and herzegovina": "bosnia y herzegovina",
    "saint barthélemy": "san bartolomé",
    "belarus": "bielorrusia",
    "belize": "belice",
    "bermuda": "bermudas",
    "bolivia": "bolivia",
    "brazil": "brasil",
    "barbados": "barbados",
    "brunei": "brunei",
    "bhutan": "bután",
    "bouvet island": "isla bouvet",
    "botswana": "botswana",
    "central african republic": "república centroafricana",
    "canada": "canadá",
    "cocos (keeling) islands": "islas cocos o islas keeling",
    "switzerland": "suiza",
    "chile": "chile",
    "china": "china",
    "ivory coast": "costa de marfil",
    "cameroon": "camerún",
    "dr congo": "congo (rep. dem.)",
    "republic of the congo": "congo",
    "cook islands": "islas cook",
    "colombia": "colombia",
    "comoros": "comoras",
    "cape verde": "cabo verde",
    "costa rica": "costa rica",
    "cuba": "cuba",
    "curaçao": "curazao",
    "christmas island": "isla de navidad",
    "cayman islands": "islas caimán",
    "cyprus": "chipre",
    "czech republic": "república checa",
    "germany": "alemania",
    "djibouti": "djibouti",
    "dominica": "dominica",
    "denmark": "dinamarca",
    "dominican republic": "república dominicana",
    "algeria": "argelia",
    "ecuador": "ecuador",
    "egypt": "egipto",
    "eritrea": "eritrea",
    "western sahara": "sahara occidental",
    "spain": "españa",
    "estonia": "estonia",
    "ethiopia": "etiopía",
    "finland": "finlandia",
    "fiji": "fiyi",
    "falkland islands": "islas malvinas",
    "france": "francia",
    "faroe islands": "islas faroe",
    "micronesia": "micronesia",
    "gabon": "gabón",
    "united kingdom": "reino unido",
    "georgia": "georgia",
    "guernsey": "guernsey",
    "ghana": "ghana",
    "gibraltar": "gibraltar",
    "guinea": "guinea",
    "guadeloupe": "guadalupe",
    "gambia": "gambia",
    "guinea-bissau": "guinea-bisáu",
    "equatorial guinea": "guinea ecuatorial",
    "greece": "grecia",
    "grenada": "grenada",
    "greenland": "groenlandia",
    "guatemala": "guatemala",
    "french guiana": "guayana francesa",
    "guam": "guam",
    "guyana": "guyana",
    "hong kong": "hong kong",
    "heard island and mcdonald islands": "islas heard y mcdonald",
    "honduras": "honduras",
    "croatia": "croacia",
    "haiti": "haiti",
    "hungary": "hungría",
    "indonesia": "indonesia",
    "isle of man": "isla de man",
    "india": "india",
    "british indian ocean territory": "territorio británico del océano índico",
    "ireland": "irlanda",
    "iran": "iran",
    "iraq": "irak",
    "iceland": "islandia",
    "israel": "israel",
    "italy": "italia",
    "jamaica": "jamaica",
    "jersey": "jersey",
    "jordan": "jordania",
    "japan": "japón",
    "kazakhstan": "kazajistán",
    "kenya": "kenia",
    "kyrgyzstan": "kirguizistán",
    "cambodia": "camboya",
    "kiribati": "kiribati",
    "saint kitts and nevis": "san cristóbal y nieves",
    "south korea": "corea del sur",
    "kosovo": "kosovo",
    "kuwait": "kuwait",
    "laos": "laos",
    "lebanon": "líbano",
    "liberia": "liberia",
    "libya": "libia",
    "saint lucia": "santa lucía",
    "liechtenstein": "liechtenstein",
    "sri lanka": "sri lanka",
    "lesotho": "lesotho",
    "lithuania": "lituania",
    "luxembourg": "luxemburgo",
    "latvia": "letonia",
    "macau": "macao",
    "saint martin": "saint martin",
    "morocco": "marruecos",
    "monaco": "mónaco",
    "moldova": "moldavia",
    "madagascar": "madagascar",
    "maldives": "maldivas",
    "mexico": "méxico",
    "marshall islands": "islas marshall",
    "macedonia": "macedonia",
    "mali": "mali",
    "malta": "malta",
    "myanmar": "myanmar",
    "montenegro": "montenegro",
    "mongolia": "mongolia",
    "northern mariana islands": "islas marianas del norte",
    "mozambique": "mozambique",
    "mauritania": "mauritania",
    "montserrat": "montserrat",
    "martinique": "martinica",
    "mauritius": "mauricio",
    "malawi": "malawi",
    "malaysia": "malasia",
    "mayotte": "mayotte",
    "namibia": "namibia",
    "new caledonia": "nueva caledonia",
    "niger": "níger",
    "norfolk island": "isla de norfolk",
    "nigeria": "nigeria",
    "nicaragua": "nicaragua",
    "niue": "niue",
    "netherlands": "países bajos",
    "norway": "noruega",
    "nepal": "nepal",
    "nauru": "nauru",
    "new zealand": "nueva zelanda",
    "oman": "omán",
    "pakistan": "pakistán",
    "panama": "panamá",
    "pitcairn islands": "islas pitcairn",
    "peru": "perú",
    "philippines": "filipinas",
    "palau": "palau",
    "papua new guinea": "papúa nueva guinea",
    "poland": "polonia",
    "puerto rico": "puerto rico",
    "north korea": "corea del norte",
    "portugal": "portugal",
    "paraguay": "paraguay",
    "palestine": "palestina",
    "french polynesia": "polinesia francesa",
    "qatar": "catar",
    "réunion": "reunión",
    "romania": "rumania",
    "russia": "rusia",
    "rwanda": "ruanda",
    "saudi arabia": "arabia saudí",
    "sudan": "sudán",
    "senegal": "senegal",
    "singapore": "singapur",
    "south georgia": "islas georgias del sur y sandwich del sur",
    "svalbard and jan mayen": "islas svalbard y jan mayen",
    "solomon islands": "islas salomón",
    "sierra leone": "sierra leone",
    "el salvador": "el salvador",
    "san marino": "san marino",
    "somalia": "somalia",
    "saint pierre and miquelon": "san pedro y miquelón",
    "serbia": "serbia",
    "south sudan": "sudán del sur",
    "são tomé and príncipe": "santo tomé y príncipe",
    "suriname": "surinam",
    "slovakia": "república eslovaca",
    "slovenia": "eslovenia",
    "sweden": "suecia",
    "swaziland": "suazilandia",
    "sint maarten": "sint maarten",
    "seychelles": "seychelles",
    "syria": "siria",
    "turks and caicos islands": "islas turks y caicos",
    "chad": "chad",
    "togo": "togo",
    "thailand": "tailandia",
    "tajikistan": "tayikistán",
    "tokelau": "islas tokelau",
    "turkmenistan": "turkmenistán",
    "timor-leste": "timor oriental",
    "tonga": "tonga",
    "trinidad and tobago": "trinidad y tobago",
    "tunisia": "túnez",
    "turkey": "turquía",
    "tuvalu": "tuvalu",
    "taiwan": "taiwán",
    "tanzania": "tanzania",
    "uganda": "uganda",
    "ukraine": "ucrania",
    "united states minor outlying islands": "islas ultramarinas menores de estados unidos",
    "uruguay": "uruguay",
    "united states": "estados unidos",
    "uzbekistan": "uzbekistán",
    "vatican city": "ciudad del vaticano",
    "saint vincent and the grenadines": "san vicente y granadinas",
    "venezuela": "venezuela",
    "british virgin islands": "islas vírgenes del reino unido",
    "united states virgin islands": "islas vírgenes de los estados unidos",
    "vietnam": "vietnam",
    "vanuatu": "vanuatu",
    "wallis and futuna": "wallis y futuna",
    "samoa": "samoa",
    "yemen": "yemen",
    "south africa": "república de sudáfrica",
    "zambia": "zambia",
    "zimbabwe": "zimbabue"
}

var extras = {
    comparar: function(campo) {
        return function(a, b) {
            if (a[campo] < b[campo]) {
                return -1;
            }
            if (a[campo] > b[campo]) {
                return 1;
            }
            return 0;
        }
    },
    compararNumerico: function(campo) {
        return function(a, b) {
            if (typeof a[campo] !== 'undefined') {
                if (Number(a[campo]) < Number(b[campo])) {
                    return -1;
                }
                if (Number(a[campo]) > Number(b[campo])) {
                    return 1;
                }
            }
            return 0;
        }
    },
    procesaPlayersF40: function(players) {

        var jugadores = [];
        if (typeof players !== 'undefined') {

            var playerL = players.length;

            for (var iPlayer = 0; iPlayer < playerL; iPlayer++) {
                var jugador = {
                    id: players[iPlayer].$.uID.substring(1),
                    name: players[iPlayer].name[0],
                    position: players[iPlayer].position[0]
                };
                if (typeof players[iPlayer].$.loan !== 'undefined') {
                    jugador['loan'] = players[iPlayer].$.loan;
                }
                var statL = players[iPlayer].stat.length;
                for (var iStat = 0; iStat < statL; iStat++) {
                    jugador[players[iPlayer].stat[iStat].$.Type] = typeof players[iPlayer].stat[iStat]._ !== 'undefined' ? players[iPlayer].stat[iStat]._ : '';
                }
                jugadores.push(jugador);
            }
        }

        return jugadores;
    },
    objetosAObjeto: function(objectos) {
        var propAtributos = Object.keys(objectos),
            propAtributosL = propAtributos.length,
            data = {};
        for (var iPropAtributos = 0; iPropAtributos < propAtributosL; iPropAtributos++) {
            data[propAtributos[iPropAtributos]] = objectos[propAtributos[iPropAtributos]];
        }
        return data;
    },
    calculaEdad: function(birthday) {
        var ageDifMs = Date.now() - birthday.getTime();
        var ageDate = new Date(ageDifMs);
        return Math.abs(ageDate.getFullYear() - 1970);
    },
    rolesPlayerNed: function(posicion) {
        var rol = -1;
        if (typeof posicion !== 'undefined') {
            switch (posicion.toLowerCase()) {
                case 'goalkeeper':
                    rol = 1;
                    break;
                case 'defender':
                    rol = 2;
                    break;
                case 'midfielder':
                    rol = 3;
                    break;
                case 'forward':
                    rol = 4;
                    break;
                case 'striker':
                    rol = 4;
                    break;
                default:
                    rol = -1
            }
        }
        return rol;
    },
    roundTypeTraduccion: function(roundType) {
        var traduccion;
        switch (roundType) {
            case 'Play-Offs':
                traduccion = 'Semifinal';
                break;
            case 'Round':
                traduccion = 'Primera Fase';
                break;
            case 'Round of 16':
                traduccion = 'Octavos de Final';
                break;
            case 'Quarter-Finals':
                traduccion = 'Cuartos de Final';
                break;
            case 'Semi-Finals':
                traduccion = 'Semifinal';
                break;
            case 'Final':
                traduccion = 'Final';
                break;
            default:
                traduccion = roundType;
                break;
        }
        return traduccion;
    },
    competitionNameTraduccion: function(competitionName) {
        var traduccion;
        switch (competitionName) {
            case 'South American Under 20':
                traduccion = 'Sudamericano S20';
                break;
            case 'Chile Liguilla Pre-Libertadores':
                traduccion = 'Scotiabank definición Chile 4';
                break;
            case 'Chile Play-offs 1/2':
                traduccion = 'Promoción Ascenso';
                break;
            default:
                traduccion = competitionName;
                break;
        }
        return traduccion;
    },
    matchTypeTraduccion: function(matchType) {
        var traduccion;
        switch (matchType) {
            case '2nd Leg Cup Short':
                traduccion = 'Semifinal';
                break;
            case 'Cup Short':
                traduccion = 'Liguilla';
                break;
            default:
                traduccion = matchType;
                break;
        }
        return traduccion;
    },
    teamNameTraduccion: function(teamName) {
        var traduccion;
        switch (teamName) {
            case 'Group A Winner':
                traduccion = 'Ganador Grupo A';
                break;
            case 'Group B Winner':
                traduccion = 'Ganador Grupo B';
                break;
            case 'Group A Second Place':
                traduccion = 'Segundo Lugar Grupo A';
                break;
            case 'Group B Second Place':
                traduccion = 'Segundo Lugar Grupo B';
                break;
            case 'Brazil U20':
                traduccion = 'Brasil Sub20';
                break;
            case 'Paraguay U20':
                traduccion = 'Paraguay Sub20';
                break;
            case 'Uruguay U20':
                traduccion = 'Uruguay Sub20';
                break;
            case 'Venezuela U20':
                traduccion = 'Venezuela Sub20';
                break;
            case 'Argentina U20':
                traduccion = 'Argentina Sub20';
                break;
            case 'Colombia U20':
                traduccion = 'Colombia Sub20';
                break;
            case 'Ecuador U20':
                traduccion = 'Ecuador Sub20';
                break;
            case 'Chile U20':
                traduccion = 'Chile Sub20';
                break;
            case 'Perú U20':
                traduccion = 'Perú Sub20';
                break;
            case 'Bolivia U20':
                traduccion = 'Bolivia Sub20';
                break;
            case '3rd Place Group A':
                traduccion = '3er Lugar Grupo A';
                break;
            case '3rd Place Group B':
                traduccion = '3er Lugar Grupo B';
                break;
            default:
                traduccion = teamName;
                break;
        }
        return traduccion;
    },
    symidTraduccion: function(symid) {
        var traduccion;
        traduccion = symid.replace(/ U20/g, '');
        traduccion = symid.replace(/_U20/g, '');
        /*switch (symid) {
        	case 'BRA U20':
        		traduccion = 'BRA';
        		break;			
        	default:
        		traduccion = symid;
        		break;
        }*/
        return traduccion;
    },
    paisesNed: function(pais) {
        var respuesta = null;
        var paises = {
            "aruba": 134,
            "afghanistan": 132,
            "angola": 27,
            "anguilla": null,
            "åland islands": null,
            "albania": 103,
            "andorra": 133,
            "united arab emirates": null,
            "argentina": 1,
            "armenia": 21,
            "american samoa": 203,
            "antarctica": null,
            "french southern and antarctic lands": null,
            "antigua and barbuda": 141,
            "australia": 19,
            "austria": 51,
            "azerbaijan": 143,
            "burundi": 149,
            "belgium": null,
            "benin": null,
            "burkina faso": 128,
            "bangladesh": 136,
            "bulgaria": 63,
            "bahrain": null,
            "bahamas": 135,
            "bosnia and herzegovina": null,
            "saint barthelemy": null,
            "belarus": null,
            "belize": 145,
            "bermuda": 146,
            "bolivia": 4,
            "brazil": 5,
            "barbados": 137,
            "brunei": 138,
            "bhutan": null,
            "bouvet island": null,
            "botswana": null,
            "central african republic": null,
            "canada": 73,
            "cocos (keeling) islands": null,
            "switzerland": 42,
            "chile": 6,
            "china": 82,
            "ivory coast": 29,
            "cameroon": 16,
            "dr congo": null,
            "republic of the congo": 95,
            "cook islands": 168,
            "colombia": 7,
            "comoros": 153,
            "cape verde": 129,
            "costa rica": 22,
            "cuba": 24,
            "curaçao": 234,
            "christmas island": null,
            "cayman islands": null,
            "cyprus": 105,
            "czech republic": null,
            "germany": 26,
            "djibouti": null,
            "dominica": 154,
            "denmark": 23,
            "dominican republic": 91,
            "algeria": 70,
            "ecuador": 8,
            "egypt": 53,
            "eritrea": 155,
            "western sahara": null,
            "spain": 2,
            "estonia": 156,
            "ethiopia": null,
            "finland": 90,
            "fiji": null,
            "falkland islands": null,
            "france": 31,
            "faroe islands": null,
            "micronesia": 188,
            "gabon": null,
            "united kingdom": null,
            "georgia": 113,
            "guernsey": null,
            "ghana": 32,
            "gibraltar": 242,
            "guinea": 126,
            "guadeloupe": 226,
            "gambia": 96,
            "guinea-bissau": null,
            "equatorial guinea": 162,
            "greece": 77,
            "grenada": null,
            "greenland": null,
            "guatemala": 93,
            "french guiana": null,
            "guam": 161,
            "guyana": 164,
            "hong kong": 165,
            "heard island and mcdonald islands": null,
            "honduras": 71,
            "croatia": 30,
            "haiti": null,
            "hungary": null,
            "indonesia": 166,
            "isle of man": null,
            "india": 139,
            "british indian ocean territory": null,
            "ireland": 123,
            "iran": null,
            "iraq": 74,
            "iceland": 99,
            "israel": 66,
            "italy": 3,
            "jamaica": 79,
            "jersey": null,
            "jordan": 97,
            "japan": null,
            "kazakhstan": null,
            "kenya": 173,
            "kyrgyzstan": null,
            "cambodia": 151,
            "kiribati": 175,
            "saint kitts and nevis": null,
            "south korea": 39,
            "kosovo": 232,
            "kuwait": 72,
            "laos": 176,
            "lebanon": null,
            "liberia": 178,
            "libya": 179,
            "saint lucia": 207,
            "liechtenstein": 180,
            "sri lanka": 213,
            "lesotho": null,
            "lithuania": 85,
            "luxembourg": 110,
            "latvia": 106,
            "macau": 181,
            "saint martin": 238,
            "morocco": 67,
            "monaco": null,
            "moldova": 189,
            "madagascar": 182,
            "maldives": 184,
            "mexico": 9,
            "marshall islands": 169,
            "macedonia": 115,
            "mali": 125,
            "malta": 185,
            "myanmar": null,
            "montenegro": 101,
            "mongolia": 191,
            "northern mariana islands": null,
            "mozambique": 89,
            "mauritania": 187,
            "montserrat": 240,
            "martinique": 235,
            "mauritius": 186,
            "malawi": 183,
            "malaysia": 92,
            "mayotte": null,
            "namibia": 116,
            "new caledonia": 233,
            "niger": null,
            "norfolk island": null,
            "nigeria": 25,
            "nicaragua": 194,
            "niue": null,
            "netherlands": null,
            "norway": 56,
            "nepal": 193,
            "nauru": 192,
            "new zealand": 17,
            "oman": null,
            "pakistan": null,
            "panama": 15,
            "pitcairn islands": null,
            "peru": null,
            "philippines": 158,
            "palau": null,
            "papua new guinea": null,
            "poland": 36,
            "puerto rico": 86,
            "north korea": 64,
            "portugal": 37,
            "paraguay": 10,
            "palestine": 198,
            "french polynesia": null,
            "qatar": null,
            "reunion": null,
            "romania": 49,
            "russia": 78,
            "rwanda": 202,
            "saudi arabia": null,
            "sudan": null,
            "senegal": 83,
            "singapore": 211,
            "south georgia": null,
            "svalbard and jan mayen": null,
            "solomon islands": null,
            "sierra leone": null,
            "el salvador": 65,
            "san marino": 205,
            "somalia": 212,
            "saint pierre and miquelon": null,
            "serbia": 100,
            "south sudan": null,
            "são tome and principe": null,
            "suriname": 112,
            "slovakia": null,
            "slovenia": 81,
            "sweden": 41,
            "swaziland": 214,
            "sint maarten": 237,
            "seychelles": 209,
            "syria": 118,
            "turks and caicos islands": null,
            "chad": 152,
            "togo": 43,
            "thailand": 107,
            "tajikistan": null,
            "tokelau": null,
            "turkmenistan": null,
            "timor-leste": 217,
            "tonga": 121,
            "trinidad and tobago": 44,
            "tunisia": null,
            "turkey": null,
            "tuvalu": 219,
            "taiwan": null,
            "tanzania": 216,
            "uganda": 94,
            "ukraine": 46,
            "united states minor outlying islands": null,
            "uruguay": 12,
            "united states": 14,
            "uzbekistan": null,
            "vatican city": null,
            "saint vincent and the grenadines": null,
            "venezuela": 13,
            "british virgin islands": null,
            "united states virgin islands": null,
            "vietnam": 221,
            "vanuatu": 220,
            "wallis and futuna": null,
            "samoa": 120,
            "yemen": 222,
            "south africa": null,
            "zambia": 98,
            "zimbabwe": null
        };
        pais = this.normalizaTexto(pais.toLowerCase());
        if (typeof paises[pais] !== 'undefined') {
            if (paises[pais] != null) {
                respuesta = paises[pais]
            }
        }
        return respuesta;
    },
    periodNed: function(periodo) {
        var respuesta;
        switch (periodo.toLowerCase()) {
            case 'firsthalf':
                respuesta = 1;
                break;
            case 'secondhalf':
                respuesta = 2;
                break;
            case 'extrafirsthalf':
                respuesta = 3;
                break;
            case 'extrasecondhalf':
                respuesta = 4;
                break;
            case 'shootout':
                respuesta = 5;
                break;
            default:
                respuesta = null;
                break;
        };
        return respuesta;
    },
    nombreCortoSeleccion: function(nombre) {
        var nombreCorto = nombre.replace(/ U20/g, '');
        nombreCorto = nombre.replace(/ S20/g, '');
        nombreCorto = nombre.replace(/ Sub20/g, '');
        return nombreCorto;
    },
    campeonatosPushNed: function(campeonatoOptaId, temporadaId) {
        console.log(campeonatoOptaId)
        console.log(temporadaId)
        var respuesta = false;
        campeonatoOptaId = parseInt(campeonatoOptaId);
        temporadaId = parseInt(temporadaId);
        switch (campeonatoOptaId) {
            case 558:
                { //Primera A Clausura
                    if (temporadaId == 2014 || temporadaId == 2015 || temporadaId == 2016) {
                        respuesta = true;
                    }
                }
                break;
            case 370:
                { //Primera A Apertura
                    if (temporadaId == 2015 || temporadaId == 2016 || temporadaId == 2017) {
                        respuesta = true;
                    }
                }
                break;
            case 722:
                { //Primera B
                    if (temporadaId == 2015 || temporadaId == 2016 || temporadaId == 2017) {
                        respuesta = true;
                    }
                }
                break;
            case 639:
                { //Copa Chile
                    if (temporadaId == 2015 || temporadaId == 2016 || temporadaId == 2017) {
                        respuesta = true;
                    }
                }
                break;            
            case 748:
                { //South American Under 20
                    if (temporadaId == 2016) {
                        respuesta = true;
                    }
                }
                break;
            case 637:
            { //Super copa
                if (temporadaId == 2016) {
                    respuesta = true;
                }
            }
                break;
            case 872:
                {   // promoción 2017
                    if (temporadaId == 2017) {
                        respuesta = true;
                    }
                }
                break;
            case 699:
                {   // promoción 2017
                    if (temporadaId == 2017) {
                        respuesta = true;
                    }
                }
                break;
            default:
                respuesta = false;
                break;
        };
        return respuesta;
    },
    campeonatosPushAltavoz: function(campeonatoOptaId, temporadaId){
        var respuesta = false;
        campeonatoOptaId = parseInt(campeonatoOptaId);
        temporadaId = parseInt(temporadaId);
        switch (campeonatoOptaId) {
            case 370:
                { //Primera A Apertura
                    if (temporadaId == 2017) {
                        respuesta = true;
                    }
                }
                break;
            case 722:
                { //Primera B
                    if (temporadaId == 2017) {
                        respuesta = true;
                    }
                }
                break;
            case 639:
                { //Copa Chile
                    if (temporadaId == 2017) {
                        respuesta = true;
                    }
                }
                break;

            case 637:
                { //Super copa
                    if (temporadaId == 2016) {
                        respuesta = true;
                    }
                }
                break;
            case 872:
                { //Super copa
                    if (temporadaId == 2017) {
                        respuesta = true;
                    }
                }
                break;
            case 699:
                { //Super copa
                    if (temporadaId == 2017) {
                        respuesta = true;
                    }
                }
                break;

            default:
                respuesta = false;
                break;
        };
        return respuesta;
    },
    nombresCortosNed: {
        '2644': 'Everton',
        '1433': 'U. Catolica',
        '947': 'U. Chile',
        '2654': 'U. Concepción',
        '3599': 'Wanderers'
    },
    nombresCortosCampeonatosNed: {
        '370': 'Primera A',
        '558': 'Primera A',
        '639': 'Copa Chile',
        '722': 'Primera B',
        '748': 'Sudamericado S20',
        '699': 'Scotiabank def. Chile 4',
        '872': 'Promoción Ascenso'
    },
    normalizaTexto: function(text) {
        var acentos = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç";
        var original = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc";
        for (var i = 0; i < acentos.length; i++) {
            text = text.replace(acentos.charAt(i), original.charAt(i));
        }
        return text;
    },
    dataExtraTeam: function(teamId) {
        var respuesta = {                        
            "nicks": "",
            "history": "",            
            "c_titles": "", 
            "c_classics": "", 
            "c_home": ""
        };
        /*switch (teamId) {
            case '1421':
                respuesta = {                    
                    "nicks": "Árabes, El Tino-Tino",
                    "history": "Nace en la ciudad de Osorno. El club nace en unas olimpiadas de colonias, siendo fundado por inmigrantes palestinos el 20 de agosto de 1920",                    
                    "c_titles": "Primera: 2, Primera B: 2, Copa Chile: 2", 
                    "c_classics": "Unión Española, Audax Italiano", 
                    "c_home": "Municipal de La Cisterna"
                };
                break;
            case '2652':
                respuesta = {                    
                    "nicks": "Chago, Chaguito, Bohemios",
                    "history": "El club se originó luego de la fusión de dos equipos de la ciudad de Santiago en el año 1936, el Morning Star y el Santiago Football Club, la fecha de fundación se mantuvo en la más antigua de los dos clubes, la del Santiago F.C., el 16 de octubre de 1903",
                    "c_titles": "Primera: 1, Primera B: 3", 
                    "c_classics": "Magallanes", 
                    "c_home": "Municipal de La Pintana"
                };
                break;
        }*/
        return respuesta;
    }
}

exports.optaPush = function(req, res) {

    var data = {};
    var feedId;
    var competitionIdNed;
    var seasonIdNed;
    var optaLog;

    if (typeof req.headers['x-meta-competition-id'] !== 'undefined' && typeof req.headers['x-meta-season-id'] !== 'undefined') {
        competitionIdNed = req.headers['x-meta-competition-id'];
        seasonIdNed = req.headers['x-meta-season-id'];
        optaLog = {
            "competition" : competitionIdNed,
            "season" : seasonIdNed,
            "feed": req.headers['x-meta-feed-type'],
            "hora" : m().tz("America/Santiago").format("Y-MM-DD HH:mm:ss")
        };       
        
        console.log(optaLog);

        if (extras.campeonatosPushNed(competitionIdNed, seasonIdNed)) {
            switch (req.headers['x-meta-feed-type'].toLowerCase()) {
                case '1':
                    feedId = 'f1';
                    break;
                case 'f1':
                    feedId = 'f1';
                    break;
                case '40':
                    feedId = 'f40';
                    break;
                case 'f40':
                    feedId = 'f40';
                    break;
                case '30':
                    feedId = 'f30';
                    break;
                case 'f30':
                    feedId = 'f30';
                    break;
                case '9':
                    feedId = 'f9';
                    break;
                case 'f9':
                    feedId = 'f9';
                    break;
                case '13':
                    feedId = 'f13';
                    break;
                case 'f13':
                    feedId = 'f13';
                    break;
                case '3':
                    feedId = 'f3';
                    break;
                case 'f3':
                    feedId = 'f3';
                    break;
                default:
                    feedId = 'feed';
                    break;
            };

            switch (feedId) {
                case 'f1': //FIXTURE 
                    var partidos = [],
                        equipos = {},
                        equiposFalsos = [],
                        resultados = {},
                        data = req.body.soccerfeed.soccerdocument[0],
                        partidosData = data.matchdata,
                        partidosDataL = partidosData.length,
                        equiposData = data.team,
                        equiposDataL = equiposData.length,
                        atributosCampeonato = data['$'],
                        fechasGroups = [],
                        fechasGroup = [],
                        fechasGroupName = [],
                        tipoFixture;
                    var tiposPartidos = [];
                    req.body = undefined;
                    data = undefined;
                    var fixtureAltavoz = [];

                    //atributosCampeonato.competition_id = ;
                    //atributosCampeonato.season_id = ;

                    for (var i = 0; i < equiposDataL; i++) { //cambiar validacion por players
                        if (equiposData[i].name[0].toLowerCase().indexOf("group") < 0 && equiposData[i].name[0].toLowerCase().indexOf("grupo") < 0 && equiposData[i].name[0].toLowerCase().indexOf("tbc") < 0) {
                            equipos[equiposData[i]['$'].uID.substring(1)] = extras.teamNameTraduccion(equiposData[i].name[0]);
                        } else {
                            equiposFalsos.push(equiposData[i]['$'].uID.substring(1));
                        }
                    }
                    for (var indexPartidos = 0; indexPartidos < partidosDataL; indexPartidos++) {

                        var statL = typeof partidosData[indexPartidos].stat !== 'undefined' ? partidosData[indexPartidos].stat.length : 0,
                            teamDataL = typeof partidosData[indexPartidos].teamdata !== 'undefined' ? partidosData[indexPartidos].teamdata.length : 0,
                            atributos = Object.keys(partidosData[indexPartidos]['$']),
                            atributosL = atributos.length,
                            matchInfo = Object.keys(partidosData[indexPartidos].matchinfo[0]),
                            matchInfoL = matchInfo.length,
                            partido = {};
                        for (var index = 0; index < atributosL; index++) {
                            if (atributos[index] != 'uID') {
                                if (atributos[index] != 'last_modified') {
                                    partido[atributos[index]] = partidosData[indexPartidos]['$'][atributos[index]];
                                } else {
                                    try {
                                        partido[atributos[index]] = new Date(partidosData[indexPartidos]['$'][atributos[index]]);
                                    } catch (err) {
                                        partido[atributos[index]] = null;
                                    }
                                }
                            } else {
                                partido[atributos[index]] = partidosData[indexPartidos]['$'][atributos[index]].substring(1);
                            }
                        }
                        for (var iMatchInfo = 0; iMatchInfo < matchInfoL; iMatchInfo++) {
                            if (matchInfo[iMatchInfo] == '$') {
                                var attrMatchInfo = Object.keys(partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]]),
                                    attrMatchInfoL = attrMatchInfo.length;
                                for (var index = 0; index < attrMatchInfoL; index++) {
                                    switch (attrMatchInfo[index]) {
                                        case 'Leg':
                                            partido[attrMatchInfo[index]] = partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]];
                                            if (tiposPartidos.indexOf(partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]]) < 0) {
                                                tiposPartidos.push(partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]]);
                                            }
                                            break;
                                        case 'GroupName':
                                            partido[attrMatchInfo[index]] = partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]];
                                            if (tiposPartidos.indexOf(partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]]) < 0) {
                                                tiposPartidos.push(partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]]);
                                            }
                                            break;
                                            /*case 'MatchWinner':
                                            case 'FirstLegId':
                                            	partido[attrMatchInfo[index]] = partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]];
                                            	if (tiposPartidos.indexOf(partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]]) < 0) {
                                            		tiposPartidos.push(partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]]);
                                            	}
                                            	break;
                                            case 'LegWinner':
                                            	partido[attrMatchInfo[index]] = partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]].substring(1);										
                                            	break;		*/
                                        case 'MatchType':
                                            partido[attrMatchInfo[index]] = partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]];
                                            if (tiposPartidos.indexOf(partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]]) < 0) {
                                                tiposPartidos.push(partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]]);
                                            }
                                            break;
                                        default:
                                            partido[attrMatchInfo[index]] = partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][attrMatchInfo[index]];
                                            break;
                                    }
                                }
                            } else {
                                if (matchInfo[iMatchInfo] == 'date') {
                                    /*try {
                                        partido[matchInfo[iMatchInfo]] = new Date(partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][0].replace(' ', 'T'));
                                    } catch (err) {
                                        partido[matchInfo[iMatchInfo]] = new Date(partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][0]._.replace(' ', 'T'));
                                    }*/
                                    if (typeof partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][0]._ !== 'undefined'){										
										var original = partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][0]._;
										var horaLondresGMT = m.tz(original, "Europe/London").format();
										var offset = m().utcOffset(horaLondresGMT)._offset*-1;
										var horaCorregida = m(original).utcOffset(offset).format("YYYY-MM-DD HH:mm");
										var corregidaGMT = m(horaCorregida).format("YYYY-MM-DDTHH:mm")+'Z';
									}else{
										var original = partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][0];										
										var horaLondresGMT = m.tz(original, "Europe/London").format();
										var offset = m().utcOffset(horaLondresGMT)._offset*-1;
										var horaCorregida = m(original).utcOffset(offset).format("YYYY-MM-DD HH:mm");
										var corregidaGMT = m(horaCorregida).format("YYYY-MM-DDTHH:mm")+'Z';
									}		

									partido[matchInfo[iMatchInfo]] = new Date(corregidaGMT);
                                } else {
                                    partido[matchInfo[iMatchInfo]] = partidosData[indexPartidos].matchinfo[0][matchInfo[iMatchInfo]][0];
                                }
                            }
                        }
                        for (var index = 0; index < statL; index++) {
                            partido[partidosData[indexPartidos].stat[index]['$'].Type] = partidosData[indexPartidos].stat[index]['_'];
                        }
                        for (var indexTeamData = 0; indexTeamData < teamDataL; indexTeamData++) {
                            var propiedades = Object.keys(partidosData[indexPartidos].teamdata[indexTeamData]),
                                propiedadesL = propiedades.length,
                                lado = partidosData[indexPartidos].teamdata[indexTeamData]['$'].Side,
                                atributos = Object.keys(partidosData[indexPartidos].teamdata[indexTeamData]['$']),
                                atributosL = atributos.length;
                            partido[lado] = {};
                            for (var index = 0; index < atributosL; index++) {
                                if (atributos[index] != 'Side') {
                                    if (atributos[index] != 'TeamRef') {
                                        partido[lado][atributos[index]] = partidosData[indexPartidos].teamdata[indexTeamData]['$'][atributos[index]];
                                    } else {
                                        if (equiposFalsos.indexOf(partidosData[indexPartidos].teamdata[indexTeamData]['$'][atributos[index]].substring(1)) > -1) {
                                            partido[lado][atributos[index]] = null;
                                            partido[lado]['TeamName'] = '';
                                        } else {
                                            partido[lado][atributos[index]] = partidosData[indexPartidos].teamdata[indexTeamData]['$'][atributos[index]].substring(1);
                                            partido[lado]['TeamName'] = typeof equipos[partido[lado][atributos[index]]] !== 'undefined' ? equipos[partido[lado][atributos[index]]] : null;
                                        }
                                    }
                                }
                            }

                            if (typeof partidosData[indexPartidos].teamdata[indexTeamData].goal !== 'undefined') {
                                partido[lado]['goal'] = [];
                                var golesL = partidosData[indexPartidos].teamdata[indexTeamData].goal.length;
                                for (var i = 0; i < golesL; i++) {
                                    var gol = {},
                                        atributos = Object.keys(partidosData[indexPartidos].teamdata[indexTeamData].goal[i].$),
                                        atributosL = atributos.length;
                                    for (var index = 0; index < atributosL; index++) {
                                        if (atributos[index] != 'PlayerRef') {
                                            gol[atributos[index]] = partidosData[indexPartidos].teamdata[indexTeamData].goal[i].$[atributos[index]];
                                        } else {
                                            gol[atributos[index]] = partidosData[indexPartidos].teamdata[indexTeamData].goal[i].$[atributos[index]].substring(1);
                                        }
                                    }
                                    partido[lado]['goal'].push(gol);
                                }
                            }
                        }

                        // parche 872
                        if (partido.uID == '964795') {                            
                            partido.MatchDay = "1";
                        }
                        if (partido.uID == '964800') {
                            partido.MatchDay = "2";
                        } 

                        var momentPartido = m(corregidaGMT);
                        var partidoAltavoz = {
                            "campeonato": extras.competitionNameTraduccion(atributosCampeonato.competition_name) + ' ' + ((atributosCampeonato.competition_id + '-' + atributosCampeonato.season_id == '748-2016') ? '2017' : atributosCampeonato.season_id),
                            "idCampeonato": atributosCampeonato.competition_id,
                            "temporada": atributosCampeonato.season_id,
                            "idPartido": partido.uID,
                            "fecha": momentPartido.tz("America/Santiago").format("Y-MM-DD HH:mm"),
                            "estado": typeof partido.Period !== 'undefined' ? partido.Period : undefined,
                            "fecha_campeonato": partido.MatchDay,
                            "localData":{
                                "id": partido.Home.TeamRef,
                                "nombre": partido.Home.TeamName,
                                "goles": typeof partido.Home.Score !== 'undefined' ? ( typeof partido.Home.PenaltyScore !== 'undefined' ? partido.Home.Score + ' (' + partido.Home.PenaltyScore + ')' : partido.Home.Score ) : "-"
                            },
                            "visitaData":{
                                "id": partido.Away.TeamRef,
                                "nombre": partido.Away.TeamName,
                                "goles": typeof partido.Away.Score !== 'undefined' ? ( typeof partido.Away.PenaltyScore !== 'undefined'? partido.Away.Score + ' (' + partido.Away.PenaltyScore + ')' : partido.Away.Score ) : "-"
                            }
                        };   

                        partidoAltavoz = _.omitBy(partidoAltavoz, _.isNil);
                        // parche 872
                        if (partido.uID != '959926' && partido.uID != '959925') {
                            fixtureAltavoz.push(partidoAltavoz);
                        }
                        partidos.push(partido);
                    }
                    
                    partidos = partidos.sort(extras.comparar('fecha'));
                    //return res.json(partidos);
                    var guardaF01 = function() {
                        return new Promise(function(resolve, reject) {
                            return resolve('ok');
                        });
                    }
                    var teamsPushNed = function() {

                        var equiposProp = Object.keys(equipos),
                            equiposPropL = equiposProp.length,
                            dataEquiposPush = {
                                data: []
                            }
                        for (var index = 0; index < equiposPropL; index++) {
                            if (equipos[equiposProp[index]].toLowerCase() != 'tbc') {
                                
                                if (equiposProp[index] == '7589' && atributosCampeonato.competition_id != '872' || equiposProp[index] != '7589') { // parche 872 
                                    dataEquiposPush.data.push({
                                        id: equiposProp[index],
                                        name: extras.nombreCortoSeleccion(equipos[equiposProp[index]])
                                    })
                                }
                            }
                        }

                        return ned.teamsPush(atributosCampeonato.competition_id + '-' + atributosCampeonato.season_id, dataEquiposPush.data);
                    }
                    var matchsNedData = function() {
                        var fechasDates = {},
                            respuesta = {
                                matchsDate: {
                                    data: []
                                },
                                matchs: {},
                                positions: {
                                    data: []
                                }
                            },
                            ordenPartidosKey = [],
                            machtDateData = [],
                            finales = ["839845", "839846", "839205", "839206", "852536", "852537", "852624", "852625"],
                            dateNumberKeys = 1,
                            matchNumberKey = 1,
                            positions = {},
                            dateMatchNumberKeys = 1,
                            partidosL = partidos.length;
                        partidos = partidos.sort(extras.compararNumerico('MatchDay'));

                        //return false;
                        var partidosDosKey = [];
                        for (var index = 0; index < partidosL; index++) {
                            if (partidos[index].uID!='959925' && partidos[index].uID!='959926') { // parche 872 
                                if (typeof partidos[index].FirstLegId !== 'undefined') {
                                    partidosDosKey[partidos[index].FirstLegId.substring(1)] = {
                                        id: partidos[index].uID,
                                        matchDateId: matchNumberKey,
                                        agendaOrder: 0,
                                        number: 1,
                                        stadium: partidos[index].Venue.toLowerCase() == 'tbc' ? 'Por definir' : partidos[index].Venue,
                                        //startDate: partidos[index].date.toISOString(),
                                        startDate: (partidos[index].Period == 'Postponed' && competitionIdNed == '558' && seasonIdNed == '2016') ? "2017-05-21T20:00:00.000Z" : partidos[index].date.toISOString(),
                                        city: typeof partidos[index].City !== 'undefined' ? partidos[index].City : '',
                                        winnerId: typeof partidos[index].MatchWinner !== 'undefined' ? partidos[index].MatchWinner : '',
                                        localId: partidos[index].Home.TeamRef,
                                        visitorId: partidos[index].Away.TeamRef,
                                        localGoals: typeof partidos[index].Home.Score !== 'undefined' ? parseInt(partidos[index].Home.Score) : 0,
                                        visitorGoals: typeof partidos[index].Away.Score !== 'undefined' ? parseInt(partidos[index].Away.Score) : 0
                                    };
                                    matchNumberKey++;
                                    switch (partidos[index].Period.toLowerCase()) {
                                        case 'fulltime':
                                            partidosDosKey[partidos[index].FirstLegId.substring(1)]['state'] = 2;
                                            partidosDosKey[partidos[index].FirstLegId.substring(1)]['stateText'] = 'finished';
                                            break;
                                        case 'live':
                                            partidosDosKey[partidos[index].FirstLegId.substring(1)]['state'] = 1;
                                            partidosDosKey[partidos[index].FirstLegId.substring(1)]['stateText'] = 'current';
                                            break;
                                        case 'prematch':
                                            partidosDosKey[partidos[index].FirstLegId.substring(1)]['state'] = 0;
                                            partidosDosKey[partidos[index].FirstLegId.substring(1)]['stateText'] = 'pending';
                                            break;
                                        default:
                                            partidosDosKey[partidos[index].FirstLegId.substring(1)]['state'] = 0;
                                            partidosDosKey[partidos[index].FirstLegId.substring(1)]['stateText'] = 'pending';
                                            break;
                                    }
                                }
                            } // parche 872                           
                        }

                        for (var index = 0; index < partidosL; index++) {
                            if (partidos[index].uID!='959925' && partidos[index].uID!='959926') { // parche 872 

                                var dataMatch = {
                                    id: partidos[index].uID,
                                    matchDateId: (typeof partidos[index].MatchDay !== 'undefined') ? parseInt(partidos[index].MatchDay) : dateNumberKeys,
                                    agendaOrder: 0,
                                    number: 1,
                                    stadium: partidos[index].Venue.toLowerCase() == 'tbc' ? 'Por definir' : partidos[index].Venue,
                                    //startDate: partidos[index].date.toISOString(),
                                    startDate: (partidos[index].Period == 'Postponed' && competitionIdNed == '558' && seasonIdNed == '2016') ? "2017-05-21T20:00:00.000Z" : partidos[index].date.toISOString(),
                                    city: typeof partidos[index].City !== 'undefined' ? partidos[index].City : '',
                                    winnerId: typeof partidos[index].MatchWinner !== 'undefined' ? partidos[index].MatchWinner : '',
                                    localId: partidos[index].Home.TeamRef,
                                    visitorId: partidos[index].Away.TeamRef,
                                    localGoals: typeof partidos[index].Home.Score !== 'undefined' ? parseInt(partidos[index].Home.Score) : 0,
                                    visitorGoals: typeof partidos[index].Away.Score !== 'undefined' ? parseInt(partidos[index].Away.Score) : 0
                                }                            

                                switch (partidos[index].Period.toLowerCase()) {
                                    case 'fulltime':
                                        dataMatch['state'] = 2;
                                        dataMatch['stateText'] = 'finished';
                                        break;
                                    case 'live':
                                        dataMatch['state'] = 1;
                                        dataMatch['stateText'] = 'current';
                                        break;
                                    case 'prematch':
                                        dataMatch['state'] = 0;
                                        dataMatch['stateText'] = 'pending';
                                        break;
                                    default:
                                        dataMatch['state'] = 0;
                                        dataMatch['stateText'] = 'pending';
                                        break;
                                }

                                /*if (partidos[index].uID == '959925') {
                                    dataMatch.matchDateId = "16";
                                    partidos[index].MatchDay = "16";
                                }
                                if (partidos[index].uID == '959926') {
                                    dataMatch.matchDateId = "17";
                                    partidos[index].MatchDay = "17";
                                }*/

                                var dataMatchDate = {};
                                var matchDayOpta;
                                //if (partidos[index].uID != '959925' && partidos[index].uID != '959926') {
                                    if (partidos[index].MatchType == 'Regular' && typeof partidos[index].GroupName === 'undefined') {
                                        tipoFixture = 1;

                                        if (Object.keys(fechasGroupName).length > 0) {
                                            matchDayOpta = partidos[index].MatchDay;
                                            partidos[index].MatchDay = Math.floor(parseInt(partidos[index].MatchDay) + (Object.keys(fechasGroupName).length / fechasGroups.length));
                                        }

                                        if (typeof fechasDates[partidos[index].MatchDay] === 'undefined') {

                                            var type = typeof partidos[index].GroupName === 'undefined' ? 'league' : 'group';
                                            var level = typeof partidos[index].RoundNumber !== 'undefined' ? String(partidos[index].RoundNumber) : "1";
                                            var levelName = typeof partidos[index].GroupName === 'undefined' && partidos[index].RoundNumber != "2" ? 'Fecha regular' : (typeof partidos[index].GroupName === 'undefined' ? 'Fase final' : 'Fase grupal');
                                            var name = typeof partidos[index].GroupName === 'undefined' ? 'Fecha ' + (typeof matchDayOpta !== 'undefined' ? matchDayOpta : partidos[index].MatchDay) : 'Grupo ' + partidos[index].GroupName + ' - ' + 'Fecha ' + partidos[index].MatchDay;

                                            dataMatchDate = {
                                                level: level,
                                                dateNumber: partidos[index].MatchDay,
                                                order: partidos[index].MatchDay,
                                                levelName: levelName,
                                                name: name,
                                                type: type
                                            };

                                            fechasDates[partidos[index].MatchDay] = [partidos[index].date.getTime()];

                                        } else {
                                            fechasDates[partidos[index].MatchDay].push(partidos[index].date.getTime());
                                        }
                                        //dateNumberKeys++;
                                        if (partidos[index].uID != '959925'&& partidos[index].uID != '959926') {                                
                                            var campeonato = parseInt(atributosCampeonato.competition_id) + '-' + parseInt(atributosCampeonato.season_id);
                                            var positionId = campeonato + '_' + level;                                
                                            positions[positionId] = {
                                                campeonato: campeonato,
                                                level: level,
                                                position: [{
                                                    "championshipId": campeonato,
                                                    "type": type,
                                                    "typeId": null,
                                                    "levelId": null,
                                                    "groupName": null
                                                }]
                                            };
                                        }

                                    } else if (typeof partidos[index].GroupName !== 'undefined') {

                                        tipoFixture = 1;

                                        if (typeof fechasDates[dateNumberKeys] === 'undefined' && typeof fechasGroupName[partidos[index].GroupName + partidos[index].MatchDay] === 'undefined') {

                                            var level = typeof partidos[index].RoundNumber !== 'undefined' ? String(partidos[index].RoundNumber) : "1";
                                            var name = 'Grupo ' + partidos[index].GroupName + ' - ' + 'Fecha ' + partidos[index].MatchDay;

                                            dataMatchDate = {
                                                level: level,
                                                dateNumber: parseInt(dateNumberKeys),
                                                order: dateNumberKeys,
                                                levelName: 'Fase Grupal',
                                                name: name,
                                                type: 'group'
                                            };

                                            fechasDates[dateNumberKeys] = [partidos[index].date.getTime()];
                                            fechasGroupName[partidos[index].GroupName + partidos[index].MatchDay] = parseInt(dateNumberKeys);

                                            if (fechasGroups.indexOf(partidos[index].GroupName) < 0)
                                                fechasGroups.push(partidos[index].GroupName);

                                            dateNumberKeys++;
                                        }

                                        if (typeof fechasGroupName[partidos[index].GroupName + partidos[index].MatchDay] !== 'undefined') {
                                            dataMatch.matchDateId = fechasGroupName[partidos[index].GroupName + partidos[index].MatchDay];

                                        }

                                        var campeonato = parseInt(atributosCampeonato.competition_id) + '-' + parseInt(atributosCampeonato.season_id);
                                        var positionId = campeonato + '_' + level + '_' + fechasGroups.length;
                                        positions[positionId] = {
                                            campeonato: campeonato,
                                            level: level,
                                            position: [{
                                                "championshipId": campeonato,
                                                "type": 'group',
                                                "typeId": fechasGroups.length,
                                                "levelId": null,
                                                "groupName": 'Grupo ' + fechasGroups[fechasGroups.length - 1]
                                            }]
                                        };

                                    } else {

                                        tipoFixture = 2;
                                        var fechaAux = (parseInt(atributosCampeonato.competition_id) == 722 ? 30 : (parseInt(atributosCampeonato.competition_id) == 639 || parseInt(atributosCampeonato.competition_id) == 872 || parseInt(atributosCampeonato.competition_id) == 699) ? 0 : 15);                                
                                        if (typeof fechasDates[parseInt(dateNumberKeys) + fechaAux] === 'undefined') {
                                            
                                            if (typeof partidos[index].FirstLegId !== 'undefined') {
                                                
                                                var level = typeof partidos[index].RoundNumber !== 'undefined' ? String(partidos[index].RoundNumber) : (finales.indexOf(partidos[index].uID) >= 0 ? "3" : "2");
                                                var levelName = finales.indexOf(partidos[index].uID) >= 0 ? "Final" : typeof partidos[index].RoundType !== 'undefined' ? extras.roundTypeTraduccion(partidos[index].RoundType) : extras.matchTypeTraduccion(partidos[index].MatchType);
                                                levelName = parseInt(atributosCampeonato.competition_id) == 699 ? 'Final' : levelName;
                                                fechasDates[parseInt(dateNumberKeys) + fechaAux] = [partidos[index].date.getTime()];
                                                //parche
                                                if (partidos[index].uID == '964800') {
                                                    level = "1";
                                                }

                                                dataMatchDate = {
                                                    level: level,
                                                    dateNumber: parseInt(dateNumberKeys) + fechaAux,
                                                    order: dateNumberKeys,
                                                    levelName: levelName,
                                                    //name: 'Fecha ' + (parseInt(dateNumberKeys) + parseInt(fechaAux)),
                                                    name: levelName,
                                                    type: 'key'
                                                };
                                                
                                                dateNumberKeys++;
                                                
                                            } else {
                                                // parche                                                
                                                if ( (partidos[index].RoundType == 'Final' && partidos[index].uID != '964795') || (partidos[index].RoundType == "Play-Offs" && typeof partidos[index].Leg === 'undefined')) {
                                                    var level = typeof partidos[index].RoundNumber !== 'undefined' ? String(partidos[index].RoundNumber) : "2";
                                                    var levelName = finales.indexOf(partidos[index].uID) >= 0 ? "Final" : typeof partidos[index].RoundType !== 'undefined' ? extras.roundTypeTraduccion(partidos[index].RoundType) : extras.matchTypeTraduccion(partidos[index].MatchType);
                                                    levelName = parseInt(atributosCampeonato.competition_id) == 699 ? 'Final' : levelName;
                                                    fechasDates[parseInt(dateNumberKeys) + fechaAux] = [partidos[index].date.getTime()];

                                                    dataMatchDate = {
                                                        level: level,
                                                        dateNumber: parseInt(dateNumberKeys) + fechaAux,
                                                        order: dateNumberKeys,
                                                        levelName: levelName,
                                                        //name: 'Fecha ' + (parseInt(dateNumberKeys) + parseInt(fechaAux)),
                                                        name: levelName,
                                                        type: 'key'
                                                    };
                                                    dateNumberKeys++;                                            
                                                }
                                            }

                                        } else {
                                            
                                            if (typeof partidos[index].FirstLegId !== 'undefined') {

                                                fechasDates[parseInt(dateNumberKeys) + fechaAux].push(partidos[index].date.getTime());
                                                var level = typeof partidos[index].RoundNumber !== 'undefined' ? String(partidos[index].RoundNumber) : (finales.indexOf(partidos[index].uID) >= 0 ? "3" : "2");
                                                var levelName = finales.indexOf(partidos[index].uID) >= 0 ? "Final" : typeof partidos[index].RoundType !== 'undefined' ? extras.roundTypeTraduccion(partidos[index].RoundType) : extras.matchTypeTraduccion(partidos[index].MatchType);
                                                levelName = parseInt(atributosCampeonato.competition_id) == 699 ? 'Final' : levelName;
                                                dataMatchDate = {
                                                    level: level,
                                                    dateNumber: parseInt(dateNumberKeys) + fechaAux,
                                                    order: dateNumberKeys,
                                                    levelName: levelName,
                                                    //name: 'Fecha ' + parseInt(dateNumberKeys) + fechaAux,
                                                    name: levelName,
                                                    type: 'key'
                                                };
                                                dateNumberKeys++;

                                            } else {
                                                fechasDates[parseInt(dateNumberKeys) + fechaAux] = [partidos[index].date.getTime()];
                                            }

                                        }
                                    }
                                //}
                            
                                if (Object.keys(dataMatchDate).length > 0) {
                                    machtDateData.push(dataMatchDate);
                                }

                                if (tipoFixture == 1) {
                                    // partidos tipo group / league sub 20					

                                    if (typeof partidos[index].GroupName !== 'undefined') {

                                        if (typeof respuesta.matchs[dataMatch.matchDateId] !== 'undefined') {
                                            respuesta.matchs[dataMatch.matchDateId].data.push(dataMatch);
                                        } else {
                                            respuesta.matchs[dataMatch.matchDateId] = {
                                                data: [dataMatch]
                                            }
                                        }

                                    } else {

                                        dataMatch.matchDateId = partidos[index].MatchDay;

                                        if (typeof respuesta.matchs[partidos[index].MatchDay] !== 'undefined') {
                                            respuesta.matchs[partidos[index].MatchDay].data.push(dataMatch);
                                        } else {
                                            respuesta.matchs[partidos[index].MatchDay] = {
                                                data: [dataMatch]
                                            }
                                        }
                                    }

                                } else {

                                    if (typeof respuesta.matchs[dateMatchNumberKeys + fechaAux] !== 'undefined') {

                                        if (typeof partidos[index].FirstLegId !== 'undefined') {

                                            if (typeof partidosDosKey[partidos[index].uID] !== 'undefined') {

                                                dataMatch.matchDateId = partidosDosKey[partidos[index].uID].matchDateId = dateMatchNumberKeys;

                                                respuesta.matchs[dateMatchNumberKeys + fechaAux].data.push(dataMatch);
                                                respuesta.matchs[dateMatchNumberKeys + fechaAux].data.push(partidosDosKey[partidos[index].uID]);

                                            } else {
                                                if (typeof respuesta.matchs[partidos[index].RoundNumber] !== 'undefined') {
                                                    respuesta.matchs[partidos[index].RoundNumber].data.push(dataMatch);
                                                }
                                            }
                                            dateMatchNumberKeys++;
                                        } else {

                                            if (typeof respuesta.matchs[partidos[index].RoundNumber] !== 'undefined') {
                                                respuesta.matchs[partidos[index].RoundNumber].data.push(dataMatch);
                                            }
                                        }
                                    } else {

                                        if (typeof partidos[index].FirstLegId === 'undefined') {

                                            if (typeof partidosDosKey[partidos[index].uID] !== 'undefined') {
                                                respuesta.matchs[dateMatchNumberKeys + fechaAux] = {
                                                    data: []
                                                }

                                                dataMatch.matchDateId = partidosDosKey[partidos[index].uID].matchDateId = dateMatchNumberKeys;

                                                respuesta.matchs[dateMatchNumberKeys + fechaAux].data.push(dataMatch);
                                                respuesta.matchs[dateMatchNumberKeys + fechaAux].data.push(partidosDosKey[partidos[index].uID]);

                                            } else {

                                                if (partidos[index].RoundType == 'Final' || (partidos[index].RoundType == "Play-Offs" && typeof partidos[index].Leg === 'undefined')) {
                                                    respuesta.matchs[dateMatchNumberKeys + fechaAux] = {
                                                        data: []
                                                    };
                                                    respuesta.matchs[dateMatchNumberKeys + fechaAux].data.push(dataMatch);
                                                } else {
                                                    respuesta.matchs[partidos[index].RoundNumber] = {
                                                        data: []
                                                    };
                                                    respuesta.matchs[partidos[index].RoundNumber].data.push(dataMatch);
                                                }
                                            }
                                            dateMatchNumberKeys++;
                                        }
                                    }
                                }
                            } // fin parche 872
                        }

                        if (Object.keys(positions).length > 0) {
                            Object.keys(positions).map(function(object, index) {
                                respuesta.positions.data.push(positions[object]);
                            });
                        }
                        
                        var matchDateDataL = machtDateData.length;
                        
                        for (var index = 0; index < matchDateDataL; index++) {                        
                            
                            try {
                                
                                machtDateData[index]['startDate'] = new Date(Math.min.apply(null, fechasDates[machtDateData[index].level])).toISOString();
                            } catch (e) {
                                machtDateData[index]['startDate'] = new Date(Math.min.apply(null, fechasDates[machtDateData[index].dateNumber])).toISOString();
                                //console.log(e);
                            }

                            respuesta.matchsDate.data.push(machtDateData[index]);
                        }
                        
                        return respuesta;
                    }
                    
                    var dataMatchDateYMatch = matchsNedData();

                    

                    var matchDatePushNed = function() {                        
                        return ned.matchDatesPush(atributosCampeonato.competition_id + '-' + atributosCampeonato.season_id, dataMatchDateYMatch.matchsDate.data);
                    };

                    var championshipPushNed = function() {
                        console.log('1');
                        return new Promise(function(resolve, reject) {
                            console.log("pasa");
                           
                            ned.championshipPush(atributosCampeonato.competition_id + '-' + atributosCampeonato.season_id, {
                                    "fullname": extras.competitionNameTraduccion(atributosCampeonato.competition_name) + ' ' + ((atributosCampeonato.competition_id + '-' + atributosCampeonato.season_id == '748-2016') ? '2017' : atributosCampeonato.season_id),
                                    "name": extras.competitionNameTraduccion(atributosCampeonato.competition_name),
                                    "categoryName": extras.competitionNameTraduccion(atributosCampeonato.competition_name),
                                    "categoryFullName": extras.competitionNameTraduccion(atributosCampeonato.competition_name) + ' ' + ((atributosCampeonato.competition_id + '-' + atributosCampeonato.season_id == '748-2016') ? '2017' : atributosCampeonato.season_id),
                                    "categoryId": atributosCampeonato.competition_id,
                                    'season_id': atributosCampeonato.season_id,
                                    'c_shortname': extras.nombresCortosCampeonatosNed[atributosCampeonato.competition_id] || extras.competitionNameTraduccion(atributosCampeonato.competition_name)
                                }).then(function(respuesta) {
                                    return teamsPushNed();
                                }).then(function(respuesta) {
                                    console.log('3');
                                    return matchDatePushNed();
                                }).then(function(respuesta) {
                                    console.log(4);
                                    return respuesta.data.reduce(function(sequence, matchsDates) {
                                        return sequence.then(function() {
                                            if (typeof matchsDates.id !== 'undefined' && typeof matchsDates.dateNumber !== 'undefined' && typeof dataMatchDateYMatch.matchs[matchsDates.dateNumber] !== 'undefined') {                                                
                                                return ned.matchDatesMatchsPush(matchsDates.id, dataMatchDateYMatch.matchs[matchsDates.dateNumber].data);
                                            } else resolve();
                                        }).catch(function(err) {
                                            console.log(err);
                                            resolve();
                                        });
                                        //resolve();
                                    }, Promise.resolve());
                                }).then(function(respuesta) {
                                    console.log(5);
                                    if (typeof dataMatchDateYMatch.positions !== 'undefined') {
                                        return dataMatchDateYMatch.positions.data.reduce(function(sequence, position) {
                                            return sequence.then(function() {
                                                return ned.positionsIdPush(position.campeonato, position.level, position.position);
                                            })
                                        }, Promise.resolve());
                                    } else {
                                        resolve("ok sin position");
                                    }

                                }).then(function(respuesta) {
                                    resolve('ok');
                                })
                                .catch(function(err) {
                                    console.log(err);
                                    reject(err);
                                })
                        });
                    }

                    guardaF01().then(function(respuesta) {
                        if (extras.campeonatosPushNed(atributosCampeonato.competition_id, atributosCampeonato.season_id)) {
                            return championshipPushNed();
                        } else {
                            return Promise.resolve('Ok');
                        }
                    }).then(function(respuesta) {
                        if (extras.campeonatosPushAltavoz(atributosCampeonato.competition_id, atributosCampeonato.season_id))
                            return altavoz.pushFixture(fixtureAltavoz);
                        else
                            return Promise.resolve('Ok');
                    }).then(function(respuesta){
                        res.status(200).send('Todas las peticiones correctas');
                    }).catch(function(err) {
                        res.status(err);
                    })

                    break;
                case 'f40': //JUGADORES
                    //return res.json(req.body);
                    var acciones = [];
                    var fechaActualizacion = new Date(req.body.soccerfeed.$.timestamp.substr(0, 4) + '-' + req.body.soccerfeed.$.timestamp.substr(4, 2) + '-' + req.body.soccerfeed.$.timestamp.substr(6, 2) + 'T' + req.body.soccerfeed.$.timestamp.substr(9, 2) + ':' + req.body.soccerfeed.$.timestamp.substr(11, 2) + ':' + req.body.soccerfeed.$.timestamp.substr(13)),
                        cabecera = req.body.soccerfeed.soccerdocument[0].$,
                        teams = req.body.soccerfeed.soccerdocument[0].team,
                        campeonatosEquipos = {},
                        teamsL,
                        cambiosL,
                        equipos = [],
                        equiposCambios = [];
                    if (typeof req.body.soccerfeed.soccerdocument[0].playerchanges !== 'undefined') {
                        if (typeof req.body.soccerfeed.soccerdocument[0].playerchanges[0] !== 'undefined') {
                            if (typeof req.body.soccerfeed.soccerdocument[0].playerchanges[0].team !== 'undefined') {
                                var cambios = req.body.soccerfeed.soccerdocument[0].playerchanges[0].team;
                                cambiosL = cambios.length;
                            }
                        }
                    }
                    console.log(cabecera);
                    req.body = undefined;
                    teamsL = teams.length;
                    for (var iEquipo = 0; iEquipo < teamsL; iEquipo++) {
                        if (teams[iEquipo].name[0].toLowerCase().indexOf("group") < 0 && teams[iEquipo].name[0].toLowerCase().indexOf("grupo") < 0 && teams[iEquipo].name[0].toLowerCase().indexOf("tbc") < 0) {
                            var equipo = {
                                id: teams[iEquipo].$.uID.substring(1),
                                country: teams[iEquipo].$.country,
                                country_id: teams[iEquipo].$.country_id,
                                country_iso: teams[iEquipo].$.country_iso,
                                name: extras.teamNameTraduccion(teams[iEquipo].name[0]),
                                official_club_name: teams[iEquipo].$.official_club_name,
                                founded: typeof teams[iEquipo].founded !== 'undefined' ? teams[iEquipo].founded[0] : '',
                                region_id: teams[iEquipo].$.region_id,
                                region_name: teams[iEquipo].$.region_name,
                                symid: extras.symidTraduccion(teams[iEquipo].symid[0]),
                                players: extras.procesaPlayersF40(teams[iEquipo].player),
                                teamofficial: []
                            }

                            if (typeof teams[iEquipo].stadium !== 'undefined') {
                                equipo['stadium'] = {
                                    id: teams[iEquipo].stadium[0].$.uID,
                                    capacity: typeof teams[iEquipo].stadium[0].capacity !== 'undefined' ? teams[iEquipo].stadium[0].capacity[0] : '',
                                    name: typeof teams[iEquipo].stadium[0].name !== 'undefined' ? teams[iEquipo].stadium[0].name[0] : ''
                                }
                            }
                            if (typeof teams[iEquipo].teamofficial !== 'undefined') {
                                var teamOfficialL = teams[iEquipo].teamofficial.length;
                                for (var iTeamOfficial = 0; iTeamOfficial < teamOfficialL; iTeamOfficial++) {
                                    var teamOfficialAttributes = Object.keys(teams[iEquipo].teamofficial[iTeamOfficial].$),
                                        teamOfficialAttributesL = teamOfficialAttributes.length,
                                        teamOfficial = {};
                                    for (var index = 0; index < teamOfficialAttributesL; index++) {
                                        if (teamOfficialAttributes[index] != 'uID') {
                                            teamOfficial[teamOfficialAttributes[index]] = teams[iEquipo].teamofficial[iTeamOfficial].$[teamOfficialAttributes[index]];
                                        } else {
                                            teamOfficial[teamOfficialAttributes[index]] = teams[iEquipo].teamofficial[iTeamOfficial].$[teamOfficialAttributes[index]].substring(3);
                                        }
                                    }
                                    var teamOfficialPersonName = Object.keys(teams[iEquipo].teamofficial[iTeamOfficial].personname[0]),
                                        teamOfficialPersonNameL = teamOfficialPersonName.length;
                                    for (var index = 0; index < teamOfficialPersonNameL; index++) {
                                        teamOfficial[teamOfficialPersonName[index]] = teams[iEquipo].teamofficial[iTeamOfficial].personname[0][teamOfficialPersonName[index]][0];
                                    }
                                    equipo.teamofficial.push(teamOfficial);
                                }
                            }
                            equipos.push(equipo);
                        }
                    }
                    //return res.json(equipos);
                    if (typeof cambios !== 'undefined') {
                        cambiosL = cambios.length;
                        for (var i = 0; i < cambiosL; i++) {
                            var equipo = {
                                id: cambios[i].$.uID.substring(1),
                                name: cambios[i].name[0]
                            }
                            if (typeof cambios[i].player !== 'undefined') {
                                equipo['players'] = extras.procesaPlayersF40(cambios[i].player);
                            }
                            if (typeof cambios[i].teamofficial !== 'undefined') {
                                equipo['teamofficial'] = [];
                                var teamofficialL = cambios[i].teamofficial.length;
                                for (var iTeamOfficial = 0; iTeamOfficial < teamofficialL; iTeamOfficial++) {
                                    var propAtributos = Object.keys(cambios[i].teamofficial[iTeamOfficial].$),
                                        propAtributosL = propAtributos.length,
                                        propPersonname = Object.keys(cambios[i].teamofficial[iTeamOfficial].personname[0]),
                                        propPersonnameL = propPersonname.length,
                                        data = {};
                                    for (var iPropAtributos = 0; iPropAtributos < propAtributosL; iPropAtributos++) {
                                        data[propAtributos[iPropAtributos]] = cambios[i].teamofficial[iTeamOfficial].$[propAtributos[iPropAtributos]];
                                    }
                                    for (var iPersonname = 0; iPersonname < propPersonnameL; iPersonname++) {
                                        data[propPersonname[iPersonname]] = cambios[i].teamofficial[iTeamOfficial].personname[0][propPersonname[iPersonname]][0];
                                    }
                                    equipo.teamofficial.push(data);
                                }
                            }
                            equiposCambios.push(equipo);
                        }
                    }
                    campeonatosEquipos = {
                            type: cabecera.Type,
                            competition_code: cabecera.competition_code,
                            competition_id: cabecera.competition_id,
                            competition_name: extras.competitionNameTraduccion(cabecera.competition_name),
                            season_id: cabecera.season_id,
                            season_name: cabecera.season_name,
                            update_opta: fechaActualizacion,
                            teams: equipos,
                            playerchanges: equiposCambios
                        }
                        //return res.json(campeonatosEquipos);
                    equipos = undefined;
                    cabecera = undefined;
                    teams = undefined;

                    var teamsYEquiposDataNed = function() {
                        teamsL = campeonatosEquipos.teams.length;
                        
                        var respuesta = {
                            teams: {
                                data: []
                            },
                            players: []
                        };
                        for (var iTeam = 0; iTeam < teamsL; iTeam++) {

                            if (campeonatosEquipos.teams[iTeam].name.toLowerCase() != 'tbc') {
                                var jugadores = {
                                    teamId: campeonatosEquipos.teams[iTeam].id,
                                    data: {
                                        data: []
                                    }
                                };
                                var playersL = campeonatosEquipos.teams[iTeam].players.length,
                                    equipoNed = {
                                        "id": campeonatosEquipos.teams[iTeam].id,
                                        "fullname": typeof campeonatosEquipos.teams[iTeam].official_club_name !== 'undefined' ? campeonatosEquipos.teams[iTeam].official_club_name : campeonatosEquipos.teams[iTeam].name,
                                        "name": extras.nombreCortoSeleccion(campeonatosEquipos.teams[iTeam].name),
                                        "shortname": extras.nombresCortosNed[campeonatosEquipos.teams[iTeam].id] || extras.nombreCortoSeleccion(campeonatosEquipos.teams[iTeam].name) || campeonatosEquipos.teams[iTeam].name,                                        
                                        "initials": campeonatosEquipos.teams[iTeam].symid,                                                                                
                                        "founded": campeonatosEquipos.teams[iTeam].founded,                                        
                                        "nationId": typeof campeonatosEquipos.teams[iTeam].country !== 'undefined' ? extras.paisesNed(campeonatosEquipos.teams[iTeam].country) : 6,

                                        "nicks": extras.dataExtraTeam(campeonatosEquipos.teams[iTeam].id).nicks,
                                        "history": extras.dataExtraTeam(campeonatosEquipos.teams[iTeam].id).history,
                                        "c_titles": extras.dataExtraTeam(campeonatosEquipos.teams[iTeam].id).c_titles, 
                                        "c_classics": extras.dataExtraTeam(campeonatosEquipos.teams[iTeam].id).c_classics, 
                                        "c_home": extras.dataExtraTeam(campeonatosEquipos.teams[iTeam].id).c_home
                                        
                                    }
                            } else {
                                var playersL = 0,
                                    equipoNed = {
                                        "id": campeonatosEquipos.teams[iTeam].id,
                                        "fullname": typeof campeonatosEquipos.teams[iTeam].official_club_name !== 'undefined' ? campeonatosEquipos.teams[iTeam].official_club_name : campeonatosEquipos.teams[iTeam].name,
                                        "name": extras.nombreCortoSeleccion(campeonatosEquipos.teams[iTeam].name),
                                        "shortname": extras.nombresCortosNed[campeonatosEquipos.teams[iTeam].id] || extras.nombreCortoSeleccion(campeonatosEquipos.teams[iTeam].name) || campeonatosEquipos.teams[iTeam].name,
                                        "initials": campeonatosEquipos.teams[iTeam].symid,                                                                                
                                        "nationId": typeof campeonatosEquipos.teams[iTeam].country !== 'undefined' ? extras.paisesNed(campeonatosEquipos.teams[iTeam].country) : 6,

                                        "nicks": extras.dataExtraTeam(campeonatosEquipos.teams[iTeam].id).nicks,
                                        "history": extras.dataExtraTeam(campeonatosEquipos.teams[iTeam].id).history,
                                        "c_titles": extras.dataExtraTeam(campeonatosEquipos.teams[iTeam].id).c_titles, 
                                        "c_classics": extras.dataExtraTeam(campeonatosEquipos.teams[iTeam].id).c_classics, 
                                        "c_home": extras.dataExtraTeam(campeonatosEquipos.teams[iTeam].id).c_home
                                    }
                            }

                            for (var iPlayer = 0; iPlayer < playersL; iPlayer++) {

                                var dataPlayers,
                                    fechaNacimientoArr = campeonatosEquipos.teams[iTeam].players[iPlayer].birth_date.split('-'),
                                    fechaNacimiento = new Date(fechaNacimientoArr[0], fechaNacimientoArr[1], fechaNacimientoArr[2]);

                                dataPlayers = {
                                    id: campeonatosEquipos.teams[iTeam].players[iPlayer].id,
                                    firstName: campeonatosEquipos.teams[iTeam].players[iPlayer].first_name,
                                    lastName: campeonatosEquipos.teams[iTeam].players[iPlayer].last_name,
                                    weight: typeof campeonatosEquipos.teams[iTeam].players[iPlayer].weight !== 'undefined' ? parseInt(campeonatosEquipos.teams[iTeam].players[iPlayer].weight) : null,
                                    height: typeof campeonatosEquipos.teams[iTeam].players[iPlayer].height !== 'undefined' ? parseInt(campeonatosEquipos.teams[iTeam].players[iPlayer].height) : null,
                                    nationId: typeof campeonatosEquipos.teams[iTeam].players[iPlayer].country !== 'undefined' ? extras.paisesNed(campeonatosEquipos.teams[iTeam].players[iPlayer].country) : null,
                                    shirt: typeof campeonatosEquipos.teams[iTeam].players[iPlayer].jersey_num !== 'undefined' ? parseInt(campeonatosEquipos.teams[iTeam].players[iPlayer].jersey_num) : null,
                                    //type: "titular",
                                    role: extras.rolesPlayerNed(campeonatosEquipos.teams[iTeam].players[iPlayer].position)
                                        /*stats_goalAssistances: 20,
                                        stats_goals: 2*/
                                };

                                try {
                                    dataPlayers["birthDate"] = fechaNacimiento.toISOString();
                                    dataPlayers["age"] = extras.calculaEdad(fechaNacimiento);
                                } catch (err) {

                                }
                                jugadores.data.data.push(dataPlayers);
                            }
                            /*if(typeof respuesta.players[campeonatosEquipos.teams[iTeam].id] !== 'undefined'){
                            		respuesta.players[campeonatosEquipos.teams[iTeam].id].data.push(dataPlayers);
                            	} else {
                            		respuesta.players[campeonatosEquipos.teams[iTeam].id] = {
                            			data : [dataPlayers]
                            		};
                            	}*/
                            //return res.json(players);
                            //acciones.push(ned.playersPush(campeonatosEquipos.competition_id+'-'+campeonatosEquipos.season_id, campeonatosEquipos.teams[iTeam].id, players));
                            if (typeof campeonatosEquipos.teams[iTeam].teamofficial !== 'undefined') {
                                var teamOfficialL = campeonatosEquipos.teams[iTeam].teamofficial.length;
                                for (var iTeamOfficial = 0; iTeamOfficial < teamOfficialL; iTeamOfficial++) {
                                    if (campeonatosEquipos.teams[iTeam].teamofficial[iTeamOfficial].Type.toLowerCase() == 'manager') {
                                        dataManager = {
                                            id: campeonatosEquipos.teams[iTeam].teamofficial[iTeamOfficial].uID,
                                            firstName: campeonatosEquipos.teams[iTeam].teamofficial[iTeamOfficial].first,
                                            lastName: campeonatosEquipos.teams[iTeam].teamofficial[iTeamOfficial].last,
                                            role: 5
                                        };
                                        try {
                                            var dataManager,
                                                fechaNacimientoArr = campeonatosEquipos.teams[iTeam].teamofficial[iTeamOfficial].birthdate.split('-'),
                                                fechaNacimiento = new Date(fechaNacimientoArr[0], fechaNacimientoArr[1], fechaNacimientoArr[2]);

                                            dataManager["birthDate"] = fechaNacimiento.toISOString();
                                            dataManager["age"] = extras.calculaEdad(fechaNacimiento);
                                        } catch (err) {

                                        }

                                        jugadores.data.data.push(dataManager);
                                        equipoNed['dt'] = campeonatosEquipos.teams[iTeam].teamofficial[iTeamOfficial].uID;
                                    }
                                }
                            }
                            

                            if (equipoNed.id == '7589' && campeonatosEquipos.competition_id != '872' || equipoNed.id != '7589')
                            respuesta.teams.data.push(equipoNed);
                            respuesta.players.push(jugadores);                            
                        }                                
                        return respuesta;
                    }
                    var dataTeamsYEquiposNed = teamsYEquiposDataNed();                                        
                    
                    var teamsPushNed = function() {                        
                        return new Promise(function(resolve, reject) {                            
                            ned.teamsPush(campeonatosEquipos.competition_id + '-' + campeonatosEquipos.season_id, dataTeamsYEquiposNed.teams.data).then(function(respuesta) {
                                return dataTeamsYEquiposNed.players.reduce(function(sequence, team) {
                                    return sequence.then(function() {
                                        return ned.playersPush(campeonatosEquipos.competition_id + '-' + campeonatosEquipos.season_id, team.teamId, team.data.data);
                                    }).then(function(data) {
                                        console.log("equipo ok");
                                    });
                                }, Promise.resolve());
                            }).then(function(respuesta) {
                                resolve('Todo ok');
                            }).catch(function(err) {
                                reject(err);
                            });
                        });
                    }
                
                    var guardaF40 = function() {
                        return new Promise(function(resolve, reject) {
                            resolve();
                        });
                    }

                    guardaF40().then(function(respuesta) {
                        if (extras.campeonatosPushNed(campeonatosEquipos.competition_id, campeonatosEquipos.season_id)) {
                            return teamsPushNed();
                        } else {
                            return Promise.resolve('Ok');
                        }
                        //return teamsPushNed();
                    }).then(function(respuesta) {
                        res.status(200).send('Todas las peticiones correctas');
                    }).catch(function(reject) {
                        console.log("ocurrio un problema al guardar teams/players");
                        console.log(reject);
                        res.send(reject);
                    })

                    
                    //res.status(200).json(campeonatosEquipos);
                    break;
                case 'f30': //ESTADISTICAS DE UN EQUIPO X CAMPEONATO
                    //return res.json(req.body); 
                    if (typeof req.body.seasonstatistics !== 'undefined') {
                        if (typeof req.body.seasonstatistics.$ !== 'undefined') {
                            if (extras.campeonatosPushNed(req.body.seasonstatistics.$.competition_id, req.body.seasonstatistics.$.season_id)) {
                                if (typeof req.body.seasonstatistics.team !== 'undefined') {
                                    if (typeof req.body.seasonstatistics.team[0] !== 'undefined') {
                                        ned.teamGet(req.body.seasonstatistics.$.competition_id + '-' + req.body.seasonstatistics.$.season_id, req.body.seasonstatistics.team[0].$.id).then(function(teamNed) {
                                            
                                            if (typeof req.body.seasonstatistics.team[0].player !== 'undefined') {
                                                var jugadoresOpta = req.body.seasonstatistics.team[0].player;
                                                var jugadoresOptaL = jugadoresOpta.length;
                                                req.body.seasonstatistics.team[0].player = undefined;
                                                var data = {
                                                    players: []
                                                }
                                                var playersPorId = {};
                                                if (jugadoresOptaL != 0) {
                                                    for (var iJugadoresOpta = 0; iJugadoresOpta < jugadoresOptaL; iJugadoresOpta++) {
                                                        var jugadorData = {
                                                            stats: {}
                                                        };
                                                        if (typeof jugadoresOpta[iJugadoresOpta].$ !== 'undefined') {
                                                            var propiedadesJugador = Object.keys(jugadoresOpta[iJugadoresOpta].$);
                                                            var propiedadesJugadorL = propiedadesJugador.length;
                                                            for (var iPropiedadesJugador = 0; iPropiedadesJugador < propiedadesJugadorL; iPropiedadesJugador++) {
                                                                jugadorData[propiedadesJugador[iPropiedadesJugador]] = jugadoresOpta[iJugadoresOpta].$[propiedadesJugador[iPropiedadesJugador]];
                                                            }
                                                        }

                                                        if (typeof jugadoresOpta[iJugadoresOpta].stat !== 'undefined') {
                                                            var jugadorStatsL = jugadoresOpta[iJugadoresOpta].stat.length;
                                                            for (var iJugadorStats = 0; iJugadorStats < jugadorStatsL; iJugadorStats++) {
                                                                jugadorData.stats[jugadoresOpta[iJugadoresOpta].stat[iJugadorStats].$.name] = jugadoresOpta[iJugadoresOpta].stat[iJugadorStats]._;
                                                            }
                                                        }
                                                        data.players.push(jugadorData);
                                                        playersPorId[jugadorData.player_id] = jugadorData.stats;
                                                    }

                                                    var dataNed = {
                                                        data: []
                                                    };
                            
                                                    if (teamNed.length != 0) {
                                                        var teamNedL = teamNed.length;
                                                        for (var iPlayerNed = 0; iPlayerNed < teamNedL; iPlayerNed++) {
                                                            if(typeof teamNed[iPlayerNed] !== 'undefined') {
                                                                if(typeof teamNed[iPlayerNed].player.id !== 'undefined') {
                                                                    var jugadorNedStats = {
                                                                        id: teamNed[iPlayerNed].player.id
                                                                    };                                                                
                                                                    if (typeof playersPorId[teamNed[iPlayerNed].player.id] !== 'undefined') {
                                                                        if (Object.keys(playersPorId[teamNed[iPlayerNed].player.id]).length > 0) {
                                                                            if (typeof playersPorId[teamNed[iPlayerNed].player.id]['Goal Assists'] !== 'undefined') {
                                                                                jugadorNedStats['stats_goalAssistances'] = playersPorId[teamNed[iPlayerNed].player.id]['Goal Assists'];
                                                                            }
                                                                            if (typeof playersPorId[teamNed[iPlayerNed].player.id].Goals !== 'undefined') {
                                                                                jugadorNedStats['stats_goals'] = playersPorId[teamNed[iPlayerNed].player.id].Goals;
                                                                            }
                                                                            if (Object.keys(jugadorNedStats).length > 1) {
                                                                                dataNed.data.push(jugadorNedStats);
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            } 
                                                        }
                                                        if (dataNed.data.length != 0) {     
                                                            
                                                            if(req.body.seasonstatistics.$.competition_id != '872' && req.body.seasonstatistics.team[0].$.id == '7589' || req.body.seasonstatistics.team[0].$.id != '7589'){
                                                                
                                                                return ned.playersPush(req.body.seasonstatistics.$.competition_id + '-' + req.body.seasonstatistics.$.season_id, req.body.seasonstatistics.team[0].$.id, dataNed.data);

                                                            } else {
                                                                
                                                                return Promise.resolve('Nada que ingresar');
                                                            }                                                               

                                                        } else {
                                                            return Promise.resolve('Nada que ingresar');
                                                        }
                                                    } else {
                                                        return Promise.resolve('Nada que ingresar');
                                                    }
                                                } else {
                                                    return Promise.resolve('Nada que ingresar');
                                                }
                                            } else {
                                                return Promise.resolve('Nada que ingresar');
                                            }
                                        }).then(function(respuesta) {
                                            
                                            if (typeof req.body.seasonstatistics.team[0].stat !== 'undefined') {
                                                if (typeof req.body.seasonstatistics.team[0].stat[0] !== 'undefined') {
                                                    var statsTeam = req.body.seasonstatistics.team[0].stat;                                                    
                                                    var statsTeamL = statsTeam.length;
                                                    //req.body.seasonstatistics.team[0].stat = undefined;
                                                    var dataStats = {
                                                        data: {}
                                                    };
                                                    if (statsTeamL != 0) {
                                                        dataStats.data = {};                                                       

                                                        for (var iStatsTeam = 0; iStatsTeam < statsTeamL; iStatsTeam++) {
                                                            (function() {
                                                                switch (statsTeam[iStatsTeam].$.name) {
                                                                    case 'Penalties Taken':
                                                                        dataStats.data['total_penalties'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Corners Taken (incl short corners)':
                                                                        dataStats.data['total_cornerKicks'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Goal Assists':
                                                                        dataStats.data['total_goalAssistances'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Offsides':
                                                                        dataStats.data['total_offsides'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Total Red Cards':
                                                                        dataStats.data['total_redCards'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Yellow Cards':
                                                                        dataStats.data['total_yellowCards'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Total Fouls Won':
                                                                        dataStats.data['total_foulsSuffered'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Total Fouls Conceded':
                                                                        dataStats.data['total_fouls'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Total Shots':
                                                                        dataStats.data['total_shots'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Shooting Accuracy':
                                                                        dataStats.data['effectiveness_shots'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;                                                                       
                                                                    case 'Own Goal Scored':
                                                                        dataStats.data['goals_own'] = typeof statsTeam[iStatsTeam]._ !== 'undefined' ? parseInt(statsTeam[iStatsTeam]._) : 0;
                                                                        break;
                                                                    case 'Penalty Goals':
                                                                        dataStats.data['goals_penalty'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Set Pieces Goals':
                                                                        dataStats.data['goals_freeKick'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Headed Goals':
                                                                        dataStats.data['goals_headed'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Goals Conceded':
                                                                        dataStats.data['goals_against'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Goals':
                                                                        dataStats.data['goals_scored'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        break;
                                                                    case 'Games Played': {
                                                                        
                                                                        dataStats.data['games'] = parseInt(statsTeam[iStatsTeam]._);
                                                                        dataStats.data['games_played'] = parseInt(statsTeam[iStatsTeam]._);                                                                        
                                                                        break;
                                                                    }  
                                                                    
                                                                }                                                                
                                                            }(iStatsTeam));
                                                        }

                                                        if (typeof dataStats.data['total_penalties'] !== 'undefined' && typeof dataStats.data['goals_penalty'] !== 'undefined')
                                                            dataStats.data['effectiveness_penalties'] = Math.round(dataStats.data['goals_penalty'] / dataStats.data['total_penalties'] * 100);

                                                        if (typeof dataStats.data['games'] !== 'undefined') {
                                                            if (typeof dataStats.data['goals_scored'] !== 'undefined')
                                                                dataStats.data['goals_perGame'] = Math.round((dataStats.data['goals_scored'] / dataStats.data['games']) * 10) / 10;
                                                            if (typeof dataStats.data['goals_penalty'] !== 'undefined')
                                                                dataStats.data['perGame_penalties'] = Math.round((dataStats.data['goals_penalty'] / dataStats.data['games']) * 10) / 10;
                                                            if (typeof dataStats.data['total_cornerKicks'] !== 'undefined')
                                                                dataStats.data['perGame_cornerKicks'] = Math.round((dataStats.data['total_cornerKicks'] / dataStats.data['games']) * 10) / 10;
                                                            if (typeof dataStats.data['total_goalAssistances'] !== 'undefined')
                                                                dataStats.data['perGame_goalAssistances'] = Math.round((dataStats.data['total_goalAssistances'] / dataStats.data['games']) * 10) / 10;
                                                            if (typeof dataStats.data['total_offsides'] !== 'undefined')
                                                                dataStats.data['perGame_offsides'] = Math.round((dataStats.data['total_offsides'] / dataStats.data['games']) * 10) / 10;
                                                            if (typeof dataStats.data['total_redCards'] !== 'undefined')
                                                                dataStats.data['perGame_redCards'] = Math.round((dataStats.data['total_redCards'] / dataStats.data['games']) * 10) / 10;
                                                            if (typeof dataStats.data['total_yellowCards'] !== 'undefined')
                                                                dataStats.data['perGame_yellowCards'] = Math.round((dataStats.data['total_yellowCards'] / dataStats.data['games']) * 10) / 10;
                                                            if (typeof dataStats.data['total_foulsSuffered'] !== 'undefined')
                                                                dataStats.data['perGame_foulsSuffered'] = Math.round((dataStats.data['total_foulsSuffered'] / dataStats.data['games']) * 10) / 10;
                                                            if (typeof dataStats.data['total_fouls'] !== 'undefined')
                                                                dataStats.data['perGame_fouls'] = Math.round((dataStats.data['total_fouls'] / dataStats.data['games']) * 10) / 10;
                                                            if (typeof dataStats.data['total_shots'] !== 'undefined')
                                                                dataStats.data['perGame_shots'] = Math.round((dataStats.data['total_shots'] / dataStats.data['games']) * 10) / 10;
                                                        }

                                                        if (typeof dataStats.data['goals_penalty'] !== 'undefined' && typeof dataStats.data['goals_freeKick'] !== 'undefined' &&
                                                            typeof dataStats.data['goals_headed'] !== 'undefined' && typeof dataStats.data['goals_scored'] !== 'undefined') {
                                                            dataStats.data['goals_played'] = dataStats.data['goals_scored'] - (dataStats.data['goals_penalty'] + dataStats.data['goals_freeKick'] + dataStats.data['goals_headed'])
                                                        }
                                                        if (Object.keys(dataStats.data).length != 0) {    
                                                            
                                                            if(req.body.seasonstatistics.$.competition_id != '872' && req.body.seasonstatistics.team[0].$.id == '7589' || req.body.seasonstatistics.team[0].$.id != '7589'){                                                        
                                                                
                                                                ned.championshipMatchStatPush(req.body.seasonstatistics.$.competition_id + '-' + req.body.seasonstatistics.$.season_id, req.body.seasonstatistics.team[0].$.id, dataStats).then(function(resolve) {
                                                                    return Promise.resolve();
                                                                }).catch(function() {
                                                                    return Promise.resolve('Nada que ingresar')
                                                                });
                                                            } else {
                                                                
                                                                return Promise.resolve('Nada que ingresar');    
                                                            }
                                                        } else {
                                                            return Promise.resolve('Nada que ingresar');
                                                        }
                                                    } else {
                                                        return Promise.resolve('Nada que ingresar');
                                                    }
                                                } else {
                                                    return Promise.resolve('Nada que ingresar');
                                                }
                                            } else {
                                                return Promise.resolve('Nada que ingresar');
                                            }
                                        }).then(function(resolve) {
                                            console.log('Todo ok');
                                            res.sendStatus(200);
                                        }).catch(function(err) {
                                            console.log(err);
                                            res.sendStatus(200);
                                        });
                                    } else {
                                        res.sendStatus(200);
                                    }
                                }
                            } else {
                                res.sendStatus(200);
                            }
                        } else {
                            res.sendStatus(200);
                        }
                    } else {
                        res.sendStatus(200);
                    }
                    break;
                case 'f9': //MARCADOR EN VIVO 
                    //return res.json(req.body);					
                    if (typeof req.body.soccerfeed !== 'undefined') {
                        if (typeof req.body.soccerfeed.soccerdocument !== 'undefined') {
                            if (typeof req.body.soccerfeed.soccerdocument[0] !== 'undefined') {
                                if (typeof req.body.soccerfeed.soccerdocument[0].$ !== 'undefined') {
                                    if (typeof req.body.soccerfeed.soccerdocument[0].competition !== 'undefined') {
                                        if (typeof req.body.soccerfeed.soccerdocument[0].competition[0].$ !== 'undefined') {
                                            if (typeof req.body.soccerfeed.soccerdocument[0].competition[0].$.uID !== 'undefined') {
                                                if (extras.campeonatosPushNed(competitionIdNed, seasonIdNed)) {
                                                    if (typeof req.body.soccerfeed.soccerdocument[0].$.uID !== 'undefined') {
                                                        ned.matchDateGet(competitionIdNed + '-' + seasonIdNed).then(function(matchDateByTeam) {
                                                            
                                                            var matchDateIds = matchDateByTeam;
                                                            var matchId = req.body.soccerfeed.soccerdocument[0].$.uID.substring(1);
                                                            (function(matchDateIds) {
                                                                
                                                                ned.matchGet(matchId).then(function(match) {                                                                    
                                                                    
                                                                    var dataNed = {
                                                                        data: []
                                                                    };
                                                                    var matchData = {
                                                                        data: {}
                                                                    };
                                                                    //data altavoz
                                                                    var dataAway = dataHome = { "Score" : "0", "Side" : "", "TeamRef" : "" };
                                                                    var fixtureAltavoz = [];

                                                                    if (typeof match.id !== 'undefined') {
                                                                        if (typeof req.body.soccerfeed.soccerdocument[0].matchdata !== 'undefined') {
                                                                            if (typeof req.body.soccerfeed.soccerdocument[0].matchdata[0] !== 'undefined') {
                                                                                if (typeof req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata !== 'undefined') {
                                                                                    if (typeof req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata !== 'undefined') {

                                                                                        if (typeof req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[0].$ !== 'undefined')
                                                                                            var dataHome = req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[0].$;
                                                                                        if (typeof req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[1].$ !== 'undefined')
                                                                                            var dataAway = req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[1].$;
                                                                                        //incidencias																						
                                                                                        var teamDataL = req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata.length;                                                                                        
                                                                                        for (var iTeamData = 0; iTeamData < teamDataL; iTeamData++) {
                                                                                            var propiedadesTeamData = Object.keys(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData]);
                                                                                            var propiedadesTeamDataL = propiedadesTeamData.length;
                                                                                            for (var iPropiedadesTeamData = 0; iPropiedadesTeamData < propiedadesTeamDataL; iPropiedadesTeamData++) {
                                                                                            
                                                                                                switch (propiedadesTeamData[iPropiedadesTeamData].toLowerCase()) {
                                                                                                    case 'goal':
                                                                                                        var goalsL = req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]].length;
                                                                                                        for (var iGoals = 0; iGoals < goalsL; iGoals++) {
                                                                                                            var incidencia = {
                                                                                                                "id": parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iGoals].$.EventID),
                                                                                                                "teamId": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData].$.TeamRef.substring(1),
                                                                                                                "playerId": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iGoals].$.PlayerRef.substring(1),
                                                                                                                "half": extras.periodNed(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iGoals].$.Period),
                                                                                                                "seconds": 0,
                                                                                                                "minutes": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iGoals].$.Time,
                                                                                                                "card": null,
                                                                                                                "catchedBy": null,
                                                                                                                "eventDate": typeof req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iGoals].$.TimeStamp !== 'undefined' ? m(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iGoals].$.TimeStamp).format("YYYY-MM-DDTHH:mm:ssZZ") : null
                                                                                                            };
                                                                                                            switch (req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iGoals].$.Type.toLowerCase()) {
                                                                                                                case 'goal':
                                                                                                                    incidencia['type'] = 9;
                                                                                                                    incidencia['name'] = 'Gol de Jugada';
                                                                                                                    break;
                                                                                                                case 'own':
                                                                                                                    incidencia['type'] = 10;
                                                                                                                    incidencia['name'] = 'Autogol';
                                                                                                                    break;
                                                                                                                case 'penalty':
                                                                                                                    incidencia['type'] = 13;
                                                                                                                    incidencia['name'] = 'Gol de Penal';
                                                                                                                    break;
                                                                                                            }
                                                                                                            if (typeof incidencia.type !== 'undefined') {
                                                                                                                dataNed.data.push(incidencia);
                                                                                                            }
                                                                                                        }
                                                                                                        break;
                                                                                                    case 'missedpenalty':
                                                                                                        var missedpenaltysL = req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]].length;
                                                                                                        for (var iMissedpenaltys = 0; iMissedpenaltys < missedpenaltysL; iMissedpenaltys++) {
                                                                                                            var incidencia = {
                                                                                                                "id": parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iMissedpenaltys].$.EventID),
                                                                                                                "teamId": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData].$.TeamRef.substring(1),
                                                                                                                "playerId": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iMissedpenaltys].$.PlayerRef.substring(1),
                                                                                                                "half": extras.periodNed(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iMissedpenaltys].$.Period),
                                                                                                                "seconds": 0,
                                                                                                                "minutes": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iMissedpenaltys].$.Time,
                                                                                                                "card": null,
                                                                                                                "catchedBy": null,
                                                                                                                "eventDate": typeof req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iMissedpenaltys].$.TimeStamp !== 'undefined' ? m(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iMissedpenaltys].$.TimeStamp).format("YYYY-MM-DDTHH:mm:ssZZ") : null
                                                                                                            };
                                                                                                            switch (req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iMissedpenaltys].$.Type.toLowerCase()) {
                                                                                                                case 'missed':
                                                                                                                    incidencia['type'] = 44;
                                                                                                                    incidencia['name'] = 'Penal Desviado';
                                                                                                                    break;
                                                                                                                case 'post':
                                                                                                                    incidencia['type'] = 45;
                                                                                                                    incidencia['name'] = 'Penal al Palo';
                                                                                                                    break;
                                                                                                                case 'saved':
                                                                                                                    incidencia['type'] = 43;
                                                                                                                    incidencia['name'] = 'Penal Atajado';
                                                                                                                    break;
                                                                                                            }
                                                                                                            if (typeof incidencia.type !== 'undefined') {
                                                                                                                dataNed.data.push(incidencia);
                                                                                                            }
                                                                                                        }
                                                                                                        break;
                                                                                                    case 'booking':
                                                                                                        var bookingsL = req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]].length;
                                                                                                        for (var iBooking = 0; iBooking < bookingsL; iBooking++) {
                                                                                                            var incidencia = {
                                                                                                                "id": parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iBooking].$.EventID),
                                                                                                                "teamId": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData].$.TeamRef.substring(1),
                                                                                                                "playerId": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iBooking].$.PlayerRef.substring(1),
                                                                                                                "half": extras.periodNed(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iBooking].$.Period),
                                                                                                                "seconds": 0,
                                                                                                                "minutes": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iBooking].$.Time,
                                                                                                                "card": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iBooking].$.Card.toLowerCase(),
                                                                                                                "catchedBy": null,
                                                                                                                "eventDate": typeof req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iBooking].$.TimeStamp !== 'undefined' ? m(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iBooking].$.TimeStamp).format("YYYY-MM-DDTHH:mm:ssZZ") : null
                                                                                                            };
                                                                                                            switch (req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iBooking].$.CardType.toLowerCase()) {
                                                                                                                case 'yellow':
                                                                                                                    incidencia['type'] = 3;
                                                                                                                    incidencia['name'] = 'Tarjeta Amarilla';
                                                                                                                    incidencia['card'] = 'yellow';
                                                                                                                    break;
                                                                                                                case 'secondyellow':
                                                                                                                    incidencia['type'] = 4;
                                                                                                                    incidencia['name'] = 'Roja por 2 Amarillas';
                                                                                                                    incidencia['card'] = 'red';
                                                                                                                    break;
                                                                                                                case 'straightred':
                                                                                                                    incidencia['type'] = 5;
                                                                                                                    incidencia['name'] = 'Tarjeta Roja';
                                                                                                                    incidencia['card'] = 'red';
                                                                                                                    break;
                                                                                                            }
                                                                                                            if (typeof incidencia.type !== 'undefined') {
                                                                                                                dataNed.data.push(incidencia);
                                                                                                            }
                                                                                                        }
                                                                                                        break;
                                                                                                    case 'shootout':
                                                                                                        var matchStats = req.body.soccerfeed.soccerdocument[0].matchdata[0].stat;
                                                                                                        var finPartido;
                                                                                                        var statL = matchStats.length;
                                                                                                        for (var iStat = 0; iStat < statL; iStat++) {
                                                                                                            if (matchStats[iStat].$.Type == 'match_time')
                                                                                                                finPartido = parseInt(matchStats[iStat]._);
                                                                                                        }
                                                                                                        if (typeof req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][0].penaltyshot !== 'undefined') {
                                                                                                            var penalesL = req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][0].penaltyshot.length;
                                                                                                            var primerPenal = req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][0].$.FirstPenalty;
                                                                                                            var dif = primerPenal > 0 ? 1 : 2;
                                                                                                            for (var iPenal = 0; iPenal < penalesL; iPenal++) {
                                                                                                                var incidencia = {
                                                                                                                    "id": parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][0].penaltyshot[iPenal].$.EventID),
                                                                                                                    "teamId": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData].$.TeamRef.substring(1),
                                                                                                                    "playerId": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][0].penaltyshot[iPenal].$.PlayerRef.substring(1),
                                                                                                                    "half": 5,
                                                                                                                    "seconds": 59,
                                                                                                                    "minutes": finPartido + dif,
                                                                                                                    "card": null,
                                                                                                                    "catchedBy": null,
                                                                                                                    "eventDate": typeof req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][0].penaltyshot[iPenal].$.TimeStamp !== 'undefined' ? m(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][0].penaltyshot[iPenal].$.TimeStamp).format("YYYY-MM-DDTHH:mm:ssZZ") : null
                                                                                                                };
                                                                                                                dif = dif + 2;
                                                                                                                switch (req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][0].penaltyshot[iPenal].$.Outcome.toLowerCase()) {
                                                                                                                    case 'missed':
                                                                                                                        incidencia['type'] = 44;
                                                                                                                        incidencia['name'] = 'Penal Desviado';
                                                                                                                        break;
                                                                                                                    case 'scored':
                                                                                                                        incidencia['type'] = 55;
                                                                                                                        incidencia['name'] = 'Gol Def. Penales';
                                                                                                                        break;
                                                                                                                    case 'saved':
                                                                                                                        incidencia['type'] = 43;
                                                                                                                        incidencia['name'] = 'Penal Atajado';
                                                                                                                        break;
                                                                                                                }
                                                                                                                if (typeof incidencia.type !== 'undefined') {
                                                                                                                    dataNed.data.push(incidencia);
                                                                                                                }
                                                                                                            }
                                                                                                            //console.log(req.body.soccerfeed.soccerdocument[0].matchdata);
                                                                                                        }
                                                                                                        break;
                                                                                                    case 'substitution':
                                                                                                        var cambiosL = req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]].length;
                                                                                                        for (var iCambios = 0; iCambios < cambiosL; iCambios++) {
                                                                                                            dataNed.data.push({
                                                                                                                "id": parseInt('6' + Math.round(parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iCambios].$.EventID) / 1000)),
                                                                                                                "teamId": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData].$.TeamRef.substring(1),
                                                                                                                "playerId": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iCambios].$.SubOn.substring(1),
                                                                                                                "half": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iCambios].$.Period,
                                                                                                                "seconds": 0,
                                                                                                                "minutes": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iCambios].$.Time,
                                                                                                                "card": null,
                                                                                                                "catchedBy": null,
                                                                                                                "type": 6,
                                                                                                                "name": 'Entrada'
                                                                                                            });
                                                                                                            dataNed.data.push({
                                                                                                                "id": parseInt('7' + Math.round(parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iCambios].$.EventID) / 1000)),
                                                                                                                "teamId": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData].$.TeamRef.substring(1),
                                                                                                                "playerId": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iCambios].$.SubOff.substring(1),
                                                                                                                "half": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iCambios].$.Period,
                                                                                                                "seconds": 0,
                                                                                                                "minutes": req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iCambios].$.Time,
                                                                                                                "card": null,
                                                                                                                "catchedBy": null,
                                                                                                                "type": 7,
                                                                                                                "name": 'Salida'
                                                                                                            });
                                                                                                        }
                                                                                                        break;
                                                                                                    case 'stat':
                                                                                                        var statL = req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]].length;
                                                                                                        if (req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData].$.Side == 'Home') {
                                                                                                            for (var iStat = 0; iStat < statL; iStat++) {
                                                                                                                switch (req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat].$.Type) {
                                                                                                                    case 'att_pen_goal':
                                                                                                                        matchData.data['localPenalties'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                    case 'fk_foul_lost':
                                                                                                                        matchData.data['localFouls'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                    case 'total_yel_card':
                                                                                                                        matchData.data['localYellowCards'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                    case 'total_red_card':
                                                                                                                        matchData.data['localRedCards'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                    case 'corner_taken':
                                                                                                                        matchData.data['localCorners'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                    case 'freekick_cross':
                                                                                                                        matchData.data['localFreeKicks'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                    case 'possession_percentage':
                                                                                                                        matchData.data['localPossession'] = Math.round(Number(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._))
                                                                                                                        break;
                                                                                                                    case 'att_pen_goal':
                                                                                                                        matchData.data['localPenaltyGoals'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                    case 'goals':
                                                                                                                        matchData.data['localGoals'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                }
                                                                                                            }
                                                                                                        } else {
                                                                                                            for (var iStat = 0; iStat < statL; iStat++) {
                                                                                                                switch (req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat].$.Type) {
                                                                                                                    case 'att_pen_goal':
                                                                                                                        matchData.data['visitorPenalties'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._);
                                                                                                                        break;
                                                                                                                    case 'fk_foul_lost':
                                                                                                                        matchData.data['visitorFouls'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                    case 'total_yel_card':
                                                                                                                        matchData.data['visitorYellowCards'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                    case 'total_red_card':
                                                                                                                        matchData.data['visitorRedCards'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                    case 'corner_taken':
                                                                                                                        matchData.data['visitorCorners'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                    case 'freekick_cross':
                                                                                                                        matchData.data['visitorFreeKicks'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                    case 'possession_percentage':
                                                                                                                        matchData.data['visitorPossession'] = Math.round(Number(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._))
                                                                                                                        break;
                                                                                                                    case 'att_pen_goal':
                                                                                                                        matchData.data['visitorPenaltyGoals'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                    case 'goals':
                                                                                                                        matchData.data['visitorGoals'] = parseInt(req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata[iTeamData][propiedadesTeamData[iPropiedadesTeamData]][iStat]._)
                                                                                                                        break;
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                        break;
                                                                                                    default:
                                                                                                        break;
                                                                                                }
                                                                                            }                                                                                            
                                                                                        }
                                                                                        // datos players
                                                                                        var teamData = req.body.soccerfeed.soccerdocument[0].team;
                                                                                        var dataPlayers = [];
                                                                                        for (var i = 0; i < teamData.length; i++) {
                                                                                            var players = teamData[i].player;
                                                                                            for (var j = 0; j < players.length; j++) {
                                                                                                var player = players[j];
                                                                                                dataPlayers[player.$.uID.substring(1).toString()] = {
                                                                                                    id: player.$.uID.substring(1),
                                                                                                    role: extras.rolesPlayerNed(player.$.Position)
                                                                                                };
                                                                                            }
                                                                                        }

                                                                                        //match players
                                                                                        var dataMatchPlayers = [];
                                                                                        var teamData = req.body.soccerfeed.soccerdocument[0].matchdata[0].teamdata;
                                                                                        for (var i = 0; i < teamData.length; i++) {
                                                                                            var matchPlayers = teamData[i].playerlineup[0].matchplayer;
                                                                                            dataMatchPlayers[teamData[i].$.TeamRef.substring(1)] = {
                                                                                                id: competitionIdNed + '-' + seasonIdNed,
                                                                                                matchId: matchId,
                                                                                                teamId: teamData[i].$.TeamRef.substring(1),
                                                                                                data: []
                                                                                            }
                                                                                            for (var j = 0; j < matchPlayers.length; j++) {
                                                                                                var matchPlayer = matchPlayers[j].$;
                                                                                                var formacion = matchPlayers[j].stat;
                                                                                                var orden = 0;
                                                                                                for (var k = 0; k < formacion.length; k++) {
                                                                                                    if (formacion[k].$.Type == 'formation_place')
                                                                                                        orden = parseInt(formacion[k]._);
                                                                                                }
                                                                                                dataMatchPlayers[teamData[i].$.TeamRef.substring(1)].data.push({
                                                                                                    "playerId": matchPlayer.PlayerRef.substring(1),
                                                                                                    "shirt": typeof matchPlayer.ShirtNumber !== 'undefined' ? parseInt(matchPlayer.ShirtNumber) : null,
                                                                                                    "captain": typeof matchPlayer.Captain !== 'undefined' ? (matchPlayer.Captain == 1 ? true : false) : false,
                                                                                                    "order": orden,
                                                                                                    "type": matchPlayer.Status.toLowerCase() == 'start' ? "Titular" : "Suplente",
                                                                                                    "role": matchPlayer.Status.toLowerCase() == 'start' && typeof matchPlayer.SubPosition === 'undefined' ? extras.rolesPlayerNed(matchPlayer.Position) : extras.rolesPlayerNed(matchPlayer.SubPosition)
                                                                                                });
                                                                                            }
                                                                                        }

                                                                                        //data altavoz
                                                                                        var partidoAltavoz = {
                                                                                            //"idCampeonato": req.body.soccerfeed.soccerdocument[0].competition[0].$.uID.substring(1),
                                                                                            "idPartido": matchId,
                                                                                            "localData": {
                                                                                                "id": dataHome.TeamRef.substring(1),
                                                                                                "goles": typeof dataHome.Score !== 'undefined' ? dataHome.Score : "-"
                                                                                            },
                                                                                            "visitaData": {
                                                                                                "id": dataAway.TeamRef.substring(1),                                                                                                
                                                                                                "goles": typeof dataAway.Score !== 'undefined' ? dataAway.Score : "-"
                                                                                            }
                                                                                        };

                                                                                        if (matchId != '959926' && matchId != '959925') {                                                       
                                                                                            fixtureAltavoz.push(partidoAltavoz);                                                                                                                                                                     
                                                                                        }

                                                                                        return dataMatchPlayers.reduce(function(sequence, data) {
                                                                                            return sequence.then(function(resolve) {
                                                                                                return data.data.reduce(function(sequence, player) {
                                                                                                    return sequence.then(function(resolve) {
                                                                                                                                                                                                                
                                                                                                        if (matchId != '959926' && matchId != '959925') {                                                                                                            
                                                                                                            return ned.matchTeamPlayerPush(data.id, data.matchId, data.teamId, player.playerId, [player]);
                                                                                                        }
                                                                                                    })
                                                                                                }, Promise.resolve());
                                                                                            }).
                                                                                            catch(function() {
                                                                                                console.log("error matchTeamPlayers");
                                                                                            });
                                                                                        }, Promise.resolve()).then(function() {
                                                                                            if (matchId != '959926' && matchId != '959925') {
                                                                                                return ned.incidencePush(matchId, dataNed.data);
                                                                                            }
                                                                                        }).then(function(){
                                                                                            if (extras.campeonatosPushAltavoz(competitionIdNed, seasonIdNed)){
                                                                                                if (matchId != '959926' && matchId != '959925') {
                                                                                                    return altavoz.pushFixture(fixtureAltavoz);
                                                                                                }
                                                                                            }
                                                                                            else
                                                                                                return Promise.resolve('Ok');
                                                                                        }).then(function() {
                                                                                            var fechasNedIds = {};
                                                                                            for (var i = 0, len = matchDateIds.length; i < len; i++) {
                                                                                                fechasNedIds[matchDateIds[i].name] = matchDateIds[i];
                                                                                            }
                                                                                            
                                                                                            if (matchId != '964795' && matchId != '964800') {
                                                                                                match.levelName = 'Final';                                                                                                
                                                                                            }
                                                                                            
                                                                                            if (typeof fechasNedIds[match.levelName.toString()] !== 'undefined'){
                                                                                                if (matchId != '959926' && matchId != '959925') {
                                                                                                    return ned.matchDatesMatchPush(fechasNedIds[match.levelName.toString()].id, req.body.soccerfeed.soccerdocument[0].$.uID.substring(1), matchData);
                                                                                                }
                                                                                            }
                                                                                            else {
                                                                                                console.log("fecha no encontrada");
                                                                                            }
                                                                                        }).then(function() {
                                                                                            console.log("todo OK");
                                                                                            res.sendStatus(200);
                                                                                        }).catch(function(err) {
                                                                                            console.log('error 2 ' + err);
                                                                                            res.sendStatus(200);
                                                                                        });
                                                                                    } else {
                                                                                        res.sendStatus(200);
                                                                                    }
                                                                                } else {
                                                                                    res.sendStatus(200);
                                                                                }
                                                                            } else {
                                                                                res.sendStatus(200);
                                                                            }
                                                                        } else {
                                                                            res.sendStatus(200);
                                                                        }
                                                                    } else {
                                                                        res.sendStatus(200);
                                                                    }
                                                                }).catch(function(err) {
                                                                    console.log('Error al consultar matches');
                                                                    res.send(err);
                                                                });
                                                                //}
                                                                    
                                                            })(matchDateIds);

                                                        }).catch(function(reject) {
                                                            console.log('matchDates no encontrada.');
                                                            res.send(reject);
                                                        });
                                                    } else {
                                                        res.sendStatus(200);
                                                    }
                                                } else {
                                                    res.sendStatus(200);
                                                }
                                            } else {
                                                res.sendStatus(200);
                                            }
                                        } else {
                                            res.sendStatus(200);
                                        }
                                    } else {
                                        res.sendStatus(200);
                                    }
                                } else {
                                    res.sendStatus(200);
                                }
                            } else {
                                res.sendStatus(200);
                            }
                        } else {
                            res.sendStatus(200);
                        }
                    }
                    break;
                case 'f13': //INCIDENCIAS COMENTARIOS EN VIVO
                    //return res.json(req.body);			
                    if (typeof req.body.commentary !== 'undefined') {
                        if (typeof req.body.commentary.$ !== 'undefined') {
                            if (extras.campeonatosPushNed(req.body.commentary.$.competition_id, req.body.commentary.$.season_id)) {
                                var matchId = req.body.commentary.$.game_id;
                                if (typeof req.body.commentary.message !== 'undefined') {
                                    ned.matchGet(matchId).then(function(match) {
                                        var comentariosL = req.body.commentary.message.length;
                                        var dataNed = {
                                            data: []
                                        };
                                        var periodos = [];
                                        var finPartido = {};
                                        var incidenciasPorType = {};
                                        for (var iComentarios = 0; iComentarios < comentariosL; iComentarios++) {

                                            if (typeof req.body.commentary.message[iComentarios].$ !== 'undefined') {
                                                var incidencia = {
                                                    "id": parseInt(req.body.commentary.message[iComentarios].$.id),
                                                    "teamId": null,
                                                    "playerId": null,
                                                    "seconds": req.body.commentary.message[iComentarios].$.second,
                                                    "minutes": req.body.commentary.message[iComentarios].$.minute,
                                                    "card": null,
                                                    "catchedBy": null,
                                                    "eventDate": typeof req.body.commentary.message[iComentarios].$.TimeStamp !== 'undefined' ? m(req.body.commentary.message[iComentarios].$.TimeStamp).format("YYYY-MM-DDTHH:mm:ssZZ") : null
                                                };
                                                switch (req.body.commentary.message[iComentarios].$.type) {
                                                    case 'start':
                                                        switch (req.body.commentary.message[iComentarios].$.period) {
                                                            case '1':
                                                                incidencia['type'] = 1;
                                                                incidencia['name'] = 'Inicio de Partido';
                                                                incidencia['half'] = 1;
                                                                break;
                                                            case '2':
                                                                incidencia['type'] = 18;
                                                                incidencia['name'] = 'Inicio Segundo Tiempo';
                                                                incidencia['half'] = 2;

                                                                break;
                                                            case '3':
                                                                incidencia['type'] = 50;
                                                                incidencia['name'] = 'Inicio 1º Alargue';
                                                                incidencia['half'] = 3;
                                                                break;
                                                            case '4':
                                                                incidencia['type'] = 52;
                                                                incidencia['name'] = 'Inicio 2º Alargue';
                                                                incidencia['half'] = 4;
                                                                break;
                                                            case '1':
                                                                incidencia['type'] = 54;
                                                                incidencia['name'] = 'Inicio Def. Penales';
                                                                incidencia['half'] = 5;
                                                                break;
                                                        }
                                                        break;
                                                    case 'end 14':
                                                        finPartido = incidencia;
                                                        incidencia = {};
                                                        finPartido['type'] = 2;
                                                        finPartido['name'] = 'Fin de Partido';
                                                        //incidencia['half'] = null;
                                                        break;
                                                    case 'end 1':
                                                        periodos.push(1);
                                                        incidencia['type'] = 17;
                                                        incidencia['name'] = 'Fin de Primer Tiempo';
                                                        incidencia['half'] = 1;
                                                        break;
                                                    case 'end 2':
                                                        periodos.push(2);
                                                        incidencia['type'] = 49;
                                                        incidencia['name'] = 'Fin 2º Tiempo';
                                                        incidencia['half'] = 2;
                                                        break;
                                                    case 'end 3':
                                                        periodos.push(3);
                                                        incidencia['type'] = 51;
                                                        incidencia['name'] = 'Fin 1º Alargue';
                                                        incidencia['half'] = 3;
                                                        break;
                                                    case 'end 4':
                                                        periodos.push(4);
                                                        incidencia['type'] = 53;
                                                        incidencia['name'] = 'Fin 2º Alargue';
                                                        incidencia['half'] = 4;
                                                        break;
                                                    case 'end 5':
                                                        periodos.push(5);
                                                        break;
                                                }
                                            }
                                            if (typeof incidencia.type !== 'undefined') {
                                                //dataNed.data.push(incidencia);												
                                                incidenciasPorType[incidencia.type] = incidencia;
                                            }
                                        }

                                        if (Object.keys(finPartido).length != 0 && periodos.length != 0) {
                                            //if (periodos.length != 0) {
                                            //finPartido['half'] = Math.max(...periodos);
                                            finPartido['half'] = Math.max.apply(null, periodos);
                                            dataNed.data.push(finPartido);
                                            incidenciasPorType[finPartido.type] = finPartido;
                                            //}											
                                        }

                                        if (typeof incidenciasPorType["2"] !== 'undefined') {
                                            // fix fin partido opta
                                            incidenciasPorType["2"].minutes = typeof incidenciasPorType["49"] !== 'undefined' ? incidenciasPorType["49"].minutes : incidenciasPorType["2"].minutes;
                                            incidenciasPorType["2"].seconds = typeof incidenciasPorType["49"] !== 'undefined' ? (parseInt(incidenciasPorType["49"].seconds) + 1).toString() : incidenciasPorType["2"].seconds;
                                        }
                                        if (typeof incidenciasPorType["18"] !== 'undefined') {
                                            // fix inicio 2do tiempo opta
                                            incidenciasPorType["18"].minutes = typeof incidenciasPorType["17"] !== 'undefined' ? incidenciasPorType["17"].minutes : incidenciasPorType["18"].minutes;
                                            incidenciasPorType["18"].seconds = typeof incidenciasPorType["17"] !== 'undefined' ? (parseInt(incidenciasPorType["17"].seconds) + 1).toString() : incidenciasPorType["18"].seconds;
                                        }

                                        Object.keys(incidenciasPorType).map(function(key, index) {
                                            var incidence = incidenciasPorType[key];
                                            dataNed.data.push(incidence);
                                        });

                                        ned.incidencePush(matchId, dataNed.data).then(function(respuesta) {
                                            res.json(respuesta);
                                        }).catch(function(err) {
                                            res.send(err);
                                        });
                                        //return res.json(dataNed);
                                    }).catch(function(err) {
                                        res.sendStatus(200);
                                    });
                                } else {
                                    res.sendStatus(200);
                                }
                            } else {
                                res.sendStatus(200);
                            }
                        } else {
                            res.sendStatus(200);
                        }
                    } else {
                        res.sendStatus(200);
                    }
                    break;
                case 'f3':// TABLA POSICIONES (LEAGUE)
                    if (typeof req.body.soccerfeed.soccerdocument[0].competition[0].teamstandings !== 'undefined') {
                        var data = req.body.soccerfeed.soccerdocument[0],
                            campeonatoData = data.competition,
                            tablaEquipo = [],
                            tablaEquipoL = [],
                            positionYStatData = {
                                data: {}
                            },
                            tablaGrupo = 0,
                            groupName = null,
                            type = 'league',
                            levelName = 'Temporada Regular',
                            groupId = null,
                            tablaMatch = campeonatoData[0].teamstandings,
                            tablaMatchL = tablaMatch.length,
                            atributosCampeonato = data['$'];

                        for (var i = 0; i < tablaMatchL; i++) {
                            (function(i) {
                                if (typeof positionYStatData.data[i] === 'undefined') {
                                    positionYStatData.data[i] = {
                                        positionIdArray: [],
                                        positionDataArray: [],
                                        matchStatArray: []
                                    };
                                }
                                if (typeof campeonatoData[0].teamstandings[i].teamrecord !== 'undefined') {
                                    tablaEquipo[i] = campeonatoData[0].teamstandings[i].teamrecord;
                                    tablaEquipoL[i] = tablaEquipo[i].length;

                                    if (typeof campeonatoData[0].teamstandings[i] !== 'undefined') {
                                        if (typeof campeonatoData[0].teamstandings[i].round !== 'undefined') {
                                            if (typeof campeonatoData[0].teamstandings[i].round[0].name[0] !== 'undefined') {
                                                if (campeonatoData[0].teamstandings[i].round[0].name[0]._.substring(0, 5).toLowerCase() == 'group') {
                                                    tablaGrupo++;
                                                    groupId = campeonatoData[0].teamstandings[i].round[0].name[0].$.id;
                                                }
                                            }
                                        }
                                    }
                                    req.body = undefined;
                                    var ultimaFecha = campeonatoData[0].teamstandings[i].$.Matchday;
                                    var level = typeof atributosCampeonato.Round !== 'undefined' ? atributosCampeonato.Round : 1;
                                    var campeonato = parseInt(atributosCampeonato.competition_id) + '-' + parseInt(atributosCampeonato.season_id);
                                    var positionId = campeonato + '_' + level; // tipo league, key						
                                    var typeId = tablaGrupo > 0 ? tablaGrupo : null;
                                    if (tablaGrupo > 0) {
                                        type = 'group';
                                        groupName = 'Grupo ' + groupId;
                                        levelName = 'Fase de Grupos';
                                        positionId = campeonato + '_' + level + '_' + tablaGrupo;
                                    }

                                    positionYStatData.data[i].positionIdArray.push([{
                                        "championshipId": campeonato,
                                        "positionId": positionId,
                                        "type": type,
                                        "typeId": typeId,
                                        "level": level,
                                        "levelId": null,
                                        "groupName": groupName
                                    }]);

                                    for (var j = 0; j < tablaEquipoL[i]; j++) {

                                        var stats = tablaEquipo[i][j].standing;
                                        var teamId = tablaEquipo[i][j].$.TeamRef.substring(1);

                                        positionYStatData.data[i].positionDataArray.push([{
                                            "teamId": teamId,
                                            "stats_position": parseInt(stats[0].position),
                                            "stats_points": parseInt(stats[0].points),
                                            "stats_levelName": levelName,
                                            "stats_level": level,
                                            "stats_lastMatchName": ultimaFecha != '' ? "Fecha " + ultimaFecha : '',
                                            "stats_lastMatch": ultimaFecha != '' ? parseInt(ultimaFecha) : 0,
                                            "stats_games_played": parseInt(stats[0].played),
                                            "stats_games_won": parseInt(stats[0].won),
                                            "stats_games_lost": parseInt(stats[0].lost),
                                            "stats_games_drawn": parseInt(stats[0].drawn),
                                            "stats_goals_scored": parseInt(stats[0].for),
                                            "stats_goals_against": parseInt(stats[0].against),
                                            "stats_goals_difference": parseInt(stats[0].for) - parseInt(stats[0].against)
                                        }]);

                                        positionYStatData.data[i].matchStatArray.push({
                                            "data": {
                                                "championshipId": campeonato,
                                                "teamId": teamId,
                                                "positionId": positionId,
                                                "matchDateType": type,
                                                "matchDateName": ultimaFecha != '' ? "Fecha " + ultimaFecha : '',
                                                "level": level,
                                                "levelName": levelName,
                                                "position": parseInt(stats[0].position),
                                                "points": parseInt(stats[0].points),
                                                "goals_visitor": parseInt(stats[0].awayfor),
                                                "goals_local": parseInt(stats[0].homefor),
                                                "games_drawn": parseInt(stats[0].drawn),
                                                "games_lost": parseInt(stats[0].lost),
                                                "games_won": parseInt(stats[0].won)
                                            }
                                        });
                                    }
                                }
                            })(i);
                        }
                        var positionIdArray = [],
                            positionDataArray = [],
                            matchStatArray = [];
                        var positionYStatDataArray = Object.keys(positionYStatData.data).map(function(key) { return positionYStatData.data[key]; });

                        return positionYStatDataArray.reduce(function(sequence, data) {
                            var positionIdArray = data.positionIdArray[0];
                            var positionDataArray = data.positionDataArray;
                            var matchStatArray = data.matchStatArray;
                            return sequence.then(function(resolve) {
                                return ned.positionsIdPush(positionIdArray[0].championshipId, positionIdArray[0].level, positionIdArray);
                            }).then(function(respuesta) {
                                return positionDataArray.reduce(function(sequence, positions) {

                                    var positionId = positionIdArray[0].positionId;
                                    var teamId = positions[0].teamId;                                    
                                    return sequence.then(function(resolve) {
                                        return ned.positionsPush(positionId, teamId, positions);
                                    });
                                }, Promise.resolve());
                            }).then(function(resolve) {
                                return matchStatArray.reduce(function(sequence, stat) {
                                    var championshipId = stat.data.championshipId;
                                    var teamId = stat.data.teamId;
                                    return sequence.then(function(resolve) {
                                        return ned.championshipMatchStatPush(championshipId, teamId, stat);
                                    });
                                }, Promise.resolve());
                            }).catch(function(reject) {
                                console.log("reject******");
                                console.log(reject);
                                Promise.resolve();
                            });
                        }, Promise.resolve()).then(function() {
                            console.log("todo OK");
                            res.sendStatus(200);
                        });

                    } else {
                        res.sendStatus(200);
                    }
                    break;
                default:
                    res.sendStatus(200);
                    break;
            }
        } else {
            res.sendStatus(200);
            console.log({ message: "campeonato no soportado" });
        }
    } else {
        res.sendStatus(200);
        console.log({ message: "campeonato no soportado" });
    }

};

exports.optaCargaArchivo = function(req, res) {
    var dirname = path.dirname(require.main.filename),
        archivo;

    var post = function(parametros) {
        return new Promise(function(resolve, reject) {
            fs.readFile(parametros.url, 'utf8', function(err, data) {
                if (err) {
                    return reject('Error en lectura de xml');
                }
                request.post(req.protocol + '://' + req.get('host') + '/opta', {
                    body: data,
                    headers: {
                        //'Content-Type': 'text/xml',
                        'x-meta-feed-type': parametros.feed,
                        'x-meta-feed-parameters': 'feed params',
                        'x-meta-default-filename': parametros.archivo,
                        'x-meta-game-id': 1,
                        'x-meta-competition-id': parametros.campeonato_id,
                        'x-meta-season-id': parametros.temporada_id,
                        'x-meta-gamesystem-id': 1,
                        'x-meta-matchday': 1,
                        'x-meta-away-team-id': 1,
                        'x-meta-home-team-id': 1,
                        'x-meta-game-status': 11,
                        'x-meta-language': 'en',
                        'x-meta-production-server': 'server',
                        'x-meta-production-server-timestamp': 1,
                        'x-meta-production-server-module': 1,
                        'x-meta-mime-type': 'text/xml',
                        'encoding': 'UTF-8'
                    }
                }, function(error, response, body) {
                    if (error) {
                        return reject('Error acceder a la ruta /opta');
                    }
                    if (response.statusCode != 200) {
                        return reject(response.statusCode);
                    }
                    resolve(body);
                });
            });
        });
    };
    switch (String(req.params.feed)) {
        case '1':
            var archivo = 'srml-' + req.params.campeonato_id + '-' + req.params.temporada_id + '-results.xml';
            var url = path.join(dirname, 'files', 'opta', 'f1', archivo);
            if (typeof url !== 'undefined') {
                post({
                    url: url,
                    feed: req.params.feed,
                    archivo: archivo,
                    campeonato_id: req.params.campeonato_id,
                    temporada_id: req.params.temporada_id
                }).then(function(respuesta) {
                    res.status(respuesta);
                }).catch(function(err) {
                    res.status(err);
                });
            } else {
                res.status(400).send('Url no definida, parametros incorrectos');
            }
            break;
        case '40':
            archivo = 'srml-' + req.params.campeonato_id + '-' + req.params.temporada_id + '-squads.xml'
            var url = path.join(dirname, 'files', 'opta', 'f40', archivo);
            if (typeof url !== 'undefined') {
                post({
                    url: url,
                    feed: req.params.feed,
                    archivo: archivo,
                    campeonato_id: req.params.campeonato_id,
                    temporada_id: req.params.temporada_id
                }).then(function(respuesta) {
                    res.send(respuesta);
                }).catch(function(err) {
                    res.send(err);
                });
            } else {
                res.status(400).send('Url no definida, parametros incorrectos');
            }
            break;
        case '9':
            var matchs = fs.readdirSync(path.join(dirname, 'files', 'opta', 'f9', req.params.campeonato_id, req.params.temporada_id));
            matchs.reduce(function(sequence, match) {

                return sequence.then(function() {
                    if (!(match == 'results' || match == 'squads' || match == 'standings')) {
                        var nombreArchivo = 'srml-' + req.params.campeonato_id + '-' + req.params.temporada_id + '-' + match + '-matchresults.xml';
                        return post({
                            url: path.join(dirname, 'files', 'opta', 'f9', req.params.campeonato_id, req.params.temporada_id, match, 'matchresults', nombreArchivo),
                            feed: 'F9',
                            archivo: nombreArchivo,
                            campeonato_id: req.params.campeonato_id,
                            temporada_id: req.params.temporada_id
                        }).then(function(respuesta) {
                            //console.log(respuesta);
                        });
                    } else {
                        Promise.resolve('se salta');
                    }
                });
            }, Promise.resolve()).then(function(respuesta) {
                res.send('Todo ok');
            }).catch(function(err) {
                res.send(err);
            });
            break;
        case '13':
            var matchs = fs.readdirSync(path.join(dirname, 'files', 'opta', 'f13', req.params.campeonato_id, req.params.temporada_id));
            matchs.reduce(function(sequence, match) {
                return sequence.then(function() {
                    var nombreArchivo = 'commentary-' + req.params.campeonato_id + '-' + req.params.temporada_id + '-' + match + '-es.xml';
                    return post({
                        url: path.join(dirname, 'files', 'opta', 'f13', req.params.campeonato_id, req.params.temporada_id, match, 'es', nombreArchivo),
                        feed: 'F13',
                        archivo: nombreArchivo,
                        campeonato_id: req.params.campeonato_id,
                        temporada_id: req.params.temporada_id
                    }).then(function(respuesta) {
                        console.log(respuesta);
                    });
                });
            }, Promise.resolve()).then(function(respuesta) {
                res.send('Todo ok');
            }).catch(function(err) {
                res.send(err);
            });
            break;
        case '30':
            var teams = fs.readdirSync(path.join(dirname, 'files', 'opta', 'f30', req.params.campeonato_id, req.params.temporada_id));
            teams.reduce(function(sequence, team) {
                return sequence.then(function() {
                    var nombreArchivo = 'seasonstats-' + req.params.campeonato_id + '-' + req.params.temporada_id + '-' + team + '.xml';
                    return post({
                        url: path.join(dirname, 'files', 'opta', 'f30', req.params.campeonato_id, req.params.temporada_id, team, nombreArchivo),
                        feed: 'F30',
                        archivo: nombreArchivo,
                        campeonato_id: req.params.campeonato_id,
                        temporada_id: req.params.temporada_id
                    }).then(function(respuesta) {
                        console.log(respuesta);
                    });
                });
            }, Promise.resolve()).then(function(respuesta) {
                res.send('Todo ok');
            }).catch(function(err) {
                res.send(err);
            });
            break;
        case '3':
            var standings = 'srml-' + req.params.campeonato_id + '-' + req.params.temporada_id + '-standings.xml';
            var urlStandings = path.join(dirname, 'files', 'opta', 'f9', req.params.campeonato_id, req.params.temporada_id, 'standings', standings);
            if (typeof urlStandings !== 'undefined') {
                return post({
                    url: urlStandings,
                    feed: 'F3',
                    archivo: standings,
                    campeonato_id: req.params.campeonato_id,
                    temporada_id: req.params.temporada_id
                }).then(function(respuesta) {
                    res.send("Todo ok 2");
                }).catch(function(err) {
                    res.send(err);
                });
            }
            break;
    }
}

exports.optaF01 = function(req, res) {
    f01s.findOne({
        where: {
            campeonato_id: parseInt(req.params.campeonato_id),
            temporada_id: parseInt(req.params.temporada_id)
        }
    }).then(function(f01) {
        if (!f01) {
            return res.status(404).send('Datos no encontrados');
        } else {
            res.status(200).json(f01.get());
        }
    }).catch(function(err) {
        res.status(500).send("Error al acceder a los datos : " + err);
    });
}

exports.paises = function(req, res) {
    /*var paisesJsonL = paisesJson.length;
    	var resultados = {};
    	for (var index = 0; index < paisesJsonL; index++) {
    		resultados[paisesJson[index].name.common.toLowerCase()] = paisesJson[index].translations.spa.common.toLowerCase();
    }*/
    var resultados = {};
    var paisesPropiedades = Object.keys(paisesJson);
    var paisesPropiedadesL = paisesPropiedades.length;
    for (var index = 0; index < paisesPropiedadesL; index++) {
        resultados[paisesPropiedades[index]] = parseInt(paisesIdNed[paisesJson[paisesPropiedades[index]]]);
    }
    res.json(resultados);
}
