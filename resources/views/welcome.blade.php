<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <h1>Calculator App</h1>
    <h2>history Log</h2>
    <!-- alert -->
    <?php
        if($alert){
    ?>
    <div class="alert">
        <?php
            if(Session::has('message')){
        ?>
               <p> Request limit reached. <?php echo Session::get('message') ?></p> 

        <?php
            }
        ?>
    </div>
    <?php
        }
    ?>
    <!-- alert -->
    <form  action="calculateClicked" method="post">
        @csrf

        <div class="form">
            <div>
                <input type="number" name="num1" />
            </div>
            <div class= "dropdown">
                <select name="operation">
                    <option value='+'>+</option>
                    <option value='/'>/</option>
                    <option value='-'>-</option>
                    <option value='x'>x</option>
                </select>
            </div>
            <div>
                <input type="number" name="num2" />
            </div>
            <p>=</p>

            <!-- result -->
            <div class="result"> 
                <?php
                    if(Session::has('result')){
                ?>
                    <p><?php echo Session::get('result') ?></p> 

                <?php
                    }
                ?>
            </div>    
            <!-- result -->

            <div class="submit">
                <input type="submit" value="Calculate" />
            </div>



            <input type="hidden" name="alert" value=<?php echo $alert ?>>
            <input type="hidden" name="time" value=<?php echo $time ?>>


        
        
    </form>

    <!-- table -->
    <table>
        <tr>
            <th>Number1</th>
            <th>Operation</th>
            <th>Number2</th>
            <th>Result</th>
            <th>IP</th>
            <th>Time</th>
        <tr>
            <?php
                foreach($log as $l){ ?>
                        <tr>
                            <td><?php echo $l->num1 ?></td>
                            <td><?php echo $l->operation ?></td>
                            <td><?php echo $l->num2 ?></td>
                            <td><?php echo $l->result ?></td>
                            <td><?php echo $l->ip ?></td>
                            <td><?php echo $l->time ?></td>
                        <tr>
              <?php  }
            ?>
    </table>
    <!-- table -->
    <div>
</body>
</html>
