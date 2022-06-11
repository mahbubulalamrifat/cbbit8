export default{
     // check action btn access
     checkActionBtnAccess() {
        if (this.complainDeta.process == "HO Service") {
            return true;
        }

        if (this.complainDeta.process != "Closed") {
            return true;
        }

        return false;
    },

    // getComplainData
    getComplainData() {
        this.dataLoading = true;
        axios
            .get(this.currentUrl + "/action/" + this.comId)
            .then((response) => {
                this.dataLoading = false;

                console.log(response.data);
                this.complainDeta = response.data;
                this.actionBtn();
            })
            .catch((error) => {
                this.dataLoading = false;
                console.log(error);
            });
    },

    // modifyDialogShow
    modifyDialogShow() {
        this.comModifyDialogKey++;
        this.CurrentComDataModify = this.complainDeta;
    },

    // mailSendManual
    mailSendManual(val) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to resend E-mail",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes'
        }).then((result) => {
            // Send request to the server
            if (result.value) {
                this.overlay = true;
                axios
                    .get(this.currentUrl + "/send_rem_email?id=" + val)
                    .then((response) => {
                        //console.log(response.data);
                        this.getComplainData();
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.msg,
                        });
                        this.overlay = false;
                    })
                    .catch((error) => {
                        this.overlay = false;
                        console.log(error);
                    });

            }
        })
    },

    // actionDialogShow
    actionDialogShow() {
        this.actionBtnLoading = true;

        //console.log('Process ', val)
        let currPro = this.complainDeta.process;
        this.actionVal = false;
        this.actionVal2 = false;
        this.actionVal3 = false;
        this.actionVal4 = false;
        this.actionVal5 = false;
        this.actionVal6 = false;

        if (currPro == "Not Process") {
            this.actionVal = true;
            //this.actionVal2 = false
        }

        // Processing
        if (
            currPro == "Processing" ||
            currPro == "Send Service" ||
            currPro == "Back Service" ||
            currPro == "Again Send Service" ||
            currPro == "Service Quotation"
        ) {
            // this.actionVal = false
            this.actionVal2 = true;
        }

        // HO Service
        if (currPro == "HO Service" && this.isHardwareHoService()) {
            //console.log('HO Service')
            // HO service
            this.actionVal3 = true;
        }

        // Damaged
        if (currPro == "Damaged" || currPro == "Partial Damaged") {
            let damagedData = this.complainDeta.damage;
            // Check Applicable
            if (
                damagedData.applicable_type == "Applicable" &&
                !damagedData.apply_quotation
            ) {
                // Check user applied
                if (!damagedData.apply_at) {
                    Swal.fire({
                        icon: "warning",
                        title: "Sorry!! User not yet applied",
                    });
                } else {
                    this.actionVal5 = true;
                }
            } else {
                // this.actionVal = false
                this.actionVal4 = true;
            }
        }

        // Deliverable
        if (currPro == "Deliverable") {
            //console.log('Deliverable')
            // HO service
            this.actionVal6 = true;
        }

        this.comActionsDialogKey++;
        this.CurrentComData = this.complainDeta;

        // this.comActionsDialogKey++
        // this.CurrentComData = this.complainDeta

        this.actionBtnLoading = false;
    },

    actionBtn() {
        //console.log('Process ', val)
        let currPro = this.complainDeta.process;
        // For Action BTN

        // HO access
        if (!this.isHardwareHoService() && currPro == "HO Service") {
            this.actionBtnText = "Sorry! You have no HO access";
            this.actionBtnColor = "error";
            this.actionAccess = false;
        }

        // Delivery access
        if (!this.isHardwareDelivery() && currPro == "Deliverable") {
            this.actionBtnText = "Sorry! You have no Delivery access";
            this.actionBtnColor = "error";
            this.actionAccess = false;
        }

        // Damaged access
        if (
            !this.isHardwareDamaged() &&
            (currPro == "Damaged" || currPro == "Partial Damaged")
        ) {
            this.actionBtnText = "Sorry! You have no Damage access";
            this.actionBtnColor = "error";
            this.actionAccess = false;
        }

        // Closed
        if (currPro == "Closed") {
            this.actionBtnText = "Sorry! Complain already closed";
            this.actionBtnColor = "error";
            this.actionAccess = false;
        }
    },
}