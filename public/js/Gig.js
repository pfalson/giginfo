Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

  el: '#manage-gigs',

  data: {
    gigss: [],
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
    newGig : {'id':'','created_at':'','updated_at':'','artist_id':'','venue_id':'','start':'','finish':'','description':'','poster':'','price':'','age':'','type':'','name':'','ticketurl':'',},
    fillGig : {'id':'','created_at':'','updated_at':'','artist_id':'','venue_id':'','start':'','finish':'','description':'','poster':'','price':'','age':'','type':'','name':'','ticketurl':'',}
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
  		this.getVueGigs(this.pagination.current_page);
  },

  methods : {
        getVueGigs: function(page){
          this.$http.get('/crudgigs?page='+page).then((response) => {
            this.$set('gigss', response.data.data.data);
            this.$set('pagination', response.data.pagination);
          });
        },

        createGig: function(){
		  var input = this.fillGig;
		  this.$http.post('/crudgigs',input).then((response) => {
		    this.changePage(this.pagination.current_page);
			this.newGig = {'id':'','created_at':'','updated_at':'','artist_id':'','venue_id':'','start':'','finish':'','description':'','poster':'','price':'','age':'','type':'','name':'','ticketurl':'',};
			$("#create-gigs").modal('hide');
			toastr.success('Gig Created Successfully.', 'Success Alert', {timeOut: 5000});
		  }, (response) => {
			this.formErrors = response.data;
	    });
	},

      deleteGig: function(gigs){
        this.$http.delete('/crudgigs/'+gigs.id).then((response) => {
            this.changePage(this.pagination.current_page);
            toastr.success('Gig Deleted Successfully.', 'Success Alert', {timeOut: 5000});
        });
      },

      editGig: function(gigs){
        
				this.fillGig.id = gigs.id;
				this.fillGig.created_at = gigs.created_at;
				this.fillGig.updated_at = gigs.updated_at;
				this.fillGig.artist_id = gigs.artist_id;
				this.fillGig.venue_id = gigs.venue_id;
				this.fillGig.start = gigs.start;
				this.fillGig.finish = gigs.finish;
				this.fillGig.description = gigs.description;
				this.fillGig.poster = gigs.poster;
				this.fillGig.price = gigs.price;
				this.fillGig.age = gigs.age;
				this.fillGig.type = gigs.type;
				this.fillGig.name = gigs.name;
				this.fillGig.ticketurl = gigs.ticketurl;

          $("#edit-gigs").modal('show');
      },

      updateGig: function(id){
        var input = this.fillGig;
        this.$http.put('/crudgigs/'+id,input).then((response) => {
            this.changePage(this.pagination.current_page);
            this.fillGig = {'id':'','created_at':'','updated_at':'','artist_id':'','venue_id':'','start':'','finish':'','description':'','poster':'','price':'','age':'','type':'','name':'','ticketurl':'',};
            $("#edit-gigs").modal('hide');
            toastr.success('Gig Updated Successfully.', 'Success Alert', {timeOut: 5000});
          }, (response) => {
              this.formErrorsUpdate = response.data;
          });
      },

      changePage: function (page) {
          this.pagination.current_page = page;
          this.getVueGigs(page);
      }

  }

});