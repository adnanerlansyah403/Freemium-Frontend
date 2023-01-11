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
        listMyArticle: [],
        Article: [],
        message: '',
        plan: '',
        plan_id: '',

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
                    this.name = user.data.name != null ? user.data.name : ''
                    this.username = user.data.username != null ? user.data.username : ''
                    this.email = user.data.email != null ? user.data.email : ''
                    this.password = user.data.password != null ? user.data.password : ''
                    this.photo = user.data.photo != null ? user.data.photo : ''
                    this.link_facebook = user.data.link_facebook != null ? user.data.link_facebook : ''
                    this.link_linkedin = user.data.link_linkedin != null ? user.data.link_linkedin : ''
                    this.link_instagram = user.data.link_instagram != null ? user.data.link_instagram : ''
                    this.link_twitter = user.data.link_twitter != null ? user.data.link_twitter : ''
                });
        },

        updateMe() {
            // console.log(document.getElementById('photo').files[0]);

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
                    console.log(myArticle)
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

        fetchDetailArticle(id) {
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
                    // console.log(response.json())
                    Article = await response.json()
                    this.isLoading = false

                })

        },

        setIdArticle(id) {
            console.log(id)
            this.idArticle = id
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
                    console.log(response)
                    window.location.replace(this.baseUrl + 'myarticle')
                });
        },
        paySubscription() {
            const data = new FormData()
            data.append('plan', this.plan)
            plan_id = this.plan
            console.log(this.plan)
            const token = localStorage.getItem('token')
            fetch(this.apiUrl + 'payment?plan_id=' + plan_id, {
              method: "POST",
              headers: {
                'Authorization': token
              }
            })

            .then((response) => {
                if (response.ok){
                    alert('Payment Successfully!')
                    window.location.replace(this.baseUrl + 'transaction/details')
                }else{
                    alert ('Pembayaran Gagal')
                }
              });

          }

    }))
})
