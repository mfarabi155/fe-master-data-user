@extends('app')

@section('content')
    <div class="container mt-5">
        <h1>Welcome to Dashboard</h1>
        <p>Here you can manage your data.</p>

        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Total Users</div>
                    <div class="card-body">
                        <h5 class="card-title" id="user-count">Loading...</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Users Logged In</div>
                    <div class="card-body">
                        <h5 class="card-title" id="user-login-count">Loading...</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function loadDashboardData() {
            fetch('http://localhost:8001/api/user-count', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('user-count').textContent = data.count;
            })
            .catch(error => {
                console.error('Error fetching user count:', error);
                document.getElementById('user-count').textContent = 'Error loading data';
            });

            fetch('http://localhost:8001/api/user-count-login', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('user-login-count').textContent = data.count;
            })
            .catch(error => {
                console.error('Error fetching user login count:', error);
                document.getElementById('user-login-count').textContent = 'Error loading data';
            });
        }

        // Memuat data saat halaman dimuat
        window.onload = loadDashboardData;
    </script>
@endsection
