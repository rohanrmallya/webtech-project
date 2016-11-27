var gameArea = document.querySelector('.game');
var form = document.querySelector('#form');
var stripe = document.querySelector('.stripe');
var correctness =1;
var span = document.querySelector('#click');
var side = document.querySelector('#sideNav2');
var bgcolor = "rgba(0,0,0,0.2)"

// For the top open and close of the form
span.addEventListener('click',function(){
  side.classList.toggle('close');

});

function gen() {
    var val = document.querySelector('#inp').value;
    stripe.style.background = bgcolor;
    generate(val);
}


function generate(num) {
    gameArea.innerHTML = '';
    for (i = 0; i < num; i++) {
        var division = document.createElement('div');
        division.setAttribute('class', 'square');
        gameArea.appendChild(division);
    }
    a = color();
    correctness = a[correct(a)];
    console.log(correctness);
    for (i = 0; i < a.length; i++) {
        if (a[i] != correctness) {
            a[i].addEventListener('click', function() {
                this.style.background = bgcolor;
            })
        }
    }
    correctness.addEventListener("click", function() {
        stripe.style.background = correctness.style.background;
        for (i = 0; i < a.length; i++) {
            a[i].style.background = correctness.style.background;
        }

    });
    document.querySelector('#colorid').innerHTML = correctness.style.background;



}

function reset(count) {

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
