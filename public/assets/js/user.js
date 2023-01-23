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
    data_user: [],
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
    itemMyArticle: 3,
    myTransactions: [],
    message: '',
    categories: [],

    flash() {
      if (localStorage.getItem('showFlash')) {
        this.showFlash = true;
        this.message = localStorage.getItem('message');
        window.addEventListener("beforeunload", function () {
          this.showFlash = true;
          localStorage.removeItem("typeStatus")
        });
        setTimeout(() => {
          this.showFlash = false;
          localStorage.removeItem("showFlash");
          localStorage.removeItem("message");
        }, 4000);
      }
    },

    name: '',
    username: '',
    email: '',
    password: '',
    // photo: '',
    link_facebook: '',
    link_linkedin: '',
    link_instagram: '',
    link_twitter: '',

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
            this.link_facebook = user.data.link_facebook == null ? '' : user.data.link_facebook
            this.link_linkedin = user.data.link_linkedin == null ? '' : user.data.link_linkedin
            this.link_instagram = user.data.link_instagram == null ? '' : user.data.link_instagram
            this.link_twitter = user.data.link_twitter == null ? '' : user.data.link_twitter
            this.isLoading = false;
          }
        });
    },

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

    checkAuth() {
      const token = localStorage.getItem('token')
      this.isLogedIn = token ? true : false
    },

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

    setTiny(id, text) {
      tinymce.get(id).setContent(text);
    },

    updateMe() {
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

    searchPlan(keyword) {
      // fetch(`${this.apiUrl}category`, {
      //   method: 'GET',
      //   headers: {
      //     Authorization: localStorage.getItem('token'),
      //   }
      // })
      //   .then(async (response) => {
      //     const data = await response.json();
      //     console.log(data);
      //   })
    },

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

    fetchMyArticle() {
      let url = window.location.href;
      let id = url.substring(url.lastIndexOf('/') + 1);

      fetch(`${this.apiUrl
        }article/${id}`, {
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

    loadMoreMyArticle() {
      this.isLoadingMyArticle = true;
      this.isLoadMore = true;
      setTimeout(() => {
        this.isLoadingMyArticle = false;
        this.isLoadMore = false;
        this.itemMyArticle += 3;
      }, 600)
    },

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
            this.listMyArticle = data;
            this.isLoading = false;

          })

    },

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
            this.EditArticle = data.data;
            this.categories = data.category;
            this.isLoading = false;

          })

    },

    updateArticle() {
      let editA = this.EditArticle;
      editA.description = tinymce.get('content').getContent();

      if (typeof editA.thumbnail !== 'string' && editA.thumbnail[0]) {
        editA.thumbnail = editA.thumbnail[0];
      }

      let formData = new FormData();

      formData.append('category_id[]', document.getElementById('category_id').value);
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

          if (!data.status) {
            this.status_err[0] = data.message;
          }
          else {
            this.status_err[0] = null;
            this.showFlash = true;
            this.message = data.message;
            setTimeout(() => {
              this.showFlash = false;
            }, 4000);
          }
          this.isLoading = false;
        }).catch(error => {
          console.log(error);
          this.isLoading = false;
        })

    },

    addSub() {
      let id = 0;
      let article_id = this.EditArticle.id;
      let title = '';
      let type = '';
      let description = '';
      let thumbnail = '';
      return { id, article_id, title, type, description, thumbnail };
    },

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

          if (!sub.status) {
            this.status_err[1] = sub.message;
          }
          else {
            editSub.id = sub.data.id;
            this.status_err[1] = null;
            this.message = sub.message;
            this.showFlash = true;
            setTimeout(() => {
              this.showFlash = false;
            }, 4000);
          }
          this.isLoading = false;
        })

    },

    deleteArticle(id) {
      this.isLoading = true;

      const token = localStorage.getItem('token')
      fetch(this.apiUrl + 'article/' + id + '/delete', {
        method: "POST",
        headers: {
          'Authorization': token
        }
      })
        .then((response) => {
          this.isLoading = false;
          this.fetchListMyArticle();
          // window.location.replace(this.baseUrl + 'myarticle')
        });
    },

    deleteSub(delSub) {
      this.isLoading = true;

      const token = localStorage.getItem('token')
      fetch(this.apiUrl + 'sub-article/' + delSub + '/delete', {
        method: "POST",
        headers: {
          'Authorization': token
        }
      })
        .then((response) => {
          this.isLoading = false;
          this.fetchListMyArticle();
          // window.location.replace(this.baseUrl + 'myarticle')
        });
    },

    //pay subscription
    plan: '',
    plan_id: '',
    paySubscription() {
      const data = new FormData()
      data.append('plan', this.plan)
      let plan_id = this.plan
      fetch(this.apiUrl + 'payment?plan_id=' + plan_id, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token'),
        }
      })

        .then((response) => {
          if (response.ok) {
            // Swal.fire({
            //   position: 'top-end',
            //   icon: 'success',
            //   title: 'Transaction Process',
            //   showConfirmButton: false,
            //   timer: 1500
            // })
            window.location.replace(this.baseUrl + 'transaction/details')
          } else {
            // Swal.fire({
            //   icon: 'error',
            //   title: 'Choose Plan First!',
            //   confirmButtonColor: 'primary',
            //   position: 'center'
            // })
          }
        });

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
          } else if (this.myTransactions[0] != null && lastPath == '/transaction') {
            window.location.replace(`${this.baseUrl}transaction/details`)
          }
          return;
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
            localStorage.setItem('showFlash', true)
            localStorage.setItem('message', data.message);
            window.location.replace(`${this.baseUrl}profile`);
          }
        })
        .catch(error => {
          console.log(error.message);
        })
    },

    selectedPlan(item = null) {

      var elements = document.querySelectorAll(".cardplan");
      for (var i = 0; i < elements.length; i++) {
        elements[i].classList.remove("active");
        document.querySelectorAll(".selectplan")[i].innerText = "Select"
      }

      document.getElementById(`plan${item.id}`).click();
      document.getElementById(`cardplan${item.id}`).classList.add('active');
      document.getElementById(`selectedplan${item.id}`).innerText = 'Selected';
    }

  }))

  Alpine.data('articles', () => ({
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    imgUrl: "http://127.0.0.1:8001/",
    listArticle: [],
    categoriesArticle: [],
    detailArticle: null,
    isLoadingArticle: false,
    isLoadMore: false,
    isLoading: false,
    itemArticle: 3,
    content: false,
    fetchStatus: true,
    back: false,
    showFlash: false,
    message: '',

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

    // INPUTS ARTICLE
    keywordArticle: '',

    getArticle() {

      this.isLoadingArticle = true;

      fetch(`${this.apiUrl}article`, {
        method: "GET"
      })
        .then(async (response) => {
          const data = await response.json();
          this.listArticle = data.data;

          // DOM
          // document.getElementById("all").classList.add('active');
          // document.getElementById("free").classList.remove('active');
          // document.getElementById("paid").classList.remove('active');

          this.isLoadingArticle = false;

        })
    },

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

    loadMoreArticle() {
      this.isLoadingArticle = true;
      this.isLoadMore = true;
      setTimeout(() => {
        this.isLoadingArticle = false;
        this.isLoadMore = false;
        this.itemArticle += 3;
      }, 600)
    },

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
          }
          else {
            console.log(data.message);
          }
          this.isLoadingArticle = false;
          this.isLoading = false;
        })
        .catch(error => {
          console.log(error);
          this.isLoadingArticle = false;
        })
    },

    async getSubArticle(id = 1) {
      this.isLoading = true;
      await fetch(`${this.apiUrl}sub-article/${id}`, {
        method: "GET",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
      })
        .then(async (response) => {
          const data = await response.json();
          if (!data.status) {
            this.fetchStatus = false;
            console.log('test', this.fetchStatus);
            // localStorage.setItem('message', data.message);
            // localStorage.setItem('showFlash', true);
          }
          else {
            this.content = data.data;
            this.fetchStatus = true;
          }
          this.isLoading = false;
        })
        .catch(error => {
          console.log(error);
          this.isLoading = false;
        })
    },

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

    async fetchCategory() {
      category = await fetch(`${this.apiUrl}category`);
      this.categoriesArticle = await category.json();
    },
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

    async createArticle() {
      this.isLoadingArticle = true;
      let title = document.getElementById('title');
      let description = tinymce.get('content').getContent();
      let thumbnail = document.getElementById('thumbnail').files[0];
      let category = document.getElementsByClassName('categories');
      let type = document.getElementsByClassName('type');
      let title_sub = document.getElementsByClassName('title_sub');
      let thumbnail_sub = document.getElementsByClassName('thumbnail_sub');
      // let description_sub = document.getElementsByClassName('ck-content');

      let formData = new FormData();
      formData.append('title', title.value);
      formData.append('description', description);
      formData.append('thumbnail', thumbnail);
      for (var i = 0, length = type.length; i < length; i++) {
        if (type[i].checked) {
          formData.append('type_sub[]', type[i].value);
        }
      }
      for (let i = 0; i < category.length; i++) {
        if (category[i].value == '') {
          this.category_err = { category: ['category cannot be empty!'] }
        } else {
          this.category_err = null;
        }
        formData.append('category_id[]', category[i].value);
      }
      for (let i = 0; i < title_sub.length; i++) {
        let data_id = title_sub[i].getAttribute("data-id");
        formData.append('title_sub[]', title_sub[i].value);
        formData.append('thumbnail_sub[]', thumbnail_sub[i].files[0]);
        formData.append('description_sub[]', tinymce.get(`editor${data_id}`).getContent());
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
      }
      if (!this.category_err) {
        this.isLoadingArticle = false;
        return window.location.replace(`${this.baseUrl}myarticle`)
      }
    },

    // CATEGORIES ARTICLE
    sortCol: null,
    sortAsc: false,
    search: '',
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
    paginate(url) {
      fetch(`${url}`, {
        method: "GET"
      })
        .then(async (response) => {
          const data = await response.json();
          this.categoriesArticle = data.data;
        })
    },
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
    getCategories() {

      fetch(`${this.apiUrl
        }allCategory`, {
        method: "GET"
      })
        .then(async (response) => {
          const data = await response.json();
          this.categoriesArticle = data.data;
        })

    },

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

    // FILTERS

    resetFilters(typeArticle = '') {

      let categories = document.querySelectorAll('.category');

      document.getElementById('free').checked = false;
      document.getElementById('paid').checked = false;

      for (let index = 0; index < categories.length; index++) {
        if (categories[index].classList.contains('active')) {
          categories[index].classList.remove('active');
        }
      }

      this.keywordArticle = '';
      this.getArticle();
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

    checkSession() {
      const token = localStorage.getItem('token')
      this.isLogedIn = token ? true : false

      if (!this.isLogedIn) {
        // Fetch API Check Token

        return window.location.replace(this.baseUrl + 'login')
      }
    },

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
            // localStorage.setItem("typeStatus", true)
          }
          // else {
          //   localStorage.setItem('message', data.message);
          //   localStorage.setItem('showFlash', true);
          //   this.typeStatus = false;
          //   localStorage.setItem("typeStatus", false)
          // }
          this.isLoading = false;
        })
    },

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
        });

    },

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
    },

    // FILTERING ORDERS

    sortOrder(col = 'payment_date') {
      if (this.sortCol === col) this.sortAsc = !this.sortAsc;
      this.sortCol = col;
      this.listOrder.data.sort((a, b) => {
        if (a[this.sortCol] < b[this.sortCol]) return this.sortAsc ? 1 : -1;
        if (a[this.sortCol] > b[this.sortCol]) return this.sortAsc ? -1 : 1;
        return 0;
      });
    },

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

    },

  }))

  Alpine.data('helpers', () => ({
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    imgUrl: "http://127.0.0.1:8001/",

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

    convertDate(date) {

      const months = ["Jan", "Feb", "March", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"];
      let tanggal = new Date(date);
      let month = months[tanggal.getMonth()];

      fullDate = month + ' ' + tanggal.getDate() + ' ,' + tanggal.getFullYear();

      return fullDate;

    },

    convertCurrencyUsd(money) {
      let currency = '$' + money.toFixed(2);
      return currency;
    },

    substring(string, max = 10) {
      const text = string.textContent
      if (string.length > max) {
        return string.substring(0, max) + "..."
      }
      console.log(string);
      return string;
    },

    checkString(string) {
      const parser = new DOMParser();
      const doc = parser.parseFromString(string, 'text/html');
      const hasHTMLTag = doc.body.childNodes.length > 0;
      console.log(hasHTMLTag, string);
    },

    parseToOriginalString(string, max = 10) {
      const stringWithoutHTML = string.replace(/<[^>]+>/g, '');
      if (stringWithoutHTML.length > max) {
        return stringWithoutHTML.substring(0, 150) + '...';
      }
      return stringWithoutHTML
    },

    darkMode() {
      // On page load or when changing themes, best to add inline in `head` to avoid FOUC
      if (localStorage.theme == 'dark') {
        document.documentElement.classList.add('light')
        document.documentElement.classList.remove('dark')
        localStorage.theme = 'light'
        document.getElementById("buttonMode").setAttribute("title", "Light Mode")
        document.getElementById("iconMode").setAttribute("src", this.baseUrl + "assets/images/icons/sun.svg")
      } else {
        document.documentElement.classList.add('dark')
        document.documentElement.classList.remove('light')
        localStorage.theme = 'dark'
        document.getElementById("buttonMode").setAttribute("title", "Dark Mode")
        document.getElementById("iconMode").setAttribute("src", this.baseUrl + "assets/images/icons/moon.svg")
      }
    },

  }))
})
