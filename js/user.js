function openUserMenu () {
  const userMenu = document.getElementById('user-menu')
  userMenu.style.opacity = 1
}

function logOut () {
  fetch('api/logout.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  }).then(response => {
    window.location.reload()
  })
}
