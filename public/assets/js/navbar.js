
document.addEventListener('alpine:init', () => {
  Alpine.data('navbar', () => ({
    title: 'Selamat datang, ' + localStorage.getItem('name'),
    isLogedIn: false,
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    checkSession() {
      this.isLogedIn = localStorage.getItem('token') ? true : false
    },

    logout() {
      localStorage.clear()
      window.location.replace(this.baseUrl + 'login')
    },
  }))
})