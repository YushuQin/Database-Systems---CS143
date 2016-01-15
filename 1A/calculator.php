<html>
<head>
    <title>Calculator</title>
    <style id="style-1-cropbar-clipper">
        {
            top: 18px !important;
            left: 50% !important;
            margin-left: -100px !important;
            width: 200px !important;
            border: 2px rgba(255,255,255,.38) solid !important;
            border-radius: 4px !important;
        }

        .en-markup-crop-options div div:first-of-type {
            margin-left: 0px !important;
        }
    </style>
    <style type="text/css"></style>
</head>
<body>

<h1>Calculator</h1>
Type an expression in the following box (e.g., 10.5+20*3/25).
<p>
</p><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
    <input type="text" name="expr">
    <input type="submit" value="Calculate">
</form>
<p></p>

<ul>
    <li>Only numbers and +,-,* and / operators are allowed in the expression.
    </li><li>The evaluation follows the standard operator precedence.
    </li><li>The calculator does not support parentheses.
    </li><li>The calculator handles invalid input "gracefully". It does not output PHP error messages.
    </li></ul>

Here are some(but not limit to) reasonable test cases:
<ol>
    <li> A basic arithmetic operation:  3+4*5=23 </li>
    <li> An expression with floating point or negative sign : -3.2+2*4-1/3 = 4.46666666667, 3*-2.1*2 = -12.6 </li>
    <li> Some typos inside operation (e.g. alphabetic letter): Invalid input expression 2d4+1 </li>
</ol>

<?php

function exprBlankIsCorrect(&$unexaminedExpr){
    if(preg_match('/[0-9.] +[0-9.]|[\+\-\*\/] *\- +\d/',$unexaminedExpr)){
//        echo 1;
        return FALSE;
    }else{
        return TRUE;
    }
}

function exprCharIsCorrect($unexaminedExpr){
    if(preg_match('/[^0-9 \+\-\*\/\.]/',$unexaminedExpr)){
//        echo 2;
        return FALSE;
    }else{
        return TRUE;
    }
}

function exprOperatorIsCorrect($unexaminedExpr){
    if(preg_match('/[\+\-\*\/] *[\+\-\*\/] *[\+\-\*\/]|[\+\-\*\/] *[\+\*\/]/',$unexaminedExpr)){
//        echo 3;
        return FALSE;
    }else{
        return TRUE;
    }
}

function exprNumberIsCorrect($unexaminedExpr){
    if(preg_match('/[ \+\-\*\/]\.|[ \+\-\*\/]0\d|\.\d*\.|\.[ \+\-\*\/]/',$unexaminedExpr)){
//        echo 4;
        return FALSE;
    }else{
        return TRUE;
    }
}

function exprEndpointIsCorrect($unexaminedExpr){
    if(preg_match('/^ *[\+\*\/\.]|^ *0\d|[\+\-\*\/\.] *$|^ *\-\D/',$unexaminedExpr)){
//        echo 5;
        return FALSE;
    }else{
        return TRUE;
    }
}

function exprIsCorrect($unexaminedExpr){
    if(exprBlankIsCorrect($unexaminedExpr) && exprCharIsCorrect($unexaminedExpr) && exprOperatorIsCorrect($unexaminedExpr) && exprNumberIsCorrect($unexaminedExpr) && exprEndpointIsCorrect($unexaminedExpr)){
        return TRUE;
    }else{
        return FALSE;
    };
}

function doubleMinusToPlus($unprocessedExpr){
    if(preg_match('/\- *\-/',$unprocessedExpr)){
        return preg_replace('/\- *\-/','+',$unprocessedExpr);
    }else{
        return $unprocessedExpr;
    }
}

function divisionIsZero($unexaminedExpr){
    if(preg_match('/\/ *0[^\.]|\/ *0 *$/',$unexaminedExpr)){
        return TRUE;
    }else{
        return FALSE;
    }
}

function outputCalcuResult($exprToOutput,$exprToCalcu){
    echo '<h2>Result</h2>';
    echo '<p>';
    echo $exprToOutput.'=';
    eval("echo $exprToCalcu;");
    echo '</p>';
}

if(isset($_GET['expr']) && $_GET["expr"]){
    $incomeExpr = $_GET["expr"].'';
    if(exprIsCorrect($incomeExpr)){
//        echo $incomeExpr;
        $noneDoubleMinusExpr = doubleMinusToPlus($incomeExpr);
        if(divisionIsZero($noneDoubleMinusExpr)){
            echo 'Division by zero error!';
        }else{
            outputCalcuResult($incomeExpr,$noneDoubleMinusExpr);
        }
    }else{
        echo 'Invalid Expression!';
    }
}

?>

</body></html>
