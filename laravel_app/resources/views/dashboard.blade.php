<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Encoding Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <h3>Your API Keys</h3>
    @if(auth()->user()->apiKeys->isEmpty())
        <p>No API keys generated yet.</p>
    @else
        <ul>
            @foreach(auth()->user()->apiKeys as $key)
                <li>
                    {{ $key->api_key }} 
                    <button onclick="deleteApiKey({{ $key->id }})" style="color: red;">Delete</button>
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Logout Form -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>

    <script>
        function deleteApiKey(keyId) {
            if (!confirm("Are you sure you want to delete this API key?")) {
                return;
            }

            fetch(`/dashboard/api-keys/${keyId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload(); // Refresh the page to update API key list
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>