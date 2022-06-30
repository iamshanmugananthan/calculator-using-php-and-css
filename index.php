<?php
error_reporting(E_ERROR | E_PARSE);
$answer = 0;
$question = [];
function getInputAsString($values){
	$o = "";
	foreach ($values as $value){
		$o .= $value;
	}
	return $o;
}
function calculateInput($userInput){
    $arr = [];
    $char = "";
    foreach ($userInput as $num){
        if(is_numeric($num) || $num == "."){
            $char .= $num;
        }else if(!is_numeric($num)){
            if(!empty($char)){
                $arr[] = $char;
                $char = "";
            }
            $arr[] = $num;
        }
    }
    if(!empty($char)){
        $arr[] = $char;
    }
    $now = 0;
    $action = null;
    for($i=0; $i<= count($arr)-1; $i++){
        if(is_numeric($arr[$i])){
            if($action){
                if($action == "+"){
                    $now = $now + $arr[$i];
                }
                if($action == "%"){
                    $now = $now % $arr[$i];
				}
                if($action == "-"){
                    $now = $now - $arr[$i];
                }
                if($action == "/"){
                    $now = $now / $arr[$i];
				}
                if($action == "x"){
                    $now = $now * $arr[$i];
                }

                $action = null;
            }else{
                if($now == 0){
                    $now = $arr[$i];
                }
            }
        }else{
            $action = $arr[$i];
        }
    }
    return $now;
}
$rep="";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['input'])){
        $question = json_decode($_POST['input']);
	}
    if(isset($_POST)){	
        foreach ($_POST as $key=>$value){
			if($key == 'squareroot'){
				$answer = sqrt(floatval(getInputAsString($question)));
				$question = [];
				$question[] = $answer;
			 }
			 elseif($key == 'square'){
				$answer = pow(floatval(getInputAsString($question)),2);
				$question = [];
				$question[] = $answer;
			 }
            elseif($key == 'equal'){
               $answer = calculateInput($question);
               $question = [];
               $question[] = $answer;
            }elseif($key == "c"){
                $question = [];
                $answer = 0;
            }elseif($key == "back"){
                $lastPointer = count($question) -1;
                if(is_numeric($question[$lastPointer])){
                    array_pop($question);
                }
            }elseif($key != 'input'){
                $question[] = $value;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title>AK Calculator</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body style="background-color:yellow">
	<div class="main">
<div class="cal-main-box">
            <div class="cal-upper-box">
    <form method="post" id="form">
        <center>
	<input class="form-control"; style="padding: 3px;  margin: 0; min-height: 20px;" value="<?php echo getInputAsString($question);?>">
    <input class="form-control" type="hidden" name="input" value='<?php echo json_encode($question);?>'/>
    <input class="form-control" type="text" value="<?php echo $answer;?>"/>
</center>
    <table style="width:100%;">
        <tr>
            <td><input class="delete" type="submit" name="c" value="C"/>
            <button type="submit" class="percentage"name="modulus" value="%">&#37;</button>
			<button type="submit" class="divide" name="divide" value="/">&#247;</button>
			<input class="clean" type="submit" name="squareroot" value="√"/></td>
        </tr>
        <tr>
            <td><input class="seven" type="submit" name="7" value="7"/>
            <input class="eight" type="submit" name="8" value="8"/>
			<input class="nine" type="submit" name="9" value="9"/>
			<input class="null" type="submit" name="square" value="^"/></td>
        </tr>
        <tr>
            <td><input class="four" type="submit" name="4" value="4"/>
            <input class="five" type="submit" name="5" value="5"/>
            <input class="six" type="submit" name="6" value="6"/>        
            <input class="multiply" type="submit" name="multiply" value="x"/></td>
        </tr>
        <tr>
            <input class="one" type="submit" name="1" value="1"/>
            <input class="two" type="submit" name="2" value="2"/>
            <input class="three" type="submit" name="3" value="3"/>
			<input class="minus" type="submit" name="minus" value="-"/></td>
        </tr>
        <tr>
            <td><input class="zero" type="submit" name="zero" value="0"/>
            <input class="point" type="submit" name="." value="."/>
			<input class="equal" type="submit" name="equal" value="="/>
			<input class="add" type="submit" name="add" value="+"/></td>
        </tr>
    </table>
    </form>
</div>
</div>
</div>
</body>
</html>