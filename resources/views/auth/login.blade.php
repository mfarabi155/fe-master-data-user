<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Menambahkan Bootstrap dari CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card shadow-lg" style="width: 400px;">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Login</h4>

                <!-- Form Login -->
                <form id="login-form">
                    <!-- Laravel CSRF Token -->
                    @csrf
                    <div class="form-group">
                        <label for="user_email">Email</label>
                        <input type="email" id="user_email" name="user_email" class="form-control" required />
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required />
                    </div>

                    <!-- Error Message -->
                    <div id="error-message" class="alert alert-danger" style="display: none;"></div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                </form>

                <!-- Tautan ke halaman register jika pengguna belum memiliki akun -->
                <div class="text-center">
                    <p class="mt-3">Don't have an account? <a href="/register">Register</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menambahkan JavaScript Bootstrap dan jQuery dari CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Cek apakah sudah ada token di localStorage
        const token = localStorage.getItem('token');
        
        // Jika token ada, redirect ke halaman dashboard
        if (token) {
            window.location.href = '/dashboard';
        }

        // Event listener untuk form login
        document.getElementById('login-form').addEventListener('submit', function(event) {
            event.preventDefault();  // Mencegah form untuk reload halaman
            loginUser();  // Menjalankan fungsi login
        });

        // Fungsi login menggunakan Fetch API
        function loginUser() {
            const email = document.getElementById('user_email').value;
            const password = document.getElementById('password').value;

            // Menyiapkan data untuk dikirim ke backend
            const data = {
                user_email: email,
                password: password
            };

            // Mengirim request POST ke API login
            fetch('http://localhost:8001/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.token) {
                    // Menyimpan token JWT jika login berhasil
                    localStorage.setItem('token', data.token);  
                    window.location.href = '/dashboard';  // Redirect ke halaman dashboard setelah login
                } else {
                    // Menampilkan pesan error jika login gagal
                    document.getElementById('error-message').innerText = 'Invalid credentials';
                    document.getElementById('error-message').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Menampilkan pesan error jika ada kesalahan dalam pengiriman request
                document.getElementById('error-message').innerText = 'An error occurred';
                document.getElementById('error-message').style.display = 'block';
            });
        }
    </script>
</body>
</html>
