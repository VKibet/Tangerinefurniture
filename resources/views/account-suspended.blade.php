<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance in Progress</title>

    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            
            background: radial-gradient(circle at 50% -20%, #1e293b 0%, #020617 80%);
            color: #f8fafc;

            min-height: 100vh;
            min-height: 100dvh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;
        }

        .maintenance-card {
            width: 100%;
            max-width: 520px;

            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.1);

            padding: 48px 32px;
            text-align: center;
            
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .icon-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            border-radius: 50%;
            
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.05) 100%);
            border: 1px solid rgba(245, 158, 11, 0.2);
            color: #fbbf24;

            display: flex;
            align-items: center;
            justify-content: center;
            
            box-shadow: 0 0 30px rgba(245, 158, 11, 0.15);
        }

        .icon-container svg {
            width: 36px;
            height: 36px;
            animation: spin 8s linear infinite;
        }

        h1 {
            margin: 0 0 16px;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -0.02em;
            color: #ffffff;
        }

        p {
            margin: 0;
            font-size: 16px;
            line-height: 1.6;
            color: #94a3b8;
        }

        .status-container {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            
            font-size: 14px;
            font-weight: 500;
            color: #cbd5e1;
        }

        .pulse-dot {
            position: relative;
            width: 8px;
            height: 8px;
            background-color: #fbbf24;
            border-radius: 50%;
        }

        .pulse-dot::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: #fbbf24;
            border-radius: 50%;
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(3); opacity: 0; }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 360px) {
            body { padding: 16px; }
            .maintenance-card { padding: 32px 20px; }
            h1 { font-size: 24px; }
            p { font-size: 14px; }
            .icon-container { width: 64px; height: 64px; }
            .icon-container svg { width: 28px; height: 28px; }
        }

        @media (min-width: 768px) {
            h1 { font-size: 32px; }
            p { font-size: 17px; }
        }
    </style>
</head>

<body>

    <main class="maintenance-card">

        <div class="icon-container" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg>
        </div>

        <h1>System Maintenance</h1>

        <p>
            Please check back shortly. We sincerely appreciate your patience.
        </p>

        <div class="status-container">
            <span class="pulse-dot"></span>
            Maintenance in progress
        </div>

    </main>

</body>
</html>