<?php
    $conn = mysqli_connect(
        'localhost', 
        'root',
        '1234',
        'test_db'
    );
    
    echo "<h3>Delete All Comments!</h3>";
    
    if( isset( $_POST['insert'] ) ) {
        $name = trim( $_POST['name'] );
        $comment = trim( $_POST['comment'] );
        $password = trim( $_POST['insert_pw'] );

        if( $name != '' && $comment != '' ) {
            $sql_getNum = "SELECT COUNT( number ) FROM test_table";
            $result = mysqli_query( $conn, $sql_getNum );
            $count = mysqli_fetch_array( $result )[0];
            $count++;

            $sql_insert = "INSERT INTO test_table( number, name, password, comment ) VALUES( '$count', '$name', '$password', '$comment' );";
            $result = mysqli_query( $conn, $sql_insert );
        };
    };

    if( isset( $_POST['delete'] ) ) {
        $del_number = trim( $_POST['del_num'] );
        $password = trim( $_POST['delete_pw'] );
        $sql = "SELECT password FROM test_table WHERE number = '$del_number';";
        $result = mysqli_query( $conn, $sql );
        $conf_pw = mysqli_fetch_array( $result )[0];

        if( $del_number == 1 || $del_number == 2 ) {
            echo "<script>alert('Not Allowed!');</script>";
        } else {
            if( $password == $conf_pw ) {
                $sql_delete = "DELETE FROM test_table WHERE number = '$del_number';";
                $result = mysqli_query( $conn, $sql_delete );
            } else {
                echo "<script>alert('Check Password');</script>";
            };
        };
    };
    
    if( isset( $_POST['reset'] ) ) {
        $reset = trim( $_POST['reset'] );

        $sql_clear = "DELETE FROM test_table;";
        $result = mysqli_query( $conn, $sql_clear );
        $sql_clear = "INSERT INTO test_table ( number, name, password, comment ) VALUES ( 1, 'admin', '6BFCC4026B5F162799A6DC8305C09DB9C1674AC616BD5C7', 'First Comment' );";
        $result = mysqli_query( $conn, $sql_clear );
        $sql_clear = "INSERT INTO test_table ( number, name, password, comment ) VALUES ( 2, 'user1', 'B6D0816AC163047C47A1F426F4F4C6B5B5042C671EABC4FDC7310FD5B183EEF59DC274604', 'This is test message' );";
        $result = mysqli_query( $conn, $sql_clear );
    };

    
    echo "<form name='data' method='post'>";
    echo "<input type='text' name='name' placeholder='name'>";
    echo "<input type='password' name='insert_pw' placeholder='password'>";
    echo "<input type='text' name='comment' placeholder='comment'>";
    echo "<button type='submit' name='insert' value='insert'>submit</button></form>$nbsp$nbsp";
    echo "<form name='clear' method='post'>";
    echo "<input type='text' name='del_num' placeholder='number'>";
    echo "<input type='password' name='delete_pw' placeholder='password'>";
    echo "<button type='submit' name='delete' value='delete'>delete</button>";
    echo "&nbsp&nbsp&nbsp&nbsp<button type='submit' name='reset' value='rst'>reset database</button></form><br>";
    echo "No.&nbsp&nbspName&nbsp&nbsp&nbsp&nbsp&nbspComments";

    $sql = "SELECT * FROM test_table";
    $result = mysqli_query( $conn, $sql );
 
    echo "<form name='field'>";
    while( $row = mysqli_fetch_array( $result ) ) {
        echo $row['number'].'&nbsp&nbsp&nbsp&nbsp&nbsp'.$row['name'].'&nbsp&nbsp&nbsp&nbsp&nbsp'.$row['comment'].'<br>';
    };
    echo "</form>";

    $sql = "SELECT COUNT( number ) FROM test_table;";
    $result = mysqli_query( $conn, $sql );

    if( mysqli_fetch_array( $result )[0] == 0 ) {
        echo "<script>alert('Get hack_this.text from database!');</script>";
    };

    //view source
    echo "<input type='button' onclick=window.open('./source.html') value='source'>";
?>
