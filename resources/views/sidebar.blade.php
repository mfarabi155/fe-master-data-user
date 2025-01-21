<!-- Sidebar Blade Template -->
<div class="sidebar bg-light" style="width: 250px; position: fixed; height: 100%; padding-top: 20px;">
    <div style="text-align: center; padding-bottom: 20px;" id="logo-container">
        <img src="" alt="Logo" style="width: 150px;" id="logo-image">
    </div>
    <ul class="nav flex-column">
        <div id="menu-list"></div>
    </ul>
</div>

<script>
    console.log('Fetching logo and menu...');
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch logo
        fetch('http://localhost:8001/api/settings/icon_dashboard', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token
            }
        })
            .then(response => response.json())
            .then(data => {
                const logoImage = document.getElementById('logo-image');
                logoImage.src = '/storage/' + data.value;
            })
            .catch(error => console.error('Error fetching logo:', error));

        // Fetch menu
        fetch('http://localhost:8001/api/menus', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token
            }
        })
            .then(response => response.json())
            .then(data => {
                const menuList = document.getElementById('menu-list');
                data.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'nav-item';
                    li.innerHTML = `<a class="nav-link" href="${item.menu_url}"><i class="${item.menu_icon}"></i> ${item.menu_name}</a>`;
                    menuList.appendChild(li);
                });
            })
            .catch(error => console.error('Error fetching menu:', error));
    });
</script>
