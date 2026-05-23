<!DOCTYPE html>
<html>

<head>

    <title>Register</title>

    <link
    rel="stylesheet"
    href="../assets/css/style.css">

</head>

<body>

    <div class="form-container">

        <h1>Create Account</h1>

        <form
        action="registerProcess.php"
        method="POST">

            <input
            type="text"
            name="name"
            placeholder="Full Name"
            required>

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

                Register

            </button>

        </form>

    </div>

</body>

</html>