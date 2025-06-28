<!--Thank you blade-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .success {
            color: green;
        }
        .failed {
            color: red;
        }
    </style>
</head>
<body>
<div class="message">
    <h1 class="{{ $msg === 'Success' ? 'success' : 'failed' }}">{{ $msg }}</h1>
    <p>{{ $msg1 }}</p>
    <a href="{{ url('/') }}">Return to Home</a>
</div>
</body>
</html>
