<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, {{ auth()->user()->name }}</h2>

    <h3>Your Submitted Jobs</h3>
    @if($jobs->isEmpty())
        <p>No jobs submitted yet.</p>
    @else
        <ul>
            @foreach($jobs as $job)
                <li>Job ID: {{ $job->id }} - Status: {{ $job->status }}</li>
            @endforeach
        </ul>
    @endif

    <h3>API Key</h3>
    <form action="{{ route('api.keys') }}" method="GET">
        <button type="submit">Generate API Key</button>
    </form>

    <h3>Your API Key</h3>
    @if(session('api_key'))
        <p>{{ session('api_key') }}</p>
    @endif

    <!-- In resources/views/dashboard.blade.php -->
    <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-danger">Logout</button>
    </form>

</body>
</html>