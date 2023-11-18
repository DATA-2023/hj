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
        <a href="#distance_per_time">이동시간 대비 이동거리</a>
    </nav>
    <div class="container">
        <h2>성별과 연령대에 따른 이동시간 대비 이동거리</h2>
        <p>성별과 연령대에 따른 이동시간 대비 이동거리를 보여줍니다.</p>

    <?php
        $host="localhost";
        $user="root";
        $pw="0000";
        $dbname="team17";
        $conn = new mysqli($host, $user, $pw, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
            $sql = "SELECT age_group, gender, ROUND(AVG(moving_distance/(TIMEDIFF(return_datetime,rent_datetime))),4) AS distance_per_time
            FROM rent_history r1 JOIN return_history r2 ON r1.usage_id=r2.usage_id JOIN usage_per_user upu ON r2.usage_id=upu.usage_id JOIN workout_usage wu ON upu.usage_id=wu.usage_id JOIN user u ON upu.user_id=u.user_id
            GROUP BY age_group, gender";

            $result = $conn->query($sql);
            if ($result -> num_rows >0) {
                echo "<br><table border='1'><tr><th>연령대</th><th>성별</th><th>이동시간 대비 이동거리</th</tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" .
                    $row["age_group"]. "</td><td>" . $row["gender"] ."</td><td>" . $row["distance_per_time"] . "</td></tr>";
                }
                echo "</table>";
            } else {
                    echo "<br> 결과가 없습니다.";
            }
            $conn->close();
    ?>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>

