<!DOCTYPE html>
<html>
<head>
    <title>서울시 공공자전거 이용정보 보고서</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        header {
            background-color: #0078d4;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        h1 {
            font-size: 24px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            font-size: 20px;
            margin-top: 20px;
        }
        p {
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #0078d4;
            color: #fff;
        }
        /* 네비게이션바 스타일 */
        nav {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 10px;
        }
    </style>
     <meta charset="UTF-8">
</head>
<body>
    <header>
        <h1>서울시 공공자전거 이용정보 보고서</h1>
    </header>
    <nav>
        <!-- 자기 파트 웹페이지 만들어서 제목 추하 html파일 연결하기-->
        <a href="#update_returndate">자전거 복구 날짜 변경</a>
    </nav>
    <div class="container">
        <h2>고장난 자전거 복구 날짜 변경</h2>
        <p>고장난 자전거의 접수 날짜를 입력하면 해당 날짜에 접수된 자전거의 복구 날짜를 일주일 미룹니다.</p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
   날짜를 선택하세요: <input type="date" name="user_input">
  <input type="submit">
</form>
    <?php
        $host="localhost";
        $user="root";
        $pw="0000";
        $dbname="team17";
        $conn = new mysqli($host, $user, $pw, $dbname);
        $user_input = isset($_POST['user_input']) ? $_POST['user_input'] : '';
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->begin_transaction();
        try{
            $sql = "UPDATE bike_fix bf
            SET return_datetime=ADDDATE(return_datetime, INTERVAL 7 DAY)
            WHERE bf.complaint_id = (SELECT complaint_id
                                FROM bike_breakdown as bb
                                        WHERE bb.datetime=?)";

            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("s",$user_input);
            $stmt -> execute();
            $result = $stmt -> get_result();
            if ($result) {
                
            }
            $stmt->close();
            $conn->commit();
            echo 'update가 정상적으로 처리되었습니다.';
        }
        catch (Exception $e) {
            // 에러 발생하면 rollback
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
        finally{
            $conn->close();
        }
    ?>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>

