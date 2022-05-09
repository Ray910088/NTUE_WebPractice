<!-- 110916009 資二甲 林廷叡 -->
<!-- (1)參考資料:上學期許揚老師的期末作業 也是計算機的實作 網路上遇到什麼問題就查什麼 主要是找語法 沒有特別抄太多程式碼 另外也有詢問之前上過課的學長
     (2)操作說明:正常win10小算盤的操作
                一次只能做兩個運算元的計算 支持加減乘除、負數、小數點、次方、根號、10的次方
                上一次計算的答案會成為下一次運算的第一個數字繼續運算 此時若繼續按數字 將取代上次計算的答案成為新的第一個數字
                注意若按>2個運算元 最剛開始的運算元會被取代
     (3)自評:95 理由:這樣的計算機雖然能做運算 但沒自信自評100 畢竟一次只能兩個數字計算
     (4)參考網路上html計算機的架構並用上學期課程學到的css改了計算機的整體設計 次方、根號、10的次方 除0偵錯 答案可繼續運算 計算完答案再次按下數字取代答案等等
        很多多做的都是根據win10小算盤去寫
     (5)css、次方、根號、10的次方 能力比較差只能做這些 希望老師手下留情
 -->
<%@ page contentType="text/html; charset=Big5" %>
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
   </head>
   <body>
      <!-- 宣告變數 -->
	   <%!
         String answer = "0"; //螢幕顯示
	   	double num1 = 0; //第一個運算元
         double num2 = 0; //第二個運算元
         double lastAns = 0; //之前的計算結果
         int operator = 0; //判斷現在的運算子為何
         int floatHow = 1; //小數點後幾位
         boolean floatUse = false; //是否用小數點
         boolean negative = false; //是否負號
         boolean used = false; //之前的計算過程
      %>
      <!-- 宣告函式 -->
      <%!
         private void displayNum(String formula)
         {
            answer = "0";
            double x = Double.parseDouble(formula);
            if(negative)
               x = -x;
            if(Float.parseFloat(answer) == 0)
               answer = Double.toString(x);
            else
               answer = Double.toString(Double.parseDouble(answer)*10 + x);
         }
         private void displayFloat(String formula)
         {
            double y = Double.parseDouble(formula);
            if(negative)
               y = -y;
            for (int i = 0; i < floatHow; i++)
               y = y*0.1;
            floatHow++;
            answer = Double.toString(Math.round((Double.parseDouble(answer) + y) * 100000000.0) / 100000000.0);
         }
      %>
      <!-- 計算方法 -->
      <%
         if(request.getParameter("no") != null)
         {
            if(used) //紀錄上次答案並歸零
            {
               lastAns = Double.parseDouble(answer); 
               num1 = Double.parseDouble(answer);
               num2 = 0;
               operator = 0;
               floatHow = 1;
               floatUse = false; 
               used = false;
               negative = false;
            }
            
            try
            {
               if(request.getParameter("no").equals("c")) //按c的功能
               {
                  answer = "0";
                  num1 = num2 = 0;
                  operator = 0;
                  floatHow = 1;
                  negative = false;
                  floatUse = false; 
               }
               
               else if(request.getParameter("no").equals("+")) //按+的功能
               {
                  num1 = Double.parseDouble(answer);
                  answer = "0";
                  operator = 1;
                  floatHow = 1;
                  negative = false;
                  floatUse = false;
               }
               else if(request.getParameter("no").equals("-")) //按-的功能，但有兩種情況，一種是減號，一種是負號
               {
                  if(Double.parseDouble(answer) != 0) //減號
                  {
                     num1 = Double.parseDouble(answer);
                     answer = "0";
                     operator = 2;
                     floatHow = 1;
                     negative = false;
                     floatUse = false;    
                  }
                  else if(Double.parseDouble(answer) == 0) //負號
                  {
                     negative = true;
                     answer = Double.toString(StrictMath.signum(-0.0f));
                  }
               }
               else if(request.getParameter("no").equals("*")) //按*的功能
               {
                  num1 = Double.parseDouble(answer);
                  answer = "0";
                  operator = 3;
                  floatHow = 1;
                  negative = false;
                  floatUse = false; 
               }
               else if(request.getParameter("no").equals("/")) //按/的功能
               {
                  num1 = Double.parseDouble(answer);
                  answer = "0";
                  operator = 4;
                  floatHow = 1;
                  negative = false;
                  floatUse = false;
               }
               else if(request.getParameter("no").equals("^x")) //按^x的功能
               {
                  num1 = Double.parseDouble(answer);
                  answer = "0";
                  operator = 5;
                  floatHow = 1;
                  negative = false;
                  floatUse = false; 
               }
               else if(request.getParameter("no").equals("^(1/x)")) //按^(1/x)的功能
               {
                  num1 = Double.parseDouble(answer);
                  answer = "0";
                  operator = 6;
                  floatHow = 1;
                  negative = false;
                  floatUse = false; 
               }
               else if(request.getParameter("no").equals("10^x")) //按10^x的功能
               {
                  num1 = Double.parseDouble(answer);
                  answer = "0";
                  operator = 7;
                  floatHow = 1;
                  negative = false;
                  floatUse = false; 
               }
               
               else if(request.getParameter("no").equals("=")) //按=的功能
               {
                  used = true;
                  num2 = Double.parseDouble(answer);
                  switch(operator){
                     case 1: 
                        answer = Double.toString(Math.round((num1 + num2) * 100000000.0) / 100000000.0); break;
                     case 2: 
                        answer = Double.toString(Math.round((num1 - num2) * 100000000.0) / 100000000.0); break;
                     case 3: 
                        answer = Double.toString(Math.round((num1 * num2) * 100000000.0) / 100000000.0); break;
                     case 4: 
                        if(num2 == 0.0)
                        {
                           answer = "You cannot divide by 0"; 
                           used = false;
                           break;
                        }
                        else
                        {
                           answer = Double.toString(Math.round((num1 / num2) * 100000000.0) / 100000000.0); break;
                        }
                     case 5:
                        answer = Double.toString(Math.round(Math.pow(num1, num2) * 100000000.0) / 100000000.0); break;
                     case 6:
                        if(num2 == 0.0)
                        {
                           answer = "You cannot root by 0"; 
                           used = false;
                           break;
                        }
                        else
                        {
                           answer = Double.toString(Math.round(Math.pow(num1, (1/num2)) * 100000000.0) / 100000000.0); break;
                        }
                     case 7:
                        answer = Double.toString(Math.round((num1 * (Math.pow(10, num2))) * 100000000.0) / 100000000.0); break;
                     default:
                  }
               }
               
               else //按數字跟.的功能
               {
                  if(floatUse)
                  {
                     if(request.getParameter("no").equals("."))
                     {}
                     else 
                        displayFloat(request.getParameter("no"));
                  }
                  else 
                  {
                     if(request.getParameter("no").equals("."))
                        floatUse = true;
                     else 
                        displayNum(request.getParameter("no"));
                  }
               }
            }

            //例外處理
            catch(NumberFormatException error)
            {
               answer = "0";
               num1 = num2 = 0;
               operator = 0;
               floatHow = 1;
               negative = false;
               floatUse = false;
               System.out.println(error);
            }
            catch(ArithmeticException Error)
            {
               answer = "0";
               num1 = num2 = 0;
               operator = 0;
               floatHow = 1;
               negative = false;
               floatUse = false;
               System.out.println(Error);
            }
         }
      %>
      <title>Calculator</title>
      <center>
      <form action="cal-110916009.jsp" method="post" name="Calculator">        
         <table border="15">
            <!--輸出算式-->
            <tr>
               <td style="border:3pt solid #7B7B7B;" align='right' colspan="5">
                  <font class="LA" face="Microsoft JhengHei" size="1">
                     <%
                     if(num1 != 0)
                        out.print(num1 + " "); 
                     if(operator != 0){
                        switch(operator){
                           case 1:out.print("+");break;
                           case 2:out.print("-");break;
                           case 3:out.print("*");break;
                           case 4:out.print("/");break;
                           case 5:out.print("^");break;
                           case 6:out.print("^ 1.0/");break;
                           case 7:out.print("* 10.0^");break;
                           default:
                        }
                     }
                     out.print(" "); 
                     if(num2 != 0)
                     out.println(num2);
                     %>
                  </font>
               </td>
            </tr>
            <tr>
               <td style="border:3pt solid #7B7B7B;" align='right' colspan="5">
                  <font class="LA" face="Microsoft JhengHei" size="1">
                     <%= "Last Answer : " + lastAns %>
                  </font>
               </td>
            </tr>
            <tr>
               <td style="border:3pt solid #7B7B7B;" align='right' colspan="5">
                  <font class="LA" face="Microsoft JhengHei" size="4">
                     <% out.print(answer); %>
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
      </form> 
      </center>
      <br>
   </body>
</html>