<!DOCTYPE html>
<html>
<head>
    <title>User Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="userForm">
        @csrf
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="phone" placeholder="Phone" required><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <select name="role_id" required>
            <option value="" disabled selected>Select Role</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select><br>
        <input type="file" name="profile_image"><br>
        <button type="submit">Submit</button>
    </form>

    <table id="userTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Description</th>
                <th>Role</th>
                <th>Profile Image</th>
            </tr>
        </thead>
        <tbody>
            <!-- User rows will be populated here -->
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#userForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                $.ajax({
                    url: '{{ route('users.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#userForm')[0].reset();  // Reset form fields
                        loadUsers();
                    },
                    error: function(xhr) {
                        alert('Validation failed: ' + xhr.responseText);
                    }
                });
            });

            function loadUsers() {
                $.get('{{ route('users.index') }}', function(users) {
                    let userTableBody = '';
                    users.forEach(function(user) {
                        userTableBody += `
                            <tr>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.phone}</td>
                                <td>${user.description}</td>
                                <td>${user.role.name}</td>
                                <td><img src="/storage/${user.profile_image}" width="50"></td>
                            </tr>
                        `;
                    });
                    $('#userTable tbody').html(userTableBody);
                });
            }

            loadUsers(); // Initial load
        });
    </script>
</body>
</html>
