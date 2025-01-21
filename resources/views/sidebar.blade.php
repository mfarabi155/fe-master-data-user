@extends('app')

@section('content')
    <div class="container mt-5">
        <h2>Master Pengguna</h2>
        
        <!-- Tombol Tambah Pengguna -->
        <button class="btn btn-success mb-3" onclick="showAddUserForm()">Tambah Pengguna</button>

        <!-- Tabel Daftar Pengguna -->
        <table class="table table-bordered" id="users-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Daftar pengguna akan dimuat di sini -->
            </tbody>
        </table>
    </div>

    <!-- Modal untuk Add/Edit Pengguna -->
    <div class="modal" id="userModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="user-form">
                        @csrf
                        <div class="form-group">
                            <label for="user-fullname">Nama Lengkap</label>
                            <input type="text" class="form-control" id="user-fullname" required>
                        </div>
                        <div class="form-group">
                            <label for="user-email">Email</label>
                            <input type="email" class="form-control" id="user-email" required>
                        </div>
                        <div class="form-group">
                            <label for="user-password">Password</label>
                            <input type="password" class="form-control" id="user-password" {{ isset($user) ? '' : 'required' }}>
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                        </div>
                        <div class="form-group">
                            <label for="user-password-confirm">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="user-password-confirm" {{ isset($user) ? '' : 'required' }}>
                            <small class="form-text text-muted">Masukkan ulang password untuk konfirmasi</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Menambahkan JavaScript Bootstrap dan jQuery dari CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Fungsi untuk memuat data pengguna dari backend
        function loadUsers() {
            fetch('http://localhost:8001/api/users', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                }
            })
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#users-table tbody');
                tableBody.innerHTML = ''; // Clear existing rows

                data.forEach((user, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${user.user_fullname}</td>
                        <td>${user.user_email}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="showEditUserForm(${user.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Hapus</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching users:', error);
            });
        }

        function showAddUserForm() {
            document.getElementById('userModalLabel').textContent = 'Tambah Pengguna';
            document.getElementById('user-form').reset();
            document.getElementById('user-form').dataset.userId = '';
            $('#userModal').modal('show');
        }

        function showEditUserForm(userId) {
            fetch(`http://localhost:8001/api/users/${userId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('userModalLabel').textContent = 'Edit Pengguna';
                document.getElementById('user-fullname').value = data.user_fullname;
                document.getElementById('user-email').value = data.user_email;

                document.getElementById('user-form').dataset.userId = data.id;

                $('#userModal').modal('show');
            })
            .catch(error => console.error('Error fetching user:', error));
        }

        document.getElementById('user-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const userId = this.dataset.userId;
            const fullname = document.getElementById('user-fullname').value;
            const email = document.getElementById('user-email').value;
            const password = document.getElementById('user-password').value;
            const passwordConfirm = document.getElementById('user-password-confirm').value;

            if (password !== passwordConfirm) {
                alert('Password dan konfirmasi password tidak cocok!');
                return;
            }

            const data = {
                user_fullname: fullname,
                user_email: email,
            };

            if (password) {
                data.password = password;
            }

            let method = 'POST';
            let url = 'http://localhost:8001/api/users';

            if (userId) {
                method = 'PUT';
                url = `http://localhost:8001/api/users/${userId}`;
            }

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                $('#userModal').modal('hide');
                loadUsers();
            })
            .catch(error => console.error('Error saving user:', error));
        });

        // Fungsi untuk menangani aksi hapus
        function deleteUser(userId) {
            if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
                fetch(`http://localhost:8001/api/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    }
                })
                .then(response => response.json())
                .then(data => {
                    loadUsers();
                })
                .catch(error => console.error('Error deleting user:', error));
            }
        }

        window.onload = loadUsers;
    </script>
@endsection
