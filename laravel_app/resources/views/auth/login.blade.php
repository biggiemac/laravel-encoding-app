<!-- resources/views/auth/login.blade.php -->

<form method="POST" action="{{ route('login.submit') }}">
    @csrf
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" required />
    </div>

    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" required />
    </div>

    <button type="submit">Login</button>
</form>