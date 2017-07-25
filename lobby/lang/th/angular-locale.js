'use strict';
angular.module("ngLocale", [], ["$provide", function ($provide) {
        var PLURAL_CATEGORY = {ZERO: "zero", ONE: "one", TWO: "two", FEW: "few", MANY: "many", OTHER: "other"};
        $provide.value("$locale", {
            "DATETIME_FORMATS": {
                "AMPMS": [
                    "AM",
                    "PM"
                ],
                "DAY": [
                    "วันอาทิตย์",
                    "วันจันทร์",
                    "วันอังคาร",
                    "วันพุธ",
                    "วันพฤหัสบดี",
                    "วันศุกร์",
                    "วันเสาร์"
                ],
                "MONTH": [
                    "มกราคม",
                    "กุมภาพันธุ์",
                    "มีนาคม",
                    "เมษายน",
                    "พฤษภาคม",
                    "มิถุนายน",
                    "กรกฎาคม",
                    "สิงหาคม",
                    "กันยายน",
                    "ตุลาคม",
                    "พฤศจิกายน",
                    "ธันวาคม"
                ],
                "SHORTDAY": [
                    "อาทิตย์",
                    "จันทร์",
                    "อังคาร",
                    "พุธ",
                    "พฤหัส",
                    "ศุกร์",
                    "เสาร์"
                ],
                "SHORTMONTH": [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec"
                ],
                "fullDate": "EEEE, MMMM d, y",
                "longDate": "MMMM d, y",
                "medium": "MMM d, y h:mm:ss a",
                "mediumDate": "MMM d, y",
                "mediumTime": "h:mm:ss a",
                "short": "M/d/yy h:mm a",
                "shortDate": "M/d/yy",
                "shortTime": "h:mm a"
            },
            "NUMBER_FORMATS": {
                "CURRENCY_SYM": "$",
                "DECIMAL_SEP": ".",
                "GROUP_SEP": ",",
                "PATTERNS": [
                    {
                        "gSize": 3,
                        "lgSize": 3,
                        "macFrac": 0,
                        "maxFrac": 3,
                        "minFrac": 0,
                        "minInt": 1,
                        "negPre": "-",
                        "negSuf": "",
                        "posPre": "",
                        "posSuf": ""
                    },
                    {
                        "gSize": 3,
                        "lgSize": 3,
                        "macFrac": 0,
                        "maxFrac": 2,
                        "minFrac": 2,
                        "minInt": 1,
                        "negPre": "(\u00a4",
                        "negSuf": ")",
                        "posPre": "\u00a4",
                        "posSuf": ""
                    }
                ]
            },
            "id": "th",
            "pluralCat": function (n) {
                if (n == 1) {
                    return PLURAL_CATEGORY.ONE;
                }
                return PLURAL_CATEGORY.OTHER;
            }
        });
    }]);