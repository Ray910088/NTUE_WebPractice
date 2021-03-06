<!DOCTYPE html>
<!-- 110916009 資二甲 林廷叡 -->
<!-- (1)參考資料:上學期許揚老師的期末作業 也是計算機的實作 網路上遇到什麼問題就查什麼 主要是找語法 沒有特別抄太多程式碼 另外也有詢問之前上過課的學長
     (2)操作說明:正常win10小算盤的操作
                一次只能做兩個運算元的計算 支持加減乘除、負數、小數點、次方、根號、10的次方
                上一次計算的答案會成為下一次運算的第一個數字繼續運算 此時若繼續按數字 將接續上次計算的答案成為新的第一個數字
                注意若按>2個運算元 最剛開始的運算元會被取代
     (3)自評:100 理由:我覺得相當還原win10小算盤了 希望老師能接受
     (4)參考網路上html計算機的架構並用上學期課程學到的css改了計算機的整體設計 次方、根號、10的次方 除0偵錯 答案可繼續運算 計算完答案再次按下數字取代答案等等
        很多多做的都是根據win10小算盤去寫
     (5)css、次方、根號、10的次方 能力比較差只能做這些 希望老師手下留情
 -->
<html>
    <head>
        <!-- 上學期多媒體概論課有上css用法 剛好用來計算機介面設計 -->
        <style>
         body
         {
            background-color:	#E0E0E0;
         }

         table
         {
            background-color: #ADADAD;
            height:50%;
            width:20%;
         }

         .LA
         {
            font-weight:bold;
         }

         .a
         {
            background-color:black;
            color: white;
            height:100%;
            width:100%;
            font-size:25px;
            font-family:Microsoft JhengHei;
         }

         .b
         {
            background-color:black;
            color: white;
            height:100%;
            width:100%;
            font-size:15px;
            font-family:Microsoft JhengHei;
         }

         .c
         {
            background-color:black;
            color: white;
            height:100%;
            width:100%;
            font-size:12px;
            font-family:Microsoft JhengHei;
         }
       </style>
       <meta charset="UTF-8">
       <title>cal-110916009</title>
    </head>
    <body>
        <!-- 宣告變數 -->
        <?php
            $answer = "0"; //螢幕顯示
	     $num1 = 0.0; //第一個運算元
            $num2 = 0.0; //第二個運算元
            $lastAns = 0.0; //之前的計算結果
            $operator = 0; //判斷現在的運算子為何
            $floatHow = 1; //小數點後幾位
            $floatUse = false; //是否用小數點
            $negative = false; //是否負號
            $used = false; //之前的計算過程
        ?>
        
        <!-- 宣告函式 -->
        <?php
            function displayNum($formula)
            {
               global $answer;
               global $negative;
               $x = (double)$formula;
               if($negative){
                  $x = (-1)*$x;
               }
               if((float)$answer == 0){
                  $answer = (string)$x;
               }
               else{
                  $answer = (string)((double)$answer*10 + $x);
               }
            }
            function displayFloat($formula)
            {
               global $negative;
               global $floatHow;
               global $answer;
               $y = (double)$formula;
               if ($negative) {
                    $y = (-1)*$y;
                }
               for ($i = 0; $i < $floatHow; $i++) {
                    $y = $y * 0.1;
               }
               $floatHow++;
               $answer = (string)round(((double)$answer + $y) ,8);
            }
       ?>
        
        <!-- 初始化 -->
        <?php
        if(isset($_POST["reAnswer"])){
            $answer = $_POST["reAnswer"];
        }
        if(isset($_POST["reNum1"])){
            $num1 = $_POST["reNum1"];
        }
        if(isset($_POST["reNum2"])){
            $num2 = $_POST["reNum2"];
        }
        if(isset($_POST["reLastAns"])){
            $lastAns = $_POST["reLastAns"];
        }
        if(isset($_POST["reOperator"])){
            $operator = $_POST["reOperator"];
        }
        if(isset($_POST["reFloatUse"])){
            $floatUse = $_POST["reFloatUse"];
        }
        if(isset($_POST["reNegative"])){
            $negative = $_POST["reNegative"];
        }
        if(isset($_POST["reUsed"])){
            $used = $_POST["reUsed"];
        }
        ?>
        
        <!-- 計算方法 -->
        <?php
        if($used) //紀錄上次答案並歸零
        {
            $lastAns = (double)$answer;
            $num1 = (double)$answer;
            $num2 = 0.0;
            $operator = 0;
            $floatHow = 1;
            $floatUse = false;
            $used = false;
            $negative = false;
        }

        try
        {
            if(isset($_POST["no"]))
            {
                $Press = $_POST["no"];
                if($Press == "c") //按c的功能
                {
                    $answer = "0";
                    $num1 = $num2 = 0.0;
                    $operator = 0;
                    $floatHow = 1;
                    $negative = false;
                    $floatUse = false;
                }

                else if($Press == "+") //按+的功能
                {
                    $num1 = (double)$answer;
                    $answer = "0";
                    $operator = 1;
                    $floatHow = 1;
                    $negative = false;
                    $floatUse = false;
                }
                else if($Press == "-") //按-的功能，但有兩種情況，一種是減號，一種是負號
                {
                    if((double)$answer != 0) //減號
                    {
                        $num1 = (double)$answer;
                        $answer = "0";
                        $operator = 2;
                        $floatHow = 1;
                        $negative = false;
                        $floatUse = false;
                    }
                    else if((double)$answer == 0) //負號
                    {
                        $negative = true;
                        $answer = "-";
                    }
                }
                else if($Press == "*") //按*的功能
                {
                    $num1 = (double)$answer;
                    $answer = "0";
                    $operator = 3;
                    $floatHow = 1;
                    $negative = false;
                    $floatUse = false;
                }
                else if($Press == "/") //按/的功能
                {
                    $num1 = (double)$answer;
                    $answer = "0";
                    $operator = 4;
                    $floatHow = 1;
                    $negative = false;
                    $floatUse = false;
                }
                else if($Press == "^x") //按^x的功能
                {
                    $num1 = (double)$answer;
                    $answer = "0";
                    $operator = 5;
                    $floatHow = 1;
                    $negative = false;
                    $floatUse = false;
                }
                else if($Press == "^(1/x)") //按^(1/x)的功能
                {
                    $num1 = (double)$answer;
                    $answer = "0";
                    $operator = 6;
                    $floatHow = 1;
                    $negative = false;
                    $floatUse = false;
                }
                else if($Press == "10^x") //按10^x的功能
                {
                    $num1 = (double)$answer;
                    $answer = "0";
                    $operator = 7;
                    $floatHow = 1;
                    $negative = false;
                    $floatUse = false;
                }

                else if($Press == "=") //按=的功能
                {
                    $used = true;
                    $num2 = (double)$answer;
                    switch($operator){
                        case 1:
                        $answer = (string)round(($num1 + $num2) , 8 );
                        break;
                        case 2:
                        $answer = (string)round(($num1 - $num2) , 8 );
                        break;
                        case 3:
                        $answer = (string)round(($num1 * $num2) , 8 );
                        break;
                        case 4:
                        if($num2 == 0.0)
                        {
                            $answer = "You cannot divide by 0";
                            $used = false;
                            break;
                        }
                        else
                        {
                            $answer = (string)round(($num1 / $num2) , 8 );
                            break;
                        }
                        case 5:
                        $answer = (string)round(pow($num1, $num2) , 8 );
                        break;
                        case 6:
                        if($num2 == 0.0)
                        {
                            $answer = "You cannot root by 0";
                            $used = false;
                            break;
                        }
                        else
                        {
                            $answer = (string)round(pow($num1, (1/$num2)) , 8 );
                            break;
                        }
                        case 7:
                            $answer = (string)round($num1 * pow(10, $num2) , 8 );
                            break;
                        default:
                    }
                }

                else //按數字跟.的功能
                {
                    if($floatUse)
                    {
                        if($Press == ".")
                        {}
                        else{
                            displayFloat($Press);
                        }
                    }
                    else
                    {
                        if($Press == "."){
                            $floatUse = true;
                        }
                        else{
                            displayNum($Press);
                       }
                    }
                }
            }
        }

        //例外處理
        catch(NumberFormatException $error)
        {
            $answer = "0";
            $num1 = $num2 = 0.0;
            $operator = 0;
            $floatHow = 1;
            $negative = false;
            $floatUse = false;
            $Show = $error->getMessage();
        } 
        catch(ArithmeticException $Error)
        {
            $answer = "0";
            $num1 = $num2 = 0.0;
            $operator = 0;
            $floatHow = 1;
            $negative = false;
            $floatUse = false;
            $Show = $Error->getMessage();
        }
        ?>
        <center>
        <form action="cal-110916009.php" method="post" name="Calculator">        
           <table border="15">
              <!--輸出算式-->
              <tr>
                 <td style="border:3pt solid #7B7B7B;" align='right' colspan="5">
                    <font class="LA" face="Microsoft JhengHei" size="1">
                       <?php
                       if($num1 != 0){
                          echo $num1 . " ";
                       }
                       if($operator != 0){
                          switch($operator){
                             case 1: echo "+";break;
                             case 2: echo "-";break;
                             case 3: echo "*";break;
                             case 4: echo "/";break;
                             case 5: echo "^";break;
                             case 6: echo "^ 1.0/";break;
                             case 7: echo "* 10.0^";break;
                             default:
                          }
                       }
                       echo " "; 
                       if($num2 != 0){
                        echo $num2;
                       }
                       ?>
                    </font>
                 </td>
              </tr>
              <tr>
                 <td style="border:3pt solid #7B7B7B;" align='right' colspan="5">
                    <font class="LA" face="Microsoft JhengHei" size="1">
                       <?php echo "Last Answer : " . $lastAns ?>
                    </font>
                 </td>
              </tr>
              <tr>
                 <td style="border:3pt solid #7B7B7B;" align='right' colspan="5">
                    <font class="LA" face="Microsoft JhengHei" size="4">
                       <?php echo $answer; ?>
                    </font>
                 </td>
              </tr>
              <!--計算機螢幕按鍵設計-->
              <tr>
                 <td><input type="submit" class="a" name="no" value="1"/> </td>
                 <td><input type="submit" class="a" name="no" value="2"/> </td>
                 <td><input type="submit" class="a" name="no" value="3"/> </td>
                 <td><input type="submit" class="a" name="no" value="/"/> </td>
                 <td><input type="submit" class="a" name="no" value="c"/> </td>
              </tr>
              <tr>
                 <td><input type="submit" class="a" name="no" value="4"/> </td>
                 <td><input type="submit" class="a" name="no" value="5"/> </td>
                 <td><input type="submit" class="a" name="no" value="6"/> </td>
                 <td><input type="submit" class="a" name="no" value="-"/> </td>
                 <td><input type="submit" class="b" name="no" value="^x"/> </td>
              </tr>
              <tr>
                 <td><input type="submit" class="a" name="no" value="7"/> </td>
                 <td><input type="submit" class="a" name="no" value="8"/> </td>
                 <td><input type="submit" class="a" name="no" value="9"/> </td>
                 <td><input type="submit" class="a" name="no" value="+"/> </td>
                 <td><input type="submit" class="c" name="no" value="^(1/x)"/> </td>
              </tr>
              <tr>
                 <td><input type="submit" class="a" name="no" value="."/> </td>
                 <td><input type="submit" class="a" name="no" value="0"/> </td>
                 <td><input type="submit" class="a" name="no" value="="/> </td>
                 <td><input type="submit" class="a" name="no" value="*"/> </td>
                 <td><input type="submit" class="c" name="no" value="10^x"/> </td>
              </tr>
           </table>
           <!-- 將執行結果回傳 -->
           <input type="hidden" name="reAnswer" value="<?php echo $answer ?>">
           <input type="hidden" name="reNum1" value="<?php echo $num1 ?>">
           <input type="hidden" name="reNum2" value="<?php echo $num2 ?>">
           <input type="hidden" name="reLastAns" value="<?php echo $lastAns ?>">
           <input type="hidden" name="reOperator" value="<?php echo $operator ?>">
           <input type="hidden" name="reFloatUse" value="<?php echo $floatUse ?>">
           <input type="hidden" name="reNegative" value="<?php echo $negative ?>">
           <input type="hidden" name="reUsed" value="<?php echo $used ?>">
           <input type="hidden" name="reFloatHow" value="<?php echo $floatHow ?>">
        </form> 
        </center>
        <br>
    </body>
</html>
