var r;
var MobileEsp = {
    initCompleted: !1,
    isWebkit: !1,
    isMobilePhone: !1,
    isIphone: !1,
    isAndroid: !1,
    isAndroidPhone: !1,
    isTierTablet: !1,
    isTierIphone: !1,
    isTierRichCss: !1,
    isTierGenericMobile: !1,
    engineWebKit: "webkit",
    deviceIphone: "iphone",
    deviceIpod: "ipod",
    deviceIpad: "ipad",
    deviceMacPpc: "macintosh",
    deviceAndroid: "android",
    deviceGoogleTV: "googletv",
    deviceHtcFlyer: "htc_flyer",
    deviceWinPhone7: "windows phone os 7",
    deviceWinPhone8: "windows phone 8",
    deviceWinMob: "windows ce",
    deviceWindows: "windows",
    deviceIeMob: "iemobile",
    devicePpc: "ppc",
    enginePie: "wm5 pie",
    deviceBB: "blackberry",
    deviceBB10: "bb10",
    vndRIM: "vnd.rim",
    deviceBBStorm: "blackberry95",
    deviceBBBold: "blackberry97",
    deviceBBBoldTouch: "blackberry 99",
    deviceBBTour: "blackberry96",
    deviceBBCurve: "blackberry89",
    deviceBBCurveTouch: "blackberry 938",
    deviceBBTorch: "blackberry 98",
    deviceBBPlaybook: "playbook",
    deviceSymbian: "symbian",
    deviceSymbos: "symbos",
    deviceS60: "series60",
    deviceS70: "series70",
    deviceS80: "series80",
    deviceS90: "series90",
    devicePalm: "palm",
    deviceWebOS: "webos",
    deviceWebOShp: "hpwos",
    engineBlazer: "blazer",
    engineXiino: "xiino",
    deviceNuvifone: "nuvifone",
    deviceBada: "bada",
    deviceTizen: "tizen",
    deviceMeego: "meego",
    deviceKindle: "kindle",
    engineSilk: "silk-accelerated",
    vndwap: "vnd.wap",
    wml: "wml",
    deviceTablet: "tablet",
    deviceBrew: "brew",
    deviceDanger: "danger",
    deviceHiptop: "hiptop",
    devicePlaystation: "playstation",
    devicePlaystationVita: "vita",
    deviceNintendoDs: "nitro",
    deviceNintendo: "nintendo",
    deviceWii: "wii",
    deviceXbox: "xbox",
    deviceArchos: "archos",
    engineOpera: "opera",
    engineNetfront: "netfront",
    engineUpBrowser: "up.browser",
    engineOpenWeb: "openweb",
    deviceMidp: "midp",
    uplink: "up.link",
    engineTelecaQ: "teleca q",
    engineObigo: "obigo",
    devicePda: "pda",
    mini: "mini",
    mobile: "mobile",
    mobi: "mobi",
    maemo: "maemo",
    linux: "linux",
    mylocom2: "sony/com",
    manuSonyEricsson: "sonyericsson",
    manuericsson: "ericsson",
    manuSamsung1: "sec-sgh",
    manuSony: "sony",
    manuHtc: "htc",
    svcDocomo: "docomo",
    svcKddi: "kddi",
    svcVodafone: "vodafone",
    disUpdate: "update",
    uagent: "",
    InitDeviceScan: function() {
        this.initCompleted = !1;
        navigator && navigator.userAgent &&
            (this.uagent = navigator.userAgent.toLowerCase());
        this.isWebkit = this.DetectWebkit();
        this.isIphone = this.DetectIphone();
        this.isAndroid = this.DetectAndroid();
        this.isAndroidPhone = this.DetectAndroidPhone();
        this.isTierIphone = this.DetectTierIphone();
        this.isTierTablet = this.DetectTierTablet();
        this.isMobilePhone = this.DetectMobileQuick();
        this.isTierRichCss = this.DetectTierRichCss();
        this.isTierGenericMobile = this.DetectTierOtherPhones();
        this.initCompleted = !0
    },
    DetectIphone: function() {
        return this.initCompleted || this.isIphone ?
            this.isIphone : -1 < this.uagent.search(this.deviceIphone) ? this.DetectIpad() || this.DetectIpod() ? !1 : !0 : !1
    },
    DetectIpod: function() {
        return -1 < this.uagent.search(this.deviceIpod) ? !0 : !1
    },
    DetectIphoneOrIpod: function() {
        return this.DetectIphone() || this.DetectIpod() ? !0 : !1
    },
    DetectIpad: function() {
        return -1 < this.uagent.search(this.deviceIpad) && this.DetectWebkit() ? !0 : !1
    },
    DetectIos: function() {
        return this.DetectIphoneOrIpod() || this.DetectIpad() ? !0 : !1
    },
    DetectAndroid: function() {
        return this.initCompleted || this.isAndroid ?
            this.isAndroid : -1 < this.uagent.search(this.deviceAndroid) || this.DetectGoogleTV() ? !0 : -1 < this.uagent.search(this.deviceHtcFlyer) ? !0 : !1
    },
    DetectAndroidPhone: function() {
        return this.initCompleted || this.isAndroidPhone ? this.isAndroidPhone : this.DetectAndroid() && -1 < this.uagent.search(this.mobile) || this.DetectOperaAndroidPhone() ? !0 : -1 < this.uagent.search(this.deviceHtcFlyer) ? !0 : !1
    },
    DetectAndroidTablet: function() {
        return !this.DetectAndroid() || this.DetectOperaMobile() || -1 < this.uagent.search(this.deviceHtcFlyer) ?
            !1 : -1 < this.uagent.search(this.mobile) ? !1 : !0
    },
    DetectAndroidWebKit: function() {
        return this.DetectAndroid() && this.DetectWebkit() ? !0 : !1
    },
    DetectGoogleTV: function() {
        return -1 < this.uagent.search(this.deviceGoogleTV) ? !0 : !1
    },
    DetectWebkit: function() {
        return this.initCompleted || this.isWebkit ? this.isWebkit : -1 < this.uagent.search(this.engineWebKit) ? !0 : !1
    },
    DetectWindowsPhone: function() {
        return this.DetectWindowsPhone7() || this.DetectWindowsPhone8() ? !0 : !1
    },
    DetectWindowsPhone7: function() {
        return -1 < this.uagent.search(this.deviceWinPhone7) ?
            !0 : !1
    },
    DetectWindowsPhone8: function() {
        return -1 < this.uagent.search(this.deviceWinPhone8) ? !0 : !1
    },
    DetectWindowsMobile: function() {
        return this.DetectWindowsPhone() ? !1 : -1 < this.uagent.search(this.deviceWinMob) || (-1 < this.uagent.search(this.deviceIeMob) || -1 < this.uagent.search(this.enginePie)) || -1 < this.uagent.search(this.devicePpc) && !(-1 < this.uagent.search(this.deviceMacPpc)) ? !0 : -1 < this.uagent.search(this.manuHtc) && -1 < this.uagent.search(this.deviceWindows) ? !0 : !1
    },
    DetectBlackBerry: function() {
        return -1 < this.uagent.search(this.deviceBB) ||
            -1 < this.uagent.search(this.vndRIM) ? !0 : this.DetectBlackBerry10Phone() ? !0 : !1
    },
    DetectBlackBerry10Phone: function() {
        return -1 < this.uagent.search(this.deviceBB10) && -1 < this.uagent.search(this.mobile) ? !0 : !1
    },
    DetectBlackBerryTablet: function() {
        return -1 < this.uagent.search(this.deviceBBPlaybook) ? !0 : !1
    },
    DetectBlackBerryWebKit: function() {
        return this.DetectBlackBerry() && -1 < this.uagent.search(this.engineWebKit) ? !0 : !1
    },
    DetectBlackBerryTouch: function() {
        return this.DetectBlackBerry() && (-1 < this.uagent.search(this.deviceBBStorm) ||
            -1 < this.uagent.search(this.deviceBBTorch) || -1 < this.uagent.search(this.deviceBBBoldTouch) || -1 < this.uagent.search(this.deviceBBCurveTouch)) ? !0 : !1
    },
    DetectBlackBerryHigh: function() {
        return this.DetectBlackBerryWebKit() ? !1 : this.DetectBlackBerry() && (this.DetectBlackBerryTouch() || -1 < this.uagent.search(this.deviceBBBold) || -1 < this.uagent.search(this.deviceBBTour) || -1 < this.uagent.search(this.deviceBBCurve)) ? !0 : !1
    },
    DetectBlackBerryLow: function() {
        return this.DetectBlackBerry() ? this.DetectBlackBerryHigh() || this.DetectBlackBerryWebKit() ?
            !1 : !0 : !1
    },
    DetectS60OssBrowser: function() {
        return this.DetectWebkit() ? -1 < this.uagent.search(this.deviceS60) || -1 < this.uagent.search(this.deviceSymbian) ? !0 : !1 : !1
    },
    DetectSymbianOS: function() {
        return -1 < this.uagent.search(this.deviceSymbian) || -1 < this.uagent.search(this.deviceS60) || -1 < this.uagent.search(this.deviceSymbos) && this.DetectOperaMobile || -1 < this.uagent.search(this.deviceS70) || -1 < this.uagent.search(this.deviceS80) || -1 < this.uagent.search(this.deviceS90) ? !0 : !1
    },
    DetectPalmOS: function() {
        return this.DetectPalmWebOS() ?
            !1 : -1 < this.uagent.search(this.devicePalm) || -1 < this.uagent.search(this.engineBlazer) || -1 < this.uagent.search(this.engineXiino) ? !0 : !1
    },
    DetectPalmWebOS: function() {
        return -1 < this.uagent.search(this.deviceWebOS) ? !0 : !1
    },
    DetectWebOSTablet: function() {
        return -1 < this.uagent.search(this.deviceWebOShp) && -1 < this.uagent.search(this.deviceTablet) ? !0 : !1
    },
    DetectOperaMobile: function() {
        return -1 < this.uagent.search(this.engineOpera) && (-1 < this.uagent.search(this.mini) || -1 < this.uagent.search(this.mobi)) ? !0 : !1
    },
    DetectOperaAndroidPhone: function() {
        return -1 <
            this.uagent.search(this.engineOpera) && -1 < this.uagent.search(this.deviceAndroid) && -1 < this.uagent.search(this.mobi) ? !0 : !1
    },
    DetectOperaAndroidTablet: function() {
        return -1 < this.uagent.search(this.engineOpera) && -1 < this.uagent.search(this.deviceAndroid) && -1 < this.uagent.search(this.deviceTablet) ? !0 : !1
    },
    DetectKindle: function() {
        return -1 < this.uagent.search(this.deviceKindle) && !this.DetectAndroid() ? !0 : !1
    },
    DetectAmazonSilk: function() {
        return -1 < this.uagent.search(this.engineSilk) ? !0 : !1
    },
    DetectGarminNuvifone: function() {
        return -1 <
            this.uagent.search(this.deviceNuvifone) ? !0 : !1
    },
    DetectBada: function() {
        return -1 < this.uagent.search(this.deviceBada) ? !0 : !1
    },
    DetectTizen: function() {
        return -1 < this.uagent.search(this.deviceTizen) ? !0 : !1
    },
    DetectMeego: function() {
        return -1 < this.uagent.search(this.deviceMeego) ? !0 : !1
    },
    DetectDangerHiptop: function() {
        return -1 < this.uagent.search(this.deviceDanger) || -1 < this.uagent.search(this.deviceHiptop) ? !0 : !1
    },
    DetectSonyMylo: function() {
        return -1 < this.uagent.search(this.manuSony) && (-1 < this.uagent.search(this.qtembedded) ||
            -1 < this.uagent.search(this.mylocom2)) ? !0 : !1
    },
    DetectMaemoTablet: function() {
        return -1 < this.uagent.search(this.maemo) ? !0 : -1 < this.uagent.search(this.linux) && -1 < this.uagent.search(this.deviceTablet) && !this.DetectWebOSTablet() && !this.DetectAndroid() ? !0 : !1
    },
    DetectArchos: function() {
        return -1 < this.uagent.search(this.deviceArchos) ? !0 : !1
    },
    DetectGameConsole: function() {
        return this.DetectSonyPlaystation() || this.DetectNintendo() || this.DetectXbox() ? !0 : !1
    },
    DetectSonyPlaystation: function() {
        return -1 < this.uagent.search(this.devicePlaystation) ?
            !0 : !1
    },
    DetectGamingHandheld: function() {
        return -1 < this.uagent.search(this.devicePlaystation) && -1 < this.uagent.search(this.devicePlaystationVita) ? !0 : !1
    },
    DetectNintendo: function() {
        return -1 < this.uagent.search(this.deviceNintendo) || -1 < this.uagent.search(this.deviceWii) || -1 < this.uagent.search(this.deviceNintendoDs) ? !0 : !1
    },
    DetectXbox: function() {
        return -1 < this.uagent.search(this.deviceXbox) ? !0 : !1
    },
    DetectBrewDevice: function() {
        return -1 < this.uagent.search(this.deviceBrew) ? !0 : !1
    },
    DetectSmartphone: function() {
        return this.DetectTierIphone() ||
            this.DetectS60OssBrowser() || this.DetectSymbianOS() || this.DetectWindowsMobile() || this.DetectBlackBerry() || this.DetectPalmOS() ? !0 : !1
    },
    DetectMobileQuick: function() {
        return this.DetectTierTablet() ? !1 : this.initCompleted || this.isMobilePhone ? this.isMobilePhone : this.DetectSmartphone() || -1 < this.uagent.search(this.mobile) || this.DetectKindle() || this.DetectAmazonSilk() || -1 < this.uagent.search(this.deviceMidp) || this.DetectBrewDevice() || this.DetectOperaMobile() || this.DetectArchos() || -1 < this.uagent.search(this.engineObigo) ||
            -1 < this.uagent.search(this.engineNetfront) || -1 < this.uagent.search(this.engineUpBrowser) || -1 < this.uagent.search(this.engineOpenWeb) ? !0 : !1
    },
    DetectMobileLong: function() {
        return this.DetectMobileQuick() || this.DetectGameConsole() || (this.DetectDangerHiptop() || this.DetectMaemoTablet() || this.DetectSonyMylo() || this.DetectGarminNuvifone()) || -1 < this.uagent.search(this.devicePda) && !(-1 < this.uagent.search(this.disUpdate)) || -1 < this.uagent.search(this.manuSamsung1) || -1 < this.uagent.search(this.manuSonyEricsson) ||
            -1 < this.uagent.search(this.manuericsson) || -1 < this.uagent.search(this.svcDocomo) || -1 < this.uagent.search(this.svcKddi) || -1 < this.uagent.search(this.svcVodafone) ? !0 : !1
    },
    DetectTierTablet: function() {
        return this.initCompleted || this.isTierTablet ? this.isTierTablet : this.DetectIpad() || this.DetectAndroidTablet() || this.DetectBlackBerryTablet() || this.DetectWebOSTablet() ? !0 : !1
    },
    DetectTierIphone: function() {
        return this.initCompleted || this.isTierIphone ? this.isTierIphone : this.DetectIphoneOrIpod() || this.DetectAndroidPhone() ||
            this.DetectWindowsPhone() || this.DetectBlackBerry10Phone() || this.DetectPalmWebOS() || this.DetectBada() || this.DetectTizen() || this.DetectGamingHandheld() ? !0 : this.DetectBlackBerryWebKit() && this.DetectBlackBerryTouch() ? !0 : !1
    },
    DetectTierRichCss: function() {
        return this.initCompleted || this.isTierRichCss ? this.isTierRichCss : this.DetectTierIphone() || (this.DetectKindle() || this.DetectTierTablet()) || !this.DetectMobileQuick() ? !1 : this.DetectWebkit() ? !0 : this.DetectS60OssBrowser() || this.DetectBlackBerryHigh() || this.DetectWindowsMobile() ||
            -1 < this.uagent.search(this.engineTelecaQ) ? !0 : !1
    },
    DetectTierOtherPhones: function() {
        return this.initCompleted || this.isTierGenericMobile ? this.isTierGenericMobile : this.DetectTierIphone() || this.DetectTierRichCss() || this.DetectTierTablet() ? !1 : this.DetectMobileLong() ? !0 : !1
    }
};
MobileEsp.InitDeviceScan();

