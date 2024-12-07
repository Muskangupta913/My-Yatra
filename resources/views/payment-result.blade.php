<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.1/lottie.min.js"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        #lottie-animation {
            width: 300px;
            height: 300px;
        }
    </style>
</head>
<body>
    <div id="lottie-animation"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the status from query parameters (success or failure)
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            // Select animation based on status
            const animationPath = status === 'success'
                ? '/assets/success.json'
                : '/assets/failed.json';

            // Load the Lottie animation
            lottie.loadAnimation({
                container: document.getElementById('lottie-animation'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: animationPath, // Path to the JSON animation file
            });
        });
    </script>
</body>
</html>
