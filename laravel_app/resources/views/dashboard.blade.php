<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Encoding Dashboard</title>
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
    <!-- Form to generate an API key -->
    <form action="{{ route('api.keys') }}" method="POST">
        @csrf
        <button type="submit">Generate API Key</button>
    </form>

    <h3>Your API Key</h3>
    @if(session('api_key'))
        <p>{{ session('api_key') }}</p>
    @else
        <p>No API key generated yet.</p>
    @endif

    <!-- Logout Form -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>

</body>
</html>