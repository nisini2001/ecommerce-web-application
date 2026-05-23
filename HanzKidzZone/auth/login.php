<!DOCTYPE html>
<html>

<head>

    <title>Customer Login</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <div class="form-container">

        <h1>Customer Login</h1>

        <form
        action="loginProcess.php"
        method="POST">

            <input
            type="email"
            name="email"
            placeholder="Email"
            required>

            <input
            type="password"
            name="password"
            placeholder="Password"
            required>

            <button type="submit">

                Login

            </button>

        </form>

    </div>

</body>

</html>