
// reset ให้เป็นรูปภาพเก่า
$('#resetimage').on('click', function () {
    var reimage = $(this).attr("reimage");
    // console.log(reimage);
    document.getElementById("myshowImage").src = '../images/' + reimage + '';
});
// reset รูปภาพให้เป็นค่าเริ่มต้น
$('#myreset').on('click', function () {
    // document.getElementById("myshowImage").src = '';
    document.getElementById("myshowImage").removeAttribute("src");
});

// แสดงภาพตัวอย่าง
$('#myfilename').click(function () {
    var myfilename = document.getElementById('myfilename');
    myfilename.onchange = function () {
        var files = myfilename.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(files);
        reader.onload = function () {
            var result = reader.result;
            document.getElementById('myshowImage').src = result;
        };
    };
});

// แสดงภาพตัวอย่าง
$('#imge_qt').click(function () {
    var imge_qt = document.getElementById('imge_qt');
    imge_qt.onchange = function () {
        var files = imge_qt.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(files);
        reader.onload = function () {
            var result = reader.result;
            document.getElementById('showimge_qt').src = result;
        };
    };
});

// แสดงภาพตัวอย่าง
$('#imge_c1').click(function () {
    var imge_c1 = document.getElementById('imge_c1');
    imge_c1.onchange = function () {
        var files = imge_c1.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(files);
        reader.onload = function () {
            var result = reader.result;
            document.getElementById('showimge_c1').src = result;
        };
    };
});

// แสดงภาพตัวอย่าง
$('#imge_c2').click(function () {
    var imge_c2 = document.getElementById('imge_c2');
    imge_c2.onchange = function () {
        var files = imge_c2.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(files);
        reader.onload = function () {
            var result = reader.result;
            document.getElementById('showimge_c2').src = result;
        };
    };
});

// แสดงภาพตัวอย่าง
$('#imge_c3').click(function () {
    var imge_c3 = document.getElementById('imge_c3');
    imge_c3.onchange = function () {
        var files = imge_c3.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(files);
        reader.onload = function () {
            var result = reader.result;
            document.getElementById('showimge_c3').src = result;
        };
    };
});

// แสดงภาพตัวอย่าง
$('#imge_c4').click(function () {
    var imge_c4 = document.getElementById('imge_c4');
    imge_c4.onchange = function () {
        var files = imge_c4.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(files);
        reader.onload = function () {
            var result = reader.result;
            document.getElementById('showimge_c4').src = result;
        };
    };
});

// reset รูปภาพให้เป็นค่าเริ่มต้น
$('#resetimge').on('click', function () {
    document.getElementById("showimge_qt").removeAttribute("src");
    document.getElementById("showimge_c1").removeAttribute("src");
    document.getElementById("showimge_c2").removeAttribute("src");
    document.getElementById("showimge_c3").removeAttribute("src");
    document.getElementById("showimge_c4").removeAttribute("src");
});

// reset ให้เป็นรูปภาพเก่า
$('#reset_imge').on('click', function () {
    var e_qt_im = $(this).attr("e_qt_im");
    var e_c1_im = $(this).attr("e_c1_im");
    var e_c2_im = $(this).attr("e_c2_im");
    var e_c3_im = $(this).attr("e_c3_im");
    var e_c4_im = $(this).attr("e_c4_im");
    if (e_qt_im == "") {
        document.getElementById("showimge_qt").src = '';
    } else {
        document.getElementById("showimge_qt").src = '../images/' + e_qt_im + '';
    }
    if (e_c1_im == "") {
        document.getElementById("showimge_c1").src = '';
    } else {
        document.getElementById("showimge_c1").src = '../images/' + e_c1_im + '';
    }
    if (e_c2_im == "") {
        document.getElementById("showimge_c2").src = '';
    } else {
        document.getElementById("showimge_c2").src = '../images/' + e_c2_im + '';
    }
    if (e_c3_im == "") {
        document.getElementById("showimge_c3").src = '';
    } else {
        document.getElementById("showimge_c3").src = '../images/' + e_c3_im + '';
    }
    if (e_c4_im == "") {
        document.getElementById("showimge_c4").src = '';
    } else {
        document.getElementById("showimge_c4").src = '../images/' + e_c4_im + '';
    }
});