"undefined" == typeof thubContentId && (thubContentId = 0);

jQuery(document).ready(function(e) {
    jQuery('body').append('<div id="thumb-load0" class="thumbContent js-thumbContent"></div><div id="thumb-load1" class="thumbContent js-thumbContent"></div>');
    
    jQuery(document).on("mouseleave", ".js-thumbnail", function() {
        clearInterval(r);
    }).on("mouseenter", ".js-thumbnail", function() {
        if (jQuery(this).parent().hasClass("deleted")) return !0;
        
        var a = jQuery("#thumb-load" +
                thubContentId),
            b = jQuery(this).closest(".thumbnail-container") ;
        
        
        var c = b.html();

        a.html(c).find("a.js-thumb_preview").css({
              'min-width'   : "360px",
        });

        jQuery("#thumb-load" + thubContentId + " .js-thumbnail-proposed").empty() ;

        var c = a.outerWidth(),
            f = a.outerHeight(),
            g = b.outerWidth()
            h = (c - g) / 2;
            g = b.offset(),
            j = g.top - 80,
            k = h = g.left - h,
            l = j,
            n = jQuery(document).scrollLeft(),
            p = jQuery(window).width(),
            u = jQuery(document).scrollTop(),
            O = jQuery(window).height(),
            N = !1;

        g.top + b.height() > u + O && (N = !0);
        k + c > n + p ? h = k - (k + c - (n + p)) - 30 : 30 > k - n && (h = 30 + n);
        l + f > u + O ? j = l - (l + f - (u + O)) - 30 : 30 > l - u && (j = 30 + u);
        
        a.css({
            position: 'absolute',
            top: j,
            left: h,
            display: 'block'
        });

        clearTimeout(r);
    });

    if (MobileEsp.DetectIos()) jQuery(".js-thumbnail-item").click(function() {
        jQuery("#thumb-load" + thubContentId).html("")
    });
    else jQuery("#thumb-load0, #thumb-load1").on("mouseleave", function() {
        var a = jQuery("#thumb-load" + thubContentId);
        clearTimeout(r);
        a.html("");
        a.fadeOut();
        thubContentId = 0 === thubContentId ? 1 : 0
    });
    
}) ;

jQuery(document).ready(function() {
    jQuery(".js-thumbnail-item").on("touchend", function(a) {
        jQuery(this).parents(".js-thumbnail").trigger("mouseenter");
        a.stopImmediatePropagation() ;
    });
});        