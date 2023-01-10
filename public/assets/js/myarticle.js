
document.addEventListener('alpine:init', () => {
  Alpine.data('myarticle', () => ({
    title: 'Selamat datang, ' + localStorage.getItem('name'),
    isLogedIn: false,
    baseUrl: "http://127.0.0.1:8000/",
    apiUrl: "http://127.0.0.1:8001/api/",
    imgUrl: "http://127.0.0.1:8001/",
    myarticle: [],
    checkSession() {
      this.isLogedIn = localStorage.getItem('token') ? true : false

      if (!this.isLogedIn) return window.location.replace(this.baseUrl + 'login')

      if (localStorage.getItem('role') != 2) return window.history.back()
    },

    logout() {
      localStorage.clear()
      window.location.replace(this.baseUrl + 'login')
    },

    fetchMyArticle() {
      fetch(this.apiUrl + 'myArticle', {
        method: "GET",
        headers: {
          'Authorization': localStorage.getItem('token')
        }
      }).then(async response => {
        article = await response.json()
        this.myarticle = article.data;
        console.log(this.myarticle)
      })
    }
  }))
})