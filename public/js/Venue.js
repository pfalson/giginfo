Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

  el: '#manage-venues',

  data: {
    venuess: [],
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
    newVenue : {'id':'','created_at':'','updated_at':'','name':'','website':'','facebook':'','address_id':'','phone':'',},
    fillVenue : {'id':'','created_at':'','updated_at':'','name':'','website':'','facebook':'','address_id':'','phone':'',}
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
  		this.getVueVenues(this.pagination.current_page);
  },

  methods : {
        getVueVenues: function(page){
          this.$http.get('/crudvenues?page='+page).then((response) => {
            this.$set('venuess', response.data.data.data);
            this.$set('pagination', response.data.pagination);
          });
        },

        createVenue: function(){
		  var input = this.fillVenue;
		  this.$http.post('/crudvenues',input).then((response) => {
		    this.changePage(this.pagination.current_page);
			this.newVenue = {'id':'','created_at':'','updated_at':'','name':'','website':'','facebook':'','address_id':'','phone':'',};
			$("#create-venues").modal('hide');
			toastr.success('Venue Created Successfully.', 'Success Alert', {timeOut: 5000});
		  }, (response) => {
			this.formErrors = response.data;
	    });
	},

      deleteVenue: function(venues){
        this.$http.delete('/crudvenues/'+venues.id).then((response) => {
            this.changePage(this.pagination.current_page);
            toastr.success('Venue Deleted Successfully.', 'Success Alert', {timeOut: 5000});
        });
      },

      editVenue: function(venues){
        
				this.fillVenue.id = venues.id;
				this.fillVenue.created_at = venues.created_at;
				this.fillVenue.updated_at = venues.updated_at;
				this.fillVenue.name = venues.name;
				this.fillVenue.website = venues.website;
				this.fillVenue.facebook = venues.facebook;
				this.fillVenue.address_id = venues.address_id;
				this.fillVenue.phone = venues.phone;

          $("#edit-venues").modal('show');
      },

      updateVenue: function(id){
        var input = this.fillVenue;
        this.$http.put('/crudvenues/'+id,input).then((response) => {
            this.changePage(this.pagination.current_page);
            this.fillVenue = {'id':'','created_at':'','updated_at':'','name':'','website':'','facebook':'','address_id':'','phone':'',};
            $("#edit-venues").modal('hide');
            toastr.success('Venue Updated Successfully.', 'Success Alert', {timeOut: 5000});
          }, (response) => {
              this.formErrorsUpdate = response.data;
          });
      },

      changePage: function (page) {
          this.pagination.current_page = page;
          this.getVueVenues(page);
      }

  }

});