export default{
    //Set Manager
    setManager(){
        // make empty
        this.form.manager_id = []
        this.selectedManagerName = []

        var allDataArr = this.fullUserList;
        var managerId  = this.selectedManager

        // Manager ID check in all Data
        for (var key in allDataArr) {
            var value = allDataArr[key];
            // Check manager ID in Current Data
            for(var key2 in managerId){
                var value2 = managerId[key2];
                // Single value check
                if(value2 == value.id){
                    //console.log('value found', value.id, value.name)
                    // Name push in array
                    this.selectedManagerName.push(value.name)
                    // ID Push in form obj
                    this.form.manager_id.push(value.id)
                }
                // console.log('for2 -- ', key2, value2);
            }
        }
       
       
        console.log('setManager', this.selectedManagerName,'selectedManager', managerId, 'form.manager_id',this.form.manager_id)
        // Hide second modal
        this.userModal2ndShowHide = false
   
    },
}