var b = document.querySelector('.game');
var strip = document.querySelector('.stripe');
// var amaze = document.querySelector('#amaze');
var correctness = 1;
var isSuc = 2;

body.style.background = "#F57F17";
b.addEventListener("load", generate(2));

function generate(num) {
    b.innerHTML = '';
    strip.style.background = "#FBC02D";
    // amaze.style.background = "#FDC02D";
    for (i = 0; i < num; i++) {
        var division = document.createElement('div');
        division.setAttribute('class', 'square');
        b.appendChild(division);
    }
    a = color();
    correctness = a[correct(a)];
    console.log(correctness);
    for (i = 0; i < a.length; i++) {
        if (a[i] != correctness) {
            a[i].addEventListener('click', function() {
                this.style.background = body.style.background;
            })
        }
    }
    correctness.addEventListener("click", function() {
        strip.style.background = correctness.style.background;
        // amaze.style.background = correctness.style.background;

        for (i = 0; i < a.length; i++) {
            a[i].style.background = correctness.style.background;
        }
        setTimeout(function() {
            if (isSuc < 9) {
                generate(++isSuc);
            }

        },2500)

    });
    document.querySelector('#colorid').innerHTML = correctness.style.background;



}


function genColor(num) {
    var arr = []
    for (i = 0; i < num; i++) {
        var r = Math.ceil(Math.random() * 255);
        var g = Math.ceil(Math.random() * 255);
        var b = Math.ceil(Math.random() * 255);
        var str = "rgb(" + r + ", " + g + ", " + b + ")";
        arr.push(str);
    }
    return arr;

}

function color() {

    var squareCollection = document.querySelectorAll('.square');
    var arrayOfColors = genColor(squareCollection.length);
    for (i = 0; i < squareCollection.length; i++) {
        squareCollection[i].style.background = arrayOfColors[i];
    }
    return squareCollection;
}

function correct(arr) {
    var corr = Math.floor(Math.random() * arr.length);
    return corr;
}

function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
