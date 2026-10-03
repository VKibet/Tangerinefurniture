<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Account Suspended</title>

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Helvetica,
                Arial,
                sans-serif;

            background: #f5f7fa;
            color: #1f2937;

            min-height: 100vh;
            min-height: 100dvh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;
        }

        .suspension-card {
            width: 100%;
            max-width: 480px;

            background: #ffffff;

            border-radius: 16px;

            padding: 32px 24px;

            text-align: center;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .icon {
            width: 64px;
            height: 64px;

            margin: 0 auto 20px;

            border-radius: 50%;

            background: #fef2f2;
            color: #dc2626;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 30px;
        }

        h1 {
            margin: 0 0 12px;

            font-size: 26px;
            line-height: 1.25;

            color: #111827;
        }

        p {
            margin: 0;

            font-size: 15px;
            line-height: 1.6;

            color: #6b7280;
        }

        .support {
            margin-top: 24px;

            padding-top: 20px;

            border-top: 1px solid #e5e7eb;

            font-size: 14px;
            color: #6b7280;
        }

        /* Small phones */
        @media (max-width: 360px) {
            body {
                padding: 16px;
            }

            .suspension-card {
                padding: 28px 18px;
            }

            h1 {
                font-size: 23px;
            }

            p {
                font-size: 14px;
            }
        }

        /* Tablets and larger screens */
        @media (min-width: 768px) {
            body {
                padding: 40px;
            }

            .suspension-card {
                padding: 44px 40px;
            }

            h1 {
                font-size: 30px;
            }
        }
    </style>
</head>

<body>

    <main class="suspension-card">

        <div class="icon" aria-hidden="true">
            !
        </div>

        <h1>
            Account Suspended
        </h1>

        <p>
            This account has been temporarily suspended.
            Please contact support for more information.
        </p>

        <div class="support">
            If you believe this is an error, please contact support.
        </div>

    </main>

</body>
</html>