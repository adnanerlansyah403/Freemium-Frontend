document.addEventListener('alpine:init', () => {

  Alpine.data('user', () => ({
    buttonshow: false,
    isLogedIn: false,
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    imgUrl: "http://127.0.0.1:8001/",
    subscribe_status: false,
    linkInputFacebook: true,
    linkInputLinkedin: false,
    linkInputInstagram: false,
    linkInputTwitter: false,
    limitcategory : 4,

    data_user: [],
    professions: [
      'Freemium blogger',
      'Doctor',
      'Teacher',
      'Police officer',
      'Professor',
      'Programmer',
      'Engineer',
      'Business owner',
      'Journalist',
      'Photographer',
      'Artist'
    ],
    showFlash: false,
    status_err: [],
    category_err: [],
    typeStatus: true,
    isLoading: false,
    isLoadingMyArticle: false,
    isLoadMore: false,
    DetailArticle: {
      data: ''
    },
    EditArticle: [],
    listMyArticle: [],
    listMyView: [],
    itemMyArticle: 3,
    myTransactions: [],
    message: '',
    categories: [],

    // User data
    name: '',
    username: '',
    email: '',
    password: '',
    profession: '',
    // photo: '',
    link_facebook: '',
    link_linkedin: '',
    link_instagram: '',
    link_twitter: '',
    diffpayment: '',
    paymentDateProfile: '',
    diffPaymentByDay: '',

    checkExists(obj, id) {
      return obj.some(function (gfg) {
        return gfg.id === id;
      });
    },

    // Flash user
    flash() {
      if (localStorage.getItem('showFlash')) {
        this.showFlash = true;
        this.message = this.message;
        // window.addEventListener("beforeunload", function () {
        //   this.showFlash = true;
        //   localStorage.removeItem("typeStatus")
        // });
        setTimeout(() => {
          this.showFlash = false;
          this.message = '';
          // localStorage.removeItem("showFlash");
          // localStorage.removeItem("message");
        }, 5000);
      }
    },

    // Adding months to inputted date
    addMonths(date, months) {
      date.setMonth(date.getMonth() + months);

      return date;
    },

    // Fetch logged in user data
    fetchMe() {
      this.isLoading = true;
      fetch(this.apiUrl + 'me', {
        method: "GET",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
      })
        .then(async response => {
          user = await response.json();
          if (user.status) {
            this.data_user = user.data
            this.name = user.data.name == null ? '' : user.data.name
            this.username = user.data.username == null ? '' : user.data.username
            this.email = user.data.email == null ? '' : user.data.email
            this.password = user.data.password == null ? '' : user.data.password
            this.photo = user.data.photo == null ? '' : user.data.photo
            this.profession = user.data.profession == null ? '' : user.data.profession
            this.link_facebook = user.data.link_facebook == null ? '' : user.data.link_facebook
            this.link_linkedin = user.data.link_linkedin == null ? '' : user.data.link_linkedin
            this.link_instagram = user.data.link_instagram == null ? '' : user.data.link_instagram
            this.link_twitter = user.data.link_twitter == null ? '' : user.data.link_twitter
            this.isLoading = false;
            this.diffpayment = user.data.payments[0].plan.expired
            this.paymentDateProfile = user.data.payments[0].payment_date

            const resultPaymentProfile = this.addMonths(new Date(this.paymentDateProfile), this.diffpayment)
            const datenow = Date.now();
            const diff = Math.abs(resultPaymentProfile - datenow)
            this.diffPaymentByDay = Math.ceil(diff / (1000 * 60 * 60 * 24));

          }
        });
    },

    // Check if user logged in and set islogedIn session to true
    checkSession() {
      const token = localStorage.getItem('token')
      this.isLogedIn = token ? true : false

      if (!this.isLogedIn) {
        // Fetch API Check Token
        let url = window.location.pathname;
        let originalUrl = url.replace(/detail\/.*$/, "detail");

        if (originalUrl == '/article/detail') {
          localStorage.setItem("showFlash", true);
          localStorage.setItem("typeStatus", false);
          localStorage.setItem("message", "You're not allowed for this, please login first");
        }

        return window.location.replace(this.baseUrl + 'login')
      }
    },

    // Check token
    checkAuth() {
      const token = localStorage.getItem('token')
      this.isLogedIn = token ? true : false
    },

    // Check if user is not admin
    checkRole() {
      this.isLoading = true;
      fetch(this.apiUrl + 'me', {
        method: "GET",
        headers: {
          'Content-Type': 'application/json',
          'Authorization': localStorage.getItem('token')
        },
      })
        .then(async response => {
          user = await response.json();
          this.data_user = user.data
          if (this.data_user.role != 1) {
            return window.location.replace(this.baseUrl + 'article');
          }
          if (this.data_user.role == 1) {
            this.isLoading = false;
          }
        });
    },

    // Isn't this is same with checkRole() ?
    checkRoleUser() {
      this.isLoading = true;
      fetch(this.apiUrl + 'me', {
        method: "GET",
        headers: {
          'Content-Type': 'application/json',
          'Authorization': localStorage.getItem('token')
        },
      })
        .then(async response => {
          user = await response.json();
          this.data_user = user.data
          if (this.data_user.role != 2) {
            return window.history.back()
          }
          if (this.data_user.role == 2) {
            this.isLoading = false;
          }
        });
    },

    // Set tinyMce content with inputted text
    setTiny(id, text) {
      tinymce.get(id).setContent(text);
    },

    // Update user profile
    updateMe() {
      let profession = document.getElementById('profession').value;
      let photoProfile = document.getElementById('photo').files[0];

      if (photoProfile == undefined) {
        photoProfile = this.data_user.photo;
      }

      let formData = new FormData();
      formData.append('name', this.name ? this.name : '');
      formData.append('username', this.username ? this.username : '');
      formData.append('email', this.email ? this.email : '');
      if (this.password.length != 0) {
        formData.append('password', this.password);
      }
      if (photoProfile) formData.append('photo', photoProfile);
      formData.append('profession', profession ? profession : '');
      formData.append('link_facebook', this.link_facebook ? this.link_facebook : '');
      formData.append('link_linkedin', this.link_linkedin ? this.link_linkedin : '');
      formData.append('link_instagram', this.link_instagram ? this.link_instagram : '');
      formData.append('link_twitter', this.link_twitter ? this.link_twitter : '');

      fetch(this.apiUrl + 'profileUpdate', {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
        body: formData
      })
        .then(async response => {
          user = await response.json();
          this.data_user = user.data != null ? user.data : ''
          this.name = user.data.name != null ? user.data.name : ''
          this.username = user.data.username != null ? user.data.username : ''
          this.email = user.data.email != null ? user.data.email : ''
          this.password = user.data.password != null ? user.data.password : ''
          this.photo = user.data.photo != null ? user.data.photo : ''
          this.link_facebook = user.data.link_facebook != null ? user.data.link_facebook : ''
          this.link_linkedin = user.data.link_linkedin != null ? user.data.link_linkedin : ''
          this.link_instagram = user.data.link_instagram != null ? user.data.link_instagram : ''
          this.link_twitter = user.data.link_twitter != null ? user.data.link_twitter : ''

          localStorage.setItem('showFlash', true)
          localStorage.setItem('message', user.message);
          // this.typeStatus = true;
          window.location.replace(this.baseUrl + 'profile');
        })
    },

    // Logout
    logout() {
      localStorage.clear()
      window.location.replace(this.baseUrl + 'login')
    },
    listPlan: '',
    keywordPlan: '',
    fetchListPlan() {
      this.isLoading = true;
      const token = localStorage.getItem('token')
      fetch(`${this.apiUrl}plan`, {
        method: "GET",
        headers: {
          'Content-Type': 'application/json',
          'Authorization': localStorage.getItem('token')
        }
      })
        .then(async (response) => {
          const data = await response.json();
          if (data.message === 'Unauthorized') {
            window.location.replace(this.baseUrl + 'login')
          }
          this.listPlan = data.data;
          this.isLoading = false;
        })

    },


    modalHandler(val, id = 0) {
      let modal = document.getElementById("modal");
      let plan_id = document.getElementById("plan_id");
      let name = document.getElementById("name");
      let price = document.getElementById("price");
      let expired = document.getElementById("expired");

      if (id === 0) {
        name.value = '';
        price.value = '';
        expired.value = '';
        plan_id.value = 0;
      }

      if (val) {
        fadeIn(modal);
      } else {
        fadeOut(modal);
      }
      fetch(`${this.apiUrl}plan/${id}`, {
        method: "GET",
        headers: {
          'Content-Type': 'application/json',
          'Authorization': localStorage.getItem('token')
        }
      })
        .then(async (response) => {
          data = await response.json();
          name.value = data.data.name;
          price.value = data.data.price;
          expired.value = data.data.expired;
          plan_id.value = data.data.id;

        })
    },

    // searchPlan(keyword) {
    //   fetch(`${this.apiUrl}category`, {
    //     method: 'GET',
    //     headers: {
    //       Authorization: localStorage.getItem('token'),
    //     }
    //   })
    //     .then(async (response) => {
    //       const data = await response.json();
    //     })
    // },

    modalHandlerCategory(val, id = 0) {
      let modal = document.getElementById("modal");
      let category_id = document.getElementById("category_id");
      let name = document.getElementById("name");

      if (id === 0) {
        name.value = '';
        category_id.value = 0;
      }

      if (val) {
        fadeIn(modal);
      } else {
        fadeOut(modal);
      }
      fetch(`${this.apiUrl}category/${id}`, {
        method: "GET",
        headers: {
          'Content-Type': 'application/json',
          'Authorization': localStorage.getItem('token')
        }
      })
        .then(async (response) => {
          data = await response.json();
          name.value = data.data.name;
          category_id.value = data.data.id;
        })
    },

    async actionCategory() {
      let id = document.getElementById("category_id").value;
      let name = document.getElementById("name");
      let icon = document.getElementById('icon').files[0];

      formData = new FormData();

      formData.append('name', name.value);

      if (id == 0) {
        path = '';
        formData.append('icon', icon);
      } else {
        path = `/${id}/update`;
        if (icon) {
          formData.append('icon', icon);
        }
      }

      category = await fetch(`${this.apiUrl}category${path}`, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
        body: formData
      })

      data = await category.json();

      if (data.status) {
        localStorage.setItem('message', data.message);
        localStorage.setItem('showFlash', true);
        window.location.reload();
      }
      if (!data.status) {
        this.showFlash = true;
        this.status_err = data.message;
        this.isLoadingArticle = false;
      }
    },

    async actionPlan() {
      let id = document.getElementById("plan_id").value;
      let name = document.getElementById("name");
      let price = document.getElementById("price");
      let expired = document.getElementById("expired");

      formData = new FormData();

      formData.append('name', name.value);
      formData.append('price', price.value);
      formData.append('expired', expired.value);

      if (id == 0) {
        path = '';
      } else {
        path = `/${id}/update`;
      }

      plan = await fetch(`${this.apiUrl}plan${path}`, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
        body: formData
      })

      data = await plan.json();

      if (data.status) {
        localStorage.setItem('message', data.message);
        localStorage.setItem('showFlash', true);
        window.location.reload();
      }
      if (!data.status) {
        this.showFlash = true;
        this.status_err = data.message;
        this.isLoadingArticle = false;
      }
    },

    // Delete plan
    async deletePlan(id) {
      plan = await fetch(`${this.apiUrl}plan/${id}/delete`, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token')
        }
      })

      data = await plan.json();

      if (data.status) {
        localStorage.setItem('message', "data successfully deleted!");
        localStorage.setItem('showFlash', true);
        window.location.reload();
      }
    },

    // Delete category
    async deleteCategory(id) {
      category = await fetch(`${this.apiUrl}category/${id}/delete`, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token')
        }
      })

      data = await category.json();

      if (data.status) {
        localStorage.setItem('message', "data successfully deleted!");
        localStorage.setItem('showFlash', true);
        window.location.reload();
      }
    },

    listUser: [],
    search: '',
    paginate(url) {
      fetch(`${url}`, {
        method: "GET",
        headers: {
          'Authorization': localStorage.getItem('token')
        }
      })
        .then(async (response) => {
          const data = await response.json();
          this.listUser = data.data;
        })
    },
    sort(col = 'name') {
      if (this.sortCol === col) this.sortAsc = !this.sortAsc;
      this.sortCol = col;
      this.listUser.data.sort((a, b) => {
        if (a[this.sortCol] < b[this.sortCol]) return this.sortAsc ? 1 : -1;
        if (a[this.sortCol] > b[this.sortCol]) return this.sortAsc ? -1 : 1;
        return 0;
      });
    },

    // Search user from list (admin)
    searchUser() {
      fetch(`${this.apiUrl
        }user/all?search=${this.search}`, {
        method: "GET",
        headers: {
          'Content-Type': 'application/json',
          'Authorization': localStorage.getItem('token')
        }
      })
        .then(async (response) => {
          const data = await response.json();
          this.listUser = data.data;
        })
    },

    // Fetch all user data ) (admin)
    fetchListUser() {
      this.isLoading = true;
      fetch(`${this.apiUrl}user/all`, {
        method: "GET",
        headers: {
          'Content-Type': 'application/json',
          'Authorization': localStorage.getItem('token')
        }
      })
        .then(async (response) => {
          data = await response.json();
          this.listUser = data.data;
          this.isLoading = false;
        })
    },

    // Delete user data (admin)
    async deleteUser(id) {
      user = await fetch(`${this.apiUrl}user/${id}/delete`, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token')
        }
      })

      data = await user;

      if (data.status) {
        localStorage.setItem('message', "data successfully deleted!");
        localStorage.setItem('showFlash', true);
        window.location.reload();
      }
    },

    // Fetch logged in user article
    fetchMyArticle() {
      let url = window.location.href;
      let id = url.substring(url.lastIndexOf('/') + 1);

      fetch(`${this.apiUrl}article/${id}`, {
        method: "GET",
        headers: {
          "Content-Type": "application/json"
        }
      })
        .then(async (response) => {
          let myArticle = await response.json();
        })
        .catch(error => {
          console.log(error)
        })

    },

    // Load more article
    loadMoreMyArticle() {
      this.isLoadingMyArticle = true;
      this.isLoadMore = true;
      setTimeout(() => {
        this.isLoadingMyArticle = false;
        this.isLoadMore = false;
        this.itemMyArticle += 3;
        this.fetchListMyArticle();
      }, 600)
    },

    // Fetch logged in user article
    keywordMyArticle: '',
    fetchListMyArticle() {
      const token = localStorage.getItem('token')

      this.isLoading = true,
        fetch(`${this.apiUrl}myArticle`, {
          method: "GET",
          headers: {
            'Content-Type': 'application/json',
            'Authorization': localStorage.getItem('token')
          }
        })
          .then(async (response) => {
            data = await response.json();
            if (data.message === 'Unauthorized') {
              window.location.replace(this.baseUrl + 'login')
            }
            this.listMyArticle = data.data;
            this.listMyView = data.views;
            this.isLoading = false;

          })
          .catch(error => {
            console.log(error);
            this.isLoading = false;
          })

    },

    // My article search filter
    searchMyArticle(keyword) {
      const token = localStorage.getItem('token')

      this.isLoadingMyArticle = true;
      fetch(`${this.apiUrl}myArticle?search=${keyword}`, {
        method: "GET",
        headers: {
          'Content-Type': 'application/json',
          'Authorization': localStorage.getItem('token')
        }
      })
        .then(async (response) => {
          data = await response.json();
          if (data.message === 'Unauthorized') {
            window.location.replace(this.baseUrl + 'login')
          }
          this.listMyArticle = data.data;

          this.isLoadingMyArticle = false;
        })
        .catch(error => {
          console.log(error);
          this.isLoadingMyArticle = false;
        })

    },

    // Fetch article user want to edit
    fetchEditArticle(id) {
      const token = localStorage.getItem('token')

      this.isLoading = true,
        fetch(`${this.apiUrl}article/${id}/edit`, {
          method: "GET",
          headers: {
            'Content-Type': 'application/json',
            'Authorization': localStorage.getItem('token')
          }
        })
          .then(async (response) => {
            data = await response.json();

            if (data.status == false) {
              localStorage.setItem('showFlash', true);
              localStorage.setItem('message', data.message);
              window.history.back();
            } else {
              this.EditArticle = data.data;
              this.categories = data.category;
            }
            this.isLoading = false;


          })
          .catch(error => {
            console.log(error);
            this.isLoading = false;
          })

    },

    // Update editted article
    updateArticle() {
      let editA = this.EditArticle;
      editA.description = tinymce.get('content').getContent();

      if (typeof editA.thumbnail !== 'string' && editA.thumbnail[0]) {
        editA.thumbnail = editA.thumbnail[0];
      }

      let selected = document.getElementById('category_id');

      let formData = new FormData();

      for (let i = 0; i < selected.options.length; i++) {
        if (selected.options[i].selected) {
          formData.append('category_id[]', selected.options[i].value);
        }
      }

      formData.append('title', editA.title);
      formData.append('description', editA.description);
      formData.append('thumbnail', editA.thumbnail);

      this.isLoading = true;
      fetch(this.apiUrl + `article/${editA.id}/update`, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
        body: formData
      })
        .then(async response => {
          data = await response.json();

          if (data.status) {
            this.status_err[0] = null;
            this.showFlash = true;
            this.message = data.message;
          }
          else {
            this.status_err[0] = data.message;
            this.showFlash = true;
            this.message = 'Update article failed';
          }

          setTimeout(() => {
            this.showFlash = false;
            this.message = '';
          }, 4000);

          this.isLoading = false;
        }).catch(error => {
          console.log(error);
          this.isLoading = false;
        })

    },

    // add subarticle (edit)
    addSub() {
      let id = 0;
      let article_id = this.EditArticle.id;
      let title = '';
      let type = '';
      let description = '';
      let thumbnail = '';
      return { id, article_id, title, type, description, thumbnail };
    },

    // Updated editted sub-article
    updateSub(number) {
      let editSub = this.EditArticle.subarticles[number];
      editSub.description = tinymce.get('sub_content').getContent();

      if (typeof editSub.thumbnail !== 'string' && editSub.thumbnail[0]) {
        editSub.thumbnail = editSub.thumbnail[0];
      }

      let formData = new FormData();

      formData.append('article_id', editSub.article_id);
      formData.append('title', editSub.title);
      formData.append('type', editSub.type);
      formData.append('description', editSub.description);
      formData.append('thumbnail', editSub.thumbnail);

      this.isLoading = true;
      fetch(this.apiUrl + `sub-article/${editSub.id}/update`, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
        body: formData
      })
        .then(async response => {
          sub = await response.json();

          if (sub.status) {
            editSub.id = sub.data.id;
            this.status_err[1] = null;
            this.showFlash = true;
            this.message = sub.message;
          }
          else {
            this.status_err[1] = sub.message;
            this.showFlash = true;
            this.message = 'Update sub-article failed';
          }
          setTimeout(() => {
            this.showFlash = false;
            this.message = '';
          }, 4000);

          this.isLoading = false;
        })
        .catch(error => {
          console.log(error);
          this.isLoading = true;
        })

    },

    // Delete user article
    deleteArticle(id) {
      this.isLoading = true;

      const token = localStorage.getItem('token')
      fetch(this.apiUrl + 'article/' + id + '/delete', {
        method: "POST",
        headers: {
          'Authorization': token
        }
      })
        .then(async response => {
          data = await response.json();

          if (data.status) {
            this.showFlash = true;
            this.message = data.message;
            this.fetchListMyArticle();
          }
          else {
            this.showFlash = true;
            this.message = data.message;
          }

          setTimeout(() => {
            this.showFlash = false;
            this.message = '';
          }, 4000);

          this.isLoading = false;
        }).catch(error => {
          console.log(error);
          this.isLoading = false;
        })
    },

    // Delete user sub-article
    deleteSub(delSub) {
      this.isLoading = true;

      const token = localStorage.getItem('token')
      fetch(this.apiUrl + 'sub-article/' + delSub + '/delete', {
        method: "POST",
        headers: {
          'Authorization': token
        }
      })
        .then(async response => {
          data = await response.json();

          if (data.status) {
            this.showFlash = true;
            this.message = data.message;
            this.fetchListMyArticle();
          }
          else {
            this.showFlash = true;
            this.message = data.message;
          }

          setTimeout(() => {
            this.showFlash = false;
            this.message = '';
          }, 4000);

          this.isLoading = false;
        }).catch(error => {
          console.log(error);
          this.isLoading = false;
        })
    },

    //pay subscription
    plan: 0,
    plan_id: 0,
    paySubscription() {
      const data = new FormData()
      data.append('plan', this.plan_id)
      let plan_id = this.plan_id
      fetch(this.apiUrl + 'payment?plan_id=' + plan_id, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token'),
        }
      })

        .then(async response => {
          let data = await response.json();
          console.log(data);
          if (data.status) {
            window.open(data.data, '_blank');
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Choose Plan First!',
              titleColor: '#FFFF',
              iconColor: '#FFFF',
              color: '#FFFF',
              background: '#7C030B',
              position: 'center',
            })

          }
        })
        .catch(error => {
          console.log(error);
        })

    },

    // Select plan for subscribe
    selectedPlan(item = null) {

      this.plan_id = item.id;

      var elements = document.querySelectorAll(".cardplan");
      for (var i = 0; i < elements.length; i++) {
        elements[i].classList.remove("active");
        document.querySelectorAll(".selectplan")[i].innerText = "Select"
      }

      document.getElementById(`plan${item.id}`).click();
      document.getElementById(`cardplan${item.id}`).classList.add('active');
      document.getElementById(`selectedplan${item.id}`).innerText = 'Selected';
    },

    getTime(date) {
      var newDate = new Date(date);
      var hour = newDate.getHours();
      var minutes = newDate.getMinutes();
      return `${hour}:${minutes}`;
    },

    // MY TRANSACTONS

    fetchMyTransactions() {

      fetch(`${this.apiUrl}payment/getMyPayment`, {
        method: "GET",
        headers: {
          'Authorization': localStorage.getItem('token'),
        }
      })
        .then(async (response) => {
          const data = await response.json();
          this.myTransactions = data.data;

          let url = window.location.href;
          let lastPath = url.substring(url.lastIndexOf('/'));

          if (this.myTransactions[0] != null) {
            if (this.myTransactions[0].status == 1 && lastPath == '/details') {
              window.location.replace(this.baseUrl + "profile");
            }
          }

          if (this.myTransactions[0] == null && lastPath == '/details') {
            window.location.replace(`${this.baseUrl}transaction`)
          }
          return;
        })
        .catch(error => {
          console.log(error);
        })
    },

    updateMyTransaction() {
      let attachment = document.getElementById('attachment').files[0];
      let formData = new FormData();

      if (attachment) formData.append('attachment', attachment);
      if (!attachment) formData = '';

      fetch(`${this.apiUrl}payment/checkout`, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
        body: formData
      })
        .then(async response => {
          data = await response.json();
          if (data.status) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Transaction Success',
              background: '#7C030B',
              showConfirmButton: false,
              timer: 3000
            })
            localStorage.setItem('showFlash', true, 5000)
            localStorage.setItem('message', data.message);
            setTimeout(function () {
              // const baseUrl = "http://127.0.0.1:8000/";
              window.location.replace(`${baseUrl}profile`);
            }, 3500)
          } else {
            message = data.message.attachment[0];
            Swal.fire({
              icon: 'error',
              title: message,
              titleColor: '#FFFF',
              iconColor: '#FFFF',
              color: '#FFFF',
              background: '#7C030B',
              position: 'center',
            })
          }
        })
        .catch(error => {
          console.log(error);
        })
    },

    // Show user order detail on modal
    showOrder(val, id = 0) {
      let modal = document.getElementById("modal");

      let planOrder = document.getElementById("planOrder");
      let priceOrder = document.getElementById("priceOrder");
      let vaOrder = document.getElementById("vaOrder");
      let paymentDateOrder = document.getElementById("paymentDateOrder");

      if (id === 0) {
        vaOrder.value = 0;
        priceOrder = 0;
        paymentDateOrder.value = '';
      }

      if (val) {
        fadeIn(modal);
      } else {
        fadeOut(modal);
        // return;
      }

      fetch(`${this.apiUrl}payment/getMyPayment`, {
        method: "GET",
        headers: {
          'Content-Type': 'application/json',
          'Authorization': localStorage.getItem('token')
        }
      })
        .then(async (response) => {
          const data = await response.json();

          data.data.filter(item => {
            if (item.id == id) {
              planOrder.innerText = item.plan.name;
              priceOrder.innerText = '$' + item.total_price;
              vaOrder.innerText = item.virtual_account_number;
              paymentDateOrder.innerText = `${this.convertDate(item.payment_date)} ${this.getTime(item.payment_date)}`;
            }
          })
            .catch(error => {
              console.log(error);
            })

        })
    },

  }))

  Alpine.data('articles', () => ({
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    imgUrl: "http://127.0.0.1:8001/",
    listArticle: [],
    listView: [],
    categoriesArticle: [],
    detailArticle: null,
    detailViews: null,
    isLoadingArticle: false,
    isLoadMore: false,
    isLoading: false,
    itemArticle: 3,
    content: false,
    fetchStatus: true,
    back: false,
    showFlash: false,
    message: '',

    // INPUTS ARTICLE
    filtersKey: [],

    // CATEGORIES ARTICLE
    sortCol: null,
    sortAsc: false,
    search: '',

    // CREATE ARTICLE
    sub_article_err: '',
    status_sub_err: false,


    // Flash admin
    flash() {
      if (localStorage.getItem('showFlash')) {
        this.showFlash = true;
        this.message = localStorage.getItem('message');
        window.addEventListener("beforeunload", function () {
          localStorage.removeItem("showFlash")
          localStorage.removeItem("message")
          localStorage.removeItem("typeStatus")
        })
        setTimeout(function () {
          this.showFlash = false;
          localStorage.removeItem("showFlash")
          localStorage.removeItem("message")
          localStorage.removeItem("message")
        }, 3000);
      }
    },

    paginateArticle(url) {
      fetch(`${url}`, {
        method: "GET"
      })
        .then(async (response) => {
          const data = await response.json();
          this.listArticle = data.data;
        })
    },

    // Get list all article
    getArticle() {

      this.isLoadingArticle = true;

      fetch(`${this.apiUrl}article`, {
        method: "GET"
      })
        .then(async (response) => {
          const data = await response.json();
          this.listArticle = data.data;
          this.listView = data.views;
          console.log(this.listView)

          // DOM
          // document.getElementById("all").classList.add('active');
          // document.getElementById("free").classList.remove('active');
          // document.getElementById("paid").classList.remove('active');

          this.isLoadingArticle = false;

        })
    },

    // load more feature
    loadMoreArticle() {
      this.isLoadingArticle = true;
      this.isLoadMore = true;
      setTimeout(() => {
        this.isLoadingArticle = false;
        this.isLoadMore = false;
        this.itemArticle += 3;
      }, 600)
    },

    checkExists(obj, id) {
      return obj.some(function (gfg) {
        return gfg.id === id;
      });
    },

    // Get detail article
    getDetailArticle(id) {
      this.isLoadingArticle = true;
      fetch(`${this.apiUrl}article/${id}`, {
        method: "GET",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
      })
        .then(async (response) => {
          const data = await response.json();
          if (data.status) {
            this.detailArticle = data.data;
            this.detailViews = data.views;
            console.log(this.detailViews)
          }
          else {
            // console.log(data.message);
          }
          this.isLoadingArticle = false;
          this.isLoading = false;
        })
        .catch(error => {
          console.log(error);
          this.isLoadingArticle = false;
        })
    },

    // Get detail sub-article
    getSubArticle(id = 1) {
      this.isLoading = true;
      fetch(`${this.apiUrl}sub-article/${id}`, {
        method: "GET",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
      })
        .then(async (response) => {
          const data = await response.json();
          if (!data.status) {
            this.fetchStatus = false;
            // localStorage.setItem('message', data.message);
            // localStorage.setItem('showFlash', true);
          }
          else {
            this.content = data.data;
            this.detailViews = data.views;
            this.fetchStatus = true;
          }
          this.isLoading = false;
        })
        .catch(error => {
          console.log(error);
          this.isLoading = false;
        })
    },

    // Get all categories
    async fetchCategory() {
      category = await fetch(`${this.apiUrl}category`);
      this.categoriesArticle = await category.json();
    },

    // Pagination category
    async fetchPaginationCategory() {
      this.isLoading = true;
      // category = await fetch(`${this.apiUrl}category`);
      // data = await category.json();
      fetch(`${this.apiUrl}category`, {
        method: 'GET',
      }).then(async (response) => {
        const data = await response.json();
        this.categoriesArticle = data.data;
        this.isLoading = false;
      })
    },

    // Sweet alert ?
    styleMessage(msg) {
      return `
        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
          <span class="span-danger">${msg}</span>
        </div>
      `
    },

    // Create article (user)
    async createArticle() {
      this.sub_article_err = '';
      this.isLoadingArticle = true;
      let title = document.getElementById('title');
      let description = tinymce.get('content').getContent();
      let thumbnail = document.getElementById('thumbnail').files[0];
      let category = document.getElementById('category_id');
      let type = document.getElementsByClassName('type');
      let title_sub = document.getElementsByClassName('title_sub');
      let thumbnail_sub = document.getElementsByClassName('thumbnail_sub');
      // let description_sub = document.getElementsByClassName('ck-content');

      let formData = new FormData();

      formData.append('title', title.value);
      formData.append('description', description);

      thumb_err = document.getElementById("err_thumb");
      thumb_err.innerHTML = '';

      if (thumbnail) {
        file_thumbnail = thumbnail;
        getTypeThumbnail = file_thumbnail.type;
        typeThumbnail = getTypeThumbnail.split('/')[0];
        if (typeThumbnail === 'image') {
          if (thumbnail.size > 1023546) {
            thumb_err.innerHTML += this.styleMessage(`Thumbnail not be greater than 1024 kilobytes.`);
          } else {
            formData.append('thumbnail', thumbnail);
          }
        } else {
          thumb_err.innerHTML += this.styleMessage(`Thumbnail must be image.`);
        }
      } else {
        thumb_err.innerHTML += this.styleMessage(`Thumbnail required.`);
      }

      // Type validation
      for (var i = 0, length = type.length; i < length; i++) {
        if (type[i].checked) {
          formData.append('type_sub[]', type[i].value);
        }
      }

      // Category validation
      if (category.selectedOptions.length > 0) {
        this.category_err = null;
      } else {
        this.category_err = { category: ['category cannot be empty!'] }
      }
      for (let i = 0; i < category.length; i++) {
        if (category.options[i].selected) {
          formData.append('category_id[]', category.options[i].value);
        }
      }
      for (let i = 0; i < title_sub.length; i++) {
        let data_id = title_sub[i].getAttribute("data-id");
        let accordion = document.getElementById(`accordionTitle${data_id}`);
        let tab = document.getElementById(`tab${data_id}`);

        accordion.style.border = 'none';

        titleSub = document.getElementById(`err_title${data_id}`);
        titleSub.innerHTML = '';

        thumbnailSub = document.getElementById(`err_thumbnail${data_id}`);
        thumbnailSub.innerHTML = '';

        description_sub = document.getElementById(`err_description${data_id}`);
        description_sub.innerHTML = '';

        if (title_sub[i].value != '') {
          this.status_sub_err = false;
          if (title_sub[i].value.trim().length > 255) {
            this.status_sub_err = true;
            tab.classList.remove("max-h-0");
            tab.classList.add("max-h-[1305px]");
            accordion.style.border = '1px solid #b91c1c';
            accordion.style.borderRadius = '10px';
            titleSub.innerHTML += this.styleMessage(`title sub article ${i + 1} not be greater than 255 character.`);
          } else {
            formData.append('title_sub[]', title_sub[i].value);
          }
        } else {
          this.status_sub_err = true;
          tab.classList.remove("max-h-0");
          tab.classList.add("max-h-[1305px]");
          accordion.style.border = '1px solid #b91c1c';
          accordion.style.borderRadius = '10px';
          titleSub.innerHTML += this.styleMessage(`title sub article ${i + 1} required.`);
        }
        if (thumbnail_sub[i].files[0]) {
          this.status_sub_err = false;
          file = thumbnail_sub[i].files[0];
          getType = file.type;
          type = getType.split('/')[0];
          if (type === 'image') {
            if (file.size > 1023546) {
              this.status_sub_err = true;
              tab.classList.remove("max-h-0");
              tab.classList.add("max-h-[1305px]");
              accordion.style.border = '1px solid #b91c1c';
              accordion.style.borderRadius = '10px';
              thumbnailSub.innerHTML += this.styleMessage(`Thumbnail sub article ${i + 1} not be greater than 1024 kilobytes.`);
            } else {
              formData.append('thumbnail_sub[]', thumbnail_sub[i].files[0]);
            }
          } else {
            this.status_sub_err = true;
            tab.classList.remove("max-h-0");
            tab.classList.add("max-h-[1305px]");
            accordion.style.border = '1px solid #b91c1c';
            accordion.style.borderRadius = '10px';
            thumbnailSub.innerHTML += this.styleMessage(`Thumbnail sub article ${i + 1} must be image.`);
          }
        } else {
          this.status_sub_err = true;
          tab.classList.remove("max-h-0");
          tab.classList.add("max-h-[1305px]");
          accordion.style.border = '1px solid #b91c1c';
          accordion.style.borderRadius = '10px';
          thumbnailSub.innerHTML += this.styleMessage(`Thumbnail sub article ${i + 1} required.`);
        }
        if (tinymce.get(`editor${data_id}`).getContent() != '') {
          this.status_sub_err = false;
          accordion.style.border = 'none';
          if (tinymce.get(`editor${data_id}`).getContent().trim().length < 100) {
            this.status_sub_err = true;
            tab.classList.remove("max-h-0");
            tab.classList.add("max-h-[1305px]");
            accordion.style.border = '1px solid #b91c1c';
            accordion.style.borderRadius = '10px';
            description_sub.innerHTML += this.styleMessage(`Description sub article ${i + 1} must be greater than 100 charcter.`);
          } else {
            formData.append('description_sub[]', tinymce.get(`editor${data_id}`).getContent());
          }
        } else {
          this.status_sub_err = true;
          tab.classList.remove("max-h-0");
          tab.classList.add("max-h-[1305px]");
          accordion.style.border = '1px solid #b91c1c';
          accordion.style.borderRadius = '10px';
          description_sub.innerHTML += this.styleMessage(`Description sub article ${i + 1} required`);
        }

        this.sub_article_err += `<br>`;
      }

      article = await fetch(`${this.apiUrl}article`, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
        body: formData
      })

      data = await article.json();
      if (!data.status) {
        this.showFlash = true;
        this.status_err = data.message;
        this.isLoadingArticle = false;
      }

      if (data.status) {
        this.isLoadingArticle = false;
        localStorage.setItem('message', 'article successfully created!');
        localStorage.setItem('showFlash', true);
        if (!this.category_err && !this.status_sub_err) {
          this.isLoadingArticle = false;
          return window.location.replace(`${this.baseUrl}myarticle`)
        }
      }
    },

    // Sort article by abjad
    sort(col) {
      if (this.sortCol === col) this.sortAsc = !this.sortAsc;
      this.sortCol = col;
      let repeatIcon = document.getElementById("repeatIcon")
      this.categoriesArticle.data.sort((a, b) => {
        if (a[this.sortCol] < b[this.sortCol]) {
          repeatIcon.classList.add("active");
          return this.sortAsc ? 1 : -1
        };
        if (a[this.sortCol] > b[this.sortCol]) {
          repeatIcon.classList.remove("active");
          return this.sortAsc ? -1 : 1
        };
        repeatIcon.classList.remove("active");
        return 0;
      });
    },

    // Paginate category ?
    paginate(url) {
      fetch(`${url}`, {
        method: "GET"
      })
        .then(async (response) => {
          const data = await response.json();
          this.categoriesArticle = data.data;
        })
    },

    // Search Category
    searchCategory() {
      this.isLoading = true;
      fetch(`${this.apiUrl
        }category?search=${this.search}`, {
        method: "GET"
      })
        .then(async (response) => {
          const data = await response.json();
          this.categoriesArticle = data.data;
          this.isLoading = false
        })
    },

    // Get all categories
    getCategories(addMore=false) {

      if(addMore == true){
        this.limitcategory+=4
      }

      fetch(`${this.apiUrl
        }allCategory`, {
        method: "GET"
      })
        .then(async (response) => {
          const data = await response.json();
          let limitcategoriesArticle = data.data
          //   this.categoriesArticle = data.data;
          this.categoriesArticle = [];

          limitcategoriesArticle.map((data, index)=>{
            if(index<this.limitcategory) {
                this.categoriesArticle.push(data)
            }

          })

        })

    },


    // FILTERS

    filterArticle() {
      query = '';

      if (this.filtersKey[0] && this.filtersKey[0] != '') {
        query += 'search=' + this.filtersKey[0] + '&';
      }
      if (this.filtersKey[1] && this.filtersKey[1] != '') {
        query += 'type=' + this.filtersKey[1] + '&';
      }
      if (this.filtersKey[2] && this.filtersKey[2] != '') {
        query += 'category=' + this.filtersKey[2] + '&';
      }
      if (this.filtersKey[3] && this.filtersKey[3] != '') {
        query += 'author=' + this.filtersKey[3] + '&';
      }

      this.isLoadingArticle = true;

      fetch(`${this.apiUrl}article?${query}`, {
        method: 'GET',
      })
        .then(async (response) => {
          const data = await response.json();

          if (data.status) {
            this.listArticle = data.data;
          }
          else {
            this.listArticle = data.data;
            this.showFlash = true;
            this.message = data.message;
          }

          setTimeout(() => {
            this.showFlash = false;
            this.message = false;
          }, 4000);

          console.log(this.listArticle);

          this.isLoadingArticle = false;
        }).catch(error => {
          console.log(error);
          this.isLoadingArticle = false;
        })

    },

    // Search article by keyword
    searchArticle(keyword) {

      this.isLoadingArticle = true;

      fetch(`${this.apiUrl}article?search=${keyword}`, {
        method: 'GET',
      })
        .then(async (response) => {
          const data = await response.json();
          this.listArticle = data.data;
          this.isLoadingArticle = false;
        })

    },

    // Get free article
    getFreeArticle() {

      this.isLoadingArticle = true;

      fetch(`${this.apiUrl}article?type=free`, {
        method: "GET"
      })
        .then(async (response) => {
          const data = await response.json();
          this.listArticle = data.data;

          // DOM
          // document.getElementById("all").classList.remove('active');
          // document.getElementById("free").classList.add('active');
          // document.getElementById("paid").classList.remove('active');

          this.isLoadingArticle = false;

        })
    },

    // Get paid article
    getPaidArticle() {

      this.isLoadingArticle = true;

      fetch(`${this.apiUrl}article?type=paid`, {
        method: "GET"
      })
        .then(async (response) => {
          const data = await response.json();
          this.listArticle = data.data

          // DOM
          // document.getElementById("all").classList.remove('active');
          // document.getElementById("free").classList.remove('active');
          // document.getElementById("paid").classList.add('active');

          this.isLoadingArticle = false;

        })
    },

    // filter article by category
    fetchArticleByCategory(categoryId) {

      this.isLoadingArticle = true;

      fetch(`${this.apiUrl}article?category=${categoryId}`, {
        method: "GET"
      })
        .then(async (response) => {
          const data = await response.json();
          this.listArticle = data.data;
          this.isLoadingArticle = false;

          this.getCategories();

          // for (let index = 0; index < this.categoriesArticle.length; index++) {
          //   if (this.categoriesArticle[index].id === categoryId) {
          //     document.getElementById(`category${ categoryId }`).classList.add('active');
          //   } else {
          //     document.getElementById(`category${ this.categoriesArticle[index].id }`).classList.remove('active');
          //   }
          // }

        })

    },

    // Reset filters
    resetFilters() {
      // document.getElementById('search').value = null;
      // document.getElementById('category').value = '';
      // document.getElementById('free').checked = false;
      // document.getElementById('paid').checked = false;

      this.filtersKey = [];
      this.getArticle();
    },

    index: 1,
    total: 1,

    radioType(index, val) {
      type = document.getElementById(`type${index}`);
      type.innerHTML = '';
      type.innerHTML = `(${val})`;
    },

    // Create sub-article (user)
    createSubArticle(refs) {
      refs.listsubarticle.insertAdjacentHTML('beforeend', `
            <li class="relative bg-white dark:bg-slate-secondary rounded-lg my-2 shadow-[0px_0px_4px_rgba(0,0,0,0.25)] accordion" id="${`accordion` + this.index}" x-data="accordion(${this.index})">

                <ul id="errorSubArticle${this.index}" class="absolute top-full border border-primary dark:border-none bg-white shadow-[0px_0px_4px_rgba(0,0,0,0.25)] dark:shadow-none dark:text-slate-primary rounded-primary max-w-[400] py-2 px-4" style="transform: scale(0); opacity: 0; z-index: 50">
                    <li class="font-medium text-base mb-4">
                        <p>
                            <span class="span">E</span>rrors
                        </p>
                    </li>
                </ul>

                <h2
                id="${`accordionTitle${this.index}`}"
                class="flex flex-row justify-between items-center font-semibold px-3 py-2 cursor-pointer"
                >
                    <span>Sub Article ${this.index} <span id="type${this.index}">(Free)</span></span>
                    <div class="translate-y-1 flex items-center">
                        <span class="p-1 rounded-full text-gray-secondary hover:text-opacity-60" @click="deleteSubArticle(${this.index})">
                            <ion-icon name="trash-outline" class="w-6 h-6 text-primary dark:text-white dark:hover:text-opacity:75"></ion-icon>
                        </span>
                        <span
                        :class="handleRotate()"
                        @click="handleClick()"
                        class="-mt-[6px] h-6 w-6 transform transiton-transform duration-200 ease-in-out"
                        title="Open"
                        style="transform: translateY(-3px)"
                        >
                            <ion-icon name="chevron-down-circle-outline" class="w-full h-full text-primary dark:text-white dark:hover:text-opacity:75"></ion-icon>
                        </span>
                    </div>
                </h2>

                <div
                id="tab${this.index}"
                x-ref="tab"
                :style="handleToggle()"
                class="px-4 overflow-y-scroll has-scrollbar overflow-x-hidden max-h-0 duration-500 transition-all"
                >
                    <div class="mt-4 flex flex-wrap lg:flex-nowrap">
                        <div class="mb-5 col-12 lg:col-12">
                            <label for="text" class="text-md">Title</label>
                            <input required data-id="${this.index}" type="text" placeholder="Your text..."
                                class="title_sub dark:text-white px-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] dark:shadow-none dark:border-white rounded-primary bg-white border-none dark:bg-slate-primary border border-white hover:bg-white mt-4">
                                <div id="err_title${this.index}"></div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="text" class="text-md">Thumbnail</label>
                        <input required accept="image/*" class="thumbnail_sub" type="file" name="thumbnail" placeholder="Your thumbnail..."
                            hidden
                            id="file${this.index}">
                        <span
                            class="relative cursor-pointer flex items-center justify-center h-[300px] md:h-[400px] lg:h-[500px] px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] dark:shadow-none dark:border dark:border-white rounded-primary bg-white border border-primary dark:bg-slate-primary mt-4 overflow-y-hidden"
                            id="buttonClickImage${this.index}"
                        >
                            <img src=""
                            id="image${this.index}" class="absolute w-full h-full rounded-lg object-cover" alt="" onerror="this.style.opacity = 0" onload="this.style.opacity = 1">
                            <div class="text-center"
                            id="iconimage${this.index}">
                                <i
                                data-feather="image"
                                class="w-[100px] h-[100px] lg:h-[100px] mx-auto text-primary dark:text-white"
                                >
                                </i>
                                <span class="block mt-4">
                                    <b class="span dark:text-white">Click to Upload</b> <br> <p class="text-sm font-semibold">(SVG, PNG, JPG, JPEG)</p>
                                </span>
                            </div>
                            <div class="text-center"
                            id="iconimageerror${this.index}" style="display: none">
                              <i
                              data-feather="alert-circle"
                              class="w-[100px] h-[100px] lg:h-[100px] mx-auto text-primary dark:text-white"
                              >
                              </i>
                              <span class="block mt-4">
                                  <b class="span dark:text-white">Oops!</b> You cannot input anything other than images. <br>
                                  <b>Please Click Again</b>
                              </span>
                            </div>
                            <p
                                class="filename absolute w-full -bottom-full py-2 bg-primary text-white text-center font-semibold rounded-b-lg transition duration-200 ease-in-out"
                                id="filename${this.index}"
                            >
                            </p>
                        </span>
                        <div id="err_thumbnail${this.index}"></div>
                    </div>

                    <div class="mb-5 col-12" id="content${this.index}" class="content${this.index}">
                        <label for="text" class="text-md">Content</label><br>
                        <textarea id="editor${this.index}" placeholder="Your content..."
                        class="description_sub px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] dark:shadow-none dark:border dark:border-white rounded-primary bg-white">
                        </textarea>
                        <div id="err_description${this.index}"></div>
                    </div>

                    <div class="mb-5 col-12">
                        <span class="text-md">Choose Your Plan</span>
                        <div class="flex items-center gap-2 mt-2">
                            <label for="free" class="flex items-center gap-1">
                                <input class="type checked:bg-primary dark:checked:bg-slate-third" type="radio" name="status${this.index}" value="free" id="free${this.index}" x-on:change="radioType(${this.index}, $event.target.value)" checked>
                                <span class="text-base">Free</span>
                            </label>
                            <label for="paid" class="flex items-center gap-1">
                                <input class="type checked:bg-primary dark:checked:bg-slate-third" type="radio" name="status${this.index}" value="paid" id="paid${this.index}" x-on:change="radioType(${this.index}, $event.target.value)">
                                <span class="text-base">Member-Only</span>
                            </label>
                        </div>
                        <p class="mt-4">*Get Royalty for Author</p>
                    </div>

                </div>
            </li>
        `);

      feather.replace()

      let file = document.getElementById(`file${this.index}`);
      let filename = document.getElementById(`filename${this.index}`);
      let image = document.getElementById(`image${this.index}`);
      let iconimage = document.getElementById(`iconimage${this.index}`);
      let iconimageerror = document.getElementById(`iconimageerror${this.index}`);
      let buttonClickImage = document.getElementById(`buttonClickImage${this.index}`);

      buttonClickImage.addEventListener("click", function () {
        file.click();
      })

      document.getElementById(`file${this.index}`).addEventListener("change", () => {
        if (file) {

          iconimage.style.display = 'none';
          var reader = new FileReader();
          reader.readAsDataURL(file.files[0]);
          reader.addEventListener("load", (e) => {
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if (!allowedExtensions.exec(file.files[0].name)) {
              iconimageerror.style.display = 'block';
              image.src = '';
              image.alt = '';
              filename.classList.remove('active');
              filename.innerText = '';
              removefile.classList.remove('active')
            } else {
              image.setAttribute("src", e.target.result);
              image.setAttribute("alt", e.target.result);
              filename.classList.add('active');
              filename.innerText = file.files[0].name;
            }
          })

          // $refs.iconimage${this.index}.style.display = 'none';
          // var reader = new FileReader();
          // reader.readAsDataURL($refs.file${this.index}.files[0]);
          // reader.onload = function (e) {
          //     $refs.image${this.index}.src = e.target.result;
          //     $refs.image${this.index}.alt = $refs.file${this.index}.name;
          //     $refs.filename${this.index}.classList.add('active');
          //     $refs.filename${this.index}.innerText = $refs.file${this.index}.files[0].name;
          // }
        }
      })

      tinymce.init({
        selector: `#editor${this.index}`,
        plugins: 'anchor autolink code codesample formatselect charmap preview fullscreen emoticons image link lists media searchreplace table wordcount',
        height: '600px',
        force_br_newlines: true,
        force_p_newlines: false,
        forced_root_block: false,
        cleanup: true,
      });

      let title_sub = document.getElementsByClassName('title_sub');
      if (this.total > 3) {
        for (let i = 0; i < this.total; i++) {
          let data_id = title_sub[i].getAttribute("data-id");
          if (i <= 2) {
            type = document.getElementById(`type${data_id}`);
            type.innerHTML = '';
            type.innerHTML = '(Free)';
            document.getElementById(`free${data_id}`).checked = true;
            document.getElementById(`paid${data_id}`).disabled = true;
          }
        }
      }
      this.index++;
      this.total++;

    },

    // Delete sub-article (user)
    deleteSubArticle(id) {
      let parentElement = document.getElementById('listsubarticle');
      parentElement.querySelector(`#accordion${id}`).remove();
      this.total -= 1;
      let title_sub = document.getElementsByClassName('title_sub');
      if (this.total < 5) {
        for (let i = 0; i < this.total; i++) {
          let data_id = title_sub[i].getAttribute("data-id");
          document.getElementById(`paid${data_id}`).disabled = false;
        }
      }
    }

  }))

  Alpine.data('admin', () => ({
    isLogedIn: false,
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    imgUrl: "http://127.0.0.1:8001/",
    data_user: [],
    data_admin: [],
    years: [],
    user_chart: [],
    payment_chart: [],
    status_err: [],
    listOrder: [],
    showFlash: false,
    isLoading: false,
    message: '',
    keyword: '',

    // Flash admin
    flash() {
      this.showFlash = false;
      if (localStorage.getItem('showFlash')) {
        this.showFlash = true;
        this.message = localStorage.getItem('message');
        setTimeout(function () {
          localStorage.removeItem("showFlash")
          localStorage.removeItem("message")
          localStorage.removeItem("typeStatus")
          this.showFlash = false;
        }, 3000);
      }
    },

    //  Check if token exist and set isLogedIn session to true
    checkSession() {
      const token = localStorage.getItem('token')
      this.isLogedIn = token ? true : false

      if (!this.isLogedIn) {
        // Fetch API Check Token

        return window.location.replace(this.baseUrl + 'login')
      }
    },

    // Check if logged in user role is admin
    checkRole() {
      fetch(this.apiUrl + 'me', {
        method: "GET",
        headers: {
          'Content-Type': 'application/json',
          'Authorization': localStorage.getItem('token')
        },
      })
        .then(async response => {
          user = await response.json();
          this.data_user = user.data
          if (this.data_user.role != 1) {
            return window.history.back()
          }
        });
    },

    // Its same as checkRole()
    checkIsAdmin() {
      fetch(this.apiUrl + 'me', {
        method: "GET",
        headers: {
          'Content-Type': 'application/json',
          'Authorization': localStorage.getItem('token')
        },
      })
        .then(async response => {
          user = await response.json();
          this.data_user = user.data
          if (this.data_user.role == 1) {
            return window.history.back()
          }
        });
    },

    // Fetch admin data
    fetchAdminData() {
      this.isLoading = true;
      fetch(`${this.apiUrl}admin`, {
        method: "GET",
        headers: {
          'Authorization': localStorage.getItem('token'),
        }
      })
        .then(async (response) => {
          const data = await response.json();

          if (data.status) {
            this.data_admin = data.data;
            this.fetchChart();
            // this.showFlash = true;
            // this.typeStatus = true;
            localStorage.setItem("typeStatus", true)
          }
          else {
            localStorage.setItem('message', data.message);
            localStorage.setItem('showFlash', true);
            this.typeStatus = false;
            localStorage.setItem("typeStatus", false)
          }
          this.isLoading = false;
        })
        .catch()
    },

    // Make chart based on admin data
    fetchChart() {
      const barChart = document.getElementById('barChart');
      const lineChart = document.getElementById('lineChart');

      let user = this.data_admin.user_chart;
      let payment = this.data_admin.payment_chart;

      if (user == null || user.length == 0) {
        user = [{ year: '' + new Date().getFullYear(), count: 0 }]
      }

      if (payment == null || payment.length == 0) {
        payment = [{ year: '' + new Date().getFullYear(), count: 0 }]
      }

      this.years[0] = user[0] ? user[0].year : new Date().getFullYear();
      let endyear = new Date().getFullYear() - this.years[0];

      for (let i = 0; i < endyear; i++) {
        this.years.push(parseInt(this.years[i]) + 1);
      }

      this.user_chart = [];
      this.payment_chart = [];
      for (let i = 0; i < endyear + 1; i++) {

        if (user[i] && user[i].year == this.years[i]) {
          this.user_chart.push(user[i].count);
        }
        else {
          this.user_chart.push(0);
        }

        if (payment[i] && payment[i].year == this.years[i]) {
          this.payment_chart.push(payment[i].count);
        }
        else {
          this.payment_chart.push(0);
        }

      }

      // Chart.defaults.backgroundColor = '#7C000B';
      // Chart.defaults.borderColor = '#fff';
      // Chart.defaults.color = '#000';

      new Chart(barChart, {
        type: 'bar',
        data: {
          labels: this.years,
          datasets: [
            {
              label: 'Total Members',
              data: this.user_chart,
              borderWidth: 1,
              backgroundColor: '#7C000B',
            },
            {
              label: 'Total Orders',
              data: this.payment_chart,
              borderWidth: 1,
              backgroundColor: 'lightgreen',
            },
          ]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        },
      });

      new Chart(lineChart, {
        type: 'line',
        data: {
          labels: this.years,
          datasets: [
            {
              label: 'Total Members',
              data: this.user_chart,
              borderWidth: 1,
              backgroundColor: '#7C000B',
            },
            {
              label: 'Total Orders',
              data: this.payment_chart,
              borderWidth: 1,
              backgroundColor: 'lightgreen',
            },
          ]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        },
      });
    },

    // ORDERS

    convertDate(date) {

      const months = ["Jan", "Feb", "March", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"];
      let tanggal = new Date(date);
      let month = months[tanggal.getMonth()];

      fullDate = month + ' ' + tanggal.getDate() + ' ,' + tanggal.getFullYear();

      return fullDate;

    },

    // Fetch all user order
    fetchListOrder() {
      this.isLoading = true;
      fetch(`${this.apiUrl}payment`, {
        method: 'GET',
        headers: {
          Authorization: localStorage.getItem('token'),
        }
      })
        .then(async response => {
          const data = await response.json();
          this.listOrder = data.data;
          this.isLoading = false;
        })
        .catch(error => {
          console.log(error);
          this.isLoading = false;
        })

    },

    // Show detail order on modal
    showOrder(val, id = 0) {
      let modal = document.getElementById("modal");

      let nameOrder = document.getElementById("nameOrder");
      let emailOrder = document.getElementById("emailOrder");
      let planOrder = document.getElementById("planOrder");
      let priceOrder = document.getElementById("priceOrder");
      let vaOrder = document.getElementById("vaOrder");
      let paymentDateOrder = document.getElementById("paymentDateOrder");

      if (id === 0) {
        nameOrder.value = '';
        emailOrder.value = '';
        vaOrder.value = 0;
        priceOrder = 0;
        paymentDateOrder.value = '';
      }

      if (val) {
        fadeIn(modal);
      } else {
        fadeOut(modal);
      }
      fetch(`${this.apiUrl}payment/${id}/show`, {
        method: "GET",
        headers: {
          'Content-Type': 'application/json',
          'Authorization': localStorage.getItem('token')
        }
      })
        .then(async (response) => {
          const data = await response.json();

          nameOrder.innerText = data.data.user.name ? data.data.user.name : "User hasn't name yet";
          emailOrder.innerText = data.data.user.email ? data.data.user.email : "User hasn't email yet";
          planOrder.innerText = data.data.plan.name;
          priceOrder.innerText = '$' + data.data.total_price;
          vaOrder.innerText = data.data.virtual_account_number;
          paymentDateOrder.innerText = this.convertDate(data.data.payment_date);

        })
        .catch(error => {
          console.log(error);
        })
    },


    // FILTERING ORDERS

    // Sort order list
    sortOrder(col = 'payment_date') {
      if (this.sortCol === col) this.sortAsc = !this.sortAsc;
      this.sortCol = col;
      this.listOrder.data.sort((a, b) => {
        if (a[this.sortCol] < b[this.sortCol]) return this.sortAsc ? 1 : -1;
        if (a[this.sortCol] > b[this.sortCol]) return this.sortAsc ? -1 : 1;
        return 0;
      });
    },

    // Order list search feature
    searchOrder(keyword) {
      fetch(`${this.apiUrl}payment?search=${keyword}`, {
        method: 'GET',
        headers: {
          Authorization: localStorage.getItem("token"),
        }
      })
        .then(async (response) => {
          const data = await response.json();
          this.listOrder = data.data
        })
        .catch(error => {
          console.log(error);
        })

    },

  }))

  Alpine.data('helpers', () => ({
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    imgUrl: "http://127.0.0.1:8001/",

    // Convert expired month from number of month to string years / month
    convertExpiredPlan(time = 1) {
      if (time >= 12) {
        if (time == 12) {
          return 'Yearly';
        } else if (time >= 12 * 2) {
          return time + " Years"
        }
      } else if (time <= 12 && time > 1) {
        return time + ' Months'
      }
      return 'Unlimited';
    },

    // Convert laravel timestamp to readable string date
    convertDate(date) {

      const months = ["Jan", "Feb", "March", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"];
      let tanggal = new Date(date);
      let month = months[tanggal.getMonth()];

      fullDate = month + ' ' + tanggal.getDate() + ' ,' + tanggal.getFullYear();

      return fullDate;

    },

    // I dont know what is this
    convertCurrencyUsd(money) {
      let currency = '$' + money.toFixed(2);
      return currency;
    },

    // Cut some long text as long as inputted length
    substring(string, max = 10) {
      const text = string.textContent
      if (string.length > max) {
        return string.substring(0, max) + "..."
      }
      return string;
    },

    // Check if text is string (not html text)
    checkString(string) {
      const parser = new DOMParser();
      const doc = parser.parseFromString(string, 'text/html');
      const hasHTMLTag = doc.body.childNodes.length > 0;
    },

    // Convert tinyMce content with html tag to original string
    parseToOriginalString(string, max = 10) {
      const stringWithoutHTML = string.replace(/<[^>]+>/g, '');
      if (stringWithoutHTML.length > max) {
        return stringWithoutHTML.substring(0, 150) + '...';
      }
      return stringWithoutHTML
    },

    // Dark mode
    darkMode() {
      // On page load or when changing themes, best to add inline in `head` to avoid FOUC
      if (localStorage.theme == 'dark') {
        document.documentElement.classList.add('light')
        document.documentElement.classList.remove('dark')
        localStorage.theme = 'light'
        document.getElementById("buttonMode").setAttribute("title", "Light Mode")
        document.getElementById("iconMode").setAttribute("src", this.baseUrl + "assets/images/icons/moon.svg")
      } else {
        document.documentElement.classList.add('dark')
        document.documentElement.classList.remove('light')
        localStorage.theme = 'dark'
        document.getElementById("buttonMode").setAttribute("title", "Dark Mode")
        document.getElementById("iconMode").setAttribute("src", this.baseUrl + "assets/images/icons/sun.svg")
      }
    },

    firstName(string) {
      let firstName = string.match(/^\w+/)[0];

      return firstName;
    }

  }))
})
