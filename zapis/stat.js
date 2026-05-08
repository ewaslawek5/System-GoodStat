document.cookie = 'ekran=' + window.screen.width + 'x' + window.screen.height;

const nVer = navigator.appVersion;
const nAgt = navigator.userAgent;
let przeg = navigator.appName;
let fullVersion = '' + parseFloat(navigator.appVersion);
let majorVersion = parseInt(navigator.appVersion, 10);
let verOffset, nameOffset, ix;

//******************************************************************************
//		ROZPOZNAWANIE PRZEGLADARKI (Zoptymalizowane)
//******************************************************************************

if ((verOffset = nAgt.indexOf("Edge")) !== -1) {
    przeg = 'Microsoft Edge';
    fullVersion = nAgt.substring(verOffset + 5);
} else if ((verOffset = nAgt.indexOf("Edg")) !== -1) { // Nowszy Edge (Chromium)
    przeg = 'Microsoft Edge';
    fullVersion = nAgt.substring(verOffset + 4);
} else if ((verOffset = nAgt.indexOf("OPR")) !== -1 || (verOffset = nAgt.indexOf("Opera")) !== -1) {
    przeg = 'Opera';
    fullVersion = nAgt.substring(verOffset + (nAgt.indexOf("OPR") !== -1 ? 4 : 6));
} else if ((verOffset = nAgt.indexOf("MSIE")) !== -1) {
    przeg = 'Internet Explorer';
    fullVersion = nAgt.substring(verOffset + 5);
} else if (nAgt.indexOf("Trident/") !== -1) { // IE 11 detection
    przeg = 'Internet Explorer';
    verOffset = nAgt.indexOf("rv:");
    fullVersion = nAgt.substring(verOffset + 3);
} else if ((verOffset = nAgt.indexOf("Chrome")) !== -1) {
    przeg = 'Chrome';
    fullVersion = nAgt.substring(verOffset + 7);
} else if ((verOffset = nAgt.indexOf("Safari")) !== -1) {
    przeg = 'Safari';
    fullVersion = nAgt.substring(verOffset + 7);
    if ((verOffset = nAgt.indexOf("Version")) !== -1) fullVersion = nAgt.substring(verOffset + 8);
} else if ((verOffset = nAgt.indexOf("Firefox")) !== -1) {
    przeg = 'Firefox';
    fullVersion = nAgt.substring(verOffset + 8);
} else if ((nameOffset = nAgt.lastIndexOf(' ') + 1) < (verOffset = nAgt.lastIndexOf('/'))) {
    przeg = nAgt.substring(nameOffset, verOffset);
    fullVersion = nAgt.substring(verOffset + 1);
    if (przeg.toLowerCase() === przeg.toUpperCase()) {
        przeg = navigator.appName;
    }
}

// Czyszczenie ciągu wersji (usuwanie średników i spacji)
if ((ix = fullVersion.indexOf(";")) !== -1) fullVersion = fullVersion.substring(0, ix);
if ((ix = fullVersion.indexOf(" ")) !== -1) fullVersion = fullVersion.substring(0, ix);

majorVersion = parseInt('' + fullVersion, 10);

if (isNaN(majorVersion)) {
    fullVersion = '' + parseFloat(navigator.appVersion);
    majorVersion = parseInt(navigator.appVersion, 10);
}

//******************************************************************************
//		ROZPOZNAWANIE SYSTEMU (Zmodernizowane)
//******************************************************************************

