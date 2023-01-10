
document.addEventListener('alpine:init', () => {
  Alpine.data('user', () => ({
    isLogedIn: false,
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    imgUrl: "http://127.0.0.1:8001/",
    subscribe_status: false,
    data_user: [],
    listMyArticle:[],


    checkSession() {
      const token = localStorage.getItem('token')
      this.isLogedIn = token ? true : false
      console.log(this.data_user);

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
          console.log(this.data_user)
        });
    },

    logout() {
      localStorage.clear()
      window.location.replace(this.baseUrl + 'login')
    },

    fetchListMyArticle(){
        const token = localStorage.getItem('token')

        this.isLoading = true,
        fetch(`${this.apiUrl}myArticle`,{
            method: "GET",
            headers: {
              'Content-Type': 'application/json',
              'Authorization': localStorage.getItem('token')
            }})
        .then(async (response) => {
            this.listMyArticle = await response.json()
            console.log(this.listMyArticle)
            this.isLoading = false

        })

    },

    deleteArticle(id){
        const token = localStorage.getItem('token')
        fetch(this.apiUrl + 'article/'+id+'/delete',{
            method: "POST",
            headers: {
                'Authorization': token
            }})
        .then( (response) => {
            console.log(response)
            window.location.replace(this.baseUrl+'myarticle')
        });
    }

  }))
})
