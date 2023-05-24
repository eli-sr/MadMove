const userMenu = document.getElementById('user-menu')

let open = false

function openUserMenu () {
  userMenu.style.display = 'flex'
  userMenu.style.opacity = 1
}
function closeUserMenu () {
  userMenu.style.opacity = 0
  setTimeout(() => {
    userMenu.style.display = 'none'
  }, 150)
}

function toggleUserMenu () {
  if (open) {
    closeUserMenu()
    open = false
  } else {
    openUserMenu()
    open = true
  }
}

function logOut () {
  fetch('api/logout.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  }).then((response) => {
    window.location.reload()
  })
}
