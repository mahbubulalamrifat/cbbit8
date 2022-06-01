export default {

   // Get table data
   getResults(page = 1) {
        this.dataLoading = true;
        axios.get(this.currentUrl+'/index?page=' + page +
                '&paginate=' + this.paginate +
                '&search=' + this.search +
                '&sort_direction=' + this.sort_direction +
                '&sort_field=' + this.sort_field +
                '&sort_by_day=' + this.sort_by_day+
                '&sort_by_startDate=' + this.sort_by_startDate+
                '&sort_by_endDate=' + this.sort_by_endDate+
                '&sort_by_type=' + this.sort_by_type
            )
            .then(response => {
                //console.log(response.data.data);
                //console.log(response.data.from, response.data.to, response.data.current_page);
                this.allData = response.data;
                this.totalValue = response.data.total;
                this.dataShowFrom = response.data.from;
                this.dataShowTo = response.data.to;
                this.currentPageNumber  = response.data.current_page
                // Loading Animation
                this.dataLoading = false;

            });
    },

  
    // DataTable Shorting by field name
    change_sort(field) {
        this.$Progress.start();
        if (this.sort_field == field) {
            this.sort_direction = this.sort_direction == "asc" ? "desc" : "asc";
        } else {
            this.sort_field = field;
        }
        this.getResults();
        this.$Progress.finish();
    },

    
}