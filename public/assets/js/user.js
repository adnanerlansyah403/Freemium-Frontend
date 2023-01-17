document.addEventListener('alpine:init', () => {

  Alpine.data('user', () => ({
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
    status_err: [],
    showFlash: false,
    isLoading: false,
    DetailArticle: {
      data: ''
    },
    EditArticle: {
      data: ''
    },
    listMyArticle: [],
    myTransactions: [],
    message: '',
    categories: [],

    flash() {
      if (localStorage.getItem('showFlash')) {
        this.showFlash = true;
        this.message = localStorage.getItem('message');
        setTimeout(function () {
          localStorage.removeItem("showFlash")
          this.showFlash = false;
        }, 3000);
      }
    },
    name: '',
    username: '',
    email: '',
    password: '',
    photo: '',
    link_facebook: '',
    link_linkedin: '',
    link_instagram: '',
    link_twitter: '',

    fetchMe() {
      fetch(this.apiUrl + 'me', {
        method: "GET",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
      })
        .then(async response => {
          user = await response.json();
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
        });
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
            return window.location.replace(this.baseUrl + 'article');
          }
        });
    },

    setTiny(id, text) {
      tinymce.get(id).setContent(text);
    },

    updateMe() {

      this.isLoading = true;

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
      formData.append('photo', photoProfile);
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

          localStorage.setItem('message', user.message);
          localStorage.setItem('showFlash', true);
          window.location.reload();
          this.isLoading = false;
        })
    },

    logout() {
      localStorage.clear()
      window.location.replace(this.baseUrl + 'login')
    },
    listPlan: '',
    fetchListPlan() {
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
    fetchListUser() {
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

      console.log(data)

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
            this.EditArticle = await response.json()
            if (this.EditArticle.status == false) {
              return window.location.replace(`${this.baseUrl}myarticle`);
            }
            this.isLoading = false

          })

    },

    updateArticle() {
      let editA = this.EditArticle.data;
      editA.description = tinymce.get('content').getContent();

      if (typeof editA.thumbnail !== 'string' && editA.thumbnail[0]) {
        editA.thumbnail = editA.thumbnail[0];
      }

      let formData = new FormData();

      formData.append('category_id[]', document.getElementById('category_id').value);
      formData.append('title', editA.title);
      formData.append('description', editA.description);
      formData.append('thumbnail', editA.thumbnail);

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
            this.showFlash = true;
            this.status_err[0] = data.message;
            console.log(this.status_err)
          }
          else {
            this.status_err[0] = null;
            localStorage.setItem('message', data.message);
            localStorage.setItem('showFlash', true);
            this.flash()
          }
        })

    },

    addSub() {
      let id = 0;
      let article_id = this.EditArticle.data.subarticles[0].article_id;
      let title = '';
      let type = '';
      let description = '';
      let thumbnail = '';
      return { id, article_id, title, type, description, thumbnail };
    },

    updateSub(number) {
      let editSub = this.EditArticle.data.subarticles[number];
      editSub.description = tinymce.get('sub_content').getContent();

      if (typeof editSub.thumbnail !== 'string' && editSub.thumbnail[0]) {
        editSub.thumbnail = editSub.thumbnail[0];
      }
      console.log(editSub);
      let formData = new FormData();

      formData.append('article_id', editSub.article_id);
      formData.append('title', editSub.title);
      formData.append('type', editSub.type);
      formData.append('description', editSub.description);
      formData.append('thumbnail', editSub.thumbnail);

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
            this.showFlash = true;
            this.status_err[1] = sub.message;
            console.log(this.status_err)
          }
          else {
            editSub.id = sub.data.id;
            this.status_err[1] = null;
            localStorage.setItem('message', sub.message);
            localStorage.setItem('showFlash', true);
            this.flash()
          }
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
          console.log(response);
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
    itemArticle: 3,
    content: false,
    back: false,
    showFlash: false,
    message: '',

    flash() {
      if (localStorage.getItem('showFlash')) {
        this.showFlash = true;
        this.message = localStorage.getItem('message');
        setTimeout(function () {
          localStorage.removeItem("showFlash")
          this.showFlash = false;
        }, 3000);
        console.log('test');
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
          console.log(this.listArticle);
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
          console.log(this.listArticle);
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
      // console.log(id);
      fetch(`${this.apiUrl}article/${id}`, {
        method: "GET",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
      })
        .then(async (response) => {
          const data = await response.json();
          console.log(data);
          this.detailArticle = data.data;
          // console.log(this.detailArticle);
        })
        .catch(error => {
          console.log(error);
        })
    },

    getSubArticle(id) {
      fetch(`${this.apiUrl}sub-article/${id}`, {
        method: "GET",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
      })
        .then(async (response) => {
          const data = await response.json();
          if (!data.status) {
            this.showFlash = true;
            localStorage.setItem('message', data.message);
            localStorage.setItem('showFlash', true);
            console.log(data)
          }
          else {
            this.showFlash = false;
            this.content = data.data;
          }


        })
        .catch(error => {
          console.log(error);
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
      this.categories = await category.json();
    },

    async createArticle() {
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
        formData.append('category_id[]', category[i].value);
      }
      for (let i = 0; i < title_sub.length; i++) {
        formData.append('title_sub[]', title_sub[i].value);
        formData.append('thumbnail_sub[]', thumbnail_sub[i].files[0]);
        formData.append('description_sub[]', tinymce.get(`editor${i + 1}`).getContent());
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
        console.log(this.status_err)
      }

      if (data.status) {
        localStorage.setItem('message', 'article successfully created!');
        localStorage.setItem('showFlash', true);
        return window.location.replace(`${this.baseUrl}myarticle`)
      }
    },

    // CATEGORIES ARTICLE

    getCategories() {
      const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
      });
      // Get the value of "some_key" in eg "https://example.com/?some_key=some_value"
      let search = params.search;
      if (search) {
        path = '?search=' + search;
      } else {
        path = ''
      }

      fetch(`${this.apiUrl
        }category${path}`, {
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
    status_err: [],
    listOrder: [],
    showFlash: false,
    isLoading: false,
    keyword: '',

    flash() {
      if (localStorage.getItem('showFlash')) {
        this.showFlash = true;
        this.message = localStorage.getItem('message');
        setTimeout(function () {
          localStorage.removeItem("showFlash")
          this.showFlash = false;
        }, 3000);
        console.log('test');
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
            return window.location.replace(this.baseUrl + 'article');
          }
        });
    },

    fetchAdminData() {

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
            this.showFlash = true;
            console.log(this.data_admin);
          }
          else {
            localStorage.setItem('message', data.message);
            localStorage.setItem('showFlash', true);
            // this.flash()
          }
        })
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

      fetch(`${this.apiUrl}payment`, {
        method: 'GET',
        headers: {
          Authorization: localStorage.getItem('token'),
        }
      })
        .then(async response => {
          const data = await response.json();
          this.listOrder = data.data;
          console.log(this.listOrder);
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
      let imageOrder = document.getElementById("imageOrder");

      if (id === 0) {
        nameOrder.value = '';
        emailOrder.value = '';
        vaOrder.value = '';
        priceOrder.value = '';
        paymentDateOrder.value = '';
        document.getElementById('imageOrderWrapper').style.display = 'none';
        imageOrder.setAttribute('src', '');
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
          // console.log(data.data);

          nameOrder.innerText = data.data.user.name ? data.data.user.name : "User hasn't name yet";
          emailOrder.innerText = data.data.user.email ? data.data.user.email : "User hasn't email yet";
          planOrder.innerText = data.data.plan.name;
          priceOrder.innerText = '$' + data.data.total_price;
          vaOrder.innerText = data.data.virtual_account_number;
          paymentDateOrder.innerText = this.convertDate(data.data.payment_date);

          if (data.data.attachment) {
            document.getElementById('imageOrderWrapper').style.display = 'block';
            imageOrder.setAttribute('src', this.imgUrl + data.data.attachment);
          }

        })
    },

    // FILTERING ORDERS

    searchOrder(keyword) {
      // console.log(keyword);

      fetch(`${this.apiUrl}payment?search=${keyword}`, {
        method: 'GET',
        headers: {
          Authorization: localStorage.getItem("token"),
        }
      })
        .then(async (response) => {
          const data = await response.json();
          this.listOrder = data.data
          console.log(data);
        })

    },

  }))

  Alpine.data('helpers', () => ({
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    imgUrl: "http://127.0.0.1:8001/",

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

    substring(string, max = 5) {
      if (string.length > max) {
        return string.substring(0, max) + "..."
      }
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
