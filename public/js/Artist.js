Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

  el: '#manage-artists',

  data: {
    artistss: [],
    pagination: {
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1
      },
    offset: 4,
    formErrors:{},
    formErrorsUpdate:{},
    newArtist : {'id':'','created_at':'','updated_at':'','name':'','website':'','facebook':'',},
    fillArtist : {'id':'','created_at':'','updated_at':'','name':'','website':'','facebook':'',}
  },

  computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },

  ready : function(){
  		this.getVueArtists(this.pagination.current_page);
  },

  methods : {
        getVueArtists: function(page){
          this.$http.get('/crudartists?page='+page).then((response) => {
            this.$set('artistss', response.data.data.data);
            this.$set('pagination', response.data.pagination);
          });
        },

        createArtist: function(){
		  var input = this.fillArtist;
		  this.$http.post('/crudartists',input).then((response) => {
		    this.changePage(this.pagination.current_page);
			this.newArtist = {'id':'','created_at':'','updated_at':'','name':'','website':'','facebook':'',};
			$("#create-artists").modal('hide');
			toastr.success('Artist Created Successfully.', 'Success Alert', {timeOut: 5000});
		  }, (response) => {
			this.formErrors = response.data;
	    });
	},

      deleteArtist: function(artists){
        this.$http.delete('/crudartists/'+artists.id).then((response) => {
            this.changePage(this.pagination.current_page);
            toastr.success('Artist Deleted Successfully.', 'Success Alert', {timeOut: 5000});
        });
      },

      editArtist: function(artists){
        
				this.fillArtist.id = artists.id;
				this.fillArtist.created_at = artists.created_at;
				this.fillArtist.updated_at = artists.updated_at;
				this.fillArtist.name = artists.name;
				this.fillArtist.website = artists.website;
				this.fillArtist.facebook = artists.facebook;

          $("#edit-artists").modal('show');
      },

      updateArtist: function(id){
        var input = this.fillArtist;
        this.$http.put('/crudartists/'+id,input).then((response) => {
            this.changePage(this.pagination.current_page);
            this.fillArtist = {'id':'','created_at':'','updated_at':'','name':'','website':'','facebook':'',};
            $("#edit-artists").modal('hide');
            toastr.success('Artist Updated Successfully.', 'Success Alert', {timeOut: 5000});
          }, (response) => {
              this.formErrorsUpdate = response.data;
          });
      },

      changePage: function (page) {
          this.pagination.current_page = page;
          this.getVueArtists(page);
      }

  }

});