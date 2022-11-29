<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="Windows-1251">
	<title>Is Valid card</title>
</head>
<body>
<div>
        <form  method="post">
            <input type="text" placeholder="Введите номер карты" maxlength=16 name="name">
            <button type="submit">Проверить</button>
        </form>
    </div>
<?php 
    // $mysqli = new mysqli('localhost', 'root', '', 'numbersCards');
    //     if ($mysqli->connect_error) {
    //         die('Connect Error (' .$mysqli->connect_errno. ') ' . $mysqli->connect_error);
    // }

    // $mysqli->query("DROP TABLE IF EXISTS test");
    // $mysqli->query("CREATE TABLE test(id INT)");
    // $mysqli->query("INSERT INTO test(id) VALUES (1), (2), (3)");
    //$mysqli->query("SELECT * FROM cards");
    
    // $result = $mysqli->query("SELECT * FROM 'cards'");
    // echo $result;
    // echo "Обратный порядок...\n";
    // for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {
    //     $result->data_seek($row_no);
    //     $row = $result->fetch_assoc();
    //     echo " id = " . $row['id'] . "\n";
    // }
    
    // echo "Исходный порядок строк...\n";
    // foreach ($result as $row) {
    //     echo " id = " . $row['id'] . "\n";
    // }
    try {
        $dbh = new PDO('mysql:dbname=numbersCards;host=localhost', 'root', '');
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    $sth = $dbh->prepare("SELECT * FROM `cards` WHERE `id` = ?");
    $sth->execute(array('4'));
    $array = $sth->fetch(PDO::FETCH_ASSOC);
    print_r($array);


	function checkNumberCard($cardNumber){

        $numLength = strlen($cardNumber);           // Длина номера
        $amount = 0;                                // Сумма чисел
        $isSecond = false;                          // Второе число

        echo "Длина номера карты = ".$numLength."<br>";
      
        $patternDaron = "/^([1][4]|[8][1]|[9][9])/";
        $patternMasterCard = "/^[2][2-7][0-9][0-9]/";
        $patternMaestro = "/^[0-1][0-3][0-9][0-9]/";

        if (preg_match($patternMasterCard, $cardNumber)) {
            echo "Это карта MasterCard кредит!<br>";
        } elseif (preg_match($patternMaestro, $cardNumber)) {
            echo "Это карта Maestro кредит!<br>";
        } elseif (preg_match($patternDaron, $cardNumber)) {
            echo "Это карта Даронь кредит!<br>";
        } else {
            echo "Карта с таким номером не поддерживается!<br>";
        } 

        for ($i = 0; $i <= $numLength - 1; $i++) {
 

            $value = $cardNumber[$i];               // Текущее значение

            if ($isSecond == true) {
                $value = $value * 2;
                $amount += floor($value / 10);
                $amount += $value % 10;
            } else {
                $amount += $value;
            }
            $isSecond = !$isSecond;
        }
        return ($amount % 10 == 0);
       

    }

    // function checkPrefixCard($cardNumber){

    //     //$prefix = substr($cardNumber, 0, 2);
    //     $prefix = $cardNumber;

    //     $patternDaron = "/^([1][4]|[8][1]|[9][9])/";
    //     $patternMasterCard = "/^[2][2-7][0-9][0-9]/";
    //     $patternMaestro = "/^[0-1][0-3][0-9][0-9]/";

    //     if (preg_match($patternMasterCard, $prefix)) {
    //         echo "Это карта MasterCard кредит!<br>";
    //     } elseif (preg_match($patternMaestro, $prefix)) {
    //         echo "Это карта Maestro кредит!<br>";
    //     } elseif (preg_match($patternDaron, $prefix)) {
    //         echo "Это карта Даронь кредит!<br>";
    //     } else {
    //         echo "Карта с таким номером не поддерживается!<br>";
    //     }

    //     // $array = array(
    //     //     '14' => "Это карта Даронь кредит!<br>",
    //     //     '81' => "Это карта Даронь кредит!<br>",
    //     //     '99' => "Это карта Даронь кредит!<br>",
    //     //     '22' => "Это карта MasterCard кредит!<br>",
    //     //     '23' => "Это карта MasterCard кредит!<br>",
    //     //     '24' => "Это карта MasterCard кредит!<br>",
    //     //     '25' => "Это карта MasterCard кредит!<br>",
    //     //     '26' => "Это карта MasterCard кредит!<br>",
    //     // );
    //     // $i = 0;
    //     // foreach ($array as $value) {
    //     //     if($value == $prefix){
    //     //         echo $array[$i]." => ".$value;
                
    //     //     }
    //     //     $i++;
    //     // }
    //     // echo "Префикс = ".$prefix."<br>";
    //     // switch ($prefix) {
    //     //     case '14': 
    //     //     case '81': 
    //     //     case '99':
    //     //         printf("Это карта Даронь кредит!<br>");
    //     //         break;
    //     //     case '22': 
    //     //     case '23': 
    //     //     case '27':
    //     //         printf("Это карта MasterCard кредит!<br>");
    //     //         break;

            
    //     //     default:
    //     //         printf("Это карта не поддерживается!<br>");
    //     //         break;
    //     // }
    // }

    $cardNumber = htmlspecialchars($_POST['name']);
    if ($cardNumber == '') {
        echo "Введите номер карты";
    } else { 
        echo "Ваш номер карты: ".$cardNumber."<br>";
        // checkPrefixCard($cardNumber);
        
        if (checkNumberCard($cardNumber)) {
            printf("<h3 color='green'>Корректный номер карты</h3>");
        } else{
            printf("<h3 color='red'>Неверный номер карты</h3>");
        }
    }
    

    

?>

</body>
</html>


