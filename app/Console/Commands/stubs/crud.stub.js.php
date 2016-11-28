Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

  el: '#manage-<?=$table_name?>',

  data: {
    <?=$table_name?>s: [],
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
    new<?=$ClassName?> : {<?=$jsFillable?>},
    fill<?=$ClassName?> : {<?=$jsFillable?>}
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
  		this.getVue<?=$ClassName?>s(this.pagination.current_page);
  },

  methods : {
        getVue<?=$ClassName?>s: function(page){
          this.$http.get('/crud<?=$table_name?>?page='+page).then((response) => {
            this.$set('<?=$table_name?>s', response.data.data.data);
            this.$set('pagination', response.data.pagination);
          });
        },

        create<?=$ClassName?>: function(){
		  var input = this.fill<?=$ClassName?>;
		  this.$http.post('/crud<?=$table_name?>',input).then((response) => {
		    this.changePage(this.pagination.current_page);
			this.new<?=$ClassName?> = {<?=$jsFillable?>};
			$("#create-<?=$table_name?>").modal('hide');
			toastr.success('<?=$ClassName?> Created Successfully.', 'Success Alert', {timeOut: 5000});
		  }, (response) => {
			this.formErrors = response.data;
	    });
	},

      delete<?=$ClassName?>: function(<?=$table_name?>){
        this.$http.delete('/crud<?=$table_name?>/'+<?=$table_name?>.id).then((response) => {
            this.changePage(this.pagination.current_page);
            toastr.success('<?=$ClassName?> Deleted Successfully.', 'Success Alert', {timeOut: 5000});
        });
      },

      edit<?=$ClassName?>: function(<?=$table_name?>){
        <?php
          echo "\n";
          foreach ( $fields as $fieldName => $fieldValue) {
              echo "\t\t\t\tthis.fill$ClassName.$fieldValue = $table_name.$fieldValue;\n";
            }
        ?>

          $("#edit-<?=$table_name?>").modal('show');
      },

      update<?=$ClassName?>: function(id){
        var input = this.fill<?=$ClassName?>;
        this.$http.put('/crud<?=$table_name?>/'+id,input).then((response) => {
            this.changePage(this.pagination.current_page);
            this.fill<?=$ClassName?> = {<?=$jsFillable?>};
            $("#edit-<?=$table_name?>").modal('hide');
            toastr.success('<?=$ClassName?> Updated Successfully.', 'Success Alert', {timeOut: 5000});
          }, (response) => {
              this.formErrorsUpdate = response.data;
          });
      },

      changePage: function (page) {
          this.pagination.current_page = page;
          this.getVue<?=$ClassName?>s(page);
      }

  }

});