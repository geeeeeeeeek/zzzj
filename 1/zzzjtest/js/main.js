$(document).ready(function () {
    var time1 = null;
    var category = null;
    var inited = false;
    var quesid;	//存储题目序号
    var quescount = 20;	//题目数量
    var quesnow = 0;	//当前题目;
    var first = false;	//是否是第一次答题
    var permit = false;
    var init = function () {
        $("#logout").click(function () {
            $.ajax({
                url: "http://stu.fudan.edu.cn/teleport/gateway/logout",
                type: "get",
                success: function () {
                    window.location.href = "http://stu.fudan.edu.cn/ztalents";
                }
            })
        })
        $.ajax({
            url: "./php/checkuser.php",
            type: "get",
            async: false,
            success: function (data) {
                /*if (data == 1) {
                    permit = true;
                    $("#content-inf").html("恭喜您进入复赛~点击下一步进入答题!");
                }
                else {
                    $("#intro .next").attr("href", "http://stu.fudan.edu.cn");
                }*/
                permit=true;
            }
        })
        $(".page-wrap").hide();
        $("#intro-page").show();
        $("#intro-page").css("margin-left", "-300px");
/*        $.ajax({	//查询用户信息
            url: "./php/needtodelete.php",
            type: "get",
            async: false,
            success: function (data) {
            }
        })*/

        if (window.localStorage && localStorage.quesid2 != null) {	//获取存储的题目
            quesid = localStorage.quesid2.split(",");

        }
        else {
            first = true;
        }
        $.ajax({	//获取题号
            url: "./php/checkhistory.php",
            type: "get",
            async: false,
            success: function (data) {
                if (data != 0) {
                    quesnow = parseInt(data);
                    if (quesnow == 100) {
                        $("#intro-page .content").text("您本次比赛只能回答一次问题");
                        $("#intro-page .content").addClass("alertonce");
                        $("#intro-page .each-page").css("height", "231px");
                    }
                }
            }
        })

    }
    var bind = function () {
        $("#intro-page .next").click(function () {
            if (quesnow == 100) {
                window.location.href = "http://stu.fudan.edu.cn";
            }
            else {
                if ($("#clicktomove").css("display") == "none") {
                    if (permit == true || true) {
                        $("#intro-page p").hide();
                        $("#clicktomove").show();
                        $("#intro-page img").show();

                        if (quesnow == 0)
                            $("#intro-page #category-picker").show();
                        else {
                            $("#category-picker").remove();
                            $("#alert-history").show();
                            $("#alert-history").text("检测到您刚刚做到第" + (quesnow) + "题，您可以从下一道题继续作答");
                        }
                    }

                }
                else {
                    if ($("#category").text() != "请选择专业")
                        pageswitch();
                }
            }
        })
        $("#category-picker li").click(function () {
            $("#category").text($(this).text());
            switch ($(this).text()) {
                case "计算机软工":
                    category = 1;
                    break;
                case "药学":
                    category = 2;
                    break;
                case "微电":
                    category = 3;
                    break;
                default:
                    category = -1;
            }
        })
        $(document).on("click", ".next", function () {
            if ($("#intro-page").css("display") == "none") {

                pageswitch();
            }
        })
        $("#timer-wrap").on("mouseover", function () {
            $("#timer-wrap").css("visibility", "hidden");
            $(".page-wrap.show .next p").show();
        })
        $("#timer-wrap").on("mouseout", function () {
            if ($("#intro-page").css("display") == "none") {
                $("#timer-wrap").css("visibility", "visible");
                $(".page-wrap.show .next p").hide();
            }
        })


    };
    var checkans = function () {
        var index = $(".option-each.click").parent().find(".option-each").index($(".option-each.click"));
        switch (index) {
            case 0:
                var anstemp = "A";
                break;
            case 1:
                var anstemp = "B";
                break;
            case 2:
                var anstemp = "C";
                break;
            case 3:
                var anstemp = "D";
                break;
            default:
                var anstemp = ""
        }
        var datatemp = function () {
            this.ans;
        }
        var data1 = new datatemp();
        data1.ans = anstemp;
        $.ajax({
            url: "./php/checkans.php",
            data: data1,
            type: "post",
            async: true,
            success: function (data) {

            }

        })
    };
    var pageswitch = function () {
        $("#timer").removeClass("alertred");
        if (inited == false) {
            if (first == true) {
                $.ajax({	//如果没有存储，从服务器选题
                    url: "./php/choosequestion.php?type=" + category,
                    type: "get",
                    async: false,
                    dataType: "json",
                    success: function (data) {
                        quesid = data.wrap;
                        quescount = quesid.length;
                        if (window.localStorage) {
                            localStorage.quesid2 = quesid;
                        }
                    }
                })
            }
            inited = true;
        }
        else {
            checkans();
        }
        $("#timer-wrap").hide();
        if (time1 != null) {
            clearTimeout(time1);
        }
        $("#timer-wrap").before($("#questiontemplate").html());
        $(".next:last").on("mouseover", function () {
            $("#timer-wrap").css("visibility", "hidden");
            $(".page-wrap.show .next p").show();
        })
        $(".next:last").on("mouseout", function () {
            if ($("#intro-page").css("display") == "none") {
                $("#timer-wrap").css("visibility", "visible");
                $(".page-wrap.show .next p").hide();
            }
        })
        $(".option-each").off();
        $(".option-each").on("click", function () {
            $(this).parent().find(".option-check").show();
            $(".option-each.click").removeClass("click");
            $(this).addClass("click");
            var obj = $(this);
            $(this).parent().find(".option-check").animate({"marginTop": (-165 + 40 * ($(this).parent().find(".option-each").index($(this)))) + "px"}, 100);
        })
        $(".page-wrap.show").animate({"marginLeft": "-2000px"}, 300, function () {

            var obj = $(".page-wrap.show").next();
            $(".page-wrap.show").hide();
            $(".page-wrap.show").removeClass("show");
            obj.addClass("show");
            var pic = new Image();
            if (quesnow >= quescount) {
                localStorage.removeItem("quesid2");
                $.ajax({
                    url: "./php/checkscore.php",
                    type: "get",
                    dataType: "json",
                    async: true,
                    success: function (data) {
                        //console.log(data.score);
                        $(".page-wrap.show .each-page").empty();
                        $(".page-wrap.show .each-page").append($("#score").html());

                        var percent = parseInt((1 - parseInt(data.percent) / parseInt(data.usernum)) * 95);

                        $(".page-wrap .each-page").css("height", "310px");
                        $(".page-wrap .each-page").css("text-align", "center");
                        $(".next").click(function () {
                            window.location.href = "http://stu.fudan.edu.cn";
                        })
                        $(".page-wrap.show").animate({"marginLeft": "-300px"}, 200, function () {
                            $("#score-get").text(data.score);
                            $("#score-percent").text(percent + "%");
                        });

                    }
                })

            }
            else {
                pic.src = "./php/createpic.php?id=" + quesid[quesnow] + "&&count=" + quesnow;
                pic.onload = function () {
                    $(".page-wrap.show .question").append(pic);
                    $("#timer-wrap").show();
                    $("#timer-wrap").css("visibility", "visible");
                    $(".next p").hide();
                    $.ajax({
                        url: "./php/checkinfo.php",
                        type: "get",
                        dataType: "json",
                        async: true,
                        success: function (data) {
                            data = data.wrap;
                            quesnow++;
                            refreshtime();
                            $("#timer").html(data.time);
                            $(".question-page.show .option-each:eq(0)").html(data.ansa);
                            $(".question-page.show .option-each:eq(1)").html(data.ansb);
                            $(".question-page.show .option-each:eq(2)").html(data.ansc);
                            $(".question-page.show .option-each:eq(3)").html(data.ansd);
                            $(".page-wrap.show").animate({"marginLeft": "-300px"}, 200);
                        }
                    })

                }
            }
        });

    }
    var refreshtime = function () {
        $("#timer").removeClass("timer-hide");
        setTimeout(function () {
            $("#timer").addClass("timer-hide");
        }, 900);

        time1 = setTimeout(function () {
            var time = $("#timer").text() - 1;
            if (time < 10) {
                time = "0" + time;
                $("#timer").addClass("alertred");
            }
            $("#timer").text(time);
            if (time >= 0) {
                refreshtime();
            }
            if (time == 0) {

                pageswitch();
            }
        }, 1000);


    }
    init();
    bind();

})