if (navigator.userAgent.indexOf("Win") != -1) {
    // Domyślnie sprawdzamy starsze wersje lub bazę NT 10.0
    if (navigator.userAgent.indexOf("NT 10.0") != -1) {
        system = "Windows 10";
        
        // Specjalna weryfikacja dla Windows 11
        // Windows 11 używa User-Agent Client Hints, bo UA string zatrzymał się na "NT 10.0"
        if (navigator.userAgentData && navigator.userAgentData.brands) {
            navigator.userAgentData.getHighEntropyValues(["platformVersion"])
                .then(ua => {
                    if (navigator.userAgentData.platform === "Windows") {
                        const majorPlatformVersion = parseInt(ua.platformVersion.split('.')[0]);
                        // Wersje platformy 13.0.0 i wyższe to Windows 11
                        if (majorPlatformVersion >= 13) {
                            system = "Windows 11";
                        }
                    }
                });
        }
    } 
    else if (navigator.userAgent.indexOf("NT 6.3") != -1) { system = "Windows 8.1"; }
    else if (navigator.userAgent.indexOf("NT 6.2") != -1) { system = "Windows 8"; }
    else if (navigator.userAgent.indexOf("NT 6.1") != -1) { system = "Windows 7"; }
    else if (navigator.userAgent.indexOf("NT 6.0") != -1) { system = "Windows Vista"; }
    else if (navigator.userAgent.indexOf("NT 5.1") != -1) { system = "Windows XP"; }
    else if (navigator.userAgent.indexOf("NT 5.2") != -1) { system = "Windows Server 2003"; }
    else if (navigator.userAgent.indexOf("NT 5.0") != -1) { system = "Windows 2000"; }
    else if (navigator.userAgent.indexOf("Win98") != -1) { system = "Windows 98"; }
    else if (navigator.userAgent.indexOf("Win 9x 4.90") != -1) { system = "Windows ME"; } 
    else if (navigator.userAgent.indexOf("Win95") != -1) { system = "Windows 95"; }
    else { system = "Windows (nieznany)"; }
} 
else if (navigator.userAgent.indexOf("Android") != -1) { system = "Android"; }
else if (navigator.userAgent.indexOf("iPhone") != -1 || navigator.userAgent.indexOf("iPad") != -1) { system = "iOS"; }
else if (navigator.userAgent.indexOf("Mac") != -1) { system = "Macintosh"; }
else if (navigator.userAgent.indexOf("Linux") != -1 || navigator.userAgent.indexOf("X11") != -1) { system = "Linux"; }
else { system = "inny"; }


//******************************************************************************
//		ROZPOZNANIE JEZYKA (Zoptymalizowane)
//******************************************************************************

// Pobieramy kod języka z właściwego miejsca (np. "pl-PL", "en-US")
var userLang = (navigator.language || navigator.userLanguage || "en").toLowerCase();

// Mapa mapująca kody ISO na Twoje nazwy wynikowe
var languageMap = {
    "pl": "polski",
    "en": "angielski",
    "fr": "francuski",
    "de": "niemiecki",
    "it": "wloski",
    "es": "hiszpanski",
    "uk": "ukrainski",
    "ru": "rosyjski",
    "cs": "czeski",
    "nl": "holenderski",
    "sv": "szwedzki",
    "no": "norwegia",
    "pt": "portugalia",
    "ro": "rumunia",
    "sk": "slowacja",
    "sl": "slowenia",
    "sr": "serbia",
    "zh": "chiny",
    "bg": "bulgaria",
    "da": "dania",
    "el": "grecja",
    "et": "estonia",
    "fi": "finlandia",
    "hu": "wegry",
    "hy": "armenia",
	"ca": "kanada",
    "kn": "indie" // Uwaga: 'kn' to język kannada (Indie), kod Kanady jako kraju to 'ca'
};

// Domyślnie ustawiamy "inny"
jezyk_przegladarki = "inny";

// Sprawdzamy czy początek kodu języka (np. "pl" z "pl-PL") znajduje się w naszej mapie
for (var key in languageMap) {
    if (userLang.indexOf(key) === 0) {
        jezyk_przegladarki = languageMap[key];
        break;
    }
}

                function setCookie(sName, sValue, oExpires, sPath, sDomain, bSecure) {
                    var sCookie = sName + "=" + encodeURIComponent(sValue);
                
                    if (oExpires) {
                        sCookie += "; expires=" + oExpires.toGMTString();
                    }
                
                    if (sPath) {
                        sCookie += "; path=" + sPath;
                    }
                
                    if (sDomain) {
                        sCookie += "; domain=" + sDomain;
                    }
                
                    if (bSecure) {
                        sCookie += "; secure";
                    }
                
                    document.cookie = sCookie;
                }

                function getCookie(sName) {
                
                    var sRE = "(?:; )?" + sName + "=([^;]*);?";
                    var oRE = new RegExp(sRE);
                    
                    if (oRE.test(document.cookie)) {
                        return decodeURIComponent(RegExp["$1"]);
                    } else {
                        return null;
                    }
                
                } 
				
var ekranik = window.screen.width + 'x' + window.screen.height;

setCookie(ekran, ekranik);

var ekran = getCookie(ekran);
var color = screen.colorDepth;
var przegladarka = przeg;

var podstrona = location.pathname + window.location.search;

var podstrona = podstrona.replace("&", "|");

/*
var podstrona = location.pathname+location;
var podstrona = location.pathname + window.location.search;
*/

 
document.write('<img src="'+ ipath +'/zapis.php?podstrona='+ podstrona +'&przegladarka='+ przegladarka +'&ekran='+ ekran +'&color='+ color +'&system=' +system+ '&jezyk_przegladarki=' +jezyk_przegladarki+ '&ciaguser=' +nAgt+ '&idref=' +document.referrer+ '"style="border: none; display:none; visibility:collapse;">')

