<?php
header("Access-Control-Allow-Origin: *"); // 모든 도메인에서 접근 허용
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "ec2-43-203-41-139.ap-northeast-2.compute.amazonaws.com";  // AWS 인스턴스의 퍼블릭 IPv4 주소
$username = "root";  // MySQL 사용자 이름
$password = "Airple123@@@!!";  // MySQL 비밀번호
$dbname = "saemtleDb";  // 데이터베이스 이름
$table = "reservoir";  // 테이블 이름

// MySQL 서버와 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// SQL 쿼리
$sql = "SELECT id, name, manageid, address, x, y, levelmin, levelfull, levelover, 
               incharge, macid, phone, telecom, swversion, regdate, commstatus, 
               comminterval, commlast, waittime, senseadd, leveladd, rsvtype, 
               prange, act1open, keeptime, height, effquan 
        FROM $table";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    // 결과를 배열로 변환
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data = ["message" => "No results found"];
}
$conn->close();

// JSON 형식으로 데이터 반환
echo json_encode($data);
?>