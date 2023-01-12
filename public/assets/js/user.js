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
    showFlash: false,
    isLoading: false,
    DetailArticle: {
      tags: [],
      subarticles: []
    },
    EditArticle: {
      tags: [],
      subarticles: []
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

    checkSession() {
      const token = localStorage.getItem('token')
      this.isLogedIn = token ? true : false

      if (!this.isLogedIn) {
        // Fetch API Check Token
        return window.location.replace(this.baseUrl + 'login')
      }
    },

    setTiny(id, text) {
      tinymce.get(id).setContent(text);
    },

    fetchMe() {
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
        })
    },

    logout() {
      localStorage.clear()
      window.location.replace(this.baseUrl + 'login')
    },

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

    fetchDetailMyArticle(id) {
      const token = localStorage.getItem('token')

      this.isLoading = true,
        fetch(`${this.apiUrl}article/${id}`, {
          method: "GET",
          headers: {
            'Content-Type': 'application/json',
            'Authorization': localStorage.getItem('token')
          }
        })
          .then(async (response) => {
            this.DetailArticle = await response.json()
            this.isLoading = false

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

    updateSub(number) {
      let editSub = this.EditArticle.data.subarticles[number];
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

      fetch(this.apiUrl + `sub-article/${editSub.id}/update`, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
        body: formData
      })
        .then(async response => {
          sub = await response.json();

          localStorage.setItem('message', sub.message);
          localStorage.setItem('showFlash', true);
          this.flash()
        })

    },

    deleteArticle(id) {
      const token = localStorage.getItem('token')
      fetch(this.apiUrl + 'article/' + id + '/delete', {
        method: "POST",
        headers: {
          'Authorization': token
        }
      })
        .then((response) => {
          window.location.replace(this.baseUrl + 'myarticle')
        });
    },

    //pay subscription
    plan: '',
    plan_id: '',
    paySubscription() {
      const data = new FormData()
      data.append('plan', this.plan)
      plan_id = this.plan
      fetch(this.apiUrl + 'payment?plan_id=' + plan_id, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token'),
        }
      })

        .then((response) => {
          if (response.ok) {
            console.log(response)
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Transaction Process',
              showConfirmButton: false,
              timer: 1500
            })
            window.location.replace(this.baseUrl + 'transaction/details')
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Choose Plan First!',
              confirmButtonColor: 'primary',

            })
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


          if (this.myTransactions != null && this.myTransactions[0].status == 1) {
            if (this.myTransactions[0].status == 1 && lastPath == '/details') {
              window.location.replace(this.baseUrl + "profile");
            }
          }

          if (this.myTransactions == null && lastPath == '/details') {
            window.location.replace(`${this.baseUrl}transaction`)
          } else if (this.myTransactions != null && lastPath == '/transaction') {
            window.location.replace(`${this.baseUrl}transaction/details`)
          }
          return;
        })
    },

    updateMyTransaction() {
      let attachment = document.getElementById('attachment').files[0];
      let formData = new FormData();


      if (attachment != undefined) {
        formData.append('attachment', attachment);

        fetch(`${this.apiUrl}payment/checkout`, {
          method: "POST",
          headers: {
            'Authorization': localStorage.getItem('token')
          },
          body: formData
        })
          .then(async (response) => {
            const { data } = await response.json();
            if (data) {
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Payment Successfully!',
                showConfirmButton: false,
                timer: 3000
              })
              return window.location.replace(`${this.baseUrl}profile`)
            }
          })
          .catch(error => {
            console.log(error.message);
          })

        return;
      }

      fetch(`${this.apiUrl}payment/checkout`, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
      })
        .then(async (response) => {
          const data = await response.json();
          if (data) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Payment Successfully!',
              showConfirmButton: false,
              timer: 3000
            })
            return window.location.replace(`${this.baseUrl}profile`)
          }
        })
        .catch(error => {
          console.log(error.message);
        })

      return;
    },

  }))

  Alpine.data('articles', () => ({
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    imgUrl: "http://127.0.0.1:8001/",
    listArticle: [],
    categoriesArticle: [],
    detailArticle: null,
    isLoadingArticle: false,
    itemArticle: 3,

    // INPUTS ARTICLE
    keywordArticle: '',

    getArticle() {
      fetch(`${this.apiUrl}article`, {
        method: "GET"
      })
        .then(async (response) => {
          const data = await response.json();
          this.listArticle = data.data;
        })

    },

    loadMoreArticle() {
      this.isLoadingArticle = true;
      setTimeout(() => {
        this.isLoadingArticle = false;
        this.itemArticle += 3;
      }, 600)
    },

    getDetailArticle(id) {


      fetch(`${this.apiUrl}article/${id}`, {
        method: "GET"
      })
        .then(async (response) => {
          const data = await response.json();
          this.detailArticle = data.data;
        })
        .catch(error => {
          console.log(error.message);
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
      let description = document.getElementById('content');
      let thumbnail = document.getElementById('thumbnail').files[0];
      let category = document.getElementsByClassName('categories');
      let type = document.getElementsByClassName('type');
      let title_sub = document.getElementsByClassName('title_sub');
      let thumbnail_sub = document.getElementsByClassName('thumbnail_sub');
      let description_sub = document.getElementsByClassName('ck-content');
      let formData = new FormData();
      formData.append('title', title.value);
      formData.append('description', description.value);
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
        formData.append('description_sub[]', description_sub[i].innerHTML);
      }
      article = await fetch(`${this.apiUrl}article`, {
        method: "POST",
        headers: {
          'Authorization': localStorage.getItem('token')
        },
        body: formData
      })

      data = await article.json();

      if (data.status) {
        localStorage.setItem('message', 'article successfully created!');
        localStorage.setItem('showFlash', true);
        return window.location.replace(`${this.baseUrl}myarticle`)
      }
    },

    // CATEGORIES ARTICLE

    getCategories() {

      fetch(`${this.apiUrl}category`, {
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

          for (let index = 0; index < this.categoriesArticle.length; index++) {
            if (this.categoriesArticle[index].id === categoryId) {
              document.getElementById(`category${categoryId}`).classList.add('active');
            } else {
              document.getElementById(`category${this.categoriesArticle[index].id}`).classList.remove('active');
            }
          }

        })

    },

    // FILTERS

    resetFilters() {

      let categories = document.querySelectorAll('.category');

      for (let index = 0; index < categories.length; index++) {
        if (categories[index].classList.contains('active')) {
          categories[index].classList.remove('active');
        }
      }

      this.keywordArticle = '';
      this.getArticle();
    }

  }))

  Alpine.data('helpers', () => ({

    convertDate(date) {

      const months = ["Jan", "Feb", "March", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"];
      let tanggal = new Date(date);
      let month = months[tanggal.getMonth()];

      fullDate = month + ' ' + tanggal.getDate() + ' ,' + tanggal.getFullYear();

      return fullDate;

    }

  }))
})
