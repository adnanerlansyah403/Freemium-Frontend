
document.addEventListener('alpine:init', () => {
  Alpine.data('auth', () => ({
    isLogedIn: false,
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    email: '',
    password: '',

    checkSession() {
      const token = localStorage.getItem('token')
      console.log(token);
      this.isLogedIn = token ? true : false

      if (this.isLogedIn) {
        // Fetch API Check Token

        if (token) {
          if (localStorage.getItem('role') == 1) {
            return window.location.replace(this.baseUrl + 'admin')
          }
          if (localStorage.getItem('role') == 2) {
            return window.location.replace(this.baseUrl + 'myarticle')
          }
        }
      }
    },

    fetchLogin() {
      let params = {
        email: this.email,
        password: this.password
      }
      fetch(this.apiUrl + 'login', {
        method: "POST",
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(params)
      })
        .then(async response => {
          user = await response.json()
          console.log(user)
          token = `Bearer ${user.data.auth.token}`;
          fullName = user.data.user.name;
          role = user.data.user.role;

          localStorage.setItem('token', token)
          localStorage.setItem('name', fullName)
          localStorage.setItem('role', role)
          // console.log(localStorage.getItem('token'));
          if (role == 2) {
            return window.location.replace(this.baseUrl + 'myarticle')
          }
          if (role == 1) {
            return window.location.replace(this.baseUrl + 'admin')
          }
        });
    },

    logout() {
      localStorage.clear()
      window.location.replace(this.baseUrl + 'login')
    },
  }))
})