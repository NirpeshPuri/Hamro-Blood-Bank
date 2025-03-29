<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eSewa Payment</title>
</head>
<body>
<form method="POST" action="{{ $esewaUrl }}" id="esewa-form">

    @foreach ($formInputs as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endforeach
</form>
<script type="text/javascript">
    document.getElementById("esewa-form").submit();
</script>
</body>
</html>
