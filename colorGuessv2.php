<?php

// TODO:  The color submission and checking.
// Handle cases where color name is like "grey/gray"
  $serverName = "localhost";
  $username = "root";
  $password = "Rohann!!";
  $dbName = "colorListFinal";

  $conn = new mysqli($serverName,$username,$password,$dbName);

  if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
  }
    // echo "success";
    $sql = "SELECT colorName,hex FROM colorListFinal";
    $result = $conn->query($sql);
    $arr = array();

// To create an assoc array like color_name : hexCode
// If you don't do this, you get {Column name : nameOfColor, Col2Name : hexCode}
    while($row = $result->fetch_assoc()){
      $arr[$row['hex']] = $row['colorName'];
    }



    $jsonString = json_encode($arr);
?>
<!--  HTML STARTS HERE -->
<!DOCTYPE html>
<html>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
  <head>
    <meta charset="utf-8">
    <title>Guess The Color!</title>
    <link href="assets/stylesheets/colorGuess.css" rel="stylesheet">
    <link href="assets/stylesheets/font-awesome.css" rel="stylesheet">

  </head>

  <body>
    <div class="container">
      <div class="navBar">
        <a href="index.html">
          <div class="item"> <i class="fa fa-home"></i> </div></a>
        <a href="unlimited.html"><div class="item"> Custom  </div></a>
        <a href="color.html"><div class="item"> Series </div></a>
        <a href="colorGuessv2.php"><div class="item"> Guess </div></a>


      </div>
      <div class="stripe">

        <h1 id="textcon"> Which <span id="col">&lt;color&gt;</span> is this? </h1>
        <button id="hint"> &lt;Hint&gt; </button>
        <button id="reset">&lt;Reset&gt;</button>

      </div>
      <div class="instr" style="height:3%;width:100%;font-family:stellarlight;text-align:center;background:rgba(0,0,0,0.5);font-size:22px;">
        <p> <i>If your answer is right, the division above changes to green and reloads. If your answer is wrong, the division changed to red </i></p>
      </div>

      <div class="game">
        <div class="answer">

        </div>
      </div>
    </div>



    <!--  Javascript Starts here -->
    <script>
    var mahLyf = <?php echo $jsonString ?>;
    var button = document.querySelector('#hint');
    var reset  = document.querySelector('#reset');
    var stripe = document.querySelector('.stripe');
    var len = Object.keys(mahLyf).length;
    var keys = Object.keys(mahLyf);
    var arrayOfColors = [];
    var namedColors = [];
    var correct = "";
    var corChecker = [];
    var hintClicker = 0;
    var idAssigner = 0;

    function pick() {
        correct = "";
        hintClicker = 0;
        corChecker = []
        arrayOfColors = [];
        namedColors = [];
        idAssigner = 0;
        randomNumber = Math.floor(Math.random() * len);
        // console.log(randomNumber);
        arrayOfColors.push(keys[randomNumber]);
        // console.log(arrayOfColors);
        namedColors.push(mahLyf[arrayOfColors[0]]);

    }



    function onLoad() {
        pick();
        document.querySelector('.stripe').style.background = arrayOfColors[0];
        var a = namedColors[0];
        correct = namedColors[0];

        // console.log(a.length);
        // a = a.replace(/ /g,'');
        // console.log(a);


        for (i = 0; i < a.length; i++) {
            if (a[i] != " ") {
                var elem = document.createElement('input');
                elem.setAttribute('type', 'text');
                elem.setAttribute('class', 'inp');
                elem.setAttribute('maxlength', '1');
                elem.setAttribute('id', "char" + idAssigner);
                idAssigner++;
                document.querySelector('.answer').appendChild(elem);
            } else if (a[i] == " ") {
                var elem = document.createElement('div');
                elem.textContent = "";
                elem.setAttribute('style', 'float:left;width:40px;height:1px;');
                document.querySelector(".answer").appendChild(elem);
            }
        }

        //Automatically Move to next text field!!
        var inputC = document.querySelectorAll('.inp');
        for (i = 0; i < inputC.length; i++) {
            inputC[i].addEventListener('keyup', function checker(e) {
                var target = e.srcElement;
                var maxLength = parseInt(target.attributes["maxlength"].value, 10);
                var myLength = target.value.length;
                if (myLength >= maxLength) {
                    var next = target;
                    while (next = next.nextElementSibling) {
                        if (next == null)
                            break;
                        if (next.tagName.toLowerCase() == "input") {
                            next.focus();
                            break;
                        }
                    }
                }
            });
        }
        // button.addEventListener('click', hint(a));
        var subB = document.createElement('button');
        subB.textContent = "SUBMIT";
        subB.setAttribute('onclick',"validate()");
        subB.setAttribute('id','subm');
        document.querySelector('.answer').appendChild(subB);
        return a;

    }

    function hint() {
        a = correct.replace(/\s/g,'');
        // console.log("button clicked");
        randNum = Math.floor(Math.random() * idAssigner);
        console.log("The Number is "+randNum+" and length is "+a.length);
        if(hintClicker > 4){
          alert("Out Of Hints!!");
        }
        else if(corChecker.indexOf(randNum)==-1){
          //Element Not found
          hintClicker++;
          corChecker.push(randNum);

          idVal = document.querySelector('#char' + randNum);
          idVal.value = a[randNum];

        }else{
          hint();

        }

    }

    function validate(){
      var ans = "";
      console.log(correct.length);
      for(i=0; i<idAssigner;i++){
        ans = ans+document.querySelector('#char'+i).value;
      }
      // console.log(ans);
      var c = correct.replace(/\s/g,'');
      console.log(c);
      if(ans === c){
        // alert("Correct Answer!");
        stripe.style.background = "green";
        setTimeout(function(){location.reload();},1500);
        // location.reload();

      }else{
        wrong();
      }
    }

    function wrong(){
      var inputC = document.querySelectorAll('.inp');
      for(i=0;i<inputC.length;i++){
        inputC[i].value = '';
      }
      stripe.style.background = "red";
      setTimeout(recolor,1500);
    }


    function recolor(){
      // console.log("REcoloring");
      console.log(correct)
     // document.querySelector('#textcon').textContent = "CORRECT!!";

      stripe.style.background = arrayOfColors[0];

    }


    window.addEventListener('load', onLoad());
    console.log("The answer is: "+correct);
    button.addEventListener('click',hint);
    reset.addEventListener('click',function(){
      location.reload();
    });


    </script>
  </body>
</html>
