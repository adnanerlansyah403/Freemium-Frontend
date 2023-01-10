
document.addEventListener('alpine:init', () => {
  Alpine.data('auth', () => ({
    isLogedIn: false,
    baseUrl: "http://127.0.0.1:8002/",
    apiUrl: "http://127.0.0.1:8001/api/",
    name: '',
    email: '',
    password: '',
    subscribe_status: false,
    data_user: [],

    checkSubscribe() {
      this.subscribe_status = localStorage.getItem('subscribe_status');
    },

    checkSession() {
      const token = localStorage.getItem('token')
      console.log(token);
      this.isLogedIn = token ? true : false

      // if (this.isLogedIn) {
      //   // Fetch API Check Token

      //   if (token) {
      //     if (localStorage.getItem('role') == 1) {
      //       return window.location.replace(this.baseUrl + 'admin')
      //     }
      //     if (localStorage.getItem('role') == 2) {
      //       return window.location.replace(this.baseUrl + 'article')
      //     }
      //   }
      // }
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
          subscribe_status = user.data.user.subscribe_status;
          localStorage.setItem('token', token)
          localStorage.setItem('name', fullName)
          localStorage.setItem('role', role)
          localStorage.setItem('subscribe_status', subscribe_status)
          this.data_user = user.data
          if (role == 2) {
            return window.location.replace(this.baseUrl + 'article')
          }
          if (role == 1) {
            return window.location.replace(this.baseUrl + 'admin')
          }
        });
    },

    register() {
      let params = {
        name: this.name,
        email: this.email,
        password: this.password
      }
      fetch(this.apiUrl + 'register', {
        method: "POST",
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(params)
      })
        .then(async response => {
          user = await response.json();
          if (user) {
            window.location.replace(this.baseUrl + 'login')
          }
        });
    },

    logout() {
      localStorage.clear()
      window.location.replace(this.baseUrl + 'login')
    },
  }))
})