const express = require('express');
const bodyParser = require('body-parser');
const path = require('path');
const session = require('express-session');

const app = express();
const port = 3000;

// 세션 설정
app.use(session({
  secret: 'your-secret-key',
  resave: false,
  saveUninitialized: true,
  cookie: { secure: false } // HTTPS를 사용할 경우 secure: true로 설정
}));

app.use(bodyParser.json());
app.use(express.static(path.join(__dirname, 'public')));

// 사용자 데이터 (비밀번호는 해시화되지 않음)
const users = {
  'airple': '0000' 
};

// 로그인 엔드포인트
app.post('/api/login', (req, res) => {
  const { username, password } = req.body;

  if (users[username] && users[username] === password) {
    // 비밀번호가 일치하는 경우
    req.session.user = username;
    res.json({ success: true, message: 'Login successful' });
  } else {
    // 비밀번호가 일치하지 않는 경우
    res.json({ success: false, message: 'Invalid credentials' });
  }
});

// 세션 확인 미들웨어
function isAuthenticated(req, res, next) {
  if (req.session.user) {
    return next();
  } else {
    res.redirect('/login.html');
  }
}

// 사용자 아이디를 반환하는 엔드포인트
app.get('/api/user', isAuthenticated, (req, res) => {
  res.json({ username: req.session.user });
});

// 지도 페이지 접근 시 세션 확인
app.get('/main', isAuthenticated, (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'main.html'));
});

// 서버 시작
app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});
