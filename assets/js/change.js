

function changeColor(){
    var r =  document.getElementById('r').value
    var g =  document.getElementById('g').value
    var b =  document.getElementById('b').value
    var colour = "rgb("+r+", "+g+", "+b+")"
    console.log(colour)
    document.getElementById('container').style.background=colour;


}
