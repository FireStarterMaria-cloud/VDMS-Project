<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Offline — Velora VMS</title>
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/assets/vendor/css/core.css" />
  <link rel="stylesheet" href="/assets/css/demo.css" />
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: #f5f5f9;
      font-family: 'Public Sans', sans-serif;
    }
    .offline-box {
      text-align: center;
      padding: 60px 40px;
      background: white;
      border-radius: 20px;
      box-shadow: 0 8px 40px rgba(0,0,0,0.08);
      max-width: 440px;
    }
    .offline-icon {
      width: 80px;
      height: 80px;
      background: rgba(105,108,255,0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 24px;
    }
    .offline-icon i { font-size: 36px; color: #696cff; }
    h2 { color: #2b2c40; font-size: 24px; font-weight: 700; margin-bottom: 12px; }
    p { color: #566a7f; font-size: 15px; line-height: 1.7; margin-bottom: 24px; }
    .status-dot {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255,171,0,0.1);
      color: #ffab00;
      padding: 8px 20px;
      border-radius: 50px;
      font-size: 13px;
      font-weight: 500;
    }
    .dot {
      width: 8px; height: 8px;
      background: #ffab00;
      border-radius: 50%;
      animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.3; }
    }
    .retry-btn {
      display: inline-block;
      margin-top: 20px;
      background: #696cff;
      color: white;
      padding: 12px 28px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      cursor: pointer;
      border: none;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="offline-box">
    <div class="offline-icon">
      <i class='bx bx-wifi-off'></i>
    </div>
    <h2>You're Offline</h2>
    <p>
      No internet connection detected. Don't worry —
      Velora VMS has saved your recent data locally.
      Everything will sync automatically when you reconnect.
    </p>
    <div class="status-dot">
      <div class="dot"></div>
      Waiting for connection...
    </div>
    <br>
    <button class="retry-btn" onclick="window.location.reload()">
      <i class='bx bx-refresh'></i> Try Again
    </button>
  </div>

  <script>
    // Auto redirect when back online
    window.addEventListener('online', () => {
      window.location.href = '/dashboard';
    });
  </script>
</body>
</html>