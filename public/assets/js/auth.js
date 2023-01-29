
document.addEventListener('alpine:init', () => {
  Alpine.data('auth', () => ({
    isLogedIn: false,
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    name: '',
    username: '',
    email: '',
    password: null,
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
          localStorage.setItem('showFlash', true)
          localStorage.setItem('message', 'Oops, you must have to logged out first');
          this.flash();
          // this.isLoadingAuth = false;
          return window.history.back();
        }
        // this.isLoadingAuth = false;
        return window.location.href = this.baseUrl;
      } else {
        this.isLoadingAuth = false;
      }

      this.isLoadingAuth = false;

    },

    // Fetch login
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
            this.data_user = user.data
            // this.showFlash = true;
            // this.message = user.message;
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Success!',
              text: user.message,
              background: '#fff',
              titleColor: '#000',
              color: '#000',
              showConfirmButton: false,
              timer: 3000
            })
            // localStorage.setItem('showFlash', true)
            // localStorage.setItem('message', user.message);
            if (role == 2) {
              setTimeout(function () {
                let baseUrl = "http://127.0.0.1:8000/";
                return window.location.replace(baseUrl + 'article')
              }, 3300)
            }
            if (role == 1) {
              setTimeout(function () {
                let baseUrl = "http://127.0.0.1:8000/";
                return window.location.replace(this.baseUrl + 'admin/dashboard')
              }, 3300)
            }
          }
        })
        .catch(error => {
          console.log(error);
          this.isLoading = false;
        })
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
            this.status_err = [];
            // localStorage.setItem('showFlash', true)
            // localStorage.setItem('message', user.message);
            // this.flash();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Success!',
              text: user.message,
              background: '#fff',
              titleColor: '#000',
              color: '#000',
              showConfirmButton: false,
              timer: 3000
            })
          }
        })
        .catch(error => {
          console.log(error);
        })
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
            // localStorage.setItem('showFlash', true)
            // localStorage.setItem('message', user.message);
            // this.flash();
            Swal.fire(
              'Success!',
              user.message,
              'success',
            )

            setTimeout(function () {
              let baseUrl = "http://127.0.0.1:8000/";
              window.location.replace(baseUrl + 'login')
            }, 3300)
          }
        })
        .catch(error => {
          console.log(error);
          this.isLoading = false;
          localStorage.setItem('showFlash', true)
          localStorage.setItem('message', 'Sorry, an unexpected error has occurred');
        })
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
          } else {
            // localStorage.setItem('showFlash', true)
            // localStorage.setItem('message', user.message);
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Registration Success',
              text: user.message,
              background: '#fff',
              titleColor: '#000',
              color: '#000',
              showConfirmButton: false,
              timer: 3000
            })
            setTimeout(function () {
              let baseUrl = "http://127.0.0.1:8000/";
              window.location.replace(baseUrl + 'login')
            }, 3500)
          }
        })
        .catch(error => {
          console.log(error);
        })
    },

    logout() {
      localStorage.clear()
      window.location.replace(this.baseUrl + 'login')
    },
  }))
})