Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

  el: '#manage-artist',

  data: {
    artists: [],
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
          this.$http.get('/crudartist?page='+page).then((response) => {
            this.$set('artists', response.data.data.data);
            this.$set('pagination', response.data.pagination);
          });
        },

        createArtist: function(){
		  var input = this.fillArtist;
		  this.$http.post('/crudartist',input).then((response) => {
		    this.changePage(this.pagination.current_page);
			this.newArtist = {'id':'','created_at':'','updated_at':'','name':'','website':'','facebook':'',};
			$("#create-artist").modal('hide');
			toastr.success('Artist Created Successfully.', 'Success Alert', {timeOut: 5000});
		  }, (response) => {
			this.formErrors = response.data;
	    });
	},

      deleteArtist: function(artist){
        this.$http.delete('/crudartist/'+artist.id).then((response) => {
            this.changePage(this.pagination.current_page);
            toastr.success('Artist Deleted Successfully.', 'Success Alert', {timeOut: 5000});
        });
      },

      editArtist: function(artist){
        
				this.fillArtist.id = artist.id;
				this.fillArtist.created_at = artist.created_at;
				this.fillArtist.updated_at = artist.updated_at;
				this.fillArtist.name = artist.name;
				this.fillArtist.website = artist.website;
				this.fillArtist.facebook = artist.facebook;

          $("#edit-artist").modal('show');
      },

      updateArtist: function(id){
        var input = this.fillArtist;
        this.$http.put('/crudartist/'+id,input).then((response) => {
            this.changePage(this.pagination.current_page);
            this.fillArtist = {'id':'','created_at':'','updated_at':'','name':'','website':'','facebook':'',};
            $("#edit-artist").modal('hide');
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