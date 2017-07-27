window.QuestCfg = {};
QuestCfg[1] = new(function() {
    this["subSteps"] = [{
        key: "1_1",
        progress: 2
    }];
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.GENERAL,
            1: QuestGiver.ROBBER
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        type: "input",
        condition: null,
        replacements: [],
        callback: "setName",
        anchor: "a",
        text: "",
        funnelTriggerOnStart: 1,
        funnelTriggerOnEnd: 2
    });
    this.dialog[1]["text"].push({
        actor: 1,
        type: "text",
        condition: null,
        replacements: [],
        callback: "activate",
        anchor: null,
        text: "",
        funnelTriggerOnEnd: 3
    });
    this.dialog[1]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: null,
        anchor: null,
        text: "",
        funnelTriggerOnEnd: 4
    });
    this.dialog[2] = {
        actors: {
            0: QuestGiver.WREN,
            1: QuestGiver.ROBBER
        },
        text: []
    };
    this.dialog[2]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: null,
        anchor: null,
        text: "",
        funnelTriggerOnEnd: 7
    });
    this.dialog[2]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: "backToVillage",
        anchor: null,
        text: "",
        funnelTriggerOnEnd: 8
    });

    function h(k) {
        k.triggerTutorialFunnelStep(5);
        var l = {
            x: 1,
            y: 1,
            type: Troops.MOVEMENT_TYPE_ATTACK
        };
        var j = {};
        j.preselect = {};
        if (Travian.Player.data.tribeId == Player.TRIBE.GAUL) {
            j.preselect[2] = 99
        } else {
            j.preselect[1] = 99
        }
        j.preselect[11] = 1;
        Travian.rootScope.openWindow("sendTroops", l, j);
        Travian.rootScope["$broadcast"]("contextMenuClose")
    }
    var d = -1;
    var c = -1;
    var b = 0;
    var i = null;
    var e = null;
    var a = 0;
    var g = false;

    function f() {
        var j = $("#dialogInputField");
        if (j.length > 0) {
            var k = j[0].getBoundingClientRect();
            if (k.left < 0) {
                window.setTimeout(f, 100);
                return
            }
            j.focus()
        }
    }
    this.getHintArrows = function(r, v, j, q, s, o) {
        var t = [];
        var m = [];
        var p = [];
        if (!g) {
            Travian.rootScope.$on("contextMenuOpen", function(x, w) {
                if (typeof w != "undefined") {
                    a = w.id
                }
            });
            g = true
        }
        if (r.status == Quest.STATUS_ACTIVATABLE) {
            if (s != "map") {
                Travian.rootScope.openPage("map")
            }
            var u = v.getParam("dialogId");
            var n = v.getParam("lineNr");
            if (u == 1 && n == 1 && e === null) {
                e = window.setTimeout(function() {
                    e = null;
                    if (r.status == Quest.STATUS_ACTIVATABLE) {
                        j.showClickForCurrentTask()
                    }
                }, 1800)
            }
            if (d != Quest.STATUS_ACTIVATABLE) {
                b = (new Date()).getTime()
            }
            if (i == null) {
                i = window.setTimeout(function() {
                    i = null;
                    j.ensureDialog(r, 1, Quest.STATUS_ACTIVE);
                    requestAngularApply()
                }, 2200)
            }
            j.disableButton(".send-troops button.next");
            window.setTimeout(f, 500)
        }
        if (r.status == Quest.STATUS_ACTIVE) {
            if (e !== null) {
                window.clearTimeout(e)
            }
            if (s != "map") {
                Travian.rootScope.openPage("map")
            }
            if (d != Quest.STATUS_ACTIVE) {
                j.setActiveQuest(r.id);
                Travian.rootScope.closeWindow("sendTroops")
            }
            window.setTimeout(f, 500);
            j.disableButton(".abortTroopMovementButton");
            j.disableButton("button.sendTroops");
            if (r.progress < 1) {
                if (d != Quest.STATUS_ACTIVE) {
                    if (o != "questDialog") {
                        j.startDialog(QuestGiver.WREN, r.id, 1, 2)
                    }
                }
                if ($("#contextMenu").css("display") == "none") {
                    if (o == "sendTroops") {
                        $(".sendTroops .tabulation.maintab").css("display", "none");
                        $(".sendTroops button.back").css("display", "none");
                        t.push($(".send-troops button.sendTroops"));
                        t.push($(".send-troops button.next"));
                        j.enableButton("button.sendTroops")
                    } else {
                        if (!o) {
                            t.push({
                                elem: $("#tutorialClouds"),
                                offset: {
                                    top: 1465,
                                    left: 10
                                },
                                direction: "down"
                            })
                        }
                    }
                } else {
                    if (a == 536887296) {
                        Travian.rootScope.$broadcast("ContentMenu.overrideCallback", ["pos1", function() {
                            h(j)
                        }]);
                        t.push({
                            elem: $("#contextMenu .pos1"),
                            direction: "up"
                        })
                    }
                }
            } else {
                if (c < 1) {
                    j.triggerTutorialFunnelStep(6);
                    if (!window.disableTutorialAnimations) {
                        var k = $('<div class="tutorialAttackMovement"><div class="tutorialAttackAnimation"></div></div>');
                        getAngularService("AnimationService").showAnimatedElement(k, "#tutorialClouds")
                    }
                }
                j.disableButton("#contextMenu .pos1 .roundButton")
            }
        }
        if (r.status == Quest.STATUS_DONE) {
            if (r.progress == 2) {
                j.ensureVictoryScreen(r.id)
            } else {
                if (r.progress == 3) {
                    j.disableButton("button.sendTroops");
                    j.ensureDialog(r, 2, Quest.STATUS_FINISHED);
                    if (c != 3) {
                        j.setActiveQuest(null);
                        if (!window.disableTutorialAnimations) {
                            var l = Travian.rootScope.$on("urlChanged", function(w, x) {
                                if (x.lineNr && x.lineNr == 1) {
                                    $("#tutorialClouds").append('<div class="tutorialRobbersAnimation"></div>');
                                    l()
                                }
                            })
                        }
                    }
                }
            }
        }
        if (d < 0 && Travian.rootScope.windows["sendTroops"]) {
            h(j)
        }
        d = r.status;
        c = r.progress;
        return {
            arrows: t,
            hints: m,
            npcTexts: p
        }
    }
})();
QuestCfg[23] = new(function() {
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: "email",
        anchor: "a",
        text: "",
        funnelTriggerOnEnd: 28
    });
    this.dialog[2] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[2]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: "email",
        anchor: "a",
        text: ""
    });
    this.dialog[3] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[3]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: "form",
        anchor: "",
        text: "",
        funnelTriggerOnEnd: 29
    });
    this.dialog[4] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[4]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: "form",
        anchor: "",
        text: ""
    });
    var a = -1;
    this.getHintArrows = function(c, f, d) {
        var b = [];
        if (c.status == Quest.STATUS_ACTIVE) {
            d.disableButton(".trainTroops .footerButton");
            d.disableButton("button.sendTroops");
            var h = 1;
            if (c.data == 1) {
                h = 2
            }
            d.ensureDialog(c, h, Quest.STATUS_ACTIVE, 2);
            if (c.progress == 2) {
                d.ensureDialog(c, h + 2, Quest.STATUS_ACTIVE, 3)
            }
            if ((c.progress == 3)) {
                var e = f.getParam("mellonPopup");
                var i = $(".jqFensterContainer");
                if (e != "instantUpgrade" || (e == "instantUpgrade" && i.length == 0)) {
                    d.openInstantUpgrade()
                }
            }
            if (c.progress == 6) {
                d.openActivationWindow();
                var g = {
                    questId: 23,
                    command: "finish"
                };
                Travian.writeRequest("quest/dialogAction", g)
            }
        }
        a = c.status;
        return b
    }
})();
QuestCfg[24] = new(function() {
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.MYSELF,
            1: QuestGiver.CHIEF
        },
        text: []
    };
    this.getHintArrows = function(f, i, a, e, g, c) {
        var h = [];
        var b = [];
        var d = {};
        if ((f.status >= Quest.STATUS_ACTIVATABLE) && (f.status < Quest.STATUS_FINISHED)) {
            a.disableButton(".jsQuestButtonCoronation")
        }
        if (f.status == Quest.STATUS_ACTIVE) {
            if (f.progress == 0) {
                a.addAllowedBuilding(18, -1)
            }
        } else {
            if (f.status == Quest.STATUS_ACTIVATABLE) {
                if (g != "village") {
                    h.push($(".navi_village"))
                }
            }
        }
        return {
            arrows: h,
            hints: b,
            npcTexts: d
        }
    }
})();
QuestCfg[25] = new(function() {
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "input",
        condition: null,
        replacements: [],
        callback: "setName",
        anchor: "a",
        text: ""
    });
    this.dialog[2] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[2]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: "1|a",
        anchor: "a",
        text: ""
    });
    var a = -1;
    this.getHintArrows = function(d, f, e, h, g, c) {
        var b = [];
        if (d.status == Quest.STATUS_ACTIVE) {
            if ((d.progress == 1) && (!c)) {
                e.startDialog(QuestGiver.SCOUT, d.id, 1)
            }
        }
        a = d.status;
        return b
    }
})();
QuestCfg[30] = new(function() {
    this["subSteps"] = [];
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.WREN,
            1: QuestGiver.ROBBER
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: "attack",
        anchor: null,
        text: "",
        funnelTriggerOnEnd: 19
    });
    var a = -1;
    var e = -1;
    var c = null;
    var d = 0;
    var b = false;
    this.getHintArrows = function(m, q, f, k, n, i) {
        var o = [];
        var h = [];
        var j = [];
        if (!b) {
            Travian.rootScope.$on("contextMenuOpen", function(s, r) {
                if (typeof r != "undefined") {
                    d = r.id
                }
            });
            b = true
        }
        if (m.status == Quest.STATUS_ACTIVE) {
            f.disableButton("button.sendTroops");
            if (a != Quest.STATUS_ACTIVE) {
                var l = Travian.Player.data.tribeId;
                var p = m.id;
                this["subSteps"] = [{
                    key: p + "_1_" + l,
                    progress: 1
                }, {
                    key: p + "_2",
                    progress: 2
                }, {
                    key: p + "_3_" + l,
                    progress: 3
                }, {
                    key: p + "_4",
                    progress: 5
                }];
                f.setActiveQuest(m.id)
            }
            f.disableButton(".abortTroopMovementButton");
            if (n == "map") {
                if ($("#contextMenu").css("display") == "none") {
                    if (i == "sendTroops") {
                        o.push($(".send-troops button.sendTroops"));
                        o.push($(".send-troops button.next"))
                    } else {
                        if (!i) {
                            o.push({
                                elem: $("#tutorialClouds"),
                                offset: {
                                    top: 1465,
                                    left: 10
                                },
                                direction: "down"
                            })
                        }
                    }
                } else {
                    if (d == 536887296) {
                        o.push({
                            elem: $("#contextMenu .item.pos0"),
                            offset: {
                                top: 0,
                                left: 0
                            },
                            direction: "up"
                        })
                    }
                }
            } else {
                if (n == "resources") {
                    Travian.rootScope.openPage("village")
                }
            }
            if (m.progress == 3) {
                if (e != 3) {
                    c = (new Date()).getTime()
                }
                if (i) {
                    var g = (new Date()).getTime();
                    if (g > c + 5000) {
                        o.push($(".modal .decoration .close"))
                    }
                } else {
                    f.ensureDialog(m, 1, Quest.STATUS_ACTIVE, 4)
                }
            }
        }
        if (m.status == Quest.STATUS_DONE) {
            f.ensureVictoryScreen(m.id);
            $("#tutorialClouds .tutorialRobbersAnimation").remove()
        }
        a = m.status;
        e = m.progress;
        return {
            arrows: o,
            hints: h,
            npcTexts: j
        }
    }
})();
QuestCfg[31] = new(function() {
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.WREN,
            1: QuestGiver.ROBBER
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: null,
        anchor: null,
        text: "",
        funnelTriggerOnStart: 9,
        funnelTriggerOnEnd: 10
    });
    var a = -1;
    var c = -1;
    var b = false;
    this.getHintArrows = function(i, l, d, h, j, f) {
        var k = [];
        var e = [];
        var g = [];
        if (i.status == Quest.STATUS_ACTIVE) {
            if (j == "village") {
                if (!b) {
                    b = true;
                    d.startDialog(QuestGiver.WREN, i.id, 1)
                }
            }
            d.addAllowedBuilding(31, 33);
            d.addAllowedBuilding(32, 33);
            d.addAllowedBuilding(33, 33)
        }
        if (i.status == Quest.STATUS_DONE) {
            d.triggerTutorialFunnelStep(11);
            d.ensureVictoryScreen(i.id, true)
        }
        a = i.status;
        c = i.progress;
        return {
            arrows: k,
            hints: e,
            npcTexts: g
        }
    }
})();
QuestCfg[32] = new(function() {
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.WREN,
            1: QuestGiver.ROBBER
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: null,
        anchor: null,
        text: "",
        funnelTriggerOnEnd: 12
    });
    var a = -1;
    var c = -1;
    var b = false;
    this.getHintArrows = function(i, l, d, h, j, f) {
        var k = [];
        var e = [];
        var g = [];
        if (i.status == Quest.STATUS_ACTIVE) {
            if (!b) {
                b = true;
                d.startDialog(QuestGiver.WREN, i.id, 1)
            }
            d.addAllowedBuilding(19, -1);
            if (f == "building") {
                d.triggerTutorialFunnelStep(13)
            }
        }
        a = i.status;
        c = i.progress;
        return {
            arrows: k,
            hints: e,
            npcTexts: g
        }
    }
})();
QuestCfg[33] = new(function() {
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.WREN,
            1: QuestGiver.ROBBER
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: null,
        anchor: null,
        text: "",
        funnelTriggerOnStart: 14,
        funnelTriggerOnEnd: 15
    });
    var a = -1;
    var d = -1;
    var b = false;
    var c = 2;
    this.prepareDialogScope = function(f, e) {
        if (Travian.Player.data.tribeId == Player.TRIBE.GAUL) {
            c = 1
        }
        f.troopName = Travian.translate("Troop_" + nrToUnitId(c, Travian.Player.data.tribeId))
    };
    this.getHintArrows = function(n, q, f, m, o, j) {
        var p = [];
        var h = [];
        var l = [];
        if (n.status == Quest.STATUS_ACTIVE) {
            f.disableButton(".trainTroops .footerButton");
            f.disableButton("button.sendTroops");
            if (!b) {
                b = true;
                f.startDialog(QuestGiver.WREN, n.id, 1)
            }
            if (!j) {
                var i = $(".buildingId19");
                i.arrowOffset = {
                    top: -10,
                    left: -5
                };
                p.push(i)
            } else {
                var g = $(".unitList");
                var e = g.find(".unit > .active");
                if (e.length !== 0 && e.find(".unitType" + c).length !== 0) {
                    var k = parseInt(g.find(".inputContainer input").val(), 10);
                    if (k < 3) {
                        p.push($(".buildingDetails .inputContainer .maxButton"));
                        f.triggerTutorialFunnelStep(16)
                    } else {
                        p.push($(".buildingDetails .footerButton"));
                        f.triggerTutorialFunnelStep(17)
                    }
                    f.enableButton(".trainTroops .footerButton")
                } else {
                    f.disableButton(".trainTroops .footerButton");
                    p.push(g.find(".unitType" + c))
                }
            }
        }
        if (n.status == Quest.STATUS_FINISHED) {
            if (j == "building") {
                f.triggerTutorialFunnelStep(18)
            }
            Travian.rootScope.closeWindow(j)
        }
        a = n.status;
        d = n.progress;
        return {
            arrows: p,
            hints: h,
            npcTexts: l
        }
    }
})();
QuestCfg[34] = new(function() {
    this["subSteps"] = [{
        key: "34_1",
        progress: 1
    }];
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.WREN,
            1: QuestGiver.ROBBER
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: "activate",
        anchor: null,
        text: "",
        funnelTriggerOnEnd: 20
    });
    var a = -1;
    var b = -1;
    var c = false;
    this.getHintArrows = function(j, m, d, i, k, f) {
        var l = [];
        var e = [];
        var g = [];
        if (j.status == Quest.STATUS_ACTIVATABLE) {
            d.disableButton(".trainTroops .footerButton");
            d.disableButton("button.sendTroops");
            d.ensureDialog(j, 1, Quest.STATUS_ACTIVE, 0)
        }
        if (j.status == Quest.STATUS_ACTIVE) {
            d.disableButton(".trainTroops .footerButton");
            d.disableButton("button.sendTroops");
            d.disableButton(".windowOverlay .darkener");
            d.disableButton(".windowOverlay .closeOverlay");
            if (a != Quest.STATUS_ACTIVE) {
                d.setActiveQuest(j.id)
            }
            var h = m.getParam("herotab");
            if ((f != "hero") || (h != "Attributes")) {
                Travian.rootScope.openWindow("hero", {
                    herotab: "Attributes",
                    modal: true
                })
            } else {
                if (f == "hero" && h == "Attributes") {
                    Travian.rootScope.$broadcast("heroEditor.openOverlay");
                    if (!c) {
                        Travian.rootScope.$on("heroEditor.saveFace", function() {
                            var n = {
                                questId: 34,
                                dialogId: 1,
                                command: "face",
                                input: ""
                            };
                            d.triggerTutorialFunnelStep(21);
                            setTimeout(function() {
                                Travian.writeRequest("quest/dialogAction", n, function() {
                                    Travian.rootScope.closeWindow("hero")
                                })
                            }, 100)
                        });
                        c = true
                    }
                }
            }
        }
        a = j.status;
        b = j.progress;
        return {
            arrows: l,
            hints: e,
            npcTexts: g
        }
    }
})();
QuestCfg[35] = new(function() {
    this["subSteps"] = [{
        key: "35_1",
        progress: 1
    }];
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.WREN,
            1: QuestGiver.ROBBER
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: null,
        anchor: null,
        text: "",
        funnelTriggerOnEnd: 22
    });
    this.dialog[1]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: "activate",
        anchor: null,
        text: "",
        funnelTriggerOnEnd: 23
    });
    var a = -1;
    var b = -1;
    this.getHintArrows = function(h, k, c, g, i, e) {
        var j = [];
        var d = [];
        var f = [];
        if (i == "resources" && h.status == Quest.STATUS_ACTIVE) {
            c.triggerTutorialFunnelStep(24)
        }
        if (h.status == Quest.STATUS_ACTIVATABLE) {
            c.ensureDialog(h, 1, Quest.STATUS_ACTIVE, 0)
        }
        if (h.status == Quest.STATUS_ACTIVE) {
            c.disableButton(".trainTroops .footerButton");
            c.disableButton("button.sendTroops");
            if (a != Quest.STATUS_ACTIVE) {
                c.setActiveQuest(h.id)
            }
            c.addAllowedBuilding(4, 15)
        }
        if (h.status == Quest.STATUS_DONE) {
            c.triggerTutorialFunnelStep(25);
            c.ensureVictoryScreen(h.id)
        }
        a = h.status;
        b = h.progress;
        return {
            arrows: j,
            hints: d,
            npcTexts: f
        }
    }
})();
QuestCfg[101] = new(function() {
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.ENVOY,
            1: QuestGiver.MYSELF
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: ["player.data.name"],
        callback: "check",
        anchor: null,
        text: ""
    });
    this.dialog[1]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: ["kingName"],
        callback: null,
        anchor: null,
        text: ""
    });
    this.dialog[1]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: null,
        anchor: null,
        text: ""
    });
    this.dialog[1]["text"].push({
        actor: 1,
        type: "MC",
        condition: null,
        replacements: ["kingName"],
        callback: "accept",
        anchor: null,
        text: ""
    });
    this.dialog[1]["text"].push({
        actor: 1,
        type: "MC",
        condition: null,
        replacements: [],
        callback: "decline",
        anchor: null,
        text: ""
    });
    this.dialog[1]["text"].push({
        actor: 1,
        type: "MC",
        condition: null,
        replacements: [],
        callback: null,
        anchor: null,
        text: ""
    });
    this.prepareDialogScope = function(a, b) {
        if (typeof b === "undefined") {
            a.closeWindow("questDialog");
            return
        }
        var e = Kingdom.get(b.progress);
        var d = -1;
        if (e.getKingId() > 0) {
            c()
        } else {
            d = e.subscribe(c)
        }

        function c() {
            Travian.nameService.getNameForId(e.getKingId(), function(f) {
                a.kingName = f;
                a.addData = f
            });
            if (d >= 0) {
                e.unsubscribe(d)
            }
        }
    }
})();
QuestCfg[102] = new(function() {
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.ENVOY,
            1: QuestGiver.MYSELF
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: ["player.data.name", "kingName"],
        callback: null,
        anchor: null,
        text: ""
    });
    this.dialog[1]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: null,
        anchor: null,
        text: ""
    });
    this.dialog[1]["text"].push({
        actor: 1,
        type: "MC",
        condition: null,
        replacements: [],
        callback: "accept",
        anchor: null,
        text: ""
    });
    this.dialog[1]["text"].push({
        actor: 1,
        type: "MC",
        condition: null,
        replacements: [],
        callback: "decline",
        anchor: null,
        text: ""
    });
    this.dialog[1]["text"].push({
        actor: 1,
        type: "MC",
        condition: null,
        replacements: [],
        callback: null,
        anchor: null,
        text: ""
    });
    this.prepareDialogScope = function(a, b) {
        if (!Travian.nameService) {
            return
        }
        Travian.nameService.getNameForId(b.progress, function(c) {
            a.kingName = c
        })
    }
})();
QuestCfg[203] = new(function() {
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.WREN,
            1: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: "activate",
        anchor: null,
        text: "",
        funnelTriggerOnEnd: 26
    });
    var a = -1;
    this.getHintArrows = function(c, f, d) {
        var b = [];
        if (c.status == Quest.STATUS_ACTIVATABLE) {
            d.ensureDialog(c, 1, Quest.STATUS_ACTIVE, 0)
        }
        if (c.status == Quest.STATUS_ACTIVE) {
            d.disableButton(".trainTroops .footerButton");
            d.disableButton("button.sendTroops");
            if (a != Quest.STATUS_ACTIVE) {
                d.setActiveQuest(null)
            }
            var e = f.getParam("window");
            if (e != "kingOrGovernor") {
                Travian.rootScope.openWindow("kingOrGovernor")
            }
        }
        a = c.status;
        return b
    }
})();
QuestCfg[204] = new(function() {
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: "3|a",
        anchor: null,
        text: "",
        funnelTriggerOnStart: 30,
        funnelTriggerOnEnd: 31
    });
    this.dialog[2] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[2]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: "3|a",
        anchor: null,
        text: ""
    });
    this.dialog[3] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[3]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: "activate",
        anchor: "a",
        text: "",
        funnelTriggerOnEnd: 32
    });
    var a = -1;
    var c = -1;
    var b = false;
    this.getHintArrows = function(e, h, f) {
        var d = [];
        switch (e.status) {
            case Quest.STATUS_FINISHED:
                if (typeof(fbq) != "undefined") {
                    fbq("track", "CompleteRegistration")
                }
                break;
            case Quest.STATUS_ACTIVE:
                f.disableButton(".trainTroops .footerButton");
                f.disableButton("button.sendTroops");
                if (a != Quest.STATUS_ACTIVE) {
                    f.setActiveQuest(null)
                }
                f.disableButton(".jsQuestButtonCoronation");
                var g = h.getParam("window");
                if (e.progress < 3 && g != "questPuzzle") {
                    Travian.rootScope.openWindow("questPuzzle")
                }
                if (e.progress == 4 && g != "questDirectionSelection") {
                    f.triggerTutorialFunnelStep(33);
                    if (Travian.Player.data.prestige == 0 && !b) {
                        b = true;
                        Travian.request("player/getReferralDirection", {}, function(j) {
                            var k = {
                                questId: e.id,
                                dialogId: 0,
                                command: "direction" + j.direction
                            };
                            Travian.writeRequest("quest/dialogAction", k, function() {
                                Travian.rootScope.closeWindow("questDirectionSelection")
                            })
                        })
                    } else {
                        if (!b) {
                            Travian.rootScope.openWindow("questDirectionSelection")
                        }
                    }
                }
                if (e.progress == 6 && g != "questDirectionSelection") {
                    Travian.rootScope.openWindow("questDirectionSelection", {
                        choseDirectionError: "Error.Map.DirectionSelection"
                    })
                }
                break;
            case Quest.STATUS_ACTIVATABLE:
                var i = 1;
                if (e.data == 1) {
                    i = 2
                }
                if (e.data == 3) {
                    i = 3
                }
                f.ensureDialog(e, i, Quest.STATUS_ACTIVE, 0);
                break
        }
        a = e.status;
        c = e.progress;
        return d
    }
})();
QuestCfg[302] = new(function() {
    this["subSteps"] = [{
        key: "302_1",
        progress: 1
    }, {
        key: "302_2",
        progress: 2
    }, {
        key: "302_3",
        progress: 5
    }];
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: "activate",
        anchor: null,
        text: "",
        funnelTriggerOnEnd: 34
    });
    var e = null;
    var a = -1;
    var d = -1;
    var c = 0;
    var b = false;
    this.getHintArrows = function(t, l, v, x, h, o) {
        var p = [];
        var u = [];
        var r = [];
        if (!b) {
            Travian.rootScope.$on("contextMenuOpen", function(B, i) {
                if (typeof i != "undefined") {
                    c = i.id
                }
            });
            b = true
        }
        if (t.status == Quest.STATUS_ACTIVATABLE) {
            v.ensureDialog(t, 1, Quest.STATUS_ACTIVE, 0)
        }
        if ((t.status >= Quest.STATUS_ACTIVATABLE) && (t.status < Quest.STATUS_FINISHED)) {
            v.disableButton("#jsQuestButtonCommunityAttacks");
            v.disableButton("#jsQuestButtonIgm");
            v.disableButton("#jsQuestButtonQuestbook");
            v.disableButton("#jsQuestButtonStatistics");
            v.disableButton(".jsQuestButtonCoronation");
            v.disableButton(".abortTroopMovementButton");
            v.disableButton(".send-troops button.next")
        }
        if (t.status == Quest.STATUS_ACTIVE) {
            v.disableButton(".trainTroops .footerButton");
            v.disableButton("button.sendTroops");
            if (a != Quest.STATUS_ACTIVE) {
                v.setActiveQuest(t.id)
            }
            v.disableButton(".abortTroopMovementButton");
            v.disableButton(".chooseMissionType .clickableContainer:not(.missionType3)");
            if (t.progress <= 1) {
                var j = $("#troopMovements").find(".countdown");
                if (h != "map" && j.length == 0) {
                    p.push($(".navi_map"))
                } else {
                    if (j.length == 0) {
                        v.triggerTutorialFunnelStep(35);
                        if ($("#contextMenu").css("display") == "none") {
                            if (o == "sendTroops") {
                                v.triggerTutorialFunnelStep(36);
                                var y = $(".searchVillage .playerVillage");
                                if (y.length !== 0 && parseInt(y.attr("data-village-type"), 10) === Village.TYPE_ROBBER_VILLAGE) {
                                    var q = 0;
                                    if (Travian.Player.data.tribeId == Player.TRIBE.GAUL) {
                                        q = 1
                                    }
                                    var k = $(".send-troops .unitInput" + q);
                                    var g = parseInt(k.attr("number"), 10);
                                    var f = parseInt(k.val(), 10);
                                    if ((f < g) || (k.val() == "")) {
                                        p.push(k);
                                        $(".send-troops button.next").addClass("disabled")
                                    } else {
                                        k = $(".send-troops .unitInput10");
                                        f = parseInt(k.val());
                                        if ((f < 1) || (k.val() == "")) {
                                            p.push(k);
                                            $(".send-troops button.next").addClass("disabled")
                                        } else {
                                            $(".send-troops button.next").removeClass("disabled");
                                            p.push($(".send-troops button.sendTroops"));
                                            p.push($(".send-troops button.next"));
                                            v.enableButton("");
                                            v.triggerTutorialFunnelStep(37)
                                        }
                                    }
                                } else {
                                    var n = $(".send-troops button.sendTroops");
                                    if (n.length > 0) {
                                        v.enableButton("button.sendTroops");
                                        p.push($(".send-troops button.sendTroops"));
                                        v.triggerTutorialFunnelStep(38)
                                    } else {
                                        p.push($(".sendTroops .closeWindow"));
                                        v.disableButton(".send-troops button.next")
                                    }
                                }
                            } else {
                                if (e == null) {
                                    var m = x.getActiveVillageId();
                                    var s = $("#overlayMarkers .villageName");
                                    for (var w = 0; w < s.length; w++) {
                                        var z = s[w].id.split("villageName");
                                        if (z[1] != m && $(s[w]).find(".inner").hasClass("jsVillageType5")) {
                                            e = z[1]
                                        }
                                    }
                                }
                                if (e != null) {
                                    p.push($("#villageName" + e))
                                }
                            }
                        } else {
                            if (c == e) {
                                t.progress = 1;
                                p.push($("#contextMenu .pos1"))
                            }
                        }
                    }
                }
            }
            if (t.progress == 2) {
                v.triggerTutorialFunnelStep(39)
            }
            if (t.progress == 3) {
                v.ensureVictoryScreen(t.id)
            }
            if ((t.progress == 4) && (d != 4)) {
                var A = {
                    questId: t.id,
                    dialogId: 1,
                    command: "finish"
                };
                Travian.writeRequest("quest/dialogAction", A, function() {})
            }
        }
        d = t.progress;
        a = t.status;
        return {
            arrows: p,
            hints: u,
            npcTexts: r
        }
    }
})();
QuestCfg[303] = new(function() {
    this["subSteps"] = [{
        key: "303_1",
        progress: 2
    }];
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: "activate",
        anchor: null,
        text: "",
        funnelTriggerOnEnd: 40
    });
    this.removeBuildingRestriction = true;
    var a = -1;
    this.getHintArrows = function(g, j, b, e, h, c) {
        var i = [];
        if ((g.status >= Quest.STATUS_ACTIVATABLE) && (g.status < Quest.STATUS_FINISHED)) {
            b.disableButton("#jsQuestButtonCommunityAttacks");
            b.disableButton("#jsQuestButtonIgm");
            b.disableButton("#jsQuestButtonQuestbook");
            b.disableButton("#jsQuestButtonStatistics");
            b.disableButton(".jsQuestButtonCoronation");
            b.ensureDialog(g, 1, Quest.STATUS_ACTIVE, 0)
        }
        if (g.status == Quest.STATUS_ACTIVE) {
            b.disableButton(".trainTroops .footerButton");
            b.disableButton("button.sendTroops");
            if (a != Quest.STATUS_ACTIVE) {
                b.setActiveQuest(g.id)
            }
            if (c == "hero") {
                var f = j.getParam("herotab");
                if ((f == null) || (f == "Inventory")) {
                    b.triggerTutorialFunnelStep(41);
                    var d = $(".hero.inWindowPopupOpened");
                    if (d.length < 1) {
                        i.push($(".inventory .item_" + HeroItem.TYPE_TREASURES))
                    } else {
                        b.triggerTutorialFunnelStep(42);
                        i.push($(".inWindowPopupContent .useItemButton"))
                    }
                } else {
                    i.push($(".tabulation .tab"))
                }
            } else {
                if (Travian.Config.features["prestige"]) {
                    i.push({
                        elem: $("#heroQuickInfo .framedAvatarImage"),
                        additionalClass: "heroArrow"
                    })
                } else {
                    i.push($("#heroQuickInfo .framedAvatarImage"))
                }
            }
        }
        if (g.status == Quest.STATUS_DONE) {
            b.triggerTutorialFunnelStep(43);
            b.ensureVictoryScreen(g.id)
        }
        a = g.status;
        return i
    }
})();
QuestCfg[399] = new(function() {
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: "activate",
        anchor: null,
        text: "",
        funnelTriggerOnStart: 44,
        funnelTriggerOnEnd: 45
    });
    this.removeBuildingRestriction = true;
    var a = -1;
    var b = null;
    this["subSteps"] = [{
        key: "399_1",
        progress: 5
    }];
    this.getHintArrows = function(e, g, f, j, i, d) {
        var c = [];
        if (e.status == Quest.STATUS_ACTIVE) {
            if (a != Quest.STATUS_ACTIVE) {
                f.setActiveQuest(e.id)
            }
            f.enableButton("#jsQuestButtonCommunityAttacks");
            f.enableButton("#jsQuestButtonIgm");
            f.enableButton("#jsQuestButtonQuestbook");
            f.enableButton("#jsQuestButtonStatistics");
            c.push($("#jsQuestButtonQuestbook"))
        }
        if (e.status == Quest.STATUS_ACTIVATABLE) {
            if (d != "gameTimeline" && d != "questDialog") {
                Travian.rootScope.openWindow("gameTimeline");
                if (!b) {
                    $(".questCurrentTask").hide();
                    b = Travian.rootScope.$watch("windows", function(k) {
                        if ($.isEmptyObject(k)) {
                            f.ensureDialog(e, 1, Quest.STATUS_ACTIVE, 0);
                            $(".questCurrentTask").show();
                            if (typeof(b) == "function") {
                                b();
                                b = null
                            }
                        }
                    }, true)
                }
            }
        }
        if (d == "questBook") {
            f.triggerTutorialFunnelStep(46);
            var h = {
                questId: 399,
                dialogId: 1,
                command: "finish"
            };
            Travian.writeRequest("quest/dialogAction", h, function() {
                e.progress = Quest.STATUS_FINISHED;
                e.status = Quest.STATUS_FINISHED;
                setTimeout(function() {
                    f.setActiveQuest(null)
                }, 3000)
            })
        }
        a = e.status;
        return c
    }
})();
QuestCfg[400] = new(function() {
    this["subSteps"] = [{
        key: "400_1",
        progress: 1
    }];
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: "activate",
        anchor: null,
        text: ""
    });
    var a = -1;
    var c = -1;
    var b = false;
    this.getHintArrows = function(i, l, d, h, j, f) {
        var k = [];
        var e = [];
        var g = [];
        if (i.status == Quest.STATUS_ACTIVATABLE) {
            d.ensureDialog(i, 1, Quest.STATUS_ACTIVE, 0)
        }
        if (i.status == Quest.STATUS_ACTIVE) {
            d.disableButton(".trainTroops .footerButton");
            d.disableButton("button.sendTroops");
            if (a != Quest.STATUS_ACTIVE) {
                d.setActiveQuest(i.id)
            }
            d.addAllowedBuilding(Building.TYPE.HIDDEN_TREASURY, -1)
        }
        a = i.status;
        c = i.progress;
        return {
            arrows: k,
            hints: e,
            npcTexts: g
        }
    }
})();
QuestCfg[401] = new(function() {
    this["subSteps"] = [{
        key: "401_1",
        progress: 1
    }, {
        key: "401_2",
        progress: 2
    }];
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: null,
        anchor: "a",
        text: ""
    });
    this.dialog[1]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: "activate",
        anchor: null,
        text: ""
    });
    this.dialog[2] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[2]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: "startAttack",
        anchor: null,
        text: ""
    });
    this.dialog[3] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[3]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: "finish",
        anchor: null,
        text: ""
    });
    var g = null;
    var d = false;
    var f = -1;
    var a = -1;
    var b = false;
    var e = 0;
    var c = false;
    this.getHintArrows = function(t, l, v, x, j, o) {
        var p = [];
        var u = [];
        var r = {};
        if (!c) {
            Travian.rootScope.$on("contextMenuOpen", function(A, i) {
                if (typeof i != "undefined") {
                    e = i.id
                }
            });
            c = true
        }
        if (t.status == Quest.STATUS_ACTIVATABLE) {
            v.ensureDialog(t, 1, Quest.STATUS_ACTIVE, 0)
        }
        if ((t.status >= Quest.STATUS_ACTIVATABLE) && (t.status < Quest.STATUS_FINISHED)) {
            v.disableButton("#jsQuestButtonCommunityAttacks");
            v.disableButton("#jsQuestButtonIgm");
            v.disableButton("#jsQuestButtonQuestbook");
            v.disableButton("#jsQuestButtonStatistics");
            v.disableButton(".jsQuestButtonCoronation")
        }
        if (t.status == Quest.STATUS_ACTIVE) {
            v.disableButton(".trainTroops .footerButton");
            v.disableButton("button.sendTroops");
            v.disableButton("button.jsButtonSendTroopsBack");
            if (a != Quest.STATUS_ACTIVE) {
                v.setActiveQuest(t.id)
            }
            v.disableButton(".abortTroopMovementButton");
            if (t.progress < 2) {
                if (j != "map") {
                    p.push($(".navi_map"))
                } else {
                    if ($("#contextMenu").css("display") == "none") {
                        if (o == "sendTroops") {
                            v.disableButton(".chooseMissionType .clickableContainer:not(.missionType5)");
                            var y = $(".searchVillage .playerVillage");
                            if (y.length !== 0 && y.attr("data-is-governor-npc") === "true") {
                                var q = 1;
                                if (Travian.Player.data.tribeId == Player.TRIBE.GAUL) {
                                    q = 0
                                }
                                var k = $(".send-troops .unitInput" + q);
                                var h = parseInt(k.val());
                                if ((h < 3) || (k.val() == "")) {
                                    p.push(k);
                                    $(".send-troops button.next").addClass("disabled")
                                } else {
                                    $(".send-troops button.next").removeClass("disabled");
                                    p.push($(".send-troops button.sendTroops"));
                                    p.push($(".send-troops button.next"))
                                }
                            } else {
                                var n = $(".send-troops button.sendTroops");
                                if (n.length > 0) {
                                    p.push($(".send-troops button.sendTroops"));
                                    v.enableButton("button.sendTroops")
                                } else {
                                    p.push($(".sendTroops .closeWindow"));
                                    v.disableButton(".send-troops button.next")
                                }
                            }
                        } else {
                            if (g == null) {
                                var m = x.getActiveVillageId();
                                var s = $("#overlayMarkers .villageName");
                                for (var w = 0; w < s.length; w++) {
                                    var z = s[w].id.split("villageName");
                                    if (z[1] != m) {
                                        g = z[1]
                                    }
                                }
                            }
                            if (g != null) {
                                p.push($("#villageName" + g))
                            }
                        }
                    } else {
                        if (e == g) {
                            p.push($("#contextMenu .pos1"));
                            t.progress = 1
                        }
                    }
                }
            }
            if (t.progress == 2) {
                v.ensureDialog(t, 2, Quest.STATUS_ACTIVE, 3)
            }
            if ((t.progress == 3) && (f != 3)) {
                window.setTimeout(function() {
                    v.ensureVictoryScreen(t.id)
                }, 10000)
            }
            f = t.progress
        }
        if (t.status == Quest.STATUS_DONE) {
            v.ensureDialog(t, 3, Quest.STATUS_FINISHED, 0)
        }
        a = t.status;
        return {
            arrows: p,
            hints: u,
            npcTexts: r
        }
    }
})();
QuestCfg[402] = new(function() {
    this["subSteps"] = [{
        key: "402_1",
        progress: 1
    }, {
        key: "402_2",
        progress: 3
    }, {
        key: "402_3",
        progress: 4
    }];
    this.removeBuildingRestriction = true;
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: "activate",
        anchor: null,
        text: ""
    });
    this.dialog[2] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[2]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: "beginCallHome",
        anchor: null,
        text: ""
    });
    this.dialog[3] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[3]["text"].push({
        actor: 0,
        emotion: "friendly",
        type: "text",
        condition: null,
        replacements: [],
        callback: "finish",
        anchor: null,
        text: ""
    });
    var b = false;
    var a = -1;
    var c = -1;
    this.getHintArrows = function(k, o, d, j, m, g) {
        var n = [];
        var e = [];
        var h = {};
        if (k.status == Quest.STATUS_ACTIVATABLE) {
            d.ensureDialog(k, 1, Quest.STATUS_ACTIVE, 0)
        }
        if ((k.status >= Quest.STATUS_ACTIVATABLE) && (k.status < Quest.STATUS_FINISHED)) {
            d.disableButton("#jsQuestButtonCommunityAttacks");
            d.disableButton("#jsQuestButtonIgm");
            d.disableButton("#jsQuestButtonQuestbook");
            d.disableButton("#jsQuestButtonStatistics");
            d.disableButton(".jsQuestButtonCoronation")
        }
        if (k.status == Quest.STATUS_ACTIVE) {
            d.disableButton(".trainTroops .footerButton");
            d.disableButton("button.sendTroops");
            if (k.progress < 3) {
                d.disableButton("button.jsButtonSendTroopsBack")
            }
            if (a != Quest.STATUS_ACTIVE) {
                d.setActiveQuest(k.id)
            }
            if (k.progress == 0) {
                if (!g) {
                    n.push($("#jsQuestButtonCommunities"))
                } else {
                    var i = o.getParam("subtab");
                    if (i == null || i != "Tributes") {
                        n.push($("#optimizely_subtab_Tributes"))
                    } else {
                        n.push($(".tributes .collect .npcVillageButton"));
                        n.push($(".jsQuestTributeButtons.villageType" + Village.TYPE_GOVERNOR_NPC_VILLAGE + " button:not(.disabled)"))
                    }
                }
            }
            if (k.progress == 2) {
                d.ensureVictoryScreen(k.id)
            }
            if (k.progress == 3) {
                if (c != 3) {
                    d.startDialog(QuestGiver.SCOUT, k.id, 2)
                }
                if (m != "village") {
                    n.push($(".navi_village"))
                } else {
                    if (g) {
                        var f = $(".jsButtonSendTroopsBack");
                        if (f.length == 0) {
                            f = $(".buildingRallypointOverview  .tabulation").find("a").eq(1)
                        }
                        n.push(f)
                    } else {
                        var l = $(".buildingId16");
                        l.arrowOffset = {
                            top: -60,
                            left: 20
                        };
                        n.push(l)
                    }
                }
            }
        }
        if (k.status == Quest.STATUS_DONE) {
            d.ensureDialog(k, 3, Quest.STATUS_FINISHED, 0);
            if (a != Quest.STATUS_DONE) {
                d.setActiveQuest(null)
            }
        }
        a = k.status;
        c = k.progress;
        return {
            arrows: n,
            hints: e,
            npcTexts: h
        }
    }
})();
QuestCfg[403] = new(function() {
    this["subSteps"] = [{
        key: "400_1",
        progress: 0
    }, {
        key: "403_1",
        progress: 1
    }, {
        key: "403_2",
        progress: 2
    }];
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.SCOUT
        },
        text: []
    };
    this.dialog[1]["text"].push({
        actor: 0,
        type: "text",
        condition: null,
        replacements: [],
        callback: "activate",
        anchor: null,
        text: ""
    });
    var a = -1;
    var c = -1;
    var b = false;
    this.getHintArrows = function(i, l, d, h, j, f) {
        var k = [];
        var e = [];
        var g = [];
        if (i.status == Quest.STATUS_ACTIVATABLE) {
            d.ensureDialog(i, 1, Quest.STATUS_ACTIVE, 0)
        }
        if (i.status == Quest.STATUS_ACTIVE) {
            d.disableButton(".trainTroops .footerButton");
            d.disableButton("button.sendTroops");
            if (a != Quest.STATUS_ACTIVE) {
                d.setActiveQuest(i.id)
            }
            if (i.progress < 1) {
                if (!f) {
                    k.push({
                        elem: $(".buildingId45"),
                        offset: {
                            top: 20,
                            left: -20
                        },
                        direction: "down"
                    })
                } else {
                    k.push({
                        elem: $(".buildingType45 .treasury .activateControl button"),
                        offset: {
                            top: 0,
                            left: 0
                        },
                        direction: "up"
                    })
                }
            }
        }
        a = i.status;
        c = i.progress;
        return {
            arrows: k,
            hints: e,
            npcTexts: g
        }
    }
})();
QuestCfg[991] = new(function() {
    this["name"] = "ShortAdventure";
    this["hideStartScreen"] = true;
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.MYSELF,
            1: QuestGiver.ADVENTURER
        },
        text: [],
        module: "questSelection"
    }
})();
QuestCfg[992] = new(function() {
    this["name"] = "LongAdventure";
    this["hideStartScreen"] = true;
    this.dialog = {};
    this.dialog[1] = {
        actors: {
            0: QuestGiver.MYSELF,
            1: QuestGiver.ADVENTURER
        },
        text: [],
        module: "questSelection"
    }
})();