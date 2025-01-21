@extends('app')

@section('content')
    <h1>{{ isset($id) ? 'Edit Pengguna' : 'Tambah Pengguna' }}</h1>
    
    <form id="user-form" method="POST" action="{{ isset($id) ? '/api/users/'.$id : '/api/users' }}">
        @csrf
        @if (isset($id))
            @method('PUT') <!-- Menambahkan metode PUT untuk update data pengguna -->
        @endif

        <div class="form-group">
            <label for="user_fullname">Nama Lengkap</label>
            <input type="text" id="user_fullname" name="user_fullname" class="form-control" required value="{{ isset($user) ? $user->user_fullname : '' }}">
        </div>

        <div class="form-group">
            <label for="user_email">Email</label>
            <input type="email" id="user_email" name="user_email" class="form-control" required value="{{ isset($user) ? $user->user_email : '' }}">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" {{ isset($id) ? '' : 'required' }}>
            @if(isset($id))
                <small>Leave empty if you do not want to change the password</small>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
    <script>
        // Jika ini halaman edit, kita bisa fetch data pengguna berdasarkan ID
        @if (isset($id))
            fetch('http://localhost:8001/api/users/{{ $id }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token') // Gunakan token untuk otentikasi
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('user_fullname').value = data.user_fullname;
                document.getElementById('user_email').value = data.user_email;
                document.getElementById('user_status').value = data.user_status;
            })
            .catch(error => console.error('Error:', error));
        @endif
    </script>
@endsection
