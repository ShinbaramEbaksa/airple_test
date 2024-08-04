<?php
header('Content-Type: application/json'); // JSON 응답 헤더 설정

$servername = "ec2-43-203-41-139.ap-northeast-2.compute.amazonaws.com"; // AWS RDS 엔드포인트
$username = "root"; // 데이터베이스 사용자 이름
$password = "Airple123@@@!!"; // 데이터베이스 비밀번호
$dbname = "saemtleDb"; // 데이터베이스 이름
$table = "reservoir"; // 테이블 이름

// MySQL 서버와 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 데이터 조회 쿼리
$sql = "SELECT id, name, manageid, address, x, y, levelmin, levelfull, levelover, incharge, macid, phone, telecom, swversion, regdate, commstatus, comminterval, commlast, waittime, senseadd, leveladd, rsvtype, prange, act1open, keeptime, height, effquan FROM $table";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    // 각 행의 데이터를 배열에 추가
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    // 결과가 없는 경우
    $data['message'] = '0 results';
}
$conn->close();

// JSON 형식으로 데이터 반환
echo json_encode($data);
?>
