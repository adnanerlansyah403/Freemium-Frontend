
document.addEventListener('alpine:init', () => {
  Alpine.data('auth', () => ({
    isLogedIn: false,
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    name: '',
    username: '',
    email: '',
    password: '',
    message: '',
    isLoadingAuth: false,
    subscribe_status: false,
    showFlash: false,
    typeStatus: true,
    status_err: [],
    data_user: [],

    flash() {
      if (localStorage.getItem('showFlash')) {
        this.showFlash = true;
        this.message = localStorage.getItem('message');
        // window.addEventListener("beforeunload", function () {
        //   this.showFlash = true;
        //   localStorage.removeItem("typeStatus")
        // });
        setTimeout(() => {
          this.showFlash = false;
          localStorage.removeItem("showFlash");
          localStorage.removeItem("message");
        }, 3500);
      }
    },

    checkSubscribe() {
      this.subscribe_status = localStorage.getItem('subscribe_status');
    },

    checkSession() {
      const token = localStorage.getItem('token')
      this.isLogedIn = token ? true : false

      // if (this.isLogedIn) {
      //   return window.location.href = this.baseUrl + "article";
      // }

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

    checkAlreadyAuth() {
      this.isLoadingAuth = true;
      const token = localStorage.getItem('token')
      this.isLogedIn = token ? true : false

      let url = window.location.href;
      let lastPath = url.substring(url.lastIndexOf('/'));


      if (this.isLogedIn) {
        if (lastPath == '/passwordReset') {
          this.isLoadingAuth = false;
          localStorage.setItem('showFlash', true)
          localStorage.setItem('message', 'Oops, you must have to logged out first');
          this.flash();
          return window.history.back();
        }
        this.isLoadingAuth = false;
        return window.location.href = this.baseUrl;
      } else {
        this.isLoadingAuth = false;
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
          if (!user.status) {
            // this.showFlash = true;
            this.status_err = user.message;
          }

          if (response.ok == true) {
            this.typeStatus = true;
            localStorage.setItem("typeStatus", true)
          } else if (response.ok == false) {
            this.typeStatus = false;
            localStorage.setItem("typeStatus", false)
          }

          if (user.status) {
            token = `Bearer ${user.data.auth.token}`;
            fullName = user.data.user.name;
            role = user.data.user.role;
            subscribe_status = user.data.user.subscribe_status;
            localStorage.setItem('token', token)
            localStorage.setItem('name', fullName)
            // localStorage.setItem('role', role)
            // localStorage.setItem('subscribe_status', subscribe_status)
            localStorage.setItem('showFlash', true)
            localStorage.setItem('message', user.message);
            this.showFlash = true;
            this.message = user.message;
            this.data_user = user.data
            if (role == 2) {
              return window.location.replace(this.baseUrl + 'article')
            }
            if (role == 1) {
              return window.location.replace(this.baseUrl + 'admin/dashboard')
            }
          }
        });
    },

    passwordReset() {
      this.isLoadingAuth = true;
      let params = {
        email: this.email
      }
      fetch(this.apiUrl + 'passwordReset', {
        method: "POST",
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(params)
      })
        .then(async response => {
          user = await response.json();
          console.log(user);
          if (!user.status) {
            // localStorage.setItem('showFlash', false)
            // localStorage.setItem('message', user.message);
            // this.showFlash = true;
            // this.message = user.message;
            this.status_err = [user.message];
            this.isLoadingAuth = false;
            // this.flash();
          } else {
            this.isLoadingAuth = false;
            localStorage.setItem('showFlash', true)
            localStorage.setItem('message', user.message);
            this.flash();
            window.location.replace(this.baseUrl + 'passwordReset');
          }
        });
    },

    newPassword(token) {
      this.isLoadingAuth = true;
      let params = {
        password: this.password
      }
      fetch(`${this.apiUrl}passwordReset/${token}`, {
        method: "POST",
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(params)
      })
        .then(async response => {
          user = await response.json();
          if (!user.status) {
            this.isLoadingAuth = false;
            localStorage.setItem('showFlash', true)
            localStorage.setItem('message', user.message);
            this.flash();
          } else {
            this.isLoadingAuth = false;
            localStorage.setItem('showFlash', true)
            localStorage.setItem('message', user.message);
            this.flash();
            window.location.replace(this.baseUrl + 'login')
          }
        });
    },
    register() {
      let params = {
        name: this.name,
        username: this.username,
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
          if (!user.status) {
            this.status_err = user.message;
            localStorage.setItem('showFlash', true)
            localStorage.setItem('message', user.message);
          } else {
            localStorage.setItem('showFlash', true)
            localStorage.setItem('message', user.message);